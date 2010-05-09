<?php
include_once('base.php');

class Notas extends Base
{ 
  public $data;

  public function __construct() {
    parent::Controller();
    $this->load->model('Paralelo_model');
    $this->load->model('Nota_model');
    $this->load->model('Alumno_model');
    // Credenciales para el controlador
    $this->credentials = array(
      'index' => array('admin'),
      'new_import' => array('admin'),
      'create_import' => array('admin'),
      'edit' => array('admin'),
      'update' => array('admin'),
      'destroy' => array('admin')
    );
  }

  function index() {
    $data['cursos'] = $this->Paralelo_model->getList(array('labelField' => 'nivel, curso, paralelo'));
    $this->load->model('Alumno_model');
    $data['alumnos'] = $this->Alumno_model->getList(array('labelField' => 'primer_nombre, segundo_nombre, paterno, materno') );

    $data['template'] = 'notas/index';
    $this->load->view('layouts/application', $data);

  }

  function new_import() {
    $data['template'] = 'notas/import';
    $this->load->view('layouts/application', $data);
  }

  function create_import() {
    $config = array(
      'upload_path' => './system/excel/notas',
      'allowed_types' => 'xls'
      );

    $this->load->library('upload', $config);

    if(!$this->upload->do_upload('notas_excel') ) {
      echo $this->upload->display_errors();
    }else{
      $params = $this->upload->data();
      $file_name = $params['file_name'];
      $data['errors'] = $this->Nota_model->insertUpdateNotas($file_name, $_POST['anio']);
    }

    $data['template'] = 'notas/import';
    $this->load->view('layouts/application', $data);
  }

  /**
   * Presenta la notas por alumno
   */
  public function edit($codigo, $alumno_id, $anio) {
    $codigo = trim(str_replace('codigo:', '', $codigo));
    $alumno_id = trim( str_replace('alumno_id:', '', $alumno_id) );
    $anio = trim( str_replace('anio:', '', $anio) );


    if($codigo != '' ) {
      $field = 'codigo';
      $val = intval($codigo);
    }else{
      $field = 'id';
      $val = intval($alumno_id);
    }

    $alumno = $this->Alumno_model->findByField($field, $val);
    if(is_array($alumno)) {
      $this->session->set_flashdata('error', "El alumno que busca no existe");
      redirect("/notas");
    }

    $data['alumno'] = $alumno;
    $materia = $this->Nota_model->loadModel('Materia_model');
    $data['materias'] = $materia->getList(array('labelField' => 'nombre'));

    $anio = intval($anio);
    $data['anio'] = $anio;
    $conditions = array('conditions' => "alumno_id={$alumno->id} AND anio={$anio}" );
    $data['notas'] = $this->Nota_model->getAll($conditions);

    $data['template'] = 'notas/edit';
    $this->load->view('layouts/application', $data);
  }

  /**
   * Actualizacion de notas
   */
  public function update() {
    $notas = array('id' => $_POST['nota_id']);
    $arr = array();
    foreach($this->Nota_model->columnas as $pos => $col) {
      $arr[$col] = $_POST[$col];
    }
    $notas['notas_profesor'] = json_encode($arr);
    $this->Nota_model->update($notas);
    echo $notas['notas_profesor'];
  }
}

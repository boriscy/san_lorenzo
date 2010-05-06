<?php
include_once('base.php');

class Notas extends Base
{ 
  public $data;

  public function __construct() {
    parent::Controller();
    $this->load->model('Paralelo_model');
    $this->load->model('Nota_model');
    // Credenciales para el controlador
    $this->credentials = array(
      'index' => array('admin'),
      'edit' => array('admin'),
      'create' => array('admin'),
      'update' => array('admin'),
      'destroy' => array('admin')
    );
  }

  function index() {
    $data['cursos'] = $this->Paralelo_model->getList(array('labelField' => 'nivel, curso, paralelo'));
    $this->load->model('Alumno_model');
    $data['alumnos'] = $this->Alumno_model->getList(array('labelField' => 'paterno', 'conditions' => 'activo=0') );

    $data['template'] = 'notas/import';
    $this->load->view('layouts/application', $data);

  }

  function importar() {
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
      $errors = $this->Nota_model->insertUpdateNotas($file_name, $_POST['anio']);
    }

    $data['template'] = 'notas/import';
    $this->load->view('layouts/application', $data);
  }

  /**
   * Presenta la notas por alumno
   */
  function alumno() {
  }
}

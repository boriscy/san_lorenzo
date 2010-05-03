<?php
include_once('base.php');

class Cursos extends Base
{

  /**
   * Constructor
   */
  public function __construct() {
    parent::__construct();
    $this->load->model('Curso_model');
    $this->load->model('Usuario_model');
    $this->load->model('Paralelo_model');
    $this->load->model('Materia_model');
    // Credenciales para el controlador
    $this->credentials = array(
      'index' => array('admin'),
      'edit' => array('admin'),
      'create' => array('admin'),
      'update' => array('admin'),
      'destroy' => array('admin')
    );

    $this->checkCredentials();
  }

  /**
   * index
   */
  public function index() {
    $data['cursos'] = $this->Curso_model->getAll();

    $data['template'] = 'cursos/index';
    $this->load->view('layouts/application', $data);
  }

  /**
   * create
   */
  public function create() {
    $this->formValidations();
    if(isset($_POST['anio']) && $this->form_validation->run() == TRUE) {
      $this->Curso_model->create($_POST);
      redirect('/cursos');
    }else{
      if(isset($_POST['curso']) )
        $this->session->set_flashdata('error', 'Existen errores en le formulario');

      $data['profesores'] = $this->Usuario_model->getList(array(
        'labelField'=>'primer_nombre, segundo_nombre, paterno, materno', 
        'order' => 'primer_nombre, segundo_nombre, paterno, materno ASC',
        'conditions' => 'tipo="profe"'
      ));
      $data['materias'] = $this->Materia_model->getList(array('labelField'=>'nombre', 'order' => 'nombre ASC'));
      $data['paralelos'] = $this->Paralelo_model->getList(array('labelField'=>'nivel, curso, paralelo', 'order' => 'nivel, curso, paralelo ASC'));

      $data['template'] = 'cursos/create';
      $this->load->view('layouts/application', $data);
    }
  }

  /**
   * edit
   */
  public function edit($id) {

    $data['profesores'] = $this->Usuario_model->getList(array(
      'labelField'=>'primer_nombre, segundo_nombre, paterno, materno', 
      'order' => 'primer_nombre, segundo_nombre, paterno, materno ASC',
      'conditions' => 'tipo="profe"'
    ));
    $data['materias'] = $this->Materia_model->getList(array('labelField'=>'nombre', 'order' => 'nombre ASC'));
    $data['paralelos'] = $this->Paralelo_model->getList(array('labelField'=>'nivel, curso, paralelo', 'order' => 'nivel, curso, paralelo ASC'));
    $data['vals'] = $this->Curso_model->getId($id);
    if(isset($_POST['materias'])) {
      $data['vals']['materias'] = $_POST['materias'];
    }else{
      $data['vals']['materias'] = $this->Curso_model->getMaterias($id);
    }

    $data['template'] = 'cursos/edit';
    $this->load->view('layouts/application', $data);
  }

  /**
   * update
   */
  public function update() {

    $this->formValidations();
    if($this->form_validation->run() == TRUE) {
      $this->Curso_model->update($_POST); 
      $this->session->set_flashdata('notice', 'Se actualizo correctamente el curso');
      redirect('/cursos');
    }else{
      $this->session->set_flashdata('error', 'Existen errores en su formulario');
      $this->edit($_POST['id']);
    }
  }


  /**
   * destroy
   */
  public function destroy($id, $token) {
    if($this->Curso_model->destroy($id, $token) ) {
      $this->session->set_flashdata('notice', 'Se ha borrado correctamente el curso');
    }else{
      $this->session->set_flashdata('error', 'No fue posible borrar correctamente el curso');
    }
    redirect('cursos');
  }


  protected function formValidations() {
		$this->form_validation->set_rules('anio', 'año', 'required|numeric|trim');
		$this->form_validation->set_rules('paralelo_id', 'paralelo', 'required');
  }
}

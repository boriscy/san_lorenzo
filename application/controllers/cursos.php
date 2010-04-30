<?php
include_once('base.php');

class Cursos extends Base
{

  /**
   * Constructor
   */
  public function __construct() {
    parent::Controller();
    $this->load->model('Curso_model');
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
    $data['materias'] = $this->Materia_model->getAll();

    $data['template'] = 'materias/index';
    $this->load->view('layouts/application', $data);
  }

  /**
   * create
   */
  public function create() {
    $this->formValidations();
    if(isset($_POST['nombre']) && $this->form_validation->run() == TRUE) {
      $this->Materia_model->create($_POST);
      redirect('/materias');
    }else{
      if(isset($_POST['nombre']) )
        $this->session->set_flashdata('error', 'Existen errores en le formulario');
      $data['template'] = 'materias/create';
      $this->load->view('layouts/application', $data);
    }
  }

  /**
   * edit
   */
  public function edit($id) {

    $data['vals'] = $this->Materia_model->getId($id);
    $data['template'] = 'materias/edit';
    $this->load->view('layouts/application', $data);
  }

  /**
   * update
   */
  public function update() {

    $this->formValidations();
    if($this->form_validation->run() == TRUE) {
      $this->Materia_model->update($_POST); 
      $this->session->set_flashdata('notice', 'Se actualizo correctamente la materia');
      redirect('/materias');
    }else{
      $this->session->set_flashdata('error', 'Existen errores en su formulario');
    }

    $data['vals'] = array();
    $data['template'] = 'materias/edit';
    $this->load->view('layouts/application', $data);
  }


  /**
   * destroy
   */
  public function destroy($id, $token) {
    if($this->Materia_model->destroy($id, $token) ) {
      $this->session->set_flashdata('notice', 'Se ha borrado correctamente la materia');
    }else{
      $this->session->set_flashdata('error', 'No fue posible borrar correctamente la materia');
    }
    redirect('materias');
  }


  protected function formValidations() {
		$this->form_validation->set_rules('nombre', 'nombre', 'required|trim');
		$this->form_validation->set_rules('codigo', 'código', 'required|callback_unique_codigo|trim');
  }

  function unique_codigo($str) {
    $this->form_validation->set_message('unique_codigo', 'El código de la materia debe ser único');
    return $this->Materia_model->uniquenessOfField('codigo', $str);
  }
}

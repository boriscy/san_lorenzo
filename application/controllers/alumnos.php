<?php
include_once('base.php');

class Alumnos extends Base
{

  /**
   * Constructor
   */
  public function __construct() {
    parent::Controller();
    $this->load->model('Alumno_model');
    // Credenciales para el controlador
    $this->credentials = array(
      'index' => array('admin', 'adm'),
      'edit' => array('admin', 'adm'),
      'create' => array('admin', 'adm'),
      'update' => array('admin', 'adm'),
      'destroy' => array('admin', 'amd')
    );

    $this->checkCredentials();
  }

  /**
   * index
   */
  public function index() {
    $data['alumnos'] = $this->Alumno_model->getAll();

    $data['template'] = 'alumnos/index';
    $this->load->view('layouts/application', $data);
  }

  /**
   * create
   */
  public function create() {
    $this->formValidations();
    if(count($_POST) > 0 && $this->form_validation->run() == TRUE) {
      $this->Alumno_model->create($_POST);
      $this->session->set_flashdata('notice', 'El alumno fue creado exitosamente');
      redirect('/alumnos');
    }else{
      if(isset($_POST['nombre']) )
        $this->session->set_flashdata('error', 'Existen errores en le formulario');
      $data['template'] = 'alumnos/create';
      $this->load->view('layouts/application', $data);
    }
  }

  /**
   * edit
   */
  public function edit($id) {

    $data['vals'] = $this->Alumno_model->getId($id);
    $data['template'] = 'alumnos/edit';
    $this->load->view('layouts/application', $data);
  }

  /**
   * update
   */
  public function update() {

    $this->formValidations();
    if($this->form_validation->run() == TRUE) {
      $this->Alumno_model->update($_POST); 
      $this->session->set_flashdata('notice', 'Se actualizo correctamente el alumno');
      redirect('/alumnos');
    }else{
      $this->session->set_flashdata('error', 'Existen errores en su formulario');
    }

    $data['vals'] = array();
    $data['template'] = 'alumnos/edit';
    $this->load->view('layouts/application', $data);
  }


  /**
   * destroy
   */
  public function destroy($id, $token) {
    if($this->Alumno_model->destroy($id, $token) ) {
      $this->session->set_flashdata('notice', 'Se ha borrado correctamente la alumno');
    }else{
      $this->session->set_flashdata('error', 'No fue posible borrar correctamente el alumno');
    }
    redirect('alumnos');
  }

  protected function formValidations() {
		$this->form_validation->set_rules('primer_nombre', 'primer nombre', 'required|trim');
		$this->form_validation->set_rules('paterno', 'paterno', 'required|trim');
		$this->form_validation->set_rules('codigo', 'código', 'required|trim');
		$this->form_validation->set_rules('sexo', 'sexo', 'required|trim');
  }
}


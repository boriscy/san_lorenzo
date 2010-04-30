<?php
include_once('base.php');

class Paralelos extends Base
{

  /**
   * Constructor
   */
  public function __construct() {
    parent::Controller();
    $this->load->model('Paralelo_model');
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
    $data['paralelos'] = $this->Paralelo_model->getAll();

    $data['template'] = 'paralelos/index';
    $this->load->view('layouts/application', $data);
  }

  /**
   * create
   */
  public function create() {
    $this->formValidations();
    if(isset($_POST['curso']) && $this->form_validation->run() == TRUE) {
      $this->Paralelo_model->create($_POST);
      redirect('/paralelos');
    }else{
      if(isset($_POST['nombre']) )
        $this->session->set_flashdata('error', 'Existen errores en le formulario');
      $data['template'] = 'paralelos/create';
      $this->load->view('layouts/application', $data);
    }
  }

  /**
   * edit
   */
  public function edit($id) {

    $data['vals'] = $this->Paralelo_model->getId($id);
    $data['template'] = 'paralelos/edit';
    $this->load->view('layouts/application', $data);
  }

  /**
   * update
   */
  public function update() {

    $this->formValidations();
    if($this->form_validation->run() == TRUE) {
      $this->Paralelo_model->update($_POST); 
      $this->session->set_flashdata('notice', 'Se actualizo correctamente el paralelo');
      redirect('/paralelos');
    }else{
      $this->session->set_flashdata('error', 'Existen errores en su formulario');
    }

    $data['vals'] = array();
    $data['template'] = 'paralelos/edit';
    $this->load->view('layouts/application', $data);
  }


  /**
   * destroy
   */
  public function destroy($id, $token) {
    if($this->Paralelo_model->destroy($id, $token) ) {
      $this->session->set_flashdata('notice', 'Se ha borrado correctamente la paralelo');
    }else{
      $this->session->set_flashdata('error', 'No fue posible borrar correctamente el paralelo');
    }
    redirect('paralelos');
  }

  protected function formValidations() {
		$this->form_validation->set_rules('curso', 'curso', 'required|trim');
		$this->form_validation->set_rules('nivel', 'nivel', 'required|trim');
		$this->form_validation->set_rules('paralelo', 'paralelo', 'required|trim');
  }
}

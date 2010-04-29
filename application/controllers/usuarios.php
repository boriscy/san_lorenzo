<?php
include_once('base.php');

class Usuarios extends Base {

  public function __construct() {
    parent::Controller();
    $this->load->model('Usuario_model');
    // Credenciales para el controlador
    $this->credentials = array(
      'index' => array('admin'),
      'edit' => array('admin'),
      'create' => array('admin'),
      'update' => array('admin'),
    );

    $this->checkCredentials();
  }

  public function index() {
    $data['usuarios'] = $this->Usuario_model->getAll();

    $data['template'] = 'usuarios/index';
    $this->load->view('layouts/application', $data);
  }

  public function create() {

    $this->formValidationsCreate();
    if(isset($_POST) && $this->form_validation->run() == TRUE) {
      $this->Usuario_model->create($_POST);
      redirect('/usuarios');
    }else{
      if(isset($_POST['lgin']) )
        $this->session->set_flashdata('error', 'Existen errores en le formulario');
      $data['template'] = 'usuarios/create';
      $this->load->view('layouts/application', $data);
    }
  }

  public function update() {

    $this->formValidationsUpdate();
    if(isset($_POST) && $this->form_validation->run() == TRUE) {
      if($this->Usuario_model->update($_POST)) {
        redirect('/usuarios');
      }else{
      }
    }else{
    }
  }

  public function edit($id) {

    $data['vals'] = $this->Usuario_model->getId($id);
    $data['template'] = 'usuarios/edit';
    $this->load->view('layouts/application', $data);
  }



  /**
   * Set all form validations or run defined
   * @param $validations
   */
  protected function formValidationsCreate($validations = array()) {
    $this->formValidationsUpdate();
		$this->form_validation->set_rules('login', 'usuario', 'required|callback_unique_login');
		$this->form_validation->set_rules('password', 'contraseña', 'required|matches[password_confirmation]|md5');
		$this->form_validation->set_rules('password_confirmation', 'confirmación de contraseña', 'required');
  }

  protected function formValidationsUpdate() {
    $this->form_validation->set_rules('primer_nombre', ' ', 'trim|required');
    $this->form_validation->set_rules('paterno', ' ', 'trim|required');
		$this->form_validation->set_rules('email', 'Email', 'required');
  }

  function unique_login($str) {
    $this->form_validation->set_message('unique_login', 'su nombre de usuario debe ser único');
    return $this->Usuario_model->uniquenessOfField('login', $str);
  }



}

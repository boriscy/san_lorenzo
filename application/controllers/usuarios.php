<?php
include_once('base.php');

class Usuarios extends Base {

  /**
   * Constructor
   */
  public function __construct() {
    parent::Controller();
    $this->load->model('Usuario_model');
    $this->load->model('Materia_model');
    // Credenciales para el controlador
    $this->credentials = array(
      'index' => array('admin'),
      'edit' => array('admin'),
      'create' => array('admin'),
      'update' => array('admin'),
    );

    $this->checkCredentials();
  }

  /**
   * index
   */
  public function index() {
    $data['usuarios'] = $this->Usuario_model->getAll();

    $data['template'] = 'usuarios/index';
    $this->load->view('layouts/application', $data);
  }

  /**
   * create
   */
  public function create() {

    $data['materias'] = $this->Materia_model->getAll();

    $this->formValidationsCreate();
    if(isset($_POST) && $this->form_validation->run() == TRUE) {
      $this->Usuario_model->create($_POST);
      $this->session->set_flashdata('notice', 'Se ha creado el usuario');
      redirect('/usuarios');
    }else{
      if(isset($_POST['login']) )
        $this->session->set_flashdata('error', 'Existen errores en le formulario');
      $data['template'] = 'usuarios/create';
      $this->load->view('layouts/application', $data);
    }
  }

  /**
   * update
   */
  public function update() {

    $this->formValidationsUpdate();
    if($this->form_validation->run() == TRUE) {
      $this->Usuario_model->update($_POST);
      $this->session->set_flashdata('notice', 'Se actualizo el usuario correctamente');
      redirect('/usuarios');
    }else{
      $this->session->set_flashdata('error', 'Existen errores en le formulario');
    }

    $data['materias'] = $this->Materia_model->getAll();
    $data['vals'] = $_POST;
    $data['template'] = 'usuarios/edit';
    $this->load->view('layouts/application', $data);
  }


  /**
   * edit
   */
  public function edit($id) {
    $data['materias'] = $this->Materia_model->getAll();

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
		$this->form_validation->set_rules('login', 'usuario', 'required|alpha_numeric|max_length[30]|callback_unique_login');
		$this->form_validation->set_rules('password', 'contraseña', 'required|matches[password_confirmation]|min_length[6]|md5');
		$this->form_validation->set_rules('password_confirmation', 'confirmación de contraseña', 'required');
  }

  protected function formValidationsUpdate() {
    $this->form_validation->set_rules('tipo', ' ', 'trim|required');
    $this->form_validation->set_rules('primer_nombre', ' ', 'trim|required');
    $this->form_validation->set_rules('paterno', ' ', 'trim|required');
		$this->form_validation->set_rules('email', 'Email', 'required');
  }

  /**
   * callback para validación
   */
  function unique_login($str) {
    $this->form_validation->set_message('unique_login', 'su nombre de usuario debe ser único');
    return $this->Usuario_model->uniquenessOfField('login', $str);
  }



}

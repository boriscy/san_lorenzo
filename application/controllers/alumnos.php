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
      'destroy' => array('admin', 'amd'),
      'import' => array('admin', 'amd')
    );

    $this->checkCredentials();
  }

  /**
   * index
   */
  public function index($offset=0) {
    $this->load->library('pagination');

    $config['base_url'] = site_url(). '/alumnos/index';
    $config['total_rows'] = $this->Alumno_model->countRows();

    $this->pagination->initialize($config);

    $data['alumnos'] = $this->Alumno_model->getAll(array('offset' => $offset, 'limit' => 30, 'order' => 'primer_nombre, segundo_nombre, paterno, materno'));
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

  /**
   * importar
   */
  public function import() {
    $config = array(
      'upload_path' => './system/excel/alumnos',
      'allowed_types' => 'xls'
      );

    $this->load->library('upload', $config);

    if(!$this->upload->do_upload('alumnos_excel') ) {
      echo $this->upload->display_errors();
    }else{
      $params = $this->upload->data();
      $file_name = $params['file_name'];
      $errors = $this->Alumno_model->import($file_name);
    }
  }

  protected function formValidations() {
		$this->form_validation->set_rules('primer_nombre', 'primer nombre', 'required|trim');
		$this->form_validation->set_rules('paterno', 'paterno', 'required|trim');
		$this->form_validation->set_rules('codigo', 'código', 'required|trim');
		$this->form_validation->set_rules('sexo', 'sexo', 'required|trim');
  }
}


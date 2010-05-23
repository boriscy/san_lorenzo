<?php 
include_once('base.php');

class Padres extends Base
{
  public function __construct() {
    parent::__construct();
    $this->load->model('Padre_model');

    $this->credentals = array(
      'index' => array('admin'),
      'index' => array('edit'),
      'index' => array('create'),
      'index' => array('update'),
      'index' => array('destroy'),
      );
  }

  public function index($offset = 0) {
    $this->load->library('pagination');

    $config['base_url'] = site_url(). '/padres/index';
    $config['total_rows'] = $this->Padre_model->countRows();

    $this->pagination->initialize($config);

    $data['padres'] = $this->Padre_model->getAll(array(
      'offset' => $offset, 'limit' => 30, 'order' => 'primer_nombre, segundo_nombre, paterno, materno'
      ) );

    $data['padres_list'] = $this->Padre_model->getList( array( 'labelField' => 'primer_nombre, segundo_nombre, paterno, materno') );
    
    $data['template'] = 'padres/index';
    $this->load->view('layouts/application', $data);
  }

 /**
   * create
   */
  public function create() {
    $this->formValidations();
    if(count($_POST) > 0 && $this->form_validation->run() == TRUE) {
      $this->Padre_model->create($_POST);
      $this->session->set_flashdata('notice', 'El padre de familia fue creado exitosamente');
      redirect('/padres');
    }else{
      if(isset($_POST['primer_nombre']) )
        $this->session->set_flashdata('error', 'Existen errores en le formulario');
      $data['template'] = 'padres/create';
      $this->load->view('layouts/application', $data);
    }
  }

  /**
   * edit
   */
  public function edit($id) {

    $data['vals'] = $this->Padre_model->getId($id);
    $data['template'] = 'padres/edit';
    $this->load->view('layouts/application', $data);
  }

  protected function formValidations() {
		$this->form_validation->set_rules('primer_nombre', 'primer nombre', 'required|trim');
		$this->form_validation->set_rules('paterno', 'paterno', 'required|trim');
		$this->form_validation->set_rules('num_dc', 'número de documento', 'required|trim');
		$this->form_validation->set_rules('password', 'contraseña', 'required|min_size[6]|trim');
  }

  /**
   * callback para validación
   */
  function unique_login($str) {
    $this->form_validation->set_message('unique_login', 'el login debe ser único');
    return $this->Usuario_model->uniquenessOfField('login', $str);
  }

}

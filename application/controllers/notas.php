<?php
include_once('base.php');

class Notas extends Base
{ 

  public function __construct() {
    parent::Controller();
    $this->load->model('Paralelo_model');
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

    $data['template'] = 'notas/import';
    $this->load->view('layouts/application', $data);
  }

  function importar() {
    $config = array(
      'upload_paht' => './excel',
      'allowed_types' => 'xls'
      );

    $this->load->library('upload', $config);
    include_once('system/application/libraries/excel_reader2.php');

    if(!$this->upload->do_upload() ) {
      echo "Error";
    }else{
    }
  }
}

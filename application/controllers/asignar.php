<?php
include_once('base.php');

class Asignar extends Base
{
  /**
   * Constructor
   */
  public function __construct() {
    parent::Controller();
    $this->load->model('Curso_model');
    $this->load->model('Paralelo_model');
    $this->load->model('Alumno_model');
    // Credenciales para el controlador
    $this->credentials = array(
      'curso' => array('admin', 'adm'),
    );

    $this->checkCredentials();
  }

  public function curso($id) {
    $data['curso'] = $this->Curso_model->getId($id);
    $data['paralelo'] = $this->Paralelo_model->getId($data['curso']['paralelo_id']);
    $data['alumnos_list'] = $this->Alumno_model->getList(array(
      'labelField' => 'primer_nombre, segundo_nombre, paterno, materno',
      'order' => 'primer_nombre, segundo_nombre, paterno, materno ASC'
      )
    );
    $data['alumnos'] = $this->Curso_model->alumnos($id);

    $data['template'] = 'asignar/curso';
    $this->load->view('layouts/application', $data);
  }

}

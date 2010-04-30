<?php
include_once('base_model.php');

class Alumno_model extends Base_model
{
  /**
   * Constructor donde se define la tabla y los campos
   */
  function __construct() {
    parent::__construct('alumnos');
    $this->fields = array('primer_nombre', 'segundo_nombre', 
      'paterno', 'materno', 'codigo', 'tipo', 'sexo', 'codrude',
      'activo', 'num_doc', 'email');
  }

  static function nombreCompleto($res) {
    $names = array('primer_nombre', 'segundo_nombre', 'paterno', 'materno');
    $concat = array();
    foreach($names as $v) {
      if(trim($res->{$v}) != '')
        array_push($concat , $res->{$v});
    }
    return join(' ', $concat);
  }

}


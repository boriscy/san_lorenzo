<?php
include_once('base_model.php');

class Padre_model extends Base_model
{
  public function __construct() {
    parent::__construct('padres');
    $this->fields = array('primer_nombre', 'segundo_nombre', 
      'paterno', 'materno', 'codigo', 'password', 'email');
  }
}

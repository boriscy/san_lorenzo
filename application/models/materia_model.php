<?php
include_once('base_model.php');

class Materia_model extends Base_model
{
  /**
   * Constructor donde se define la tabla y los campos
   */
  function __construct() {
    parent::__construct('materias');
    $this->fields = array('nombre', 'sigla', 'codigo');
  }

}

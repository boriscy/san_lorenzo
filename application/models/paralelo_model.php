<?php
include_once('base_model.php');

class Paralelo_model extends Base_model
{
  /**
   * Constructor donde se define la tabla y los campos
   */
  function __construct() {
    parent::__construct('paralelos');
    $this->fields = array('curso', 'nivel', 'paralelo');
  }

}

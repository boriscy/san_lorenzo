<?php
include_once('base_model.php');

class Usuario_model extends Base_model
{
  /**
   * Constructor donde se define la tabla y los campos
   */
  function __construct() {
    parent::__construct('usuarios');
    $this->fields = array('primer_nombre', 'segundo_nombre',
      'paterno', 'materno', 'login', 'password', 'email', 'tipo');
  }

  /**
   * Compara el password
   * @param string
   * @param string
   * @return boolean
   */
  function login($login, $password) {
    $password = md5($password);
    $q = $this->db->get_where($this->table, array('login' => $login, 'password' => $password), 1, 0);
    return $q->num_rows() == 1;
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

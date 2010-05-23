<?php
include_once('base_model.php');

class Usuario_model extends Base_model
{
  public $tipos = array('admin' => 'Administrador',
//      'adm' => 'Administrativo',
//      'director' => 'Director',
        'profe' => 'Profesor'
    );
  /**
   * Constructor donde se define la tabla y los campos
   */
  function __construct() {
    parent::__construct('usuarios');
    $this->fields = array('primer_nombre', 'segundo_nombre',
      'paterno', 'materno', 'login', 'password', 'email', 'tipo');
  }

  /**
   * Recupera todos los datos necesarios de un usuario
   * @param $id
   * @return array
   */
  public function getId($id) {
    $ret = parent::getId($id);
    $materias = $this->db->get_where('materias_usuarios', array('usuario_id' => $ret['id']) );
    $materias = $materias->result_array();
    $ret['materias'] = array();
    foreach($materias as $k => $v)
      $ret['materias'][] = $v['materia_id'];
    return $ret;
  }

  /**
   * Compara el password
   * @param string
   * @param string
   * @return boolean
   */
  public function login($login, $password) {
    $password = md5($password);
    $q = $this->db->get_where($this->table, array('login' => $login, 'password' => $password), 1, 0);
    return $q->num_rows() == 1;
  }

  /**
   * Creacion de un nuevo usuario
   */
  public function create($params) {
    $this->db->trans_start();
    $id = parent::create($params);
    if(isset($params['materia'])) {
      foreach($params['materias'] as $val) {
        $this->db->insert('materias_usuarios', array(
          'materia_id' => $val, 
          'usuario_id' => $id
          ) 
        );
      }
    }
    $this->db->trans_complete();
  }

  /**
   * Actualización de usuario
   */
  public function update($params) {
    $this->db->trans_start();
    parent::update($params);
    $id = $params['id'];
    $this->db->query("DELETE FROM materias_usuarios WHERE usuario_id=$id");

    if(isset($params['materias'])) {
      foreach($params['materias'] as $val) {
        $this->db->insert('materias_usuarios', array(
          'materia_id' => $val, 
          'usuario_id' => $id
          ) 
        );
      }
    }
    $this->db->trans_complete();
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

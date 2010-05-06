<?php
class Base_model extends Model
{
  protected $table;
  protected $fields;
  /**
   * Constructor
   * @param String $table
   */
  function __construct($table) {
    parent::Model();
    $this->table = $table;
  }

  /**
   * Carga un modelo
   * @param string
   * @return Model
   */
  function loadModel($model) {
    $mod = strtolower($model);
    $file = dirname(__FILE__) .'/'. "{$mod}.php";
    require_once($file);
    return new $model();
  }

  /**
   * Intersecta los valores de $this->fields con los de los parametros cuando se realiza un create update
   */
  function intersectFields($params) {
    $fields = array();
    if(!is_array($this->fields) || count($this->fields) <= 0)
      trigger_error('You must set the $this->fields variable in '.$this->_parent_name.' model');
    foreach($this->fields as $v) {
      if(isset($params[$v]))
        $fields[$v] = $params[$v];
    }
    return $fields;
  }

  /**
   * Retorna toddos los items
   */
  function getAll($options = array()) {
    $options = $this->setOptions($options);
    $sql = "SELECT * FROM {$this->table} {$options['conditions']} {$options['order']} {$options['limit']}";
    $q = $this->db->query($sql);
    return $q;
  }

  /**
   *
   */
  function setOptions($options) {
    // ORDER
    if(isset($options['order']) ) {
      $options['order'] = 'ORDER BY ' . $options['order'];
    }else {
      $options['order'] = '';
    }
    // WHERE
    if(isset($options['conditions']) ) {
      $options['conditions'] = 'WHERE ' . $options['conditions'];
    }else {
      $options['conditions'] = '';
    }
    // LIMIT
    if(isset($options['limit'])) {
      $offset = 0;
      if(isset($options['offset']))
        $offset = $options['offset'];
      $options['limit'] = "LIMIT $offset, {$options['limit']}";
    }else {
      $options['limit'] = '';
    }

    return $options;
  }

  /**
   * Retorna un registro especifico por id
   */
  function getId($id) {
    $q = $this->db->get_where($this->table, array('id' => $id), 1, 0);
    return $q->row_array();
  }

  /**
   * Creates a list for the
   * The array must be the way
   * array(
   *  'labelField' => 'label',
   *  'valueField' => 'field',
   *  'order' => 'order',
   *  'considitons' => 'coditions'
   * )
   * @param array
   * @return array
   */
  function getList($options) {
    $default = array(
      'order' => '',
      'conditions' => '',
      'valueField' => 'id'
    );
    $options = array_merge($default, $options);
    if(!isset($options['labelField']) || !isset($options['valueField'])) {
      echo "You must set the labelField and the valueField for getting a list";
    }

    if($options['conditions'] != '')
      $options['conditions'] = " WHERE ".$options['conditions'];
    if($options['order'] != '')
      $options['order'] = "ORDER BY ".$options['order'];

    $query = "SELECT {$options['valueField']}, {$options['labelField']} FROM {$this->table} {$options['conditions']} {$options['order']}";
    $q = $this->db->query($query);
    $ret = array();
    if(preg_match('/,/', $options['labelField']) ) {
      $labels = preg_split('/,/', $options['labelField']);
      foreach($labels as $k => $v) {
        $labels[$k] = trim($v);
      }
    }

    foreach($q->result() as $row) {
      if(isset($labels)) {
        $arr = array();
        foreach($labels as $v) {
          array_push($arr, $row->{$v});
        }
        $ret[$row->{$options['valueField']}] = join($arr, ' ');
      }else{
        $ret[$row->{$options['valueField']}] = $row->{$options['labelField']};
      }
    }

    return $ret;
  }

  /**
   * Finds one record with just a and value
   */
  function findByField($field,$value, $limit=1, $offset=0) {
    $q = $this->db->get_where($this->table, array($field => $value), $limit, $offset);
    if($limit == 1) {
      return $q->row();
    }else{
      return $q;
    }
  }


  /**
   * Verigfica que el campo sea unico
   */
  function uniquenessOfField($field, $val) {
    $sql = "SELECT * FROM {$this->table} WHERE {$field}='$val'";
    if(isset($_POST['id'])){
      $id = intval($_POST['id']);
      $sql.= " AND id<>$id";
    }

    $q = $this->db->query($sql);
    return !($q->num_rows() > 0);
  }

  /**
   * Crea un nuevo item
   * @param array
   */
  function create($params) {
    $params = $this->intersectFields($params);
    $this->db->insert($this->table, $params);
    return $this->db->insert_id();
  }

  /**
   * Actualiza un item
   * @param array
   */
  function update($params) {
    $this->db->where('id', $params['id']);
    unset($params['id']);
    $params = $this->intersectFields($params);
    return $this->db->update($this->table, $params);
  }

  /**
   * Borra un item
   * @param string
   * @param string
   * @return mixed
   */
  function destroy($id, $token) {
    if( $this->session->userdata('token') == $token ){
      $this->db->where('id', $id);
      return $this->db->delete($this->table);
    }else{
      return false;
    }
  }

  /**
   * Cuenta el numero de filas
   */
  function countRows($options = array()) {
    unset($options['limit']);
    unset($options['offset']);
    $options = $this->setOptions($options);
    $q = $this->db->query("SELECT COUNT(*) AS total FROM {$this->table} {$options['conditions']}");
    return $q->row()->total;
  }

}

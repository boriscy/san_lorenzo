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
  function getAll() {
    $q = $this->db->get($this->table);
    return $q;
  }

  /**
   * Retorna un registro especifico por id
   */
  function getId($id) {
    $q = $this->db->get_where($this->table, array('id' => $id), 1, 0);
    return $q->row_array();
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
  function uniquenessOfField($field, $val){
    $q = $this->db->query("SELECT * FROM {$this->table} WHERE {$field}='$val'");
    return !($q->num_rows() > 0);
  }

  /**
   * Crea un nuevo item
   */
  function create($params) {
    $params = $this->intersectFields($params);
    $this->db->insert($this->table, $params);
  }
}

<?php
include_once('base_model.php');

class Curso_model extends Base_model
{
  /**
   * Constructor donde se define la tabla y los campos
   */
  function __construct() {
    parent::__construct('cursos');
    $this->fields = array('usuario_id', 'materia_id', 'paralelo_id',
      'anio', 'activo', 'alumnos');
  }

  /**
   * Necesario para poder obtener
   */
  public function getAll() {
    $sql = "SELECT  c.*, CONCAT(u.primer_nombre,' ', u.segundo_nombre, ' ', u.paterno, ' ', u.materno) AS nombre_completo,
      m.nombre AS materia, 
      CONCAT(p.nivel, ' ', p.curso, ' ', p.paralelo) AS paralelo FROM cursos c 
      JOIN usuarios u ON (c.usuario_id=u.id)
      JOIN materias m ON (c.materia_id=m.id)
      JOIN paralelos p ON (c.paralelo_id=p.id)";
    $q = $this->db->query($sql);
    return $q;
  }

  /**
   * Funcion que permite obtener todos los alumnos
   */
  public function alumnos($id) {
    $sql = "SELECT CONCAT(a.primer_nombre,' ', a.segundo_nombre, ' ', a.paterno, ' ', a.materno) AS alumno, 
      a.sexo, a.codigo, a.id
      FROM cursos c JOIN alumnos_cursos ac ON (c.id=ac.curso_id)
      JOIN alumnos a ON (a.id=ac.alumno_id) WHERE c.id=$id 
      ORDER BY a.paterno, a.materno, a.primer_nombre, a.segundo_nombre";

    return $this->db->query($sql);
  }

  /**
   * Inserta los alumnos de un curso
   */
  public function asignarAlumnos($params) {
    $id = $params['id'];
    $sql = "INSERT INTO alumnos_cursos (curso_id, alumno_id) VALUES ";
    $sql_array = array();
    $count = count($params['alumnos']);
    foreach($params['alumnos'] as $k => $v) {
      array_push($sql_array, "($id, $v)");
    }
    $sql.= join($sql_array,",");

    $this->db->trans_start();

    $this->db->query("DELETE FROM alumnos_cursos WHERE curso_id=$id");
    $this->db->query($sql);
    $this->db->query("UPDATE cursos SET alumnos=$count WHERE id=$id");

    $this->db->trans_complete();
  }
}


<?php
include_once('base_model.php');

class Alumno_model extends Base_model
{

  public $columnas = array(
    'codigo' => 1,
    'paterno' => 2, 
    'materno' => 3, 
    'primer_nombre' => 4, 
    'segundo_nombre' => 5,
    'curso'  => 6,
    'tipo' => 7, 
    'num_doc' => 9,
    'codrude' => 14,
    'sexo' => 15 
  );
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

  /**
   * Importa la nomina de estudiantes desde una hoja excel
   */
  public function import($archivo) {
    include_once('system/application/libraries/excel_reader2.php');
    $excel = new Spreadsheet_Excel_Reader("system/excel/alumnos/{$archivo}");
    $i = 2;
    $this->db->trans_start();
    while(intval($excel->val($i, 1))) {
      $codigo = intval($excel->val($i, 1));
      $arr = array();
      foreach($this->columnas as $col => $pos) {
        $arr[$col] = $excel->val($i, $pos);
      }
      $arr['sexo'] = intval($arr['sexo']) == 1 ? 'M': 'F';

      if($alumno = $this->alumnoExiste($codigo)) {
        // Actualizar
        $arr['id'] = $alumno['id'];
        $this->update($arr);
      }else{
        // Crear
        $this->create($arr);
      }
      $i++;
    }
    $this->db->trans_complete();
  }

  /**
   * Revisa si existe un alumno basado en su codigo
   * @param string
   * @return $arr
   */
  private function alumnoExiste($codigo) {
    $q = $this->db->query("SELECT * FROM alumnos WHERE codigo=$codigo");
    if($q->num_rows() > 0) {
      return $q->row_array();
    }else{
      return false;
    }
  }

}


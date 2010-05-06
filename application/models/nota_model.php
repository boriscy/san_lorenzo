<?php
include_once('base_model.php');

class Nota_model extends Base_model
{
  public $tipos = array('admin' => 'Administrador',
      'adm' => 'Administrativo',
      'director' => 'Director',
      'profe' => 'Profesor',
    );
  // Lista de errores que se originan al procesar la importación de notas
  public $errors; 
  // Periodos del colegio, donde la llave (key) es el periodo y (val) es la posicion en la hoja excel
  public $columnas = array(
      3 => 'n1', 4 => 'd1', 5 => 'n2', 6 => 'd2', 7 => 'tr1',
      8 => 'n3', 9 => 'd3', 10 => 'n4', 11 => 'd4', 12 => 'tr2',
      13 => 'n5', 14 => 'd5', 15 => 'n6', 16 => 'd6', 17 => 'tr3',
      18 => 'pa', 19 => 'rf', 20 => 'pf', 21 => 'pg'
    );

  // Utilizado como fecha para poder revisar las modificaciones
  public $creado_en;
  /**
   * Constructor donde se define la tabla y los campos
   */
  function __construct() {
    parent::__construct('notas');
    $this->fields = array('alumno_id', 'materia_id', 'anio', 
      'notas', 'notas_profesor' // Campos serializados en JSON
    );
  }

  /**
   *
   */
  function alumnos() {
    return $this->loadModel('Alumno_model')->getList(array('labelField' => 'id', 'valueField' => 'codigo'));
    //return $alumno->getList(array('labelField' => 'id', 'valueField' => 'codigo'));
  }

  /**
   * Realiza la inserción o actualización de notas de un estudiante
   * @param string
   * @param integer
   */
  function insertUpdateNotas($archivo, $anio) {
    include_once('system/application/libraries/excel_reader2.php');
    $excel = new Spreadsheet_Excel_Reader("system/excel/notas/{$archivo}");

    $alumnos = $this->loadModel('Alumno_model')->getList(array('labelField' => 'id', 'valueField' => 'codigo'));
    $materias = $this->loadModel('Materia_model')->getList(array('labelField' => 'id', 'valueField' => 'nombre'));

    $i = 2;
    $this->errors = array();

    $this->db->trans_start();
    while(trim( $excel->val($i, 1) ) != '') {

      $codigo = trim($excel->val($i, 1));
      if(!isset($alumnos[$codigo])) {
        array_push( $this->errors, "No existe un alumno con código \"{$codigo}\" fila $i del archivo excel");
        $i++;
        continue;
      }
      $alumno_id = $alumnos[$codigo];

      $materia_nombre = trim($excel->val($i, 2));
      if(!isset($materias[$materia_nombre])) {
        array_push($this->errors, "No existe la materia \"{$materia_nombre}\" en la fila $i del archivo excel" );
        $i++;
        continue;
      }
      $materia_id = $materias[$materia_nombre];
      $this->setNota($alumno_id, $materia_id, $excel, $anio, $i);
      $i++;
    }
    $this->db->trans_complete();

    return $this->errors;
  }

  /**
   * Crea o actualiza la nota del alumno
   * @param integer
   * @param integer
   * @param excel
   * @param integer
   * @param integer
   */
  private function setNota($alumno_id, $materia_id, &$excel, $anio, $i) {
echo $alumno_id.':'.$materia_id,'<br/>';
    $notas = array();
    foreach($this->columnas as $pos => $columna) {
      $nota = intval($excel->val($i, $pos) );
      if($nota > 100 || $nota < 0) {
        array_push($this->errors, "Error en fila $i, la nota \"$nota\" tiene un valor no permitido");
        return false;
      }
      $notas[$columna] = $nota;
    }

    $notasBD = $this->getNotas($alumno_id, $materia_id, $anio);

    if($notasBD == false) {
      // Crear
      $this->create(array(
          'alumno_id' => $alumno_id,
          'materia_id' => $materia_id,
          'anio' => $anio,
          'notas' => json_encode($notas), // Serializadión de notas en JSON
          'creado' => date("Y-m-d H:i:s"),
          'actualizado' => date("Y-m-d H:i:s")
        )
      );
    }else {
      $id = $notasBD['id'];
      // Actualizar
      $this->update(array(
          'id' => $id,
          'notas' => json_encode($notas), // Serializadión de notas en JSON
          'actualizado' => date("Y-m-d H:i:s")
        )
      );
    }
  }


  /**
   * Retorna las notas de un alumno
   * @param array
   * @param array
   * @param array
   * @return [array, false]
   */
  function getNotas($alumno_id, $materia_id, $anio) {
    $notasAlumnos[$alumno_id] = array();
    $arr = array();
    $notas = $this->db->query("SELECT * FROM notas WHERE alumno_id=$alumno_id AND materia_id=$materia_id AND anio=$anio");

    if($notas->num_rows <= 0) {
      return false;
    }else {
      return $notas->row_array();
    }
  }

}

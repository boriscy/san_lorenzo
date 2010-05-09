<?php
/**
 * Clase principal en la cual se definen metodos que todos los controladores usaran
 */
class Base extends Controller
{
  function __construct() {
    parent::Controller();
  }


  // Variable que almacena las credenciales de la siguiente forma
  // $credentials['index'] = array('admin', 'profe', 'editor'); // 'admin', 'profe' y 'editor' tienen permiso
  // $credentials['edit'] = array('admin'); # Solo el administrador tiene permiso
  protected $credentials;
  /**
   * Retorna el controlador y la acción
   * @return array
   */
  protected function getUri() {
    $arr = array();
    foreach($this->uri->rsegments as $v) {
      array_push($arr, $v);
    }
    return array($arr[0], $arr[1]);
  }

  /**
   * Funcion principal para los permisos
   */
  protected function checkCredentials() {
    if(!$this->session->userdata('usuario_id')) {
      redirect("/login");
    }else{
      list($controller, $action) = $this->getUri();

      if(!isset($this->credentials[$action])) {
        die("Error: you did not set credentals in your controller for \"$action\"");
      }
      if( !in_array($this->session->userdata('usuario_tipo'), $this->credentials[$action] ) ) {
        $this->session->set_flashdata('warning', 'Usted no tiene permiso para acceder esta área');
        redirect("/login/access");
      }
    }
  }
}

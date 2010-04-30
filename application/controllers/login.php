<?php
class Login extends Controller
{

  public function __construct() {
    parent::Controller();
    $this->load->model('Usuario_model');
  }

  /**
   * Funcion para loguearse
   */
  function index() {
    if($this->session->userdata('usuario_id') ) {
      redirect("/login/access");
    }

    if(isset($_POST['login']) && isset($_POST['password']) ) {
      if($this->Usuario_model->login($_POST['login'], $_POST['password'])) {
        $usuario = $this->Usuario_model->findByField('login', $_POST['login']);
        $this->session->set_userdata( array(
          'usuario_nombre' => Usuario_model::nombreCompleto($usuario), 
          'usuario_id' => $usuario->id,
          'usuario_tipo' => $usuario->tipo, //Nivel de acceso
          'token' => md5(rand())// Necesario para seguridad
          )
        );
        $this->session->set_flashdata('notice', "Usted a ingresado correctamente");

        redirect("/login/access");
      }else{
        $this->session->set_flashdata('error', "Usted a ingresado un usuario o contraseña inválidos");
      }
    }
    $data['template'] = 'login/index';
    $this->load->view('layouts/application', $data);
  }

  /**
   * Funcion para desloguearse
   */
  function destroy() {
    $this->session->sess_destroy();
    redirect("/login");
  }

  /**
   * Funcion de acceso una ves logueado
   */
  function access() {
    if(!$this->session->userdata('usuario_id') ) {
      redirect("/login");
    }
    $data['template'] = 'login/access';
    $this->load->view('layouts/application', $data);
  }

}

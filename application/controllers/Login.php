<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('datosUsuario');
	}

	public function index()
	{
		if($this->session->userdata('correo')){
			redirect('Dashboard');
		}
		$info['titulo']="Iniciar Sesión";
		$this->load->view('Login',$info);
	}
	public function iniciarSesion(){
		$correo = $this->input->post('correo');
		$pwd = $this->input->post('pwd');
		$resultado = $this->datosUsuario->validarUsr($correo, $pwd);

		if($resultado){
			$this->session->set_userdata('correo',$correo);
			redirect('Dashboard');
		}else{
			$this->index();
		}
	}
	public function cerrarSesion(){
		$this->session->sess_destroy();
		redirect('Login');
	}
}

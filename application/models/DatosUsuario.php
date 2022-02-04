<?php
class datosUsuario extends CI_model{
    public function __construct(){
        parent::__construct();
        $this->load->database();
    }
    
    public function validarUsr($correo, $pwd){
        $this->db->where('correo',$correo);
        $this->db->where('pwd',$pwd);
        $resultado = $this->db->get('usuario');
    
        if($resultado->num_rows()>0){
			return true;
		}else{
			return false;
		}
    }

    public function registro($nombre, $correo, $pwd){
        return $this->db->insert('datos',['nombre'=>$nombre, 'pwd'=>$pwd, 'correo'=>$correo]);
    }

}
?>
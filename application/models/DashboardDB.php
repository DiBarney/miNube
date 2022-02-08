<?php
class DashboardDB extends CI_model{
    public function __construct(){
        parent::__construct();
        $this->load->database();
    }
    
    public function registroArchivo($nombre, $ruta, $tamano, $fecha){
        return $this->db->insert('archivo_cargado',['nombre'=>$nombre, 'ruta'=>$ruta, 'tamano'=>$tamano, 'fecha'=>$fecha]);
    }

    public function eliminarArchivo($id){
        return $this->db->query("DELETE FROM archivo_cargado WHERE id = '$id';");
    }

    public function devolverArchivos(){
        $consultaArchivos = $this->db->get('archivo_cargado');
        return $consultaArchivos->result_id;
    }

    public function devolverArchivo($id){
        $consultaArchivos = $this->db->query("SELECT * FROM archivo_cargado WHERE id = '$id';");
        return $consultaArchivos->result();
    }
}
?>
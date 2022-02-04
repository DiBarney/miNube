<?php
class DashboardDB extends CI_model{
    public function __construct(){
        parent::__construct();
        $this->load->database();
    }
    
    public function registroArchivo($nombre, $ruta, $tamano){
        return $this->db->insert('archivo_cargado',['nombre'=>$nombre, 'ruta'=>$ruta, 'tamano'=>$tamano]);
    }

    public function eliminarArchivo($nombre){
        return $this->db->query("DELETE FROM archivo_cargado WHERE nombre = '$nombre';");
    }

    public function devolverArchivos(){
        $consultaArchivos = $this->db->get('archivo_cargado');
        return $consultaArchivos->result_id;
    }
}
?>
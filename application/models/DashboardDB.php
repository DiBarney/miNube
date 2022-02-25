<?php
class DashboardDB extends CI_model{
    public function __construct(){
        parent::__construct();
        $this->load->database();
    }

    public function registroArchivoPre($tamano, $fecha, $tipo){
        return $this->db->insert('archivo_cargado',['tamano'=>$tamano, 'fecha'=>$fecha, 'tipo'=>$tipo]);
    }
    
    public function registroArchivo($nombre, $ruta, $tamano, $fecha, $tipo){
        return $this->db->insert('archivo_cargado',['nombre'=>$nombre, 'ruta'=>$ruta, 'tamano'=>$tamano, 'fecha'=>$fecha, 'tipo'=>$tipo]);
    }

    public function eliminarArchivo($nombreArchivo){
        return $this->db->query("DELETE FROM archivo_cargado WHERE nombre = '$nombreArchivo';");
    }

    public function modificarArchivo($id,$nombreEditado){
        return $this->db->query("UPDATE archivo_cargado SET nombre = '$nombreEditado' WHERE (id = '$id');");
    }

    public function devolverArchivos(){
        $consultaArchivos = $this->db->get('archivo_cargado');
        return $consultaArchivos->result_id;
    }

    public function devolverArchivosPre(){
        $consultaArchivos = $this->db->get('archivo_cargado');
        return $consultaArchivos;
    }

    public function devolverArchivosTipo($tipoUno, $tipoDos){
        $consultaArchivos = $this->db->query("SELECT * FROM archivo_cargado WHERE tipo='$tipoUno' OR tipo='$tipoDos';");
        return $consultaArchivos->result_id;
    }

    public function devolverArchivo($id){
        $consultaArchivos = $this->db->query("SELECT * FROM archivo_cargado WHERE id = '$id';");
        return $consultaArchivos->result();
    }
}
?>
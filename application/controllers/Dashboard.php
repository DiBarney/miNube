<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->model('DashboardDB');
    }

	public function index(){
        if($this->session->userdata('correo')){
            $cont['archivos'] = $this->mostrarArchivos();
            $this->load->view('Dashboard',$cont);
            // var_dump($this->mostrarArchivos());
        }else{
            redirect('Login');
        }
	}

    public function subirArchivo(){
        $directorio = "cargados/";

        foreach ($_FILES as $archivo) {
            $charReservados = [" ","!","#","$","%","&","'","(",")","*","+",",","/",":",";","=","?","@","[","]"];
            $nombre = $archivo['name'];
            foreach ($charReservados as $character) {
                $nombre = str_replace($character,"_",$nombre);
                echo $nombre;
            }

            $ruta = $directorio . $nombre;
            $tamanoKb = $archivo['size']*0.001;
            $fecha = date("d/m/Y");
            $tipoStr = $archivo['type'];
            $tipoStr = substr($tipoStr,0,strpos($tipoStr,"/"));

            switch($tipoStr){
                case 'image': $tipo = 1;
                break;
                case 'video': $tipo = 2;
                break;
                default : $tipo = 3;
            }

            if($tamanoKb>1024.0){
                $tamanoKb /= 1024.0;
                $tamano = number_format($tamanoKb,2);
                $tamano .= ' MB';
            }else{
                $tamano = number_format($tamanoKb,2);
                $tamano .= ' KB';
            }

            if(move_uploaded_file($archivo['tmp_name'],$ruta)) {
                $this->DashboardDB->registroArchivo($nombre,$ruta,$tamano,$fecha,$tipo);
                if($tipo == 1){
                    $this->crearThumb($nombre);
                }
                echo "Archivo Subido";
            }else{
                echo "Error al subir archivo";
            }
        }
        // redirect('Dashboard');
    }

    function crearThumb($filename){
        $this->load->library('image_lib');
        $config['image_library'] = 'gd2';
        $config['source_image'] = 'cargados/'.$filename;
        $config['create_thumb'] = TRUE;
        $config['maintain_ratio'] = TRUE;
        $config['new_image'] = 'cargados/thumbs/';
        $config['thumb_marker'] = '';
        $config['width'] = 75;
        $config['height'] = 75;

        $this->image_lib->initialize($config);
        if(!$this->image_lib->resize()){
            echo $this->image_lib->display_errors(); 
        }else{
            echo "Thumb creado";
        }
        $this->image_lib->clear();
    }

    public function modificarArchivo($id,$nombre){

        $nombreEditado = $this->input->post('nombreEditado');
        $directorio = str_replace('http://','', base_url('cargados/'));
        $res = rename($directorio.$nombre,$directorio.$nombreEditado);
        
        var_dump($res);
        // $resultado = $this->DashboardDB->modificarArchivo($id,$nombreEditado);
        // var_dump($resultado);
    }

    public function descargarArchivo($archivo){
        $descarga = file_get_contents('./cargados/'.$archivo);
        force_download($archivo,$descarga);
    }
    
    public function eliminarArchivo($nombreArchivo){
        unlink('./cargados/'.$nombreArchivo);
        unlink('./cargados/thumbs/'.$nombreArchivo);
        $this->DashboardDB->eliminarArchivo($nombreArchivo);
        redirect('Dashboard');
    }

    public function mostrarArchivos(){
        return $this->DashboardDB->devolverArchivos();
    }

    public function devolverRuta($id){
        $fila = $this->DashboardDB->devolverArchivo($id);
        // var_dump($fila);
        echo json_encode($fila[0]);
        //mysqli_fetch_object();
    }
    public function confirmarEliminar($id){
        $consultaArchivo = $this->DashboardDB->devolverArchivo($id);
        $cont['nombreArchivo'] = $consultaArchivo[0]->nombre;
        $cont['idArchivo'] = $id;
        $this->load->view('accion/confirmarEliminar',$cont);
    }

}

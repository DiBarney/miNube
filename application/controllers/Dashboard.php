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
        
        $mi_archivo = 'archivo';
        $config['upload_path'] = "cargados/";
        $config['allowed_types'] = "*";
        $config['max_size'] = "90000000";
        $config['max_width'] = "4000";
        $config['max_height'] = "4000";
        
        $this->load->library('upload', $config);
        
        if (!$this->upload->do_upload($mi_archivo)) {
            echo $this->upload->display_errors();
            return;
        }else{
            $data['uploadSuccess'] = $this->upload->data();
            $rutaPre = $data['uploadSuccess']['full_path'];
            $tamanoPre = $data['uploadSuccess']['file_size'];
            $tamano = '';
            if($tamanoPre>1000){
                $tamanoPre /= 1000;
                $tamanoPre = number_format($tamanoPre,2);
                $tamano = strval($tamanoPre);
                $tamano .= ' MB';
            }else{
                $tamano = strval($tamanoPre);
                $tamano .= ' KB';
            }
            
            $fecha = date("d/m/Y");
            $ruta = substr($rutaPre,strpos($rutaPre,'cargados'));
            $nombre = $data['uploadSuccess']['file_name'];

            $this->DashboardDB->registroArchivo($nombre,$ruta,$tamano,$fecha);
            redirect('Dashboard');
        }

    }

    public function descargarArchivo($archivo){
        $descarga = file_get_contents('./cargados/'.$archivo);
        force_download($archivo,$descarga);
    }
    
    public function eliminarArchivo($archivo){
        $this->DashboardDB->eliminarArchivo($archivo);
        unlink('./cargados/'.$archivo);
        redirect('Dashboard');
    }

    public function mostrarArchivos(){
        return $this->DashboardDB->devolverArchivos();
    }
}

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
        
        $config['upload_path'] = "cargados/";
        $config['allowed_types'] = "*";
        
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        
        $conteoArchivos = count($_FILES['archivos']['name']);
        for ($i=0; $i < $conteoArchivos; $i++) { 
            $_FILES['archivo']['name'] = $_FILES['archivos']['name'][$i];
            $_FILES['archivo']['type'] = $_FILES['archivos']['type'][$i];
            $_FILES['archivo']['tmp_name'] = $_FILES['archivos']['tmp_name'][$i];
            $_FILES['archivo']['error'] = $_FILES['archivos']['error'][$i];
            $_FILES['archivo']['size'] = $_FILES['archivos']['size'][$i];

            // var_dump($_FILES['archivo']['name']);

            if (!$this->upload->do_upload('archivo')) {
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
            }
        }
        redirect('Dashboard');
    }

    public function descargarArchivo($archivo){
        $descarga = file_get_contents('./cargados/'.$archivo);
        force_download($archivo,$descarga);
    }
    
    public function eliminarArchivo($id){
        unlink('./cargados/'.$id);
        $this->DashboardDB->eliminarArchivo($id);
        redirect('Dashboard');
    }

    public function mostrarArchivos(){
        return $this->DashboardDB->devolverArchivos();
    }
}

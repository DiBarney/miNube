<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
Controlador Dashboard encargado de desplegar el panel principal una vez iniciada la sesión, ademas contiene
las principales funciones para los archivos.
*/
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

/*
 ---------------------------------------------- Función subir archivo
*/
    public function subirArchivo(){
        $directorio = "cargados/";

        foreach ($_FILES as $archivo) {
            // Eliminando carácteres reservados para la url, para que no haya problemas con la funcion unlink
            $charReservados = [" ","!","#","$","%","&","'","(",")","*","+",",","/",":",";","=","?","@","[","]"];
            $nombre = $archivo['name'];
            foreach ($charReservados as $character) {
                $nombre = str_replace($character,"_",$nombre);
            }

            // Declaración definitiva de la ruta, la fecha y procesamiento del tamaño y el tipo
            $ruta = $directorio . $nombre;
            $tamanoKb = $archivo['size']*0.001;
            $fecha = date("d/m/Y");
            $tipoStr = $archivo['type'];
            $tipoStr = substr($tipoStr,0,strpos($tipoStr,"/"));
            
            // Asignación de un numero en función de su tipo y su extención (Esto es para visualizar los iconos o las miniaturas)
            $extencion = substr($nombre,strpos($nombre,".")+1);
            switch($tipoStr){
                // Tipo imagen: descartados svg e ico para crear thumb, las demas extenciones tendran su miniatura
                case 'image':
                    if($extencion == 'svg'||$extencion == 'ico'){
                        $tipo = 11;
                    }else{
                        $tipo = 1;
                    }
                break;
                // Tipo video: nada que reportar xd
                case 'video': $tipo = 2;
                break;
                // Tipo audio: pendiente para una previsualización
                case 'audio': $tipo = 3;
                break;
                // Tipo application: los candidatos a tener un icono especial de momento son pdf, archivos de office y sql, los demas tendran un icono de archivo
                case 'application': 
                    switch ($extencion) {
                        case 'pdf':
                            $tipo = 41;
                            break;
                        case 'docx':
                            $tipo = 42;
                            break;
                        case 'pptx':
                            $tipo = 43;
                            break;
                        case 'xlsx':
                            $tipo = 44;
                            break;
                        case 'sql':
                            $tipo = 45;
                            break;
                        default:
                            $tipo = 6;
                            break;
                    }
                break;
                // Tipo text: tendrá un icono de archivo de texto
                case 'text': $tipo = 5;
                break;
                // Demas: cualquier otro tipo que no haya sido asignado tendra un icono de archivo
                default : $tipo = 6;
            }

            // Condicional para desplegar el tamaño en KB o en MB (esta ya es la variable definitiva que se enviara a BD)
            if($tamanoKb>1024.0){
                $tamanoKb /= 1024.0;
                $tamano = number_format($tamanoKb,2);
                $tamano .= ' MB';
            }else{
                $tamano = number_format($tamanoKb,2);
                $tamano .= ' KB';
            }

            // Ya listas todas las variables, toca moverlas al directorio final y registrarlos en BD
            if(move_uploaded_file($archivo['tmp_name'],$ruta)) {
                // Si y solo si el archivo se movió, éste se registra en BD y si es de tipo imagen "1" se crea su thumb
                $this->DashboardDB->registroArchivo($nombre,$ruta,$tamano,$fecha,$tipo);
                if($tipo == 1){
                    $this->crearThumb($nombre);
                }
                echo "Archivo Subido";
            }else{
                echo "Error al subir archivo";
            }
        }
        redirect('Dashboard');
    }

    // Función para crear las miniaturas de las imagenes con la libreria image_lib de CI
    function crearThumb($filename){
        $this->load->library('image_lib');
        $config['image_library'] = 'gd2';
        $config['source_image'] = 'cargados/'.$filename;
        $config['create_thumb'] = TRUE;
        $config['maintain_ratio'] = TRUE;
        $config['new_image'] = 'cargados/thumbs/';
        $config['thumb_marker'] = '';
        $config['width'] = 160;
        $config['height'] = 160;

        $this->image_lib->initialize($config);
        if(!$this->image_lib->resize()){
            echo $this->image_lib->display_errors(); 
        }else{
            echo "Thumb creado";
        }
        $this->image_lib->clear();
    }

    // Función descartada porque no funciona bien, de todos modos en la nueva versión del dashboard ya no sale
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

    // Función mostrarArchivos devuelve una respuesta de tipo MySQL
    public function mostrarArchivos(){
        return $this->DashboardDB->devolverArchivos();
    }

    // Funcion devolverRuta es llamada por JS de forma asincrona para mostrar las previsualizaciones
    public function devolverRuta($id){
        $fila = $this->DashboardDB->devolverArchivo($id);
        echo json_encode($fila[0]);
    }

    // Función confirmarEliminar despliega la vista para que el usuario confirme para eliminar un archivo
    public function confirmarEliminar($id){
        $consultaArchivo = $this->DashboardDB->devolverArchivo($id);
        $cont['nombreArchivo'] = $consultaArchivo[0]->nombre;
        $cont['idArchivo'] = $id;
        $this->load->view('accion/confirmarEliminar',$cont);
    }

}

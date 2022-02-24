document.addEventListener('DOMContentLoaded',()=>{
    var inpArchivo = document.getElementById('inpArchivo');
    var filaProgresoSubida = document.getElementById('filaProgresoSubida');
    var btnCancelar = document.getElementById('btnCancelar');
    var puntoRojo = document.getElementById('puntoRojo');
    //var btnsEdi = document.getElementsByClassName('btnEdi');
    var btnsPrev = document.getElementsByClassName('btnPrev');
    var preVisualizador = document.getElementById('preVisualizador');
    //var fuenteImg = document.getElementById('fuenteImg');
    var btnCerrarPrev = document.getElementById('btnCerrarPrev');
    //var reprouctor = document.getElementById('reprouctor');
    //var prevArchivo = document.getElementById('prevArchivo');
    var btnSubir = document.getElementById('btnSubir');
    var indicadorPorc = document.getElementById('indicadorPorc');
    var infosArchivo = document.getElementsByClassName('infoArchivo');
    var derPrev = document.getElementById('derPrev');
    var izqPrev = document.getElementById('izqPrev');
    var datosArchivo;
    var imagenes = document.getElementsByClassName('archivoImagen');
    var contenedorMedia = document.getElementById('contenedorMedia');
    var pos = 0;

    /* ------------------------------------- Puestas en marcha cuando carga la página ------------------------------------------ */

    // Llamada asincrona para obtener los datos de los archivos de BD
    fetch('http://192.168.0.15/miNube/index.php/Dashboard/mostrarArchivosAs',{
        method: 'GET',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        }
    }).then((respuesta)=>{
        return respuesta.json();
    }).then((res)=>{
        datosArchivo = res;
    });


    /* ------------------------------------- Funciones ------------------------------------------ */


    // ----------------------- Para el slider
    // Función setPos: establece la posicion actual para el slider una vez que se dió click a una imagen
    function setPos(num){
        pos = num-1;
    }

    // ----------------------- Para la subida "Asincrona" (En realidad la página si se va a recargar xd, pero es para la barra de progreso)
    // Función subirArchivos: hace la petición asincrona para subir y monitoriza el progreso
    function subirArchivos(){
        var formData = new FormData();
        var archivos = inpArchivo.files;
        for (let ite = 0; ite < archivos.length; ite++) {
            formData.append('archivo'+ite,archivos[ite]);
        }
        var ajax = new XMLHttpRequest();
        ajax.upload.addEventListener('progress',mostrarProgreso,false);
        ajax.addEventListener('load',mostrarCompleto,false);
        ajax.open('POST','http://192.168.0.15/miNube/index.php/Dashboard/subirArchivo');
        ajax.send(formData);
        filaProgresoSubida.style.display = "flex";

        btnCancelar.addEventListener('click',()=>{
            ajax.abort();
            indicadorPorc.style.background = '#c73434';
        });
    }

    // Función mostrarProgreso: recibe el estatus del progreso y en base a ello modifica el ancho de la barra
    function mostrarProgreso(event){
        var porcentaje = parseInt(event.loaded / event.total * 100);
        indicadorPorc.innerHTML = porcentaje + "%";
        indicadorPorc.style.width = porcentaje + "%";
    }

    // Función mostrarCompleto: muestra el mensaje de completado. Se llama cuando la subida se completó
    function mostrarCompleto(event){
        indicadorPorc.innerHTML = "Completado";
    }


    /* ------------------------------------- Eventos y Declaraciones ------------------------------------------ */


    // ----------------------- Para el slider
    // Crea una copia de las imagenes y las incrusta en el contenedorMedia del previsualizador
    for (let imagen of imagenes) {
        var nuevaImg = document.createElement('img');
        nuevaImg.src = imagen.src;
        nuevaImg.setAttribute('style','display: none;');
        contenedorMedia.appendChild(nuevaImg);
    }

    // Escucha a cada boton de previsualizacion para activar el prev y establecer la posición inicial con la funcion setPos
    for (let btnPre of btnsPrev) {
        btnPre.addEventListener('click',()=>{
            for (let elemento of datosArchivo) {
                if(elemento.id == btnPre.id && elemento.tipo == '1'){
                    var posPrev = 0;
                    for (let imgPrev of contenedorMedia.children) {
                        posPrev++;
                        if(imgPrev.src.replace('http://192.168.0.15/miNube/','') == elemento.ruta){
                            imgPrev.style.display = 'block';
                            setPos(posPrev);
                        }
                    }
                    preVisualizador.style.display = 'block';
                }/*else{
                    fuenteImg.style.display = "none";
                    reprouctor.style.display = "none";
                    prevArchivo.style.display = "block";
                    preVisualizador.style.display = 'block';
                }*/
            }
        });
    }

    // Escucha a los trigers de derecha e izquierda respectivamente para hacer el desplazamiento
    derPrev.addEventListener('click',()=>{
        for (let imgPrev of contenedorMedia.children) {
            imgPrev.style.display = 'none';
        }
        if(pos+1 > contenedorMedia.children.length-1){
            contenedorMedia.children[0].style.display = 'block';
            pos = 0;
        }else{
            contenedorMedia.children[pos+1].style.display = 'block';
            pos++;
        }
    });
    izqPrev.addEventListener('click',()=>{
        for (let imgPrev of contenedorMedia.children) {
            imgPrev.style.display = 'none';
        }
        if(pos-1 < 0){
            contenedorMedia.children[contenedorMedia.children.length-1].style.display = 'block';
            pos = contenedorMedia.children.length-1;
        }else{
            contenedorMedia.children[pos-1].style.display = 'block';
            pos--;
        }
    });

    // Escucha al botón para cerrar el previsualizador, lo oculta y a todas sus imagenes hijas tambien
    btnCerrarPrev.addEventListener('click',()=>{
        for (let imgPrev of contenedorMedia.children) {
            imgPrev.style.display = 'none';
        }
        preVisualizador.style.display = "none";
    });

    // ----------------------- Para la subida "Asincrona"
    // Escucha al input de tipo file, cuando tenga archivos seleccionados se mostrará el punto rojo.
    inpArchivo.addEventListener('input',()=>{
        puntoRojo.style.display = (puntoRojo.style.display == "none") ? "block" : "none";
    });
    
    // Llamada a la función subirArchivos
    btnSubir.addEventListener('click',()=>{
        subirArchivos();
    });

    // ----------------------- Para los menus de opciones de cada archivo
    // Mostrar las opciones cuando el usuario pasa el mouse, ************************** (sigue pendiente)
    for (let infoArchivo of infosArchivo) {
        infoArchivo.children[0].children[1].addEventListener('mouseover',()=>{
            infoArchivo.children[2].style.display = (infoArchivo.children[2].style.display == "none") ? "flex" : "none";
        });
        infoArchivo.children[0].children[1].addEventListener("mouseout",(event)=>{
            setTimeout(function() {
                infoArchivo.children[2].style.display = "none";
            }, 5000);
          }, false);
    }



    /*for (let btnPre of btnsPrev) {
        btnPre.addEventListener('click',()=>{
            fetch('http://192.168.0.15/miNube/index.php/Dashboard/devolverRuta/'+btnPre.id,{
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            }).then((respuesta)=>{
                return respuesta.json();
            }).then((datosArchivo)=>{
                switch(datosArchivo.tipo){
                    case "1":
                        reprouctor.style.display = "none";
                        prevArchivo.style.display = "none";
                        fuenteImg.src = `http://192.168.0.15/miNube/${datosArchivo.ruta}`;
                        fuenteImg.style.display = "block";
                        preVisualizador.style.display = 'block';
                        break;
                    case "2":
                        fuenteImg.style.display = "none";
                        prevArchivo.style.display = "none";
                        // fuenteVideo.src = `http://192.168.0.15/miNube/cargados/${datosArchivo.nombre}`;
                        // leerVideo();
                        // reprouctor.style.display = "block";
                        break;
                    default :
                        fuenteImg.style.display = "none";
                        reprouctor.style.display = "none";
                        prevArchivo.style.display = "block";
                        preVisualizador.style.display = 'block';
                }
            });
        });
    }*/

    /* for (let item of btnsEdi) {
        item.addEventListener('click',()=>{
            item.nextElementSibling.style.display = (item.nextElementSibling.style.display == "none")? "block" : "none";
        });
        item.nextElementSibling.getElementsByClassName("btnCancelarEditar")[0].addEventListener('click',()=>{
            item.nextElementSibling.style.display = "none";
        });
    } */
});


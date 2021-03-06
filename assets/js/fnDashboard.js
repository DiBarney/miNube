document.addEventListener('DOMContentLoaded',()=>{
    var inpArchivo = document.getElementById('inpArchivo');
    var filaProgresoSubida = document.getElementById('filaProgresoSubida');
    var btnCancelar = document.getElementById('btnCancelar');
    var puntoRojo = document.getElementById('puntoRojo');
    var btnsEdi = document.getElementsByClassName('btnEdi');
    var btnsPrev = document.getElementsByClassName('btnPrev');
    var preVisualizador = document.getElementById('preVisualizador');
    var fuenteImg = document.getElementById('fuenteImg');
    var btnCerrarPrev = document.getElementById('btnCerrarPrev');
    var reprouctor = document.getElementById('reprouctor');
    var prevArchivo = document.getElementById('prevArchivo');
    var btnSubir = document.getElementById('btnSubir');
    var indicadorPorc = document.getElementById('indicadorPorc');
    
    inpArchivo.addEventListener('input',()=>{
        puntoRojo.style.display = (puntoRojo.style.display == "none") ? "block" : "none";
    });
    
    btnCerrarPrev.addEventListener('click',()=>{
        preVisualizador.style.display = "none";
    });

    btnSubir.addEventListener('click',()=>{
        subirArchivos();
    });
    
    for (let item of btnsEdi) {
        item.addEventListener('click',()=>{
            item.nextElementSibling.style.display = (item.nextElementSibling.style.display == "none")? "block" : "none";
        });
        item.nextElementSibling.getElementsByClassName("btnCancelarEditar")[0].addEventListener('click',()=>{
            item.nextElementSibling.style.display = "none";
        });
    }
    
    for (let btnPre of btnsPrev) {
        btnPre.addEventListener('click',()=>{
            fetch('Dashboard/devolverRuta/'+btnPre.id,{
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
                        fuenteImg.src = `../${datosArchivo.ruta}`;
                        fuenteImg.style.display = "block";
                        break;
                    case "2":
                        fuenteImg.style.display = "none";
                        prevArchivo.style.display = "none";
                        fuenteVideo.src = `../${datosArchivo.ruta}`;
                        reprouctor.style.display = "block";
                        break;
                    default :
                        fuenteImg.style.display = "none";
                        reprouctor.style.display = "none";
                        prevArchivo.style.display = "block";
                }
                preVisualizador.style.display = 'block';
            });
        });
    }

    function subirArchivos(){
        var formData = new FormData();
        var archivos = inpArchivo.files;
        for (let ite = 0; ite < archivos.length; ite++) {
            formData.append('archivo'+ite,archivos[ite]);
        }
        var ajax = new XMLHttpRequest();
        ajax.upload.addEventListener('progress',mostrarProgreso,false);
        ajax.addEventListener('load',mostrarCompleto,false);
        ajax.open('POST','Dashboard/subirArchivo');
        ajax.send(formData);
        filaProgresoSubida.style.display = "flex";

        btnCancelar.addEventListener('click',()=>{
            ajax.abort();
            indicadorPorc.style.background = '#c73434';
        });
    }

    function mostrarProgreso(event){
        var porcentaje = parseInt(event.loaded / event.total * 100);
        indicadorPorc.innerHTML = porcentaje + "%";
        indicadorPorc.style.width = porcentaje + "%";
    }
    function mostrarCompleto(event){
        indicadorPorc.innerHTML = "Completado";
    }
});


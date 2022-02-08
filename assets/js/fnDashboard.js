var inpArchivo = document.getElementById('inpArchivo');
var puntoRojo = document.getElementById('puntoRojo');
inpArchivo.addEventListener('input',()=>{
    puntoRojo.style.display = (puntoRojo.style.display == "none") ? "block" : "none";
});
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | MiNube - By Barney</title>
    <link rel="stylesheet" href="<?= base_url() ?>estilosPiola/estilos.css">

</head>
<body>
    <section class="preVisualizador" id="preVisualizador" style="display:none;">
        <div class="fila">
            <div class="columna equis">
                <button type="button" id="btnCerrarPrev">x</button>
            </div>
        </div>
        <div class="fila">
            <div class="columna contenedorMedia">
                <video style="display: none;" height="400px" id="reprouctor" controls>
                    <source id="fuenteVideo" src="">
                </video>
                <img style="display: none;" id="fuenteImg" src="" alt="prev" height="500px">
                <div class="contPrevArch" id="prevArchivo" style="display: none;">
                    <div class="prevArchivo">
                        <p></p>
                        <p>Archivo</p>
                    </div>    
                </div>
            </div>
        </div>
    </section>
    <header>
        <div class="fila cabeceraLogin">
            <div class="columna titulo">
                <a href="<?= base_url('index.php/Dashboard')?>"><h2>Mi Nube</h2></a>
            </div>
            <div class="columna columnaNav">
                <nav>
                    <a href="<?= base_url('index.php/Dashboard/imagenes')?>">Imagenes</a>
                    <a href="<?= base_url('index.php/Dashboard/audiovisuales')?>">Audiovisuales</a>
                    <?php if($this->session->userdata('correo')):?>
                        <a href="<?= site_url('Login/cerrarSesion') ?>" class="iconoLogout"></a>
                    <?php else: ?>
                        <a href="<?= site_url('Login/') ?>">Iniciar Sesión</a>
                    <?php endif; ?>
                </nav>
            </div>
        </div>
    </header>

    <main>
        <div class="contenedorPrincipal">
            <section class="seccionDash">
                <div class="fila">
                    <div class="columna menuDash">
                        <h1><?= $tituloPagina?></h1>
                        <div class="contFormSubida">
                            <form method="POST" enctype="multipart/form-data">
                                <div class="btnCargar">
                                    <div class="puntoRojo" id="puntoRojo" style="display:none;"></div>
                                    <p>Subir Archivos</p>
                                    <input type="file" class="inpArchivo" id="inpArchivo" name="archivos[]" multiple required>
                                </div>    
                                <input type="submit" id="btnSubir" name="btnSubir" value="Subir">
                            </form>
                        </div>
                    </div>
                </div>
                <div class="fila filaProgresoSubida" id="filaProgresoSubida" style="display: none">
                    <div class="columna colBtnCancelar">
                        <input type="button" id="btnCancelar" name="btnCancelar" value="Cancelar">
                    </div>
                    <div class="columna progresoSubida">
                        <div class="contenedorProgreso">
                            <span id="indicadorPorc"></span>
                        </div>
                    </div>
                </div>
                <div class="fila">
                    <div class="columna contenedorPanelDeArchivos">
                        <!-- Tambien intentar hacer una "tabla" con divs y poder cambiar de modo -->
                        <div class="contenedorArchivos">
                            <?php while($fila = mysqli_fetch_array($archivos)){?>
                            <div class="contenedorPadding">
                                <div class="contenedorArchivo">
                                    <div class="miniaturaArchivo btnPrev" id="<?=$fila['id']?>">
                                        <?php if($fila['tipo'] == '1') {?>
                                            <img src="<?= base_url('/cargados/').$fila['nombre']?>">
                                        <?php }else if($fila['tipo'] == '11'){?>
                                            <p></p>
                                        <?php }else if($fila['tipo'] == '2'){?>
                                            <video src="<?= base_url('/cargados/').$fila['nombre']?>" controls>
                                        <?php }else if($fila['tipo'] == '3'){?>
                                            <p></p>
                                        <?php }else if($fila['tipo'] == '41'){?>
                                            <p></p>
                                        <?php }else if($fila['tipo'] == '42'){?>
                                            <p></p>
                                        <?php }else if($fila['tipo'] == '43'){?>
                                            <p></p>
                                        <?php }else if($fila['tipo'] == '44'){?>
                                            <p></p>
                                        <?php }else if($fila['tipo'] == '45'){?>
                                            <p></p>
                                        <?php }else if($fila['tipo'] == '5'){?>
                                            <p></p>
                                        <?php }else{?>
                                            <p></p>
                                        <?php }?>
                                    </div>
                                    <div class="infoArchivo">
                                        <div class="contNombre">
                                            <p class="nombreArchivo"><?= $fila['nombre']?></p>
                                            <p class="iconoMenu"></p>
                                        </div>
                                        <div class="contInfo" style="display:flex;flex-direction:row;">
                                            <p class="tamanoArchivo"><?= $fila['tamano']?> - <?= $fila['fecha']?></p>
                                        </div>
                                        <div class="contOpciones" style="display: none;">
                                            <a href="<?= base_url()."index.php/Dashboard/descargarArchivo/".$fila['nombre']?>" class="btnDes">
                                                <p></p><p>Descargar</p>
                                            </a>
                                            <a href="<?= base_url()."index.php/Dashboard/confirmarEliminar/".$fila['id']?>" class="btnEli">
                                                <p></p><p>Eliminar</p>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php }?>
                        </div>
                        
                    </div>
                </div>
            </section>
        </div>
    </main>
    
    <footer>
        <div class="fila">
            <p>MiNube con Panel de Divs - By Barney 2022</p>
        </div>
    </footer>
    <script src="<?= base_url('assets/js/fnDashboard.js')?>"></script>
</body>
</html>
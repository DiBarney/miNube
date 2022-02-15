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
                <img style="display: none;" id="fuenteImg" src="" alt="prev" width="500px">
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
            <div class="columna">
                <h2>Mi Nube</h2>
            </div>
            <div class="columna">
                <nav>
                    <?php if($this->session->userdata('correo')):?>
                        <a href="<?= site_url('Login/cerrarSesion') ?>">Cerrar Sesión</a>
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
                        <h1>Mi Dashboard</h1>
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
                    <div class="columna contenedorTabla">
                        <table>
                            <tr>
                                <th class="chico"></th>
                                <th class="grande">Nombre</th>
                                <th class="grande">Tamaño</th>
                                <th class="grande">Fecha de Modificación</th>
                                <th class="chico"></th>
                                <th class="chico"></th>
                                <th class="chico"></th>
                            </tr>
                            <?php while($fila = mysqli_fetch_array($archivos)){?>
                            <tr>
                                <td>
                                    <div class="miniatura">
                                        <?php if($fila['tipo'] == '1') {?>
                                            <!-- <p></p> -->
                                            <img src="<?= base_url('/cargados/thumbs/').$fila['nombre']?>">
                                        <?php }else if($fila['tipo'] == '2'){?>
                                            <p></p>
                                        <?php }else{?>
                                            <p></p>
                                        <?php }?>
                                    </div>
                                </td>
                                <td id="<?=$fila['id']?>" class="btnPrev"><?= $fila['nombre']?></td>
                                <td><?= $fila['tamano']?></td>
                                <td><?= $fila['fecha']?></td>
                                <td>
                                    <a class="btnEdi"></a>
                                    <div class="formEditar" style="display: none;">
                                        <form action="<?=base_url('index.php/Dashboard/modificarArchivo/'.$fila['id'].'/'.$fila['nombre'])?>" method="POST">
                                            <p>Renombrar</p>
                                            <input type="text" name="nombreEditado" id="nombreEditado" value="<?= $fila['nombre']?>">
                                            <div class="contenedorBotones">
                                                <button type="button" class="btnCancelarEditar">Cancelar</button>
                                                <input type="submit" value="Actualizar">
                                            </div>
                                        </form>
                                    </div>
                                </td>
                                <td><a href="<?= base_url()."index.php/Dashboard/descargarArchivo/".$fila['nombre']?>" class="btnDes"></a></td>
                                <td><a href="<?= base_url()."index.php/Dashboard/confirmarEliminar/".$fila['id']?>" class="btnEli"></a></td>
                            </tr>
                            <?php }?>
                        </table>
                    </div>
                </div>
            </section>
        </div>
    </main>
    
    <footer>
        <div class="fila">
            <p>MiNube - By Barney 2022</p>
        </div>
    </footer>
    <script src="<?= base_url('assets/js/fnDashboard.js')?>"></script>
</body>
</html>
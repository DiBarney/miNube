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
                            <form action="<?= base_url() ?>index.php/Dashboard/subirArchivo" method="POST" enctype="multipart/form-data">
                                <div class="btnCargar">
                                    <div class="puntoRojo" id="puntoRojo" style="display:none;"></div>
                                    <p>Subir Archivos</p>
                                    <input type="file" class="inpArchivo" id="inpArchivo" name="archivos[]" multiple required>
                                </div>    
                                <input type="submit" name="btnSubir" value="Subir">
                            </form>
                        </div>
                    </div>
                </div>
                <div class="fila">
                    <div class="columna contenidoEliminar">
                        <div class="contenedorFormEliminar">
                            <h2>¿Eliminar el archivo "<?=$nombreArchivo?>" ?</h2>
                            <p>El archivo se eliminará permanentemente.</p>
                            <div class="contenedorBotones">
                                <a href="<?=base_url('index.php/Dashboard')?>" class="btn">Cancelar</a>
                                <a href="<?=base_url('index.php/Dashboard/eliminarArchivo/'.$nombreArchivo)?>" class="btn">Eliminar</a>
                            </div>
                        </div>
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
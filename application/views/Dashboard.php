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
                    <div class="columna contenedorTabla">
                        <table>
                            <tr>
                                <th class="grande">Nombre</th>
                                <th class="grande">Tamaño</th>
                                <th class="grande">Fecha de Modificación</th>
                                <th class="chico"></th>
                                <th class="chico"></th>
                            </tr>
                            <?php while($fila = mysqli_fetch_array($archivos)){?>
                            <tr>
                                <td><?= $fila['nombre']?></td>
                                <td><?= $fila['tamano']?></td>
                                <td><?= $fila['fecha']?></td>
                                <td><a href="<?= base_url()."index.php/Dashboard/descargarArchivo/".$fila['nombre']?>" class="btnDes">Descargar</a></td>
                                <td><a href="<?= base_url()."index.php/Dashboard/eliminarArchivo/".$fila['id']?>" class="btnEli">Eliminar</a></td>
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
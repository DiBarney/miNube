<body>
    <?php include('comun/previsualizador.php');?>
    <?php include('comun/header.php');?>

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
                                            <img src="<?= base_url('/cargados/').$fila['nombre']?>" class="archivoImagen">
                                        <?php }else if($fila['tipo'] == '11'){?>
                                            <p></p>
                                        <?php }else if($fila['tipo'] == '2'){?>
                                            <video src="<?= base_url('/cargados/').$fila['nombre']?>" controls>
                                        <?php }else if($fila['tipo'] == '3'){?>
                                            <p></p>
                                            <!-- <audio src="<?= base_url('/cargados/').$fila['nombre']?>" controls></audio> -->
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
                                        <?php }else if($fila['tipo'] == '46'){?>
                                            <p></p>
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
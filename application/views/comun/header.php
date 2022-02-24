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
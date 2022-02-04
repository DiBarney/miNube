<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión | MiNube - By Barney</title>
    <link rel="stylesheet" href="<?= base_url() ?>estilosPiola/estilosLogin.css">
</head>
<body>
    <main>
        <div class="contenedorPrincipal">
            <section class="seccionLogin">
                <div class="fila cabeceraLogin">
                    <h2>Bienvenido a mi Nube</h2>
                    <h1><?= $titulo ?></h1>
                </div>
    
                <div class="fila contenido">
                    <div class="contenedorFormulario">
                        <form action="<?= base_url() ?>index.php/login/iniciarSesion" method="POST">
                            <input type="email" name="correo" id="correo" placeholder="Correo Electronico:">
                            <input type="password" name="pwd" id="pwd" placeholder="Contraseña:">
                            <input type="submit" value="Iniciar Sesión">
                        </form>
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
</body>
</html>
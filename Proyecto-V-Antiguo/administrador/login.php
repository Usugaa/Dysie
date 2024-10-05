<?php
session_start();

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dysie - Iniciar o Crear Cuenta</title>
    <link rel="shortcut icon" href="../assets/justLogoDysie.png" type="image/x-icon">
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="./login.css">

    <link rel="stylesheet" href="aos-master/dist/aos.css" /> <!-- AOS ANIMATE -->
    <link rel="preconnect" href="https://fonts.googleapis.com"> <!-- OUTFIT GOOGLE FONT -->
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin> <!-- OUTFIT GOOGLE FONT -->
    <link
        href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&family=Outfit:wght@100..900&display=swap"
        rel="stylesheet"> <!-- OUTFIT GOOGLE FONT -->

</head>

<body>
    <?php
    if (isset($_SESSION["error"])) {
        echo '<div class="alert alert-danger">' . $_SESSION["error"] . '</div>';
        unset($_SESSION["error"]); // Limpia la variable de sesión
    }

    if (isset($_SESSION["registro_exitoso"]) && $_SESSION["registro_exitoso"]) {
        echo '<div class="alert alert-success">Registro exitoso. Puedes iniciar sesión ahora.</div>';
        unset($_SESSION["registro_exitoso"]); // Limpia la variable de sesión
    }
    if (isset($_SESSION["error"])) {
        echo '<div class="alert alert-danger">';
        echo $_SESSION["error"];
        echo '</div>';
        unset($_SESSION["error"]);
    }
    if (isset($_SESSION["success"])) {
        echo '<div class="alert alert-success">';
        echo $_SESSION["success"];
        echo '</div>';
        unset($_SESSION["success"]);
    }

    ?>
    <!-- Logo -->
    <div class="logo">
        <a href="../index.html"><img src="../assets/logoDysie.png" alt=""></a>
    </div>
    <main>
        <div class="contenedor__todo">
            <div class="contenedor__login-register">
            <form id="formularioL" method="POST" action="procesar_login.php" class="formulario__login">
    <h2>Iniciar Sesión</h2>
    <input type="" class="form-control" id="txt_usuario" placeholder="Usuario" name="txt_usuario" required>
    <input type="password" class="form-control" id="txt_contraseñaL" placeholder="Contraseña" name="txt_contraseñaL" minlength="8" required>
    <br><br>

    <input type="hidden" id="tipo_usuario" name="tipo_usuario" value="estudiante"> <!-- Valor por defecto -->

    <button type="submit" class="botonDysie" style="margin-top: 30px;">Entrar</button>

    <div class="contenedor-linkVolver">
        <a class="link-Volver" href="../index.html">Volver a Inicio</a>
    </div>
</form>

            </div>
        </div>
    </main>
    <script src="../javasS/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</body>

</html>
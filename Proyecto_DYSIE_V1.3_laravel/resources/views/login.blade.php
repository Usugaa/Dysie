<!DOCTYPE html>
<html lang="es">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dysie - Iniciar o Crear Cuenta</title>
    <link rel="shortcut icon" href="{{asset('justLogoDysie.png')}}" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/registro.css') }}">
    <link rel="stylesheet" href="{{ asset('aos-master/dist/aos.css') }}"/> <!-- AOS ANIMATE -->
    <link rel="preconnect" href="https://fonts.googleapis.com"> <!-- OUTFIT GOOGLE FONT -->
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin> <!-- OUTFIT GOOGLE FONT -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&family=Outfit:wght@100..900&display=swap" rel="stylesheet"> <!-- OUTFIT GOOGLE FONT -->
    <style>
        .alert-container {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #f8d7da;
            color: #721c24;
            padding: 20px;
            border-radius: 5px;
            z-index: 9999;
            display: none;
        }

        .alert-container1 {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #02c77c;
            color: white;
            padding: 20px;
            border-radius: 5px;
            z-index: 9999;
            display: none;
        }

        .alert-container1.show {
            display: flex;
            flex-direction: column;
        }

        .alert-container.show {
            display: flex;
            flex-direction: column;
        }

        .btn-aceptar {
            margin-top: 10px;
            padding: 8px 16px;
            background-color: #dc3545;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn-aceptar:hover {
            background-color: #c82333;
        }

        .btn-aceptar1 {
            margin-top: 10px;
            padding: 8px 16px;
            background-color: #00a266;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn-aceptar1:hover {
            background-color: #00563b;
        }
    </style>
</head>

<body>
    <?php
    session_start();
    if (isset($_SESSION["error"])) {
        echo '<div id="alert-error" class="alert-container show">' . $_SESSION["error"] . '<button class="btn-aceptar" onclick="hideAlert(\'alert-error\')">Aceptar</button></div>';
        unset($_SESSION["error"]); // Limpia la variable de sesión
    }

    if (isset($_SESSION["registro_exitoso"]) && $_SESSION["registro_exitoso"]) {
        echo '<div id="alert-registro" class="alert-container1 show">Registro exitoso. Puedes iniciar sesión ahora.<button class="btn-aceptar1" onclick="hideAlert(\'alert-registro\')">Aceptar</button></div>';
        unset($_SESSION["registro_exitoso"]); // Limpia la variable de sesión
    }

    if (isset($_SESSION["login_exitoso"]) && $_SESSION["login_exitoso"]) {
        echo '<div id="alert-login" class="alert-container1 show">Inicio de sesión exitoso. Redirigiendo...<button class="btn-aceptar1" onclick="hideAlert(\'alert-login\')">Aceptar</button></div>';
        unset($_SESSION["login_exitoso"]); // Limpia la variable de sesión
    }
    ?>
    <!-- Logo -->
    <div class="logo">
        <a href="/"><img src="../assets/logoDysie.png" alt=""></a>
    </div>
    <main>
        <div class="contenedor__todo">
            <div class="caja__trasera">
                <div class="caja__trasera-login">
                    <h3>¿Ya tienes una cuenta?</h3>
                    <p>Inicia sesión para entrar en la página</p>
                    <button id="btn__iniciar-sesion" class="botonDysie" style="font-size: 20px; box-shadow: 0px 20px 60px -20px rgba(0,0,0, 0.5);">
                        Iniciar
                    </button>
                </div>
                <div class="caja__trasera-register">
                    <h3>¿Aún no tienes una cuenta?</h3>
                    <p>Regístrate para que puedas iniciar sesión</p>
                    <button id="btn__registrarse" class="botonDysie" style="font-size: 20px; box-shadow: 0px 20px 60px -20px rgba(0,0,0, 0.5);">
                        Registrarme
                    </button>
                </div>
            </div>
            <div class="contenedor__login-register">
                <form id="formularioL" method="POST" action="{{route('login_post')}}" class="formulario__login">
                    @csrf
                    <h2>Iniciar Sesión</h2>
                    <input type="email" class="form-control" id="txt_emailL" placeholder="Email" name="txt_emailL" required>
                    <input type="password" class="form-control" id="txt_contraseñaL" placeholder="Contraseña" name="txt_contraseñaL" minlength="8" required><br><br>
                    <input type="hidden" id="tipo_usuario" name="tipo_usuario" value="estudiante"> <!-- Valor por defecto -->
                    <button type="button" id="btn__entrar" class="botonDysie" style="margin-top: 30px;">Entrar</button>
                    <div class="contenedor-linkVolver">
                        <a class="link-Volver"   href="{{ route('password.request') }}">¿Olvidaste tu contraseña?</a>
                    </div>
                    <div class="contenedor-linkVolver">
                        <a class="link-Volver" href="/">Volver a Inicio</a>
                    </div>
                </form>
                <form id="formulario" method="POST" action="{{route('register_post')}}" class="formulario__register">
                        @csrf
                    <h2>Registrarse</h2>
                    <input type="text" class="form-control" id="txt_nombre" placeholder="Nombres" name="txt_nombre" required>
                    <input type="text" class="form-control" id="txt_apellido" placeholder="Apellidos" name="txt_apellido" required>
                    <input type="email" class="form-control" id="txt_email" placeholder="Email" name="txt_email" required>
                    <input type="password" class="form-control" id="txt_contraseña" placeholder="Contraseña" name="txt_contra" minlength="6" required>
                    <input type="password" class="form-control" id="txt_contraseña1" placeholder="Confirmacion de Contraseña" name="confirma_contra" minlength="6" required><br><br>
                    <p style="color:white;">Fecha de nacimiento:</p>
                    <input type="date" id="txt_fecha" name="txt_fecha" required>
                    <br><br>
                    <p style="color:white;">Grado:</p>
                    <select id="select_grado" name="select_grado" class="form-control" required>
                        <option value="" disabled selected>Seleccione su grado</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                    </select>                    
                    <button type="submit" class="botonDysie" style="margin-top: 30px;">Registrar</button>
                    <div class="contenedor-linkVolver">
                        <a class="link-Volver" href="/">Volver a Inicio</a>
                    </div>
                </form>
            </div>
        </div>
    </main>
    <div id="alert-container" class="alert-container"></div>
    <script>
        function showAlert(message) {
            var alertContainer = document.getElementById("alert-container");
            alertContainer.innerHTML = message;
            alertContainer.classList.add("show");
        }

        function hideAlert(alertId) {
            var alertContainer = document.getElementById(alertId);
            alertContainer.classList.remove("show");
        }

        document.getElementById("btn__iniciar-sesion").addEventListener("click", function () {
            document.getElementById("formulario").style.display = "none";
            document.getElementById("formularioL").style.display = "block";
        });

        document.getElementById("btn__registrarse").addEventListener("click", function () {
            document.getElementById("formulario").style.display = "block";
            document.getElementById("formularioL").style.display = "none";
        });

        document.getElementById("btn__entrar").addEventListener("click", function () {
            var email = document.getElementById("txt_emailL").value;
            var contrasena = document.getElementById("txt_contraseñaL").value;

            if (email.trim() === "" || contrasena.trim() === "") {
                showAlert("Por favor, completa todos los campos.");
            } else {
                document.getElementById("formularioL").submit();
            }
        });
    </script>
    <script src="{{ asset('js/script.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</body>

</html>

<?php
session_start();

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['email'])) {
    $_SESSION["error"] = "Debes iniciar sesión para acceder a esta página.";
    header("Location: login.php");
    exit();
}


    // Conexión a la base de datos (debes configurar tus propios valores)
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "dysie";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }
// Función para calcular la diferencia de días entre dos fechas
function daysDifference($date1, $date2) {
    $datetime1 = strtotime($date1);
    $datetime2 = strtotime($date2);
    $difference = abs($datetime1 - $datetime2);
    return floor($difference / (60 * 60 * 24));
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["edit_account"])) {
    $new_nombre = $_POST["new_nombre"];
    $new_raw_password = $_POST["new_password"];
    $account_id = $_POST["account_id"]; // Agrega esta línea para obtener el account_id


    // Valida los datos ingresados en el formulario aquí (longitud, formato de correo, etc.)

    // Encriptar la nueva contraseña
    $new_password = password_hash($new_raw_password, PASSWORD_DEFAULT);

    // Consulta para verificar la fecha de la última actualización
    $sql_last_update = "SELECT fecha_update FROM usuario WHERE id_usuario = ?";
    $stmt_last_update = $conn->prepare($sql_last_update);
    $stmt_last_update->bind_param("i", $account_id);
    $stmt_last_update->execute();
    $stmt_last_update->bind_result($last_update);
    $stmt_last_update->fetch();
    $stmt_last_update->close();

    // Obtiene la fecha actual
    $current_date = date("Y-m-d");

    try {
        // Intenta actualizar los datos en la base de datos
        $sql = "UPDATE usuario SET nombre_usu = ?,  contra = ?, fecha_update = ? WHERE id_usuario = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssii", $new_nombre, $new_password, $current_date, $account_id);
    
        if ($stmt->execute()) {
            $_SESSION["success"] = "Usuario actualizado con éxito.";
    
            // Guarda el nuevo nombre en la variable de sesión
            $_SESSION["new_nombre"] = $new_nombre;
        } else {
            throw new Exception("Error al actualizar el usuario: " . $stmt->error);
        }
    } catch (Exception $e) {
        $_SESSION["success"] = "<div style='flex: 1; padding: 80px; color: #00ffd4; font-family: Outfit;'>Usuario actualizado con éxito</div>";
    }
    
    // Redirige a la página donde se listan los usuarios o al índice
    header("Location: edit_usu.php");
    exit();
}

// Obtener la información del usuario a editar
if (isset($_GET["id_usuario"])) {   
    $account_id = $_GET["id_usuario"];

    // Consulta para verificar si el usuario existe
    $sql_check = "SELECT id_usuario, nombre_usu FROM usuario WHERE id_usuario = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("i", $account_id);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        $row = $result_check->fetch_assoc();
        $nombre = $row["nombre_usu"];
    } else {
        $_SESSION["error"] = "Usuario no encontrado.";
        header("Location: edit_usu.php");
        exit();
    }

    $stmt_check->close();
} 


// Cerrar la conexión a la base de datos
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Kanban Dysie</title>

    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />

    <link rel="stylesheet" href="../aos-master/dist/aos.css" /> <!-- AOS ANIMATE -->
    <link rel="preconnect" href="https://fonts.googleapis.com"> <!-- OUTFIT GOOGLE FONT -->
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin> <!-- OUTFIT GOOGLE FONT -->
    <link
    href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&family=Outfit:wght@100..900&display=swap"
    rel="stylesheet"> <!-- OUTFIT GOOGLE FONT -->

    <!-- Bootstrap icons
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet" />-->

    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="../index.css" rel="stylesheet" />

</head>

<!-- HEADER -->

<header>
    <a href="" class="logo"><img class="" src="../assets/logoDysie.png" alt=""></a>
    <nav>
        <ul>
            <li><a href="../inicio/index.php">Inicio</a></li>
            <a href="../logout.php" class="botonDysie"
                style="font-size: 20px; box-shadow: 0px 20px 60px -20px rgba(0,0,0, 0.5); padding: 10px 30px; margin: 0px 10px;">
                Cerrar Sesión
            </a>
            <a href="../usuario/view_accounts.php" class="botonDysie"
                style="font-size: 20px; box-shadow: 0px 20px 60px -20px rgba(0,0,0, 0.5); padding: 10px 30px; margin: 0px 10px;">
                Mi Perfil
            </a>
        </ul>
    </nav>
</header>
<!-- SCRIPT CANIMACIÓN HEADER -->
<script type="text/javascript">
    window.addEventListener("scroll", function () {
        var header = document.querySelector("header");
        header.classList.toggle("abajo", window.scrollY > 0);
    })
</script>

<!-- Responsive navbar HEADER BOOSTRAP
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container px-5">
        <a class="logo" href="index.php">
            <img src="../assets/Dysie (3).png" alt="">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span
                class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="btn btn-outline-light" href="../logout.php" style="margin-right: 10px;">Cerrar Sesion</a></li>
                <li class="nav-item"><a class="btn btn-primary" href="../usuario/view_accounts.php">Perfil</a></li>
            </ul>
        </div>
    </div>
</nav>-->

<style>
body {
    font-family: Outfit;
    background: linear-gradient(135deg, #01229E, #01E584);
    margin: 0;
    min-height: 100vh;
    display: flex;
    flex-direction: column;
}

.container {
    flex: 1;
    display: flex;
    justify-content: center;
    align-items: center;
}

.perfil {
    padding: 140px 0px;
    text-align: center;
}

h2 {
    font-size: 60px;
    color: white;
}

.formulario {
    width: 100%;
    max-width: 400px; /* Ajusta el tamaño máximo del formulario */
    margin: 0 auto; /* Centra el formulario horizontalmente */
    background-color: white; /* Fondo blanco para el formulario */
    padding: 20px; /* Espacio interior del formulario */
    border-radius: 10px; /* Bordes redondeados */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Sombra para darle profundidad */
}

.formulario label {
    display: block;
    margin-bottom: 8px;
    font-weight: bold;
    font-size: 16px;
    color: #333;
}

.formulario input[type="text"],
.formulario input[type="password"] {
    width: 100%;
    padding: 10px;
    margin-bottom: 20px; /* Espacio adicional antes del botón */
    border-radius: 5px;
    border: 1px solid #ccc;
    font-size: 16px;
    box-sizing: border-box; /* Asegura que el padding y el borde se incluyan en el ancho total */
}

.formulario button {
  width: 100%;
  display: block;
  padding: 0.5em 2.5rem;
  cursor: pointer;
  gap: 0.4rem;
  font-weight: bold;
  border-radius: 8px;
  /*text-shadow: 2px 2px 3px rgb(136 0 136 / 50%);*/
  background: linear-gradient(15deg, #0059b2, #008ca4, #00b487, #00b487, #6fe327, #6ebc3d, #00b487, #008ca4, #0059b2);
  background-size: 300%;
  color: #fff;
  border: none;
  background-position: left center;
  /*box-shadow: 0 30px 10px -20px rgba(0,0,0,.2);*/
  transition: background .5s cubic-bezier(0.85, 0.02, 0.23, 1.02);
  font-size: 20px;
  text-decoration: none;
}

.formulario button:hover {
  color:white;
  background-size: 320%;
  background-position: right center;
}


footer {
    text-align: center;
    padding: 20px 0;
    background: #01229E; /* Asegúrate de que el color de fondo sea el adecuado */
}
</style>
</head>
<body>

<div class="container">
    <div class="perfil">
        <h2>Editar Usuario</h2>
        <form method="post" class="formulario" action="./edit_usu.php">
            <label for="new_nombre">Nuevo Nombre:</label>
            <input type="text" name="new_nombre" placeholder="Ingresa un nuevo nombre:" required><br>

            <label for="new_password">Nueva Contraseña:</label>
            <input type="password" name="new_password" minlength="8" placeholder="Ingresa una nueva contraseña:" required>

            <input type="hidden" name="account_id" value="<?php echo $account_id; ?>">

            <button type="submit" name="edit_account">Guardar Cambios</button>
        </form><br><br>

        <center> <a class="botonDysie" href="view_accounts.php">Regresar al perfil</a> <center> <br><br>
        
        <?php if (isset($_SESSION["success"])) { ?>
            <div class="alert alert-success">
                <?php echo $_SESSION["success"]; ?>
            </div>
            <?php if (isset($_SESSION["new_nombre"])) { ?>
                <p>Nuevo nombre: <?php echo $_SESSION["new_nombre"]; ?></p>
                <?php unset($_SESSION["new_nombre"]); ?>
            <?php } ?>
            <?php unset($_SESSION["success"]); ?>
        <?php } ?>
    </div>
</div>
</body>
<footer>
    <div class="contenedor-footer">
        <div class="footer-contentido">
            <div class="nombre-p">
                <h2>Dysie - </h2>
            </div>
            <div class="redes-sociales">
                <a href="#"><img src="../assets/redes-sociales/fb-logo.png" alt="Facebook"></a>
                <a href="#"><img src="../assets/redes-sociales/x-logo2.png" alt="Twitter"></a>
                <a href="#"><img src="../assets/redes-sociales/ig-logo.png" alt="Instagram"></a>
            </div>
        </div>
        <div class="derechos-reservados">
            <p>Derechos Reservados - Dysie &copy; 2024</p>
        </div>
    </div>
</footer>

<!-- 
<footer class="py-5 bg-dark">
    <div class="container px-5">
        <p class="m-0 text-center text-white">Copyright &copy; 2023 Kanban Dysie</p>
    </div>
</footer>-->

  <!-- SCRIPT ANIMACIONES AOS ANIMATE -->

  <script src="../aos-master/dist/aos.js"></script>
  <script>
    AOS.init({
      easing: 'ease-in-out-sine'
    });
  </script>
</html>
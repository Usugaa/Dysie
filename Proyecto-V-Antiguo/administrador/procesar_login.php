<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Conexión a la base de datos (ajusta los detalles según tu configuración)
    $conexion = new mysqli("localhost", "root", "", "dysie");

    // Verificamos si la conexión tiene errores
    if ($conexion->connect_error) {
        die("La conexión falló: " . $conexion->connect_error);
    }

    // Recibimos los datos del formulario
    $usuario = $_POST["txt_usuario"];
    $contraseña = $_POST["txt_contraseñaL"];

    // Consulta SQL para buscar el usuario en la tabla de administradores
    $consulta = "SELECT * FROM administrador WHERE usuario = '$usuario' AND contra = '$contraseña'";

    // Ejecutamos la consulta
    $resultado = $conexion->query($consulta);

    // Verificamos si encontramos un usuario administrador
    if ($resultado->num_rows > 0) {
        // Iniciamos sesión y redirigimos al usuario al dashboard
        $_SESSION["usuario"] = $usuario;
        header("Location: dashboard.php");
        exit(); // Detenemos la ejecución del script
    } else {
        // Si no encontramos un usuario, mostramos un mensaje de error
        $_SESSION["error"] = "Usuario o contraseña incorrectos";
        header("Location: login.php");
        exit(); // Detenemos la ejecución del script
    }

    // Cerramos la conexión a la base de datos
    $conexion->close();
}
?>

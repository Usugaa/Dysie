<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recuperar los valores del formulario de registro

    // Expresiones regulares para validar los campos
    $expresiones = array(
        'txt_nombre' => '/^[a-zA-ZÀ-ÿ\s]{1,40}$/',
        'txt_apellido' => '/^[a-zA-ZÀ-ÿ\s]{1,40}$/',
        'txt_contraseña' => '/^.{4,12}$/',
        'txt_email' => '/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/',
    );

    // Recuperar los valores del formulario de registro

    $nombre = $_POST["txt_nombre"];
    $apellido = $_POST["txt_apellido"];
    $email = $_POST["txt_email"];
    $contrasena = $_POST["txt_contraseña"];
    $fechaNacimiento = $_POST["txt_fecha"];

    // Hashear la contraseña antes de almacenarla en la base de datos
    $hashContrasena = password_hash($contrasena, PASSWORD_DEFAULT);

    // Rol por defecto: estudiante
    $rol = "estudiante";

    // Conectar a la base de datos y realizar la inserción
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "dysie";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("La conexión a la base de datos falló: " . $conn->connect_error);
    }

    // Verificar si el email ya está registrado
    $stmt = $conn->prepare("SELECT * FROM usuario WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION["error"] = "El correo electrónico ya está registrado.";
        header("Location: login.php");
        exit();
    }

    // Calcular la edad del usuario
    $fechaNacimientoDate = new DateTime($fechaNacimiento);
    $hoy = new DateTime();
    $edad = $hoy->diff($fechaNacimientoDate)->y;

    if ($edad < 15) {
        $_SESSION["error"] = "Debes tener al menos 15 años para registrarte.";
        header("Location: login.php");
        exit();
    }

    // Hash de la contraseña
    $hashContrasena = password_hash($contrasena, PASSWORD_DEFAULT);
    // Insertar la información del usuario en la base de datos
    $stmt = $conn->prepare("INSERT INTO usuario (nombre_usu, apellidos_usu, email, contra, fecha_nacimiento, roles) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $nombre, $apellido, $email, $hashContrasena, $fechaNacimiento, $rol);

    if ($stmt->execute()) {
        $_SESSION["registro_exitoso"] = true;
        header("Location: login.php");
    } else {
        $_SESSION["error"] = "Error en el registro. Por favor, intenta de nuevo.";
        header("Location: login.php");
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: login.php");
    exit();
}

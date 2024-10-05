<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["txt_emailL"];
    $contrasena = $_POST["txt_contraseñaL"];

    // Conectar a la base de datos
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "dysie";
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("La conexión a la base de datos falló: " . $conn->connect_error);
    }

    // Verificar si el email y la contraseña son correctos
    $stmt = $conn->prepare("SELECT id_usuario, contra FROM usuario WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashContrasena = $row["contra"];

        // En procesar_login.php
if (password_verify($contrasena, $hashContrasena)) {
    // Las credenciales son correctas, iniciar sesión
    $_SESSION["usuario_id"] = $row["id_usuario"];
    $_SESSION["email"] = $email;
    $_SESSION["login_exitoso"] = true;
    error_log("Login exitoso para el usuario: $email"); // Mensaje de depuración
    header("Location: ../inicio/index.php");
    exit();
} else {
    // Contraseña incorrecta
    $_SESSION["error"] = "Contraseña incorrecta.";
    error_log("Contraseña incorrecta para el usuario: $email"); // Mensaje de depuración
    header("Location: login.php");
    exit();
}

    } else {
        // Correo electrónico no encontrado
        $_SESSION["error"] = "Correo electrónico no encontrado.";
        header("Location: login.php");
        exit();
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: login.php");
    exit();
}
?>

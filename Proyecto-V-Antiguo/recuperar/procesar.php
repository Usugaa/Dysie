<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once('../conexion.php');
require '../PHPMailer/Exception.php';
require '../PHPMailer/PHPMailer.php';
require '../PHPMailer/SMTP.php';

$email = $_POST['email'];

// Genera una nueva contraseña aleatoria
$new_password = generateRandomPassword(); // Define esta función para generar una contraseña aleatoria
$hashed_password = password_hash($new_password, PASSWORD_DEFAULT); // Asegúrate de almacenar la contraseña encriptada

// Actualiza la contraseña en la base de datos
$query = "UPDATE usuario SET contra = '$hashed_password' WHERE email = '$email'";
$result = $conn->query($query);

if ($result) {
    // Envía el correo electrónico de recuperación
    $mail = new PHPMailer(true);

    try {
        // Configuración del servidor SMTP
        $mail->isSMTP();                                            
        $mail->Host       = 'smtp.gmail.com';                     
        $mail->SMTPAuth   = true;                                   
        $mail->Username   = 'dysie791@gmail.com'; // Cambia esto a tu dirección de correo electrónico                    
        $mail->Password   = 'dysieadmin'; // Cambia esto a tu contraseña del correo o mejor usa una variable de entorno                              
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            
        $mail->Port       = 465;                                    

        // Destinatario
        $mail->setFrom('dysie791@gmail.com', 'Dysie'); // Cambia esto a tu dirección de correo electrónico
        $mail->addAddress($email);     // Agrega el destinatario

        // Contenido del correo
        $mail->isHTML(true);           // Establece el formato del correo electrónico como HTML
        $mail->Subject = 'Recuperación de contraseña';
        $mail->Body    = 'Tu nueva contraseña es: ' . $new_password;
        $mail->AltBody = 'Tu nueva contraseña es: ' . $new_password;

        $mail->send();
        echo 'Se ha enviado el mensaje de recuperación';
    } catch (Exception $e) {
        echo "No se pudo enviar el mensaje. Error del correo: {$mail->ErrorInfo}";
    }
} else {
    $_SESSION['error'] = "Error actualizando el registro: " . $conn->error;
    header("Location: ./recuperar.php");
}

// Función para generar una contraseña aleatoria
function generateRandomPassword($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomPassword = '';
    for ($i = 0; $i < $length; $i++) {
        $randomPassword .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomPassword;
}
?>

<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dysie";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener los datos enviados desde JavaScript
$data = json_decode(file_get_contents("php://input"));

if (isset($data->usuarioId) && isset($data->estadoMembresia)) {
    $usuarioId = $data->usuarioId;
    $estadoMembresia = $data->estadoMembresia;

    // Actualizar la membresía del usuario
    $sql = "UPDATE usuario SET nombre_membresia = ? WHERE id_usuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $estadoMembresia, $usuarioId);

    if ($stmt->execute()) {
        echo json_encode(["message" => "Membresía actualizada correctamente"]);
    } else {
        echo json_encode(["message" => "Error al actualizar la membresía"]);
    }

    $stmt->close();
} else {
    echo json_encode(["message" => "Datos inválidos"]);
}

$conn->close();

//ELIMINAR TABLEROS EXCEDENTES DE 12 SI SE DESACTIVA EL PLAN PREMIUM 
// Si el usuario no tiene membresía premium, se elimina el exceso de tableros
$_SESSION['tableros_eliminados'] = $exceso_tableros;

if (!$premium) {
    $sql = "SELECT COUNT(*) AS num_tableros FROM tableros WHERE id_usuario = $id_usuario";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $num_tableros = $row['num_tableros'];

        if ($num_tableros > 12) {
            $exceso_tableros = $num_tableros - 12;
            $sql = "SELECT id_tablero FROM tableros WHERE id_usuario = $id_usuario LIMIT $exceso_tableros";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $id_tablero = $row['id_tablero'];
                    $sql_delete = "DELETE FROM tableros WHERE id_tablero = $id_tablero";
                    if ($conn->query($sql_delete) !== TRUE) {
                        echo "Error al eliminar tablero: " . $conn->error;
                    }
                }
            }
        }
    }
}

?>

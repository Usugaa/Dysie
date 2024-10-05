<?php
session_start();
// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    $_SESSION["error"] = "Debes iniciar sesión para acceder a esta página.";
    header("Location: login.php");
    exit();
}

// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dysie";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if (isset($_POST['usuarioId']) && isset($_POST['estadoMembresia'])) {
    $usuarioId = $_POST['usuarioId'];
    $estadoMembresia = $_POST['estadoMembresia'] === 'true' ? 1 : 0;

    $sql = "UPDATE usuario SET nombre_membresia=$estadoMembresia WHERE id_usuario=$usuarioId";
    if ($conn->query($sql) === TRUE) {
        echo "Membresía actualizada correctamente";
    } else {
        echo "Error al actualizar la membresía: " . $conn->error;
    }
    exit();
}

// Consulta SQL para obtener todos los usuarios
$sql = "SELECT id_usuario, nombre_usu, email, nombre_membresia FROM usuario";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Perfil de Usuario</title>

    <link rel="stylesheet" href="../aos-master/dist/aos.css" /> <!-- AOS ANIMATE -->
    <link rel="preconnect" href="https://fonts.googleapis.com"> <!-- OUTFIT GOOGLE FONT -->
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin> <!-- OUTFIT GOOGLE FONT -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&family=Outfit:wght@100..900&display=swap" rel="stylesheet"> <!-- OUTFIT GOOGLE FONT -->

    <link href="estilosIndex.css" rel="stylesheet" />
    <link href="../index.css" rel="stylesheet" />

    <style>
        body {
            font-family: Outfit;
            background: linear-gradient(135deg, #01229E, #01E584);
            margin: 0;
        }

        h2 {
            text-align: center;
            font-size: 60px;
            color: white;
        }

        table {
            width: 80%;
            border-collapse: collapse;
            margin-top: 20px;
            margin-left: 120px;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background: linear-gradient(#5bffba85, #01229eb3);
            color: #fff;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        a {
            text-decoration: none;
            font-weight: bold;
        }

        .perfil {
            padding: 300px 0px;
        }
    </style>
</head>

<body>

<header>
    <a href="" class="logo"><img class="" src="../assets/logoDysie.png" alt=""></a>
    <nav>
        <ul>
            <a href="logout.php" class="botonDysie" style="font-size: 20px; box-shadow: 0px 20px 60px -20px rgba(0,0,0, 0.5); padding: 10px 30px; margin: 0px 10px;">Cerrar Sesión</a>
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

<div class="perfil">
    <h2>Usuarios Registrados</h2>
    <table>
        <tr>
            <th>ID Usuario</th>
            <th>Nombre</th>
            <th>Correo Electrónico</th>
            <th>Membresía</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            // Mostrar cada usuario en la tabla
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["id_usuario"] . "</td>";
                echo "<td>" . $row["nombre_usu"] . "</td>";
                echo "<td>" . $row["email"] . "</td>";
                echo '<td><input type="checkbox" id="membresia-' . $row["id_usuario"] . '" name="membresia" onchange="actualizarMembresia(' . $row["id_usuario"] . ')" ' . ($row["nombre_membresia"] ? 'checked' : '') . '></td>';
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No se encontraron usuarios.</td></tr>";
        }
        ?>
    </table>
</div>

<script>
function actualizarMembresia(usuarioId) {
    const checkbox = document.getElementById('membresia-' + usuarioId);
    const estadoMembresia = checkbox.checked ? 1 : 0;

    fetch('actualizar_membresia.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            usuarioId: usuarioId,
            estadoMembresia: estadoMembresia,
        }),
    })
    .then(response => response.json())
    .then(data => {
        if (data.message) {
            console.log(data.message);
        } else {
            console.error('Error al actualizar la membresía');
        }
    })
    .catch(error => {
        console.error('Error al actualizar la membresía:', error);
    });
}
</script>


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
</body>
</html>
<?php $conn->close(); ?>

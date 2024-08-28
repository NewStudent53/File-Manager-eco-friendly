<?php
// Conexión a la base de datos
$host = "localhost";
$user = "root";
$pass = "1d0ntw4nn4kn0w";
$db = "login";
$conn = new mysqli($host, $user, $pass, $db);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener el ID del archivo a actualizar
if (isset($_POST['file_id'])) {
    $file_id = $_POST['file_id'];

    // Consulta SQL para actualizar el campo trash_indicator
    $sql = "UPDATE files SET trash_indicator = 1 WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $file_id);

    if ($stmt->execute()) {
        echo "File has been moved successfully.";
    } else {
        echo "Error al mover el archivo a la papelera: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "ID de archivo no proporcionado.";
}
$conn->close();
?>

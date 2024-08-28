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
    $sql = "UPDATE files SET trash_indicator = 0 WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $file_id);

    if ($stmt->execute()) {
        echo "File has been recovered successfully.";
    } else {
        echo "There was an error in trying to recover the file: " . $stmt->error;
    }
    

    $stmt->close();
} else {
    echo "file's id has not been asigned.";
}

$conn->close();
?>
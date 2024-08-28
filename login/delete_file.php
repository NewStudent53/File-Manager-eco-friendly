<?php
// Conexión a la base de datos
$host = "localhost";
$user = "root";
$pass = "1d0ntw4nn4kn0w";
$db = "login";
$conn = new mysqli($host, $user, $pass, $db);

// Verificar conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Obtener el ID del archivo a eliminar
if (isset($_POST['file_id'])) {
    $file_id = $_POST['file_id'];

    // Consulta SQL para obtener el nombre del archivo y la ruta
    $sql = "SELECT file_name, file_path FROM files WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $file_id);
    $stmt->execute();
    $stmt->bind_result($file_name, $file_path);
    $stmt->fetch();
    $stmt->close();

    if ($file_name && $file_path) {
        // Ruta completa del archivo
        $file_full_path = $file_path . $file_name;

        echo "Byebye file: $file_full_path";
        // Eliminar el archivo físico del servidor
        if (file_exists($file_full_path)) {
            if (unlink($file_full_path)) {
                echo "File has been eliminated.";
            } else {
                echo "File couldn't be eliminated.";
            }
        } else {
            echo "Couldn't find file on server.";
        }

        // Consulta SQL para eliminar el registro de la base de datos
        $sql = "DELETE FROM files WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $file_id);

        if ($stmt->execute()) {
            echo "<script>alert('File has been permanently deleted successfully');window.location.href='Mytrashfiles.php';</script>";
        } else {
            echo "Couldn't delete the register on the db: " . $stmt->error;
            echo "<script>alert('Couldn't eliminate file');</script>";
            echo "<script>window.location.href='Mytrashfiles.php';</script>";

        }

        $stmt->close();
    } else {
        echo "Couldn't find file on db.";
    }
} else {
    echo "file_ID not found.";
}
$conn->close();
?>

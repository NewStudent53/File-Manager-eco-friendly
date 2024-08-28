<?php
session_start();
ini_set("display_errors", 1);
ini_set("display_startup_errors", 1);
error_reporting(E_ALL);
include '../connect.php';

$id_usuario = isset($_GET['user_id']) ? $_GET['user_id'] : 30;
$sql = "SELECT user_id, file_name, file_type, file_path, upload_date, trash_indicator, id FROM files WHERE user_id = ? AND trash_indicator = 0";

// Preparar y ejecutar la consulta
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$result = $stmt->get_result();

// Crear un arreglo para almacenar los resultados
$files = array();

// Llenar el arreglo con los datos obtenidos de la base de datos
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $files[] = array(
            'user_id' => $row["user_id"],
            'file_name' => $row["file_name"],
            'file_type' => $row["file_type"],
            'file_path' => $row["file_path"],
            'upload_date' => $row["upload_date"],
            'trash_indicator' => $row["trash_indicator"],
            'id' => $row['id']
        );
    }
} else {
    echo json_encode(array("message" => "No se encontraron archivos."));
    exit;
}

// Convertir el arreglo a formato JSON y mostrarlo
echo json_encode($files);

// Cerrar la conexión
$stmt->close();
$conn->close();
?>

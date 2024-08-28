<?php
// verify_login.php

$host = 'localhost';
$db = 'test_db';
$user = 'root';
$pass = 'your_password';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email AND password = :password");
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $password);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        echo "Login exitoso";
        // Aquí puedes redirigir al usuario a su dashboard
        header("Location: https://filemanager.eco/dashboard");
        exit();
    } else {
        echo "Email o contraseña incorrectos";
    }
} catch (PDOException $e) {
    echo "Error en la conexión: " . $e->getMessage();
}
?>
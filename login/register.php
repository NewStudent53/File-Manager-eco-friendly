<?php 

include 'connect.php';

if(isset($_POST['signUp'])){
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmpassword = $_POST['confirmpassword'];

    // Patrón de contraseña
    $password_pattern = '/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/';

    // Validar la contraseña
    if (!preg_match($password_pattern, $password)) {
        echo "<script>alert('Password didn\'t meet the security criteria');window.location.href='index.php';</script>";
    } else {
        $password = md5($password);

        $checkEmail = "SELECT * FROM users WHERE email='$email'";
        $result = $conn->query($checkEmail);
        if($result->num_rows > 0){
            echo "<script>alert('Email adress already exists!');window.location.href='index.php';</script>";
        } else {
            $insertQuery = "INSERT INTO users(username, email, password)
                            VALUES ('$username', '$email', '$password')";
            if($conn->query($insertQuery) === TRUE){
                echo "<script>alert('Your account has been created, sending you to Login');window.location.href='index.php';</script>";
            } else {
                echo "Error: " . $conn->error;
            }
        }
    }
}
?>

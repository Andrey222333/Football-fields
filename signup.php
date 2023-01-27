<?php 
    session_start();
    require("database.php");
    
    $name = $_POST["name"];
    $email = $_POST["email"];
    $login = $_POST["login"];
    $password = $_POST["password"];
    $password2 = $_POST["password2"];

    if ($password == $password2){
        $password = md5($password);
        $query =  mysqli_query($mysql, "SELECT * FROM users WHERE name = '$name' AND email = '$email'AND login = '$login' AND password = '$password';");
        if (mysqli_num_rows($query) == 0) {
            $query =  mysqli_query($mysql, "INSERT INTO users (name, email, login, password) VALUES ('$name', '$email', '$login', '$password');");
            header('Location: login.php');
        } else {
            $_SESSION['message'] = "Такой пользователь существует";
            header('Location: registration.php');
        }
    } else {
        $_SESSION['message'] = "Пароли не совпадают";
        header('Location: registration.php');
    } 
?>
<?php 
    session_start();
    require("database.php");
    
    $name = $_POST["name"];
    $login = $_POST["login"];
    $password = $_POST["password"];
    $password2 = $_POST["password2"];

    if ($password == $password2){
        $password = md5($password);
        $query =  mysqli_query($mysql, "SELECT * FROM users WHERE name = '$name'AND login = '$login' AND password = '$password';");
        if (mysqli_num_rows($query) == 0) {
            $query =  mysqli_query($mysql, "INSERT INTO users (name, login, password, id_role) VALUES ('$name', '$login', '$password', 2);");
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
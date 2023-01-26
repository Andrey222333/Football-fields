<?php 
    session_start();
    require("database.php");

    $login = $_POST["login"];
    $password = md5($_POST["password"]);

    $query =  mysqli_query($mysql, "SELECT * FROM users WHERE login = '$login' AND password = '$password';");
   if (mysqli_num_rows($query) > 0) {
    $user = mysqli_fetch_assoc($query);

    $_SESSION['user'] = [
        "id" => $user["id"],
        "name" => $user["name"]
    ];

    header('Location: map.php');

   } else {
        $_SESSION['message'] = "Не верный логин или пароль";
        header('Location: login.php');
   }
?>
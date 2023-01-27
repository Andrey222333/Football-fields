<?php 
    require("database.php");

    session_start();

    if ($_SESSION["user"]) {
        $id_field = $_GET['ID'];
        $id_user = $_SESSION['user']['id'];
        $query =  mysqli_query($mysql, "SELECT * FROM favourites WHERE id_user = '$id_user' AND id_field = '$id_field';");
        if (mysqli_num_rows($query) == 0) {
            $query =  mysqli_query($mysql, "INSERT INTO favourites (id_user, id_field) VALUES ('$id_user', '$id_field');");
            header('Location: account.php');
        } else {
            $_SESSION['message'] = "Поле уже добавлено в избранное";
            header('Location: account.php');
        }
    } else {
        $_SESSION['message'] = "Сначала нужно войти в аккаунт";
        header('Location: login.php');
    }
?>
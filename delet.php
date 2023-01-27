<?php
    require("database.php");
    $id = $_GET['ID'];
    $query =  mysqli_query($mysql, "DELETE FROM favourites WHERE id = '$id';");
    header('Location: account.php');
?>
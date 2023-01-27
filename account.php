<?php 
    require("database.php");

    session_start();

    if (!$_SESSION["user"]) {
        header('Location: login.php');
    }

    $user_id = $_SESSION['user']['id'];
    $favourites = array();

    $query =  mysqli_query($mysql, "SELECT address, working_hours, square, surface_type, paid, favourites.id FROM fields JOIN favourites ON fields.id = favourites.id_field AND favourites.id_user = $user_id;");

    while ($row = mysqli_fetch_assoc($query)) {
        array_push($favourites, $row);
    }
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://api-maps.yandex.ru/2.1/?apikey=deab617f-c9ac-424c-840a-3412b731797d&lang=ru_RU" type="text/javascript"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@100;400;700&family=Roboto:wght@100;400;700&display=swap" rel="stylesheet">
    <title>Личный кабинет</title>
</head>
<body class="body_account">
    <?php 
        if ($_SESSION["user"]){
            require("components/header_authorized.php");
        } else {
            require("components/header_not_authorized.php");
        }
    ?>
    <main class="main_account">
        
        <div class="title"><p>Избранное</p></div>
        <div class="styletable">
            <table class="tables">
                <thead>
                    <tr>
                        <th>№</th>
                        <th class="left">Адресс</th>
                        <th>Время работы</th>
                        <th>Площадь</th>
                        <th>Тип покрытия</th>
                        <th>Стоимость</th>
                        <th></th>
                    </tr>
                </thead>
                <?php
                    $count = 1;
                    foreach($favourites as $favourite) {
                    echo '<tr>
                    <td>',$count,'</td>
                    <td class="left">',$favourite['address'],'</td>
                    <td>',$favourite['working_hours'],'</td>
                    <td>',$favourite['square'],'</td>
                    <td>',$favourite['surface_type'],'</td>
                    <td>',$favourite['paid'],'</td>
                    <td><a href="delet.php?ID='.$favourite['id'].'">Удалить</a></td>
                    </tr>';
                    $count += 1;
                    }
                ?>
            </table>
        </div>
        <?php 
            if ($_SESSION['message']) {
                echo '<p class="msg">'.$_SESSION['message'].'</p>';
            }
            unset($_SESSION['message']);
        ?>
    </main>
    <footer class="footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="copyright"><b>© Football fields, 2023</b></div>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
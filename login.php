<?php 
    session_start();

    if ($_SESSION["user"]) {
        header('Location: account.php');
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
    <title>Вход</title>
</head>
<body class="body_login">
    <?php 
        if ($_SESSION["user"]){
            require("components/header_authorized.php");
        } else {
            require("components/header_not_authorized.php");
        }
    ?>
    <main class="main_login">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="form_body">
                        <form class="form" name="test" method="post" action="signin.php">
                            <h1 class="form_title">Вход</h1>
                            <div class="form_container">
                                <input class="form_input" type = "text" name="login" placeholder=" " >
                                <label class="form_label">Логин</label>
                            </div>
                            <div class="form_container">
                                <input class="form_input" type="password" name="password" placeholder=" ">
                                <label class="form_label">Пароль</label>
                            </div>
                            <input class="form_button" type="submit" value="Вход">
                            <p class = "newaccount"><a href="registration.php">Создать аккаунт</a><p>
                            <?php 
                                if ($_SESSION['message']) {
                                    echo '<p class="msg">'.$_SESSION['message'].'</p>';
                                }
                                unset($_SESSION['message']);
                            ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
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
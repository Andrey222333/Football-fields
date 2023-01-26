<?php 
    session_start();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style.css" rel="stylesheet">
    <script src="https://api-maps.yandex.ru/2.1/?apikey=deab617f-c9ac-424c-840a-3412b731797d&lang=ru_RU" type="text/javascript"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@100;400;700&family=Roboto:wght@100;400;700&display=swap" rel="stylesheet">
    <title>Регистрация</title>
</head>
<body class="body_registration">
    <header class="header">
        <div class="container-fluid">
             <div class="row">
                <div class="col">
                    <div class="nav-item nav-b"><b>Football fields</b></div>
                 </div>
            </div>
        </div>
    </header>
    <main class="main_registration">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="form_body">
                        <form class="form" name="test" method="post" action="signup.php">
                            <h1 class="form_title">Регистрация</h1>
                            <div class="form_container">
                                <input class="form_input" type = "text" name="name" placeholder=" " >
                                <label class="form_label">Имя</label>
                            </div>
                            <div class="form_container">
                                <input class="form_input" type = "text" name="login" placeholder=" " >
                                <label class="form_label">Логин</label>
                            </div>
                            <div class="form_container">
                                <input class="form_input" type="password" name="password" placeholder=" ">
                                <label class="form_label">Пароль</label>
                            </div>
                            <div class="form_container">
                                <input class="form_input" type="password" name="password2" placeholder=" ">
                                <label class="form_label">Повторите пароль</label>
                            </div>
                            <input class="form_button" type="submit" value="Вход">
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
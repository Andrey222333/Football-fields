<?php 
require("filter_constant.php");
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@100;400;700&family=Roboto:wght@100;400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <title>Фильтр</title>
</head>
<body class="body_filter">
     <header class="header">
        <div class="container-fluid">
             <div class="row">
                <div class="col">
                    <div class="nav-item nav-b"><b>Football fields</b></div>
                 </div>
            </div>
        </div>
    </header>
     <main class="main_filter">
        <div class="container">
            <div class="row tetx-center">
                <div class="form_filter">
                    <form class="form_2" name="test" action="map.php" method="post">
                        <div class="form_group">
                            <p class="form_text">Стоимость</p>
                            <div class="form_div">
                                <select class="form_select" name="select1" id="select1">
                                    <option disabled>Стоимость</option>
                                    <?php 
                                    foreach ($paid as $p) {
                                        echo "<option selected value=".str_replace(' ', '_', $p).">".$p."</option>";
                                    }
                                    ?>
                                    <option selected value="Не выбрано">Не выбрано</option>
                                </select>
                            </div>
                            <p class="form_text">Район</p>
                            <div class="form_div">
                                <select class="form_select" name="select2" id="select2">
                                    <option disabled>Район</option>
                                    <?php 
                                    foreach ($district as $d) {
                                        echo "<option selected value=".str_replace(' ', '_', $d).">".$d."</option>";
                                    }
                                    ?>
                                    <option selected value="Не выбрано">Не выбрано</option>
                                </select>
                            </div>
                            <p class="form_text">Тип покрытия</p>
                            <div class="form_div">
                                <select class="form_select" name="select3" id="select3">
                                    <option disabled>Тип покрытия</option>
                                    <?php 
                                    foreach ($surface_type as $s) {
                                        echo "<option selected value=".str_replace(' ', '_', $s).">".$s."</option>";
                                    }
                                    ?>
                                    <option selected value="Не выбрано">Не выбрано</option>
                                </select>
                            </div>
                            <p class="form_p"><input class="button" type="submit" value="Применить"></p>
                        </div>
                    </form>
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
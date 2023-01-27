<?php 
require("database.php");

session_start();

$football_fields = array();
$points = array();
$paid = str_replace('_', ' ', $_POST["select1"]);
$district = str_replace('_', ' ', $_POST["select2"]);
$surface_type = str_replace('_', ' ', $_POST["select3"]);

if (($paid == "Не выбрано" && $surface_type == "Не выбрано" && $district == "Не выбрано") || ($paid == NULL && $surface_type == NULL && $district == NULL)) {
    $query =  mysqli_query($mysql, "SELECT * FROM fields");
    while ($row = mysqli_fetch_assoc($query)) {
        $fields = array();

        array_push($fields,(float)$row["longitude"]);
        array_push($fields,(float)$row["width"]);
        array_push($points, $fields);
        array_push($football_fields, $row);
    }
} else {
    $request = array();
    $sql_request = "";
    $key = array();

    if ($paid != "Не выбрано") {
        $request["paid"] = $paid;
        array_push($key, "paid");
    }
    if ($surface_type != "Не выбрано") {
        $request["surface_type"] = $surface_type;
        array_push($key, "surface_type");
    }
    if ($district != "Не выбрано") {
        $request["district"] = $district;
        array_push($key, "district");
    }

    if (count($request) == 1){
        $sql_request = "SELECT * FROM fields WHERE ".$key[0]." = \"".$request[$key[0]]."\"; ";
    } else if (count($request) == 2) {
        $sql_request = "SELECT * FROM fields WHERE ".$key[0]." = \"".$request[$key[0]]."\" AND ".$key[1]." = \"".$request[$key[1]]."\"; ";
    }else if (count($request) == 3) {
        $sql_request = "SELECT * FROM fields WHERE ".$key[0]." = \"".$request[$key[0]]."\" AND ".$key[1]." = \"".$request[$key[1]]."\" AND ".$key[2]." = \"".$request[$key[2]]."\"; ";
    }

    $query =  mysqli_query($mysql, $sql_request);
    while ($row = mysqli_fetch_assoc($query)) {
        $fields = array();

        array_push($fields,(float)$row["longitude"]);
        array_push($fields,(float)$row["width"]);
        array_push($points, $fields);
        array_push($football_fields, $row);
    }
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
    <title>Football fields</title>
</head>
<body class="body_map">
    <?php 
        if ($_SESSION["user"]){
            require("components/header_authorized.php");
        } else {
            require("components/header_not_authorized.php");
        }
    ?>
    <main class="main_map">
        <div id="map" style="width: 100%; height: 90vh">
            <a href="filter.php"><button class="bt" style="position: absolute; margin-top: 10px; margin-right: 10px; right: 0; z-index: 1">Фильтр</button></a>
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

    <script type="text/javascript">

    football_fields = <?php echo json_encode($football_fields) ?>;

    ymaps.ready(init);

    function init(){
        var myMap = new ymaps.Map("map", {
            center: [55.7522, 37.6156],
            controls: ['routeButtonControl'],
            zoom: 10
        });

        myMap.controls.remove('trafficControl');
        myMap.controls.remove('searchControl');

        control = myMap.controls.get('routeButtonControl');
        let location = ymaps.geolocation.get();

        location.then(function(res) {
            let locationText = res.geoObjects.get(0).properties.get('text');
            console.log(locationText);

            control.routePanel.state.set('from', locationText);
        });
        
        clusterer = new ymaps.Clusterer({
            
            preset: 'islands#invertedBlueClusterIcons',
            
            groupByCoordinates: false,
            
            clusterDisableClickZoom: true,
            clusterHideIconOnBalloonOpen: false,
            geoObjectHideIconOnBalloonOpen: false
        }),
        
            getPointData = function (address, time, square, surface_type, paid, id, index) {
            return {
                balloonContentHeader: '<font size=3><b><p>Данные о поле</p></b></font>',
                balloonContentBody: '<p>Адресс: ' + address + '</p><p>Часы работы: '+ time +'</p><p>Площадь площадки: '+ square +'</p><p>Покрытие площадки: '+ surface_type +'</p><p>Стоимость: '+ paid +'</p><p><a href="add.php?ID='+ id +'">Добавить в избранное</a></p>',
                balloonContentFooter: '<font size=1>Информация предоставлена: </font> балуном <strong>метки ' + index + '</strong>',
                clusterCaption: 'метка <strong>' + index + '</strong>'
            };
        },
       
            getPointOptions = function () {
            return {
                preset: 'islands#blueIcon'
            };
        },
        points = <?php echo json_encode($points) ?>,
        geoObjects = [];

    for(var i = 0, len = points.length; i < len; i++) {
        fields = football_fields[i]
        geoObjects[i] = new ymaps.Placemark(points[i], getPointData(fields["address"], fields["working_hours"], fields["square"], fields["surface_type"], fields["paid"], fields["id"],  i), getPointOptions());
    }

    clusterer.options.set({
        gridSize: 80,
        clusterDisableClickZoom: true
    });

    clusterer.add(geoObjects);
    myMap.geoObjects.add(clusterer);

    myMap.setBounds(clusterer.getBounds(), {
        checkZoomRange: true
    });
    }
</script>
</body>
</html>
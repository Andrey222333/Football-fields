<?php 
require("database.php");

$football_fields = array();
$points = array();

$query =  mysqli_query($mysql, "SELECT * FROM fields");
while ($row = mysqli_fetch_assoc($query)) {
    $fields = array();

    array_push($fields,(float)$row["longitude"]);
    array_push($fields,(float)$row["width"]);
    array_push($points, $fields);
    array_push($football_fields, $row);
}
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
    <title>Football fields</title>
</head>
<body class="body_map">
    <main class="main_map">
        <div id="map" style="width: 100%; height: 100vh"></div>
    </main>
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

        clusterer = new ymaps.Clusterer({
            /**
             * Через кластеризатор можно указать только стили кластеров,
             * стили для меток нужно назначать каждой метке отдельно.
             * @see https://api.yandex.ru/maps/doc/jsapi/2.1/ref/reference/option.presetStorage.xml
             */
            preset: 'islands#invertedBlueClusterIcons',
            /**
             * Ставим true, если хотим кластеризовать только точки с одинаковыми координатами.
             */
            groupByCoordinates: false,
            /**
             * Опции кластеров указываем в кластеризаторе с префиксом "cluster".
             * @see https://api.yandex.ru/maps/doc/jsapi/2.1/ref/reference/ClusterPlacemark.xml
             */
            clusterDisableClickZoom: true,
            clusterHideIconOnBalloonOpen: false,
            geoObjectHideIconOnBalloonOpen: false
        }),
        /**
         * Функция возвращает объект, содержащий данные метки.
         * Поле данных clusterCaption будет отображено в списке геообъектов в балуне кластера.
         * Поле balloonContentBody - источник данных для контента балуна.
         * Оба поля поддерживают HTML-разметку.
         * Список полей данных, которые используют стандартные макеты содержимого иконки метки
         * и балуна геообъектов, можно посмотреть в документации.
         * @see https://api.yandex.ru/maps/doc/jsapi/2.1/ref/reference/GeoObject.xml
         */
            getPointData = function (address, time, square, surface_type, paid, index) {
            return {
                balloonContentHeader: '<font size=3><b><p>Данные о поле</p></b></font>',
                balloonContentBody: '<p>Адресс: ' + address + '</p><p>Часы работы: '+ time +'</p><p>Площадь площадки: '+ square +'</p><p>Покрытие площадки: '+ surface_type +'</p><p>Стоимость: '+ paid +'</p>',
                balloonContentFooter: '<font size=1>Информация предоставлена: </font> балуном <strong>метки ' + index + '</strong>',
                clusterCaption: 'метка <strong>' + index + '</strong>'
            };
        },
        /**
         * Функция возвращает объект, содержащий опции метки.
         * Все опции, которые поддерживают геообъекты, можно посмотреть в документации.
         * @see https://api.yandex.ru/maps/doc/jsapi/2.1/ref/reference/GeoObject.xml
         */
            getPointOptions = function () {
            return {
                preset: 'islands#blueIcon'
            };
        },
        points = <?php echo json_encode($points) ?>,
        geoObjects = [];

    /**
     * Данные передаются вторым параметром в конструктор метки, опции - третьим.
     * @see https://api.yandex.ru/maps/doc/jsapi/2.1/ref/reference/Placemark.xml#constructor-summary
     */
    for(var i = 0, len = points.length; i < len; i++) {
        fields = football_fields[i]
        geoObjects[i] = new ymaps.Placemark(points[i], getPointData(fields["address"], fields["working_hours"], fields["square"], fields["surface_type"], fields["paid"], i), getPointOptions());
    }

    for(var i = 0, len = points.length; i < len; i++) {
        console.log(points[i][0]);
        console.log(points[i][1]);
    }

    console.log(points.length);

    /**
     * Можно менять опции кластеризатора после создания.
     */
    clusterer.options.set({
        gridSize: 80,
        clusterDisableClickZoom: true
    });

    /**
     * В кластеризатор можно добавить javascript-массив меток (не геоколлекцию) или одну метку.
     * @see https://api.yandex.ru/maps/doc/jsapi/2.1/ref/reference/Clusterer.xml#add
     */
    clusterer.add(geoObjects);
    myMap.geoObjects.add(clusterer);

    /**
     * Спозиционируем карту так, чтобы на ней были видны все объекты.
     */

    myMap.setBounds(clusterer.getBounds(), {
        checkZoomRange: true
    });
    }
</script>
</body>
</html>
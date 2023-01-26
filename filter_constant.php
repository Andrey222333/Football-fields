<?php 
require("database.php");

$paid = ["бесплатно", "платно"];
$surface_type = array();
$district = array();

$query =  mysqli_query($mysql, "SELECT * FROM fields");
while ($row = mysqli_fetch_assoc($query)) {
    array_push($surface_type, $row["surface_type"]);
    array_push($district, $row["district"]);
}

$surface_type = array_unique($surface_type);
$district = array_unique($district);
$district = $district;

?>
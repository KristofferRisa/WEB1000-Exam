<?php 
include('./../php/AdminClasses.php');
include('./../php/Logg.php');

$airport = new Airport;

$logg = new Logg;

$rows = -1;

if($_GET['id']){
  $id = $_GET['id'];
  $rows = $airport->DeleteAirport($id, $logg);
}

header('Location: ./airports.php?deleteRows='.$rows);

?>
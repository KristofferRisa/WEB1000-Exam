<?php 
include('./../php/AdminClasses.php');
include('./../php/Logg.php');
include('../php/Plane.php');

$planes = new Planes;

$logg = new Logg;

$rows = -1;

if($_GET['id']){
  $id = $_GET['id'];
  $rows = $planes->DeletePlane($id, $logg);
}

header('Location: ./planes.php?deleteRows='.$rows);

?>


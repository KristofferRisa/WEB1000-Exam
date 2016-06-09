<?php 
include('./../php/AdminClasses.php');
include('./../php/Logg.php');
include('./../php/Avgang.php');

$avgang = new Avgang;

$logg = new Logg;

$rows = -1;

if($_GET['id']){
  $id = $_GET['id'];
  $rows = $avgang->DeleteAvgang($id, $logg);
}

header('Location: ./avganger.php?deleteRows='.$rows);

?>

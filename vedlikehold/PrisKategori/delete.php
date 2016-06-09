<?php 
include('./../php/AdminClasses.php');
include('./../php/Logg.php');
include('./../php/PrisKat.php');

$prisKat = new prisKat;

$logg = new Logg;

$rows = -1;

if($_GET['id']){
  $id = $_GET['id'];
  $rows = $prisKat->DeletePrisKat($id, $logg);
}

header('Location: ./priskategori.php?deleteRows='.$rows);

?>

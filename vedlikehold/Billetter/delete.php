<?php 
include('./../php/AdminClasses.php');
include('./../php/Logg.php');
include('../php/Billett.php');

$billett = new Billett;

$logg = new Logg;

$rows = -1;

if($_GET['id']){
  $id = $_GET['id'];
  $rows = $billett->DeleteBillett($id, $logg);
}

header('Location: ./billetter.php?deleteRows='.$rows);

?>


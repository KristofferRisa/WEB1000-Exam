<?php 
include('./../php/Destinasjon.php');
include('./../php/Logg.php');

$destinasjon = new Destinasjon;

$logg = new Logg;

$rows = -1;

if($_GET['id']){
  $id = $_GET['id'];
  $rows = $destinasjon->DeleteDestinasjon($id, $logg);
}

header('Location: ./destinations.php?deleteRows='.$rows);

?>
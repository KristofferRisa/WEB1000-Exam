<?php 
include('./../html/start.php');
include('../php/Bestilling.php');
$bestillinger = new Bestilling();

$rows = -1;

if($_GET['id']){
  $id = $_GET['id'];
  $rows = $bestillinger->DeleteBestilling($id, $logg);
}

header('Location: ./alle.php?deleteRows='.$rows);

?>
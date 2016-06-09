<?php 
include('./../html/start.php');
$rows = -1;

if($_GET['id']){
  $id = $_GET['id'];
  $rows = $user->DeleteUser($id, $logg);
}

header('Location: ./users.php?deleteRows='.$rows);

?>
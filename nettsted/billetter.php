<?php

include('./html/start.php');

if($_GET && $_GET['id']){
    //gir alle mulig til destinasjoner basert på destinasjon
    $bestillingsId = $_GET['id'];
    
    $billett = new Billett();

    $billettInfo = $billett->GetBillett($id,$logg);

} else {
    $data = $billett->GetAllBillett($logg);
}
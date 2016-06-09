<?php

include('./html/start.php');

if($_GET && $_GET['id'])
{
    $bestillingId = $_GET['id'];
    $bestilling = new Bestilling();

    $result = $bestilling->DeleteBestilling($bestillingId, TRUE, $logg);
    
    header('Location: ./minside.php?deleteRows='.$result);

    
}

?>

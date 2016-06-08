<?php

include('./html/start.php');

if($_GET && $_GET['id']){
    //gir alle mulig til destinasjoner basert på destinasjon
    $fraDestinasjon = $_GET['id'];
    
    $destinasjoner = $dest->GetDestinasjoner($fraDestinasjon,$logg);
    
    echo $html->GenerateSearchSelectionItem($destinasjoner);

    
} else {
    //gir alle mulige destinasjoner
    $destinasjoner = $dest->GetAllDestinasjoner($logg);
    echo $html->GenerateSearchSelectionItem($destinasjoner);
    
}

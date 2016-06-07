<?php 



$errorMelding = "";

// Validering av skjemainput

if ($_SERVER["REQUEST_METHOD"] == "POST") {


  if ( empty($_POST["flyplassID"]) || empty($_POST["navn"]) || empty($_POST["land"]) || empty($_POST["landskode"]) || empty($_POST["stedsnavn"]) || empty($_POST["geo_lat"]) || empty($_POST["geo_lng"]) )
  
   {

    $errorMelding = $html->errorMsg("Alle felt må fylles ut!");



}


elseif (filter_var($_POST["flyplassID"], FILTER_VALIDATE_INT) === false || strlen($_POST["geo_lat"]) > 100 || strlen($_POST["geo_lng"]) > 100 ) {
  $$errorMelding =  $html->errorMsg("Flyplass id må bestå kun av siffer og Geo data maks 100 tegn!");

}

elseif (strlen($_POST["navn"]) > 500 || strlen($_POST["land"]) > 500 || strlen($_POST["stedsnavn"]) > 100 ) {
  $errorMelding =  $html->errorMsg("Navn, land må være maks 500 tegn! Stedsnavn max 100! ");
}
elseif (strlen($_POST["landskode"]) !== 2 ) {
  $errorMelding = $html->errorMsg("Landskode må bestå av 2 tegn!");
}

  
  else {



    $valider = new ValiderData;

    $flyplassID = $valider->valider($_POST["flyplassID"]);
    $navn = $valider->valider($_POST["navn"]);
    $land = $valider->valider($_POST["land"]);
    $landskode = $valider->valider($_POST["landskode"]);
    $stedsnavn = $valider->valider($_POST["stedsnavn"]);
    $geo_lat = $valider->valider($_POST["geo_lat"]);
    $geo_lng = $valider->valider($_POST["geo_lng"]);

    $innIDataBaseMedData = new Destination;

    $result = $innIDataBaseMedData->AddNewDestination($flyplassID, $navn,$land,$landskode,$stedsnavn,$geo_lat,$geo_lng);

    if($result == 1){
      //Success
             $errorMelding =  $html->successMsg("Data ble lagt inn i databasen.");

    } else {
      //not succesfull
             $errorMelding = $html->errorMsg("Data ble ikke lagt inn i databasen.!");

    }

  }

}

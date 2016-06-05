<?php 

$ruterId = $hovedRute = $fraFlyplassId = $tilFlyplassId = $aktivFra = $aktivTil = $reiseTid = $statusKodeId = "";

$errorMelding = "";

// Validering av skjemainput

if ($_SERVER["REQUEST_METHOD"] == "POST") {


  if ( empty($_POST["hovedRute"]) || empty($_POST["fraFlyplassId"]) || empty($_POST["tilFlyplassId"]) || empty($_POST["aktivFra"]) || empty($_POST["aktivTil"]) ) {

    $errorMelding = "<div class='alert alert-error'><strong>Error! </strong>Alle felt må fylles ut.</div>";

}

elseif (strlen($_POST["flyplassNavn"]) > 45 || strlen($_POST["flyplassLand"]) > 45 ) {
  $errorMelding = "<div class='alert alert-error'><strong>Error! </strong>Navn og land må være maks 45 tegn.</div>";
}

  
  else {

    include('../php/AdminClasses.php');

    $valider = new ValiderData;


    $flyplassNavn = $valider->valider($_POST["flyplassNavn"]);
    $flyplassLand = $valider->valider($_POST["flyplassLand"]);
    $flyplassStatuskode = 1;

    $innIDataBaseMedData = new Airport;

    $result = $innIDataBaseMedData->AddNewAirport($flyplassNavn, $flyplassLand,$flyplassStatuskode);

    if($result == 1){
      //Success
             $errorMelding = "<div class='alert alert-success'><strong>Info! </strong>Data lagt inn i database.</div>";

    } else {
      //not succesfull
             $errorMelding = "<div class='alert alert-warning'><strong>Error! </strong>Data ble ikke lagt inn i database.</div>";

    }

  }

}



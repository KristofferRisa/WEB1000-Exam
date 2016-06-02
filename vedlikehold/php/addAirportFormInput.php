<?php 

//$flyId = $flyNr = $flyModell = $flyType = $flyAntallPlasser = $flyLaget = $flyStatusKode = $errMsg = "";

//$errorMelding = "";

// Validering av skjemainput

if ($_SERVER["REQUEST_METHOD"] == "POST") {


  if ( empty($_POST["flyplassNavn"]) || empty($_POST["flyplassLand"]) || empty($_POST["flyplassStatuskode"])) {

    $errorMelding = "<div class='alert alert-error'><strong>Error! </strong>Alle felt må fylles ut.</div>";

}


elseif (filter_var($_POST["flyplassStatuskode"], FILTER_VALIDATE_INT) === false || strlen($_POST["flyplassStatuskode"]) > 11 ) {
  $errorMelding = "<div class='alert alert-error'><strong>Error! </strong>Statuskode må være siffer og maks 11 tegn.</div>";

}

elseif (strlen($_POST["flyplassNavn"]) > 45 || strlen($_POST["flyplassLand"]) > 45 ) {
  $errorMelding = "<div class='alert alert-error'><strong>Error! </strong>Navn og land må være maks 45 tegn.</div>";
}

  
  else {

    include('../php/AdminClasses.php');

    $valider = new ValiderData;

    $flyplassNavn = $valider->valider($_POST["flyplassNavn"]);
    $flyplassLand = $valider->valider($_POST["flyplassLand"]);
    $flyplassStatuskode = $valider->valider($_POST["flyplassStatuskode"]);

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



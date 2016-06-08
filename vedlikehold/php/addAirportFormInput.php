<?php 

$flyId = $flyNr = $flyModell = $flyType = $flyAntallPlasser = $flyLaget = $flyStatusKode = $errMsg = "";

$errorMelding = "";

// Validering av skjemainput

if ($_SERVER["REQUEST_METHOD"] == "POST") {


  if ( empty($_POST["flyplassNavn"]) ) {

    $errorMelding = $html->errorMsg("Error! </strong>Alle felt må fylles ut.");

}

elseif (strlen($_POST["flyplassNavn"]) > 45 ) {
  $errorMelding = $html->successMsg("Navn må være maks 45 tegn.");
}

  
  else {

    include('../php/AdminClasses.php');

    $valider = new ValiderData;


    $flyplassNavn = $valider->valider($_POST["flyplassNavn"]);

    $innIDataBaseMedData = new Airport;

    $result = $innIDataBaseMedData->AddNewAirport($flyplassNavn);

    if($result == 1){
      //Success
             $errorMelding = "<div class='alert alert-success'><strong>Info! </strong>Data lagt inn i database.</div>";

    } else {
      //not succesfull
             $errorMelding = "<div class='alert alert-warning'><strong>Error! </strong>Data ble ikke lagt inn i database.</div>";

    }

  }

}



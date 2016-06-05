<?php 

$flyId = $flyNr = $flyModell = $flyType = $flyAntallPlasser = $flyLaget = $errMsg = "";

$errorMelding = "";

// Validering av skjemainput

if ($_SERVER["REQUEST_METHOD"] == "POST") {


  if ( empty($_POST["flyNr"]) || empty($_POST["flyModell"]) || empty($_POST["flyType"]) || empty($_POST["flyAntallPlasser"]) || empty($_POST["flyAarsmodell"]) ) {

    $errorMelding = $html->errorMsg("Alle felt må fylles ut!");



}


elseif (filter_var($_POST["flyAntallPlasser"], FILTER_VALIDATE_INT) === false || strlen($_POST["flyAntallPlasser"]) > 11 ) {
  $$errorMelding =  $html->errorMsg("Antall plasser må kun være siffer og maks 11 tegn tegn!");

}

elseif (strlen($_POST["flyNr"]) > 45 || strlen($_POST["flyModell"]) > 45 ) {
  $errorMelding =  $html->errorMsg("Modell, type og flynr må være maks 45 tegn!");
}
elseif (strlen($_POST["flyAarsmodell"]) !== 4 ) {
  $errorMelding = $html->errorMsg("Årsmodell må bestå av 4 siffer!");
}

  
  else {

    include('../php/AdminClasses.php');

    $valider = new ValiderData;

    $flyNr = $valider->valider($_POST["flyNr"]);
    $flyModell = $valider->valider($_POST["flyModell"]);
    $flyType = $valider->valider($_POST["flyType"]);
    $flyAntallPlasser = $valider->valider($_POST["flyAntallPlasser"]);
    $flyAarsmodell = $valider->valider($_POST["flyAarsmodell"]);

    $innIDataBaseMedData = new Planes;

    $result = $innIDataBaseMedData->AddNewPlane($flyNr, $flyModell,$flyType,$flyAntallPlasser,$flyAarsmodell);

    if($result == 1){
      //Success
             $errorMelding =  $html->successMsg("Data ble lagt inn i databasen.");

    } else {
      //not succesfull
             $errorMelding = $html->errorMsg("Data ble ikke lagt inn i databasen.!");

    }

  }

}

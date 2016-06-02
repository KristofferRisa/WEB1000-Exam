<?php 

//$flyId = $flyNr = $flyModell = $flyType = $flyAntallPlasser = $flyLaget = $flyStatusKode = $errMsg = "";

//$errorMelding = "";

// Validering av skjemainput

if ($_SERVER["REQUEST_METHOD"] == "POST") {


  if ( empty($_POST["flyNr"]) || empty($_POST["flyModell"]) || empty($_POST["flyType"]) || empty($_POST["flyAntallPlasser"]) || empty($_POST["flyAarsmodell"]) || empty($_POST["flyStatusKode"]) ) {

    $errorMelding = "<div class='alert alert-error'><strong>Error! </strong>Alle felt må fylles ut.</div>";

}


elseif (filter_var($_POST["flyAntallPlasser"], FILTER_VALIDATE_INT) === false || strlen($_POST["flyAntallPlasser"]) > 11 ) {
  $errorMelding = "<div class='alert alert-error'><strong>Error! </strong>Antall Plasser må være siffer og maks 11 tegn.</div>";

}

elseif (filter_var($_POST["flyStatusKode"], FILTER_VALIDATE_INT) === false || strlen($_POST["flyStatusKode"]) > 11 ) {
  $errorMelding = "<div class='alert alert-error'><strong>Error! </strong>Statuskode må være siffer og maks 11 tegn.</div>";

}

elseif (strlen($_POST["flyNr"]) > 45 || strlen($_POST["flyStatusKode"]) > 45 || strlen($_POST["flyModell"]) > 45 ) {
  $errorMelding = "<div class='alert alert-error'><strong>Error! </strong>Modell, type og flynr må være maks 45 tegn.</div>";
}
elseif (strlen($_POST["flyAarsmodell"]) !== 4 ) {
  $errorMelding = "<div class='alert alert-error'><strong>Error! </strong>Årsmodell må bestå av 4 siffer.</div>";
}

  
  else {

    include('../php/AdminClasses.php');

    $valider = new ValiderData;

    $flyNr = $valider->valider($_POST["flyNr"]);
    $flyModell = $valider->valider($_POST["flyModell"]);
    $flyType = $valider->valider($_POST["flyType"]);
    $flyAntallPlasser = $valider->valider($_POST["flyAntallPlasser"]);
    $flyAarsmodell = $valider->valider($_POST["flyAarsmodell"]);
    $flyStatusKode = $valider->valider($_POST["flyStatusKode"]);

    $innIDataBaseMedData = new Planes;

    $result = $innIDataBaseMedData->AddNewPlane($flyNr, $flyModell,$flyType,$flyAntallPlasser,$flyAarsmodell,$flyStatusKode);

    if($result == 1){
      //Success
             $errorMelding = "<div class='alert alert-success'><strong>Info! </strong>Data lagt inn i database.</div>";

    } else {
      //not succesfull
             $errorMelding = "<div class='alert alert-warning'><strong>Error! </strong>Data ble ikke lagt inn i database.</div>";

    }

  }

}

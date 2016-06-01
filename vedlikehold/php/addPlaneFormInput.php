<?php 

//$flyId = $flyNr = $flyModell = $flyType = $flyAntallPlasser = $flyLaget = $flyStatusKode = $errMsg = "";

//$errorMelding = "";

// Validering av skjemainput

if ($_SERVER["REQUEST_METHOD"] == "POST") {


  if ( empty($_POST["flyId"]) || empty($_POST["flyNr"]) || empty($_POST["flyModell"]) || empty($_POST["flyType"]) || empty($_POST["flyAntallPlasser"]) || empty($_POST["flyLaget"]) || empty($_POST["flyStatusKode"]) ) {

    $errorMelding = "<div class='alert alert-error'><strong>Info! </strong>Alle felt må fylles ut.</div>";

}

elseif (filter_var($_POST["flyId"], FILTER_VALIDATE_INT) === false || strlen($_POST["flyId"]) > 11 ) {
  $errorMelding = "<div class='alert alert-error'><strong>Info! </strong>Flyid må være siffer og maks 11 tegn.</div>";

}


elseif (filter_var($_POST["flyAntallPlasser"], FILTER_VALIDATE_INT) === false || strlen($_POST["flyAntallPlasser"]) > 11 ) {
  $errorMelding = "<div class='alert alert-error'><strong>Info! </strong>Antall Plasser må være siffer og maks 11 tegn.</div>";

}

elseif (filter_var($_POST["flyStatusKode"], FILTER_VALIDATE_INT) === false || strlen($_POST["flyStatusKode"]) > 11 ) {
  $errorMelding = "<div class='alert alert-error'><strong>Info! </strong>Statuskode må være siffer og maks 11 tegn.</div>";

}

elseif (strlen($_POST["flyNr"]) > 45 || strlen($_POST["flyStatusKode"]) > 45 || strlen($_POST["flyModell"]) > 45 ) {
  $errorMelding = "<div class='alert alert-error'><strong>Info! </strong>Modell, type og flynr må være maks 45 tegn.</div>";
}
elseif (strlen($_POST["flyLaget"]) !== 4 ) {
  $errorMelding = "<div class='alert alert-error'><strong>Info! </strong>Årsmodell må bestå av 4 siffer.</div>";
}

  
  else {

    include('../php/ValiderData.php');
    include('../php/Planes.php');

    $valider = new ValiderData;

    $flyId = $valider->valider($_POST["flyId"]);
    $flyNr = $valider->valider($_POST["flyNr"]);
    $flyModell = $valider->valider($_POST["flyModell"]);
    $flyType = $valider->valider($_POST["flyType"]);
    $flyAntallPlasser = $valider->valider($_POST["flyAntallPlasser"]);
    $flyLaget = $valider->valider($_POST["flyLaget"]);
    $flyStatusKode = $valider->valider($_POST["flyStatusKode"]);

    $innIDataBaseMedData = new Planes;

    $innIDataBaseMedData->AddNewPlane($flyId, $flyNr, $flyModell,$flyType,$flyAntallPlasser,$flyLaget,$flyStatusKode);


  }

}

//Test om data går igjennom validering

  echo $flyId;
  echo $flyNr;
  echo $flyModell;
  echo $flyType;
  echo $flyAntallPlasser;
  echo $flyLaget;
  echo $flyStatusKode;

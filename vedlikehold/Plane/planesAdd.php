<?php 
$title = "FLY - Admin";

//$flyId = $flyNr = $flyModell = $flyType = $flyAntallPlasser = $flyLaget = $flyStatusKode = $errMsg = "";

//$errorMelding = "";

// Validering av sjemainput

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


  echo $flyId;
  echo $flyNr;
  echo $flyModell;
  echo $flyType;
  echo $flyAntallPlasser;
  echo $flyLaget;
  echo $flyStatusKode;

include('../html/header.html');

include('../html/admin-start.html');



?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">

      <h1>
        Vis alle fly
        <small>Viser en oversikt over alle fly.</small>
      </h1>
    <ol class="breadcrumb">
      <li><a href="../"><i class="fa fa-dashboard"></i> Start</a></li>
      <li>Fly</li>
      <!-- Denne lese av script for å sette riktig link aktiv i menyen (husk ID i meny må være lik denne) -->
      <li class="active">Vis alle fly</li>
    </ol>
  </section>
 <!-- Main content -->
  <section class="content">


    <!-- Your Page Content Here -->

        <div class="row">
      <div class="col-sm-12">   
                 <!-- Horizontal Form -->
          <div class="box box-info">
            <div class="box-header with-border"><?php echo $errorMelding; ?>
           <h3 class="box-title">Horizontal Form</h3>
            </div>
            <!-- /.box-header -->



            <!-- form start -->

            <form method="post" class="form-horizontal" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
              <div class="box-body">        

                <div class="form-group">
                  <label for="flyId" class="col-sm-2 control-label">Fly id</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="flyId" name="flyId" placeholder="Fly id" value="<?php echo $_POST['flyId'] ?>">                      
                  </div>
                </div>

                <div class="form-group">
                  <label for="flyNr" class="col-sm-2 control-label">Fly nr</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="flyNr" name="flyNr" placeholder="Fly nr" value="<?php echo $_POST['flyNr'] ?>">
                  </div>
                </div>

                <div class="form-group">
                  <label for="flyModell" class="col-sm-2 control-label">Fly modell</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="flyModell" name="flyModell" placeholder="Fly modell" value="<?php echo $_POST['flyModell'] ?>">
                  </div>
                </div>

                <div class="form-group">
                  <label for="flyType" class="col-sm-2 control-label">Flytype</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="flyType" name="flyType" placeholder="Flytype" value="<?php echo $_POST['flyType'] ?>">
                  </div>
                </div>

                <div class="form-group">
                  <label for="flyAntallPlasser" class="col-sm-2 control-label">Antall sitteplasser</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="flyAntallPlasser" name="flyAntallPlasser" placeholder="Antall sitteplasser" value="<?php echo $_POST['flyAntallPlasser'] ?>">
                     </div>
                </div>

                <div class="form-group">
                  <label for="flyLaget" class="col-sm-2 control-label">Årsmodell</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="flyLaget" name="flyLaget" placeholder="Årsmodell" value="<?php echo $_POST['flyLaget'] ?>">
                  </div>
                </div>

                <div class="form-group">
                  <label for="flyStatusKode" class="col-sm-2 control-label">Statuskode</label>
                  <div class="col-sm-10">
                    <!--<input type="text" class="form-control" id="flyStatusKode" name="flyStatusKode" placeholder="Statuskode">
                  </div>-->

                 <select class="form-control" id="flyStatusKode" name="flyStatusKode">
                  <?php 

                  include('../php/TabelListBox.php');
                  $tabell = new TableListBox;

                  print( $tabell->makeListBox() );

                  ?>
                  </select>
    
                </div>
              </div>

              <!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" class="btn btn-default">Cancel</button>

                <button type="submit" class="btn btn-info pull-right">Sign in</button>
              </div>
              <!-- /.box-footer -->
            </form>
          </div>
          <!-- /.box -->

      </div>
   
      <!-- /.col -->
    </div>

  </section>
  <!-- /.content -->
  
  </div>
  <!-- /.content-wrapper -->
  

<?php
include('../html/admin-slutt.html');

include('../html/script.html');

?>
<?php 
$title = "FLY - NY - Admin";

include('../html/start.php');
include('../html/header.html');
include('../html/admin-start.html');
include('../php/Plane.php');

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


?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">

      <h1>
        Registrere nytt fly
        <small>Her kan du registrere nye fly i databasen</small>
      </h1>
    <ol class="breadcrumb">
      <li><a href="../"><i class="fa fa-dashboard"></i> Start</a></li>
      <li>Fly og seteoversikt</li>
      <!-- Denne lese av script for å sette riktig link aktiv i menyen (husk ID i meny må være lik denne) -->
      <li class="active">NyttFly</li>
    </ol>
  </section>
 <!-- Main content -->
  <section class="content">


    <!-- Your Page Content Here -->

        <div class="row">
      <div class="col-sm-12">   
                 <!-- Horizontal Form -->
          <div class="box box-info">
            <div class="box-header with-border"><?php echo $errorMelding; ?><div id="melding"></div>
           <h3 class="box-title">Skjema</h3>
            </div>
            <!-- /.box-header -->



            <!-- form start -->

            <form method="post" class="form-horizontal" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" onsubmit="return validerRegistrerFly()">
              <div class="box-body">        

                <div class="form-group">
                  <label for="flyNr" class="col-sm-2 control-label">Flynr</label>
                  <div class="col-sm-10" data-toggle="tooltip" data-placement="top" title="Flynr må fylles ut">
                    <input type="text" class="form-control" id="flyNr" name="flyNr" placeholder="Flynr" value="<?php echo @$_POST['flyNr'] ?>" required>
                  </div>
                </div>

                <div class="form-group">
                  <label for="flyModell" class="col-sm-2 control-label">Flymodell</label>
                  <div class="col-sm-10" data-toggle="tooltip" data-placement="top" title="Flymodell må fylles ut">
                    <input type="text" class="form-control" id="flyModell" name="flyModell" placeholder="Flymodell" value="<?php echo @$_POST['flyModell'] ?>" required>
                  </div>
                </div>

                <div class="form-group">
                  <label for="flyType" class="col-sm-2 control-label">Flytype</label>
                  <div class="col-sm-10" data-toggle="tooltip" data-placement="top" title="Flytype må fylles ut">
                    <input type="text" class="form-control" id="flyType" name="flyType" placeholder="Flytype" value="<?php echo @$_POST['flyType'] ?>" required>
                  </div>
                </div>

                <div class="form-group">
                  <label for="flyAntallPlasser" class="col-sm-2 control-label">Antall sitteplasser</label>
                  <div class="col-sm-10" data-toggle="tooltip" data-placement="top" title="Antall sitteplasser må fylles ut">
                    <input type="number" class="form-control" id="flyAntallPlasser" name="flyAntallPlasser" placeholder="Antall sitteplasser" value="<?php echo @$_POST['flyAntallPlasser'] ?>" required>
                     </div>
                </div>

                <div class="form-group">
                  <label for="flyLaget" class="col-sm-2 control-label">Årsmodell</label>
                  <div class="col-sm-10" data-toggle="tooltip" data-placement="top" title="Årsmodell må fylles ut">
                    <input type="text" class="form-control" id="flyAarsmodell" name="flyAarsmodell" placeholder="2016" value="<?php echo @$_POST['flyAarsmodell'] ?>" required>
                  </div>
                </div>

              <!-- /.box-body -->
              <div class="box-footer">
                <input type="reset" class="btn btn-default" value="Nullstill" onclick="clearForm(this.form);">
                <a href="./planes.php" class="btn btn-link" >Tilbake</a>
                
                <?php 
                if($_POST && $result == 1 ) {  ?>
                    <a href="./Plane/sete.php?nr=<?php echo $flyNr; ?>" class="btn btn-flat btn-link pull-right">Rediger seter</a>
                  <?php } else { ?>
                   <button type="submit" class="btn btn-info pull-right">Legg til</button>
                 <?php } ?>
                
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
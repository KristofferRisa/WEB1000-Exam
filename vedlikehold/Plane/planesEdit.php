<?php 
$title = "FLY - ENDRE - Admin";

include('../html/start.php');

include('../html/header.html');

include('../html/admin-start.html');

// Validering og innsending av skjemadata
include('../php/AdminClasses.php');


if($_GET['id']){
  
  //returnerer en array
  //brukes av både GET OG POST    
  $id = $_GET['id'];
  $fly = new Planes;
  $flyinfo = $fly->GetPlane($id,$logg);
 

}


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

    $valider = new ValiderData;

    $flyNr = $valider->valider($_POST["flyNr"]);
    $flyModell = $valider->valider($_POST["flyModell"]);
    $flyType = $valider->valider($_POST["flyType"]);
    $flyAntallPlasser = $valider->valider($_POST["flyAntallPlasser"]);
    $flyAarsmodell = $valider->valider($_POST["flyAarsmodell"]);

    $result = $fly->UpdatePlane($id, $flyNr, $flyModell,$flyType,$flyAntallPlasser,$flyAarsmodell,$logg );

    echo $result;

     $flyinfo = $fly->GetPlane($id,$logg);

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
        Endre fly data
          <small>Her kan du endre et registrere fly i databasen</small>
      </h1>
    <ol class="breadcrumb">
      <li><a href="../"><i class="fa fa-dashboard"></i> Start</a></li>
      <li>Fly og seteoversikt</li>
      <!-- Denne lese av script for å sette riktig link aktiv i menyen (husk ID i meny må være lik denne) -->
      <li class="active">Endre fly</li>
    </ol>
  </section>



 <!-- Main content -->
  <section class="content">

   

    <!-- Your Page Content Here -->

        <div class="row">
      <div class="col-sm-12">   
                 <!-- Horizontal Form -->
          <div class="box box-info">


<?php 
  //Viser skjema dersom det både er en GET request med querstring id
  if($_GET && $_GET['id']){ ?>


            <div class="box-header with-border"><?php echo $errorMelding; ?><div id="melding"></div>

             
           <h3 class="box-title">Skjema</h3>
            </div>
            <!-- /.box-header -->



            <!-- form start -->

            <form method="POST" class="form-horizontal" onsubmit="return validerRegistrerFly()">
              <div class="box-body">        

                      <input type="hidden" disabled class="form-control" id="inputId" name="inputId" value="<?php echo $id ?>">


                <div class="form-group">
                  <label for="flyNr" class="col-sm-2 control-label">Flynr</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="flyNr" name="flyNr" placeholder="Flynr" value="<?php echo @$flyinfo[0][1] ?>">
                  </div>
                </div>

                <div class="form-group">
                  <label for="flyModell" class="col-sm-2 control-label">Flymodell</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="flyModell" name="flyModell" placeholder="Flymodell" value="<?php echo @$flyinfo[0][2] ?>">
                  </div>
                </div>
                <div class="form-group">
                  <label for="flyType" class="col-sm-2 control-label">Flytype</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="flyType" name="flyType" placeholder="Flytype" value="<?php echo @$flyinfo[0][3] ?>">
                  </div>
                </div>

                <div class="form-group">
                  <label for="flyAntallPlasser" class="col-sm-2 control-label">Antall sitteplasser</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="flyAntallPlasser" name="flyAntallPlasser" placeholder="Antall sitteplasser" value="<?php echo @$flyinfo[0][4] ?>">
                     </div>
                </div>

                <div class="form-group">
                  <label for="flyLaget" class="col-sm-2 control-label">Årsmodell</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="flyAarsmodell" name="flyAarsmodell" placeholder="yyyy" value="<?php echo @$flyinfo[0][5] ?>">
                  </div>
                </div>

              <!-- /.box-body -->
              <div class="box-footer">
                <div class="btn btn-default" onclick="fjernMelding();clearForm(this.form);">Nullstill</div>

                <button type="submit" class="btn btn-info pull-right">Endre</button>
              </div>
              <!-- /.box-footer -->
            </form>

            <?php } 
             else {
    //lister en select box med flyplass 
?>
<!-- Your Page Content Here -->
<form class="form-horizontal" method="GET" id="redigerFly">
    <div class="row">
      <div class="col-md-12">
        
         <div class="box box-info">
            <div class="box-body">

               <div class="form-group col-md-6">
                  <select class="form-control select2 select2-hidden-accessible" name="id" style="width: 100%;" tabindex="-1" aria-hidden="true">
              
                      <?php $planeselect = new Planes; print($planeselect-> PlaneSelectOptions()); ?>
                
                  </select>
              </div>
              
              <div class="form-group col-md-2">
                <button type="submit" class="btn btn-info pull-right">Hent</button>
              </div>
          
      </div>
    </div>
  </form>


<?php } ?>
            
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
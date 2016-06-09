<?php 
$title = "BILLETTER - ENDRE - Admin ";

include('../html/start.php');
include('../html/header.html');
include('../html/admin-start.html');
include('../php/Billett.php');
if(@$_GET['id']){
  
  //returnerer en array
  //brukes av både GET OG POST    
  $id = $_GET['id'];
  $billett = new Billett;
  $billettinfo = $billett->GetBillett($id,$logg);
}

  $errorMelding = "";

// Validering av skjemainput

if ($_SERVER["REQUEST_METHOD"] == "POST") {


  if ( empty($_POST["fornavn"]) || empty($_POST["etternavn"]) || empty($_POST["kjonn"]) || empty($_POST["antallBagasje"]) ) {

    $errorMelding = $html->errorMsg("Alle felt må fylles ut!");

}


elseif (filter_var($_POST["flyAntallPlasser"], FILTER_VALIDATE_INT) === false || strlen($_POST["flyAntallPlasser"]) > 11 ) {
  $errorMelding =  $html->errorMsg("Antall plasser må kun være siffer og maks 11 tegn tegn!");

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

    if($result <=0){
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
      Endre billett
        <small>Her kan du gjøre endringer på billetter</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="../"><i class="fa fa-dashboard"></i> Start</a></li>
      <li>Billetter</li>
      <li class="active">Endre Billett</li>
    </ol>
  </section>

 <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-sm-12">   
          <!-- Horizontal Form -->
          <div class="box box-info">


<?php if($_GET && $_GET['id']){ ?>

  <div class="box-header with-border"><?php echo $errorMelding; ?><div id="melding"></div>

             
           <h3 class="box-title">Endre billett id:<?php echo $id?></h3>
            </div>
            <!-- /.box-header -->

            <!-- form start -->

            <form method="POST" class="form-horizontal" onsubmit="return validerRegistrerFly()">
              <div class="box-body">        

                      <input type="hidden" disabled class="form-control" id="inputId" name="inputId" value="<?php echo $id ?>">


                <div class="form-group">
                  <label for="fornavn" class="col-sm-2 control-label">Fornavn</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="fornavn" name="fornavn" placeholder="Fornavn" value="<?php echo @$flyinfo[0][1] ?>">
                  </div>
                </div>

                <div class="form-group">
                  <label for="etternavn" class="col-sm-2 control-label">Etternavn</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="etternavn" name="etternavn" placeholder="Etternavn" value="<?php echo @$flyinfo[0][2] ?>">
                  </div>
                </div>
                <div class="form-group">
                  <label for="kjonn" class="col-sm-2 control-label">Kjønn</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="kjonn" name="kjonn" placeholder="Kjønn" value="<?php echo @$flyinfo[0][3] ?>">
                  </div>
                </div>

                <div class="form-group">
                  <label for="antallBagasje" class="col-sm-2 control-label">Antall bagasje</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="antallBagasje" name="antallBagasje" placeholder="Antall bagasjer" value="<?php echo @$flyinfo[0][4] ?>">
                     </div>
                </div>

              <!-- /.box-body -->
              <div class="box-footer">
                <div class="btn btn-default" onclick="fjernMelding();clearForm(this.form);">Nullstill</div>

                <button type="submit" class="btn btn-info pull-right">Oppdater</button>
              </div>
              <!-- /.box-footer -->
            </form>

            <?php } 
else { //lister en select box med flyplass ?>
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
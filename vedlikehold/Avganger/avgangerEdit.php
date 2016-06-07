<?php 
$title = "AVGANG - ENDRE - Admin";

include('../html/start.php');

include('../html/header.html');

include('../html/admin-start.html');

// Validering og innsending av skjemadata
include('../php/AdminClasses.php');
include('../php/Avgang.php');

$avgang = "";

if(@$_GET['id']){
  
  //returnerer en array
  //brukes av både GET OG POST    
  $id = $_GET['id'];
  $avgang = new avgang;
  $avgangInfo = $avgang->GetAvgang ($id, $logg);
  
  print_r($avgangInfo);
  

}


$avgang= "";

$errorMelding = "";
// Validering av skjemainput

if ($_SERVER["REQUEST_METHOD"] == "POST") {


  if (empty($_POST["avgangId"]) ||  empty($_POST["flyId"]) ||  empty($_POST["fraDestId"]) ||  empty($_POST["tilDestId"]) ||
      empty($_POST["dato"]) ||  empty($_POST["direkte"]) ||  empty($_POST["reiseTid"]) ||  empty($_POST["klokkeslett"]) ||
      empty($_POST["fastpris"]) ) 
 {

    $errorMelding = $html->errorMsg("Error! </strong>Alle felt må fylles ut.");
 }
    elseif (strlen($_POST["dato"]) > 5 || (strlen($_POST["reiseTid"]) >5 || strlen($_POST["klokkeslett"]) > 5 )) 
    {
      $errorMelding = $html->successMsg("Datoformat er ÅÅÅÅ-MM-DD. Klokkeformat er HH:MM");
    }
  
  
  else {
        $valider = new ValiderData;


    $avgangId = $valider->valider($_POST["avgangId"]);
    $flyId = $valider->valider($_POST["flyId"]);
    $fraDestId = $valider->valider($_POST["fraDestId"]);
    $tilDestId = $valider->valider($_POST["tilDestId"]);
    $dato = $valider->valider($_POST["dato"]);
    $direkte = $valider->valider($_POST["direkte"]);
    $reiseTid = $valider->valider($_POST["reiseTid"]);
    $klokkeslett = $valider->valider($_POST["klokkeslett"]);
    $fastpris = $valider->valider($_POST["fastpris"]);

    $avgang = new avgang; 

    $result = $avgang->UpdateAvgang($avgangId, $flyId, $fraDestId, $tilDestId, $dato, $direkte, $reiseTid, $klokkeslett, $fastpris);
    //Henter oppdatert airport info fra databasen
    $avgangInfo = $avgangInfo->GetAvgang($avgangid,$logg);

    if($result == 1){
      //Success
             $errorMelding = "<div class='alert alert-success'><strong>Info! </strong>Data lagt inn i database.</div>";

    } else {
      //not succesfull
             $errorMelding = "<div class='alert alert-warning'><strong>Error! </strong>Data ble ikke lagt inn i database.</div>";

    }

  }

}




?>


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">

      <h1>
        Rediger avganger
        <small>Her kan du redigere avganger i databasen</small>
      </h1>
    <ol class="breadcrumb">
      <li><a href="../"><i class="fa fa-dashboard"></i> Start</a></li>
      <li>Avganger</li>
      <!-- Denne lese av script for å sette riktig link aktiv i menyen (husk ID i meny må være lik denne) -->
      <li class="active">Endre avgang</li>
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
  if($_GET && $_GET['id']){ 
?>

            <div class="box-header with-border"><?php echo $errorMelding; ?><div id="melding"></div>
           <h3 class="box-title">Skjema</h3>
            </div>
            <!-- /.box-header -->


            <!-- form start -->
          <form method="post" class="form-horizontal" onsubmit="return validerRegistrerAvgang()">
              <div class="box-body">   



              <div class="form-group"  data-toggle="tooltip" data-placement="top" title="Fly ID">
                  <label for="avgangFlyId" class="col-sm-2 control-label" >FlyId</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="avgangFlyId" name="avgangFlyId" placeholder="Fly ID" value="<?php echo @$_POST['avgangFlyId'] ?>" onmouseover="musOverRK(this)" onmouseout="musUt(this)">
                </div>
              </div>

              <div class="form-group"  data-toggle="tooltip" data-placement="top" title="Fra destinasjon ID">
                  <label for="avgangFraDestId" class="col-sm-2 control-label" >Fra destinasjon ID</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="avgangFraDestId" name="avgangFraDestId" placeholder="Fra destinasjons ID" value="<?php echo @$_POST['avgangFraDestId'] ?>" onmouseover="musOverRK(this)" onmouseout="musUt(this)">
                </div>
              </div>

                            <div class="form-group"  data-toggle="tooltip" data-placement="top" title="Til destinasjon ID">
                  <label for="avgangTilDestId" class="col-sm-2 control-label" >Til destinasjon ID</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="avgangTilDestId" name="avgangTilDestId" placeholder="Til destinasjon ID" value="<?php echo @$_POST['avgangtilDestId'] ?>" onmouseover="musOverRK(this)" onmouseout="musUt(this)">
                </div>
              </div>


              <div class="form-group"  data-toggle="tooltip" data-placement="top" title="YYYY-MM-DD">
                  <label for="avgangDato" class="col-sm-2 control-label" >Dato</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="avgangDato" name="avgangDato" placeholder="Fyll ut dato" value="<?php echo @$_POST['avgangDato'] ?>" onmouseover="musOverRK(this)" onmouseout="musUt(this)">
                  
                </div>
              </div>

              <div class="form-group"  data-toggle="tooltip" data-placement="top" title="Fyll ut ja/nei om det er direkte eller ei">
                  <label for="avgangDirekte" class="col-sm-2 control-label" >Avgang direkte</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="avgangDirekte" name="avgangDirekte" placeholder="Direkte? - Ja/nei" value="<?php echo @$_POST['avgangDirekte'] ?>" onmouseover="musOverRK(this)" onmouseout="musUt(this)">
                </div>
              </div>



              <div class="form-group"  data-toggle="tooltip" data-placement="top" title="HH:MM">
                  <label for="avgangReiseTid" class="col-sm-2 control-label" >Reisetid</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="avgangReiseTid" name="avgangReiseTid" placeholder="Fyll ut reisetid" value="<?php echo @$_POST['avgangReiseTid'] ?>" onmouseover="musOverRK(this)" onmouseout="musUt(this)">
                </div>
              </div>              
              
              
              <div class="form-group"  data-toggle="tooltip" data-placement="top" title="HH:MM">
                  <label for="avgangKl" class="col-sm-2 control-label" >Klokkelsett</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="avgangKl" name="avgangKl" placeholder="Fyll ut klokkeslett" value="<?php echo @$_POST['avgangKl'] ?>" onmouseover="musOverRK(this)" onmouseout="musUt(this)">
               </div>
              </div>
              
              <div class="form-group"  data-toggle="tooltip" data-placement="top" title="Fyll ut fastpris">
                  <label for="avgangFastKr" class="col-sm-2 control-label" >Fastpris</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="avgangFastKr" name="avgangFastKr" placeholder="Fastpris KR" value="<?php echo @$_POST['avgangFastKr'] ?>" onmouseover="musOverRK(this)" onmouseout="musUt(this)">
                </div>
              </div>


              <!-- /.box-body -->
              <div class="box-footer">
                <div class="btn btn-default" onclick="fjernMelding();clearForm(this.form);">Nullstill</div>
                <button type="submit" class="btn btn-info pull-right">Legg til</button>

              </div>
           
              
              <!-- /.box-footer -->
            </form>


                        <?php } 
             else {
    //lister en select box med priskategori 
?>

<!-- Your Page Content Here -->
<form class="form-horizontal" method="GET" id="redigerAvgang">
    <div class="row">
      <div class="col-md-12">
        
         <div class="box box-info">
            <div class="box-body">

               <div class="form-group col-md-6">
                  <select class="form-control select2 select2-hidden-accessible" name="id" style="width: 100%;" tabindex="-1" aria-hidden="true">
              
                      <?php 
                      $Avgangselect = new Avgang(); print($Avgangselect-> GetAllAvgangLB($logg)); 
                      ?>
                
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
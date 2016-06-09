<?php 
$title = "PRISKATEGORI - ENDRE - Admin";

include('../html/start.php');

include('../html/header.html');

include('../html/admin-start.html');

// Validering og innsending av skjemadata
include('../php/AdminClasses.php');
include('../php/PrisKat.php');

$prisKatNavn = "";

if(@$_GET['id']){
  
  //returnerer en array
  //brukes av både GET OG POST    
  $id = $_GET['id'];
  $prisKat = new prisKat;
  $prisKatInfo = $prisKat->getPrisKat ($id, $logg);
  
  print_r($prisKatInfo);
  

}


$prisKatNavn= "";

$errorMelding = "";
// Validering av skjemainput

if ($_SERVER["REQUEST_METHOD"] == "POST") {


  if ( empty($_POST["prisKatNavn"]) || empty($_POST["kroner"]) )
  {

    $errorMelding = $html->errorMsg("Error! </strong>Alle felt må fylles ut.");

  } 
  elseif (strlen($_POST["prisKatNavn"]) > 100 ) {
    $errorMelding = $html->successMsg("Navn må være maks 100 tegn.");
  } else {
    $valider = new ValiderData;

    $prisKatNavn = $valider->valider($_POST["prisKatNavn"]);
    $kroner = $valider->valider($_POST["kroner"]);

    $prisKat = new prisKat; 

    $result = $prisKat->UpdatePrisKat($id, $prisKatNavn, $kroner, $logg);

    //Henter oppdatert airport info fra databasen
    $prisKatInfo = $prisKat->getPrisKat($id,$logg);

    if($result >= 0){
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
        Rediger priskategori
        <small>Her kan du redigere priskategorier i databasen</small>
      </h1>
    <ol class="breadcrumb">
      <li><a href="../"><i class="fa fa-dashboard"></i> Start</a></li>
      <li>Priskategorier</li>
      <!-- Denne lese av script for å sette riktig link aktiv i menyen (husk ID i meny må være lik denne) -->
      <li class="active">EndrePriskategori</li>
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
            <form method="post" class="form-horizontal" onsubmit="return validerRegistrerPrisKat()">
              <div class="box-body">        

               <div class="form-group"  data-toggle="tooltip" data-placement="top" title="Fyll ut priskategori navn">
                  <label for="prisKatnavn" class="col-sm-2 control-label" >Navn</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="prisKatNavn" name="prisKatNavn" placeholder="Priskategori navn" value="<?php echo @$prisKatInfo[0][1]?>" onmouseover="musOverRK(this)" onmouseout="musUt(this)">
                 </div>
               
  </div>
                <div class="form-group"  data-toggle="tooltip" data-placement="top" title="Fyll ut priskategori kroner">
                  <label for="kroner" class="col-sm-2 control-label" >Kroner</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="kroner" name="kroner" placeholder="Priskategori pris" value="<?php echo @$prisKatInfo[0][2]?>" onmouseover="musOverRK(this)" onmouseout="musUt(this)">
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
<form class="form-horizontal" method="GET" id="redigerPrisKat">
    <div class="row">
      <div class="col-md-12">
        
         <div class="box box-info">
            <div class="box-body">

               <div class="form-group col-md-6">
                  <select class="form-control select2 select2-hidden-accessible" name="id" style="width: 100%;" tabindex="-1" aria-hidden="true">
              
                      <?php 
                      $prisKatselect = new prisKat(); print($prisKatselect-> GetAllPrisKategorierLB($logg)); 
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
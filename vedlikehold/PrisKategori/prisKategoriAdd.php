<?php 
$title = "PRISKATEGORI - Admin - Legg til";

include('../html/start.php');

include('../html/header.html');

include('../html/admin-start.html');

include('../php/AdminClasses.php');

?>

// Validering og innsending av skjemadata
<?php 

$prisKategoriId = $prisKategoriNavn = $prisKatProsentPaaslag = $errMsg = "";

$errorMelding = "";

// Validering av skjemainput

if ($_SERVER["REQUEST_METHOD"] == "POST") {


  if ( empty($_POST["prisKategoriNavn"]) ) {

    $errorMelding = $html->errorMsg("Error! </strong>Alle felt må fylles ut.");

}

elseif (strlen($_POST["prisKategoriNavn"]) > 100 ) {
  $errorMelding = $html->successMsg("Navn må være maks 100 tegn.");
}

  
  else {

    include('../php/PrisKat.php');

    $valider = new ValiderData;


    $prisKategoriNavn = $valider->valider($_POST["prisKategoriNavn"]);

    $innIDataBaseMedData = new PrisKat;

    $result = $innIDataBaseMedData->NewPrisKat($prisKategoriNavn);

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
        Registrere ny priskategori
        <small>Her kan du registrere nye priskategorier i databasen</small>
      </h1>
    <ol class="breadcrumb">
      <li><a href="../"><i class="fa fa-dashboard"></i> Start</a></li>
      <li>Priskategorier</li>
      <!-- Denne lese av script for å sette riktig link aktiv i menyen (husk ID i meny må være lik denne) -->
      <li class="active">NyPriskategori</li>
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

            <form method="post" class="form-horizontal" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" onsubmit="return validerRegistrerPrisKat()">
            <div class="box-body">        

              <div class="form-group"  data-toggle="tooltip" data-placement="top" title="Fyll ut priskategori navn">
                  <label for="prisKategoriNavn" class="col-sm-2 control-label" >Navn</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="prisKategoriNavn" name="prisKategoriNavn" placeholder="Priskategori navn" value="<?php echo @$_POST['prisKategoriNavn'] ?>" onmouseover="musOverRK(this)" onmouseout="musUt(this)">
                  
                </div>
              </div>

              <div class="form-group"  data-toggle="tooltip" data-placement="top" title="Fyll ut priskategori prosentpåslag">
                  <label for="prisKategoriProsentPaaslag" class="col-sm-2 control-label" >Prosent Påslag</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="prisKatProsentPaaslag" name="prisKatProsentPaaslag" placeholder="Priskat prosentpåslag " value="<?php echo @$_POST['prisKatProsentPaaslag'] ?>" onmouseover="musOverRK(this)" onmouseout="musUt(this)">
                  
                </div>
              </div>




              <!-- /.box-body -->
              <div class="box-footer">
                <button class="btn btn-default" onclick="fjernMelding();clearForm(this.form);return false;">Nullstill</button>
                <button type="submit" class="btn btn-info pull-right">Legg til</button>

              </div>
              
</div>
      </div>
    </div>
               </div>
      </div>


<?php
include('../html/admin-slutt.html');

include('../html/script.html');

?>
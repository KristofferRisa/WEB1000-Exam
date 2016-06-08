<?php 
$title = "FLYPLASS - ENDRE - Admin";

include('../html/start.php');

include('../html/header.html');

include('../html/admin-start.html');

// Validering og innsending av skjemadata
include('../php/AdminClasses.php');

$flyplassNavn= "";

$errorMelding = "";


if(@$_GET['id']){
  
  //returnerer en array
  //brukes av både GET OG POST    
  $id = $_GET['id'];
  $airport = new Airport;
  $airportinfo = $airport->GetAirport($id,$logg);
}


// Validering av skjemainput

if ($_SERVER["REQUEST_METHOD"] == "POST") {


  if ( empty($_POST["flyplassNavn"]) ) {

    $errorMelding = $html->errorMsg("Error! </strong>Alle felt må fylles ut.");

  } elseif (strlen($_POST["flyplassNavn"]) > 45 ) {
    $errorMelding = $html->successMsg("Navn må være maks 45 tegn.");
  } else {
    $valider = new ValiderData;

    $flyplassNavn = $valider->valider($_POST["flyplassNavn"]);

    $airport = new Airport; 

    $result = $airport->UpdateAirport($id,$flyplassNavn,$logg);

    
    $airportinfo = $airport->GetAirport($id,$logg);

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
        Endre flyplass
        <small>Her kan du endre flyplasser i databasen</small>
      </h1>
    <ol class="breadcrumb">
      <li><a href="../"><i class="fa fa-dashboard"></i> Start</a></li>
      <li>Flyplasser</li>
      <!-- Denne lese av script for å sette riktig link aktiv i menyen (husk ID i meny må være lik denne) -->
      <li class="active">Endre flyplass</li>
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
            <form method="post" class="form-horizontal" onsubmit="return validerRegistrerFlyplass()">
              <div class="box-body">        

                <div class="form-group"  data-toggle="tooltip" data-placement="top" title="Fyll ut flyplass navn">
                  <label for="flyplassNavn" class="col-sm-2 control-label" >Navn</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="flyplassNavn" name="flyplassNavn" placeholder="Flyplass navn" value="<?php echo @$airportinfo[0][1]?>">
                  </div>
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
              
                      <?php $airportselect = new Airport; print($airportselect-> AirportSelectOptions()); ?>
                
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
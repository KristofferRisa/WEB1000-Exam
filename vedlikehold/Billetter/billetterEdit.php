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
  print_r ($billettinfo);
}



  $errorMelding = "";



// Validering av skjemainput
if ($_SERVER["REQUEST_METHOD"] == "POST") {


  if ( empty($_POST["fornavn"]) || empty($_POST["etternavn"]) || empty($_POST["kjonn"]) ) {

    $errorMelding = $html->errorMsg("Alle felt må fylles ut!");

}

elseif ( strlen($_POST["fornavn"]) > 100 || strlen($_POST["etternavn"]) > 100) {
  $errorMelding =  $html->errorMsg("Fornavn og etternavn må maks være 100 tegn!");
}

elseif (!$_POST["kjonn"] == "Mann" || !$_POST["kjonn"] =="Kvinne"  ) {
  $errorMelding =  $html->errorMsg("Kjønn kan kun være: Mann/Kvinnen!");
}


elseif (!$_POST["antallBagasje"] === 0 || !$_POST["antallBagasje"] === 1 || !$_POST["antallBagasje"] === 3   ) {
  $errorMelding =  $html->errorMsg("Antall bagasje må være maks 3");

}


  
  else {

            $fornavn = $saner->data($_POST["fornavn"]);
            $etternavn = $saner->data($_POST["etternavn"]);
            $kjonn = $saner->data($_POST["kjonn"]);
            $antallBagasje = $saner->data($_POST["antallBagasje"]);

    $result = $billett->UpdateBillett($id, $fornavn, $etternavn,$kjonn,$antallBagasje,$logg );

    echo $result;

     $billettinfo = $billett->GetBillett($id,$logg);

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
      Endre billett
        <small>Her kan du gjøre endringer på billetter</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="../"><i class="fa fa-dashboard"></i> Start</a></li>
      <li>Billetter og bestillinger</li>
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

             
           <h3 class="box-title">Endre billett id: <?php echo $id?></h3>
            </div>
            <!-- /.box-header -->

            <!-- form start -->

            <form method="POST" class="form-horizontal" onsubmit="return validerRegistrerBillett()">
              <div class="box-body">        

                      <input type="hidden" disabled class="form-control" id="inputId" name="inputId" value="<?php echo $id ?>">


                <div class="form-group">
                  <label for="fornavn" class="col-sm-2 control-label">Fornavn</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="fornavn" name="fornavn" placeholder="Fornavn" value="<?php echo @$billettinfo[0][4] ?>" required>
                  </div>
                </div>

                <div class="form-group">
                  <label for="etternavn" class="col-sm-2 control-label">Etternavn</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="etternavn" name="etternavn" placeholder="Etternavn" value="<?php echo @$billettinfo[0][5] ?>" required>
                  </div>
                </div>

                <div class="form-group">
                        <label for="kjonn" class="col-sm-2 control-label">Kjønn</label>
                        <div class="col-sm-10">
                            <select class="form-control select2 select2-hidden-accessible" name="kjonn" id="kjonn" tabindex="-1" aria-hidden="true">
                                <option value="Mann" <?php if($billettinfo[0][6] == "Mann") {echo "Selected";} ?> >Mann</option>
                                <option value="Kvinne"<?php if($billettinfo[0][6] == "Kvinne") {echo "Selected";} ?> >Kvinne</option>
                            </select>
                        </div>
                    </div>

                
                   <div class="form-group">
                        <label for="antallBagasje" class="col-sm-2 control-label">Antall bagasje</label>
                        <div class="col-sm-10">
                            <select class="form-control select2 select2-hidden-accessible" name="antallBagasje" id="antallBagasje" tabindex="-1" aria-hidden="true">
                                <option value="0" <?php if($billettinfo[0][7] == 0) {echo "Selected";} ?>>Kun håndbagasje</option>
                                <option value="1" <?php if($billettinfo[0][7] == 1) {echo "Selected";} ?>>1 kolli (100 NOK)</option>
                                <option value="2" <?php if($billettinfo[0][7] == 2) {echo "Selected";} ?>>2 kolli (200 NOK)</option>
                            </select>
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
              
                      <?php $billettselect = new Billett; print($billettselect-> BillettSelectOptions()); ?>
                
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
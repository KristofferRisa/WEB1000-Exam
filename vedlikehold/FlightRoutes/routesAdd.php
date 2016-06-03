<?php 
$title = "FLYRUTE - Admin - Legg til";

include('../html/start.php');

include('../html/header.html');

include('../html/admin-start.html');

// Validering og innsending av skjemadata
include('../php/addRouteFormInput.php');

include('../php/TabelListBox.php');

include('../php/Logg.php');

$logg = new Logg();

include('../php/AdminClasses.php');

$data = new Airport();

$dataset = $data->ShowAllAirportsDataset();

$logg->Ny('Laster FLYRUTE LEGG TIL side', 'INFO', htmlspecialchars($_SERVER['PHP_SELF']) , 'ikke logget inn');

?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">

      <h1>
        Registrere ny flyrute
        <small>Her kan du registrere nye flyruter i databasen</small>
      </h1>
    <ol class="breadcrumb">
      <li><a href="../"><i class="fa fa-dashboard"></i> Start</a></li>
      <li>Flyrute</li>
      <!-- Denne lese av script for å sette riktig link aktiv i menyen (husk ID i meny må være lik denne) -->
      <li class="active">Legg til flyrute</li>
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

            <form method="post" class="form-horizontal" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" onsubmit="return validerRegistrerFlyrute()">
              <div class="box-body">        

                <div class="form-group">
                  <label for="hovedRute" class="col-sm-2 control-label">Hovedrute</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="hovedRute" name="hovedRute" placeholder="Navn på hovedrute" value="<?php echo @$_POST['hovedRute'] ?>">
                  </div>
                </div>

                <div class="form-group">
                  <label for="fraFlyplassId" class="col-sm-2 control-label">Fra flyplass</label>
                  <div class="col-sm-10">

                    
                    <?php                       include('../php/HtmlHelperClass.php');

                      $helper = new HtmlHelperClass;

                      print $helper->GenerateSearchSelectionbox($dataset,'fraFlyplassId','fraFlyplassId','Velg flyplass',''); ?>
                    
                  </div>
                </div>


                <div class="form-group">
                  <label for="tilFlyplassId" class="col-sm-2 control-label">Til flyplass</label>
                  <div class="col-sm-10">

                    
                    <?php                       

                     

                     print $helper->GenerateSearchSelectionbox($dataset,'tilFlyplassId','tilFlyplassId','Velg flyplass',''); ?>
                    
                  </div>
                </div>


                <div class="form-group">
                  <label for="aktivFra" class="col-sm-2 control-label">Aktiv fra dato</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="aktivFra" name="aktivFra" placeholder="Aktiv fra dato" value="<?php echo @$_POST['aktivFra'] ?>">
                     </div>
                </div>

                <div class="form-group">
                  <label for="aktivTil" class="col-sm-2 control-label">Aktiv til dato</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="aktivTil" name="aktivTil" placeholder="Aktiv til dato" value="<?php echo @$_POST['aktivTil'] ?>">
                  </div>
                </div>

                  <div class="form-group">
                  <label for="reiseTid" class="col-sm-2 control-label">Reisetid</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="reiseTid" name="reiseTid" placeholder="Reisetid i minutter" value="<?php echo @$_POST['reiseTid'] ?>">
                  </div>
                </div>

              <!-- /.box-body -->
              <div class="box-footer">
                <button class="btn btn-default" onclick="fjernMelding();clearForm(this.form);return false;">Nullstill</button>

                <button type="submit" class="btn btn-info pull-right">Legg til</button>
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
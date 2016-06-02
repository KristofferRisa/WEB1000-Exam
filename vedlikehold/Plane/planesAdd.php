<?php 
$title = "FLY - Admin";


include('../html/header.html');

include('../html/admin-start.html');

// Validering og innsending av skjemadata
include('../php/addPlaneFormInput.php');

include('../php/Logg.php');

$logg = new Logg();


$logg->Ny('Laster FLY LEGG TIL side', 'INFO', htmlspecialchars($_SERVER['PHP_SELF']) , 'ikke logget inn');

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
      <li>Fly</li>
      <!-- Denne lese av script for å sette riktig link aktiv i menyen (husk ID i meny må være lik denne) -->
      <li class="active">Legg til fly</li>
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
                    <input type="text" class="form-control" id="flyAarsmodell" name="flyAarsmodell" placeholder="2011" value="<?php echo $_POST['flyAarsmodell'] ?>">
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
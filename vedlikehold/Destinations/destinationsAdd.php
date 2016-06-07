<?php 
$title = "FLY - Admin";

include('../html/start.php');

include('../html/header.html');

include('../html/admin-start.html');

// Validering og innsending av skjemadata
include('../php/addPlaneFormInput.php');

?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">

      <h1>
        Registrere ny destinasjon
        <small>Her kan du ny destinasjon i databasen</small>
      </h1>
    <ol class="breadcrumb">
      <li><a href="../"><i class="fa fa-dashboard"></i> Start</a></li>
      <li>Ny destinasjon</li>
      <!-- Denne lese av script for å sette riktig link aktiv i menyen (husk ID i meny må være lik denne) -->
      <li class="active">Legg til destinasjony</li>
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

            <form method="post" class="form-horizontal" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" onsubmit="return validerRegistrerDestinasjon()">
              <div class="box-body">        

                <div class="form-group">
                  <label for="destinasjonsID" class="col-sm-2 control-label">Destinasjons ID</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="destinasjonsID" name="destinasjonsID" placeholder="Destinasjons ID" value="<?php echo @$_POST['destinasjonsID'] ?>">
                  </div>
                </div>

                <div class="form-group">
                  <label for="flyModellflyplassID" class="col-sm-2 control-label">Flyplass ID</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="flyplassID" name="flyplassID" placeholder="Flyplass ID" value="<?php echo @$_POST['flyplassID'] ?>">
                  </div>
                </div>

                <div class="form-group">
                  <label for="flyType" class="col-sm-2 control-label">Destinasjonsnavn</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="destinasjonsNavn" name="destinasjonsNavn" placeholder="Destinasjonsnavn" value="<?php echo @$_POST['destinasjonsNavn'] ?>">
                  </div>
                </div>

                <div class="form-group">
                  <label for="land" class="col-sm-2 control-label">Geo_lat</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="geo_lat" name="geo_lat" placeholder="geo_lat" value="<?php echo @$_POST['geo_lat'] ?>">
                     </div>
                </div>

                <div class="form-group">
                  <label for="flyLaget" class="col-sm-2 control-label">Geo_lng</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="geo_lng" name="geo_lng" placeholder="geo_lng" value="<?php echo @$_POST['Geo_lng'] ?>">
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
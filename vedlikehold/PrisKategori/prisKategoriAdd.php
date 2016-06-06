<?php 
$title = "PRISKAT - Admin";

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
        Registrere ny priskategori
        <small>Her kan du registrere nye priskategorier i databasen</small>
      </h1>
    <ol class="breadcrumb">
      <li><a href="../"><i class="fa fa-dashboard"></i> Start</a></li>
      <li>Priskategorier oversikt</li>
      <!-- Denne lese av script for å sette riktig link aktiv i menyen (husk ID i meny må være lik denne) -->
      <li class="active">Legg til prisoversikt</li>
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

                <div class="form-group">
                  <label for="navn" class="col-sm-2 control-label">Navn</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="navn" name="navn" placeholder="Navn" value="<?php echo @$_POST['navn'] ?>">
                  </div>
                </div>

                <div class="form-group">
                  <label for="prosentPaaslag" class="col-sm-2 control-label">Prosentpåslag</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="prosentpaslag" name="prosentpaslag" placeholder="Prosentpåslag" value="<?php echo @$_POST['flyModell'] ?>">
                  </div>
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
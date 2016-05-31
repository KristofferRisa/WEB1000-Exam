<?php 
$title = "FLY - Admin";

include('../html/header.html');

include('../html/admin-start.html');

?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
      <h1>
        Vis alle fly
        <small>Viser en oversikt over alle fly.</small>
      </h1>
    <ol class="breadcrumb">
      <li><a href="../"><i class="fa fa-dashboard"></i> Start</a></li>
      <li>Fly</li>
      <!-- Denne lese av script for å sette riktig link aktiv i menyen (husk ID i meny må være lik denne) -->
      <li class="active">Vis alle fly</li>
    </ol>
  </section>
 <!-- Main content -->
  <section class="content">

    <!-- Your Page Content Here -->

        <div class="row">
      <div class="col-sm-12">
       
                 <!-- Horizontal Form -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Horizontal Form</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal">
              <div class="box-body">

                <div class="form-group">
                  <label for="flyId" class="col-sm-2 control-label">Fly id</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="flyId" name="flyId" placeholder="Fly id">
                  </div>
                </div>

                <div class="form-group">
                  <label for="flyNr" class="col-sm-2 control-label">Fly nr</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="flyNr" name="flyNr" placeholder="Fly nr">
                  </div>
                </div>

                <div class="form-group">
                  <label for="flyModell" class="col-sm-2 control-label">Fly modell</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="flyModell" name="flyModell" placeholder="Fly modell">
                  </div>
                </div>

                <div class="form-group">
                  <label for="flyType" class="col-sm-2 control-label">Fly type</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="flyType" name="flyType" placeholder="Fly type">
                  </div>
                </div>

                <div class="form-group">
                  <label for="flyAntallPlasser" class="col-sm-2 control-label">Antall sitteplasser</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="flyAntallPlasser" name="flyAntallPlasser" placeholder="Antall sitteplasser">
                  </div>
                </div>

                <div class="form-group">
                  <label for="flyLaget" class="col-sm-2 control-label">Årsmodell</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="flyLaget" name="flyLaget" placeholder="Årsmodell  ">
                  </div>
                </div>

                <div class="form-group">
                  <label for="flyStatusKode" class="col-sm-2 control-label">Statuskode</label>
                  <div class="col-sm-10">
                    <!--<input type="text" class="form-control" id="flyStatusKode" name="flyStatusKode" placeholder="Statuskode">
                  </div>-->

                 <select>
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
                <button type="submit" class="btn btn-default">Cancel</button>
                <button type="submit" class="btn btn-info pull-right">Sign in</button>
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
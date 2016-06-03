<?php 
$title = "FLYRUTER - Admin ";

include('../html/start.php');

include('../html/header.html');

include('../html/admin-start.html');

?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
      <h1>
        Vis alle flyruter
        <small>Viser en oversikt over alle flyruter.</small>
      </h1>
    <ol class="breadcrumb">
      <li><a href="../"><i class="fa fa-dashboard"></i> Start</a></li>
      <li>Flyruter</li>
      <!-- Denne lese av script for å sette riktig link aktiv i menyen (husk ID i meny må være lik denne) -->
      <li class="active">Vis alle flyruter</li>
    </ol>
  </section>
 <!-- Main content -->
  <section class="content">

    <!-- Your Page Content Here -->

        <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Liste over flyruter</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
              <div class="row">
                <div class="col-sm-6"></div>
                <div class="col-sm-6"></div>
              </div>
              <div class="row">
                <div class="col-sm-12">
                  <table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                    <thead>
                      <tr role="row">
                        <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="id">ID</th>
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="hovedRute">Hovedrute</th>
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="fraFlyplassId">Fra flyplass</th>
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="tilFlyplassId">Til flyplass</th>
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="aktivFra">Aktiv fra dato</th>
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="aktivTil">Aktiv til dato</th>                      
                      <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="reiseTid">Reisetid</th>
                      <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="statusKodeId">Statuskode id</th>
                      <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="endret">Data endret</th></tr>
                      
                    </thead>
                    <tbody>
<?php 

include('../php/AdminClasses.php');

$planes = new Planes;


print( $planes->ShowAllPlanes() );


?> 


                    </tbody>
                    <tfoot>
                      <tr>
                        <th rowspan="1" colspan="1">ID</th>
                        <th rowspan="1" colspan="1">Hovedrute</th>
                        <th rowspan="1" colspan="1">Fra flyplass</th>
                        <th rowspan="1" colspan="1">Til flyplass</th>
                        <th rowspan="1" colspan="1">Aktiv fra dato</th>
                        <th rowspan="1" colspan="1">Aktiv til dato</th>
                        <th rowspan="1" colspan="1">Reisetid</th>
                        <th rowspan="1" colspan="1">Statuskode Id</th>
                        <th rowspan="1" colspan="1">Data endret</th>
                      </tr>
                    </tfoot>
                  </table>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-5">
                  <div class="dataTables_info" id="example2_info" role="status" aria-live="polite"><?php $rader = new Count; print( $rader->AntallRader('rute') ); ?></div>
                </div>
              </div>
            </div>
          </div>
          <!-- /.box-body -->
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
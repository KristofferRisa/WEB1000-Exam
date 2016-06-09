<?php 
$title = "DESTINASJONER - VIS - Admin ";

include('../html/start.php');

include('../html/header.html');

include('../html/admin-start.html');

$errorMelding ="test";

if (@$_GET["deleteRows"] && @$_GET["deleteRows"] == -1)
{
  $errorMelding = $html->errorMsg("Kan ikke slette data grunnen fremmednøkler");
}

?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
      <h1>
        Vis alle destinasjoner
        <small>Viser en oversikt over alle destinasjoner.</small>
      </h1>
    <ol class="breadcrumb">
      <li><a href="../"><i class="fa fa-dashboard"></i> Start</a></li>
      <li>Destinasjoner</li>
      <!-- Denne lese av script for å sette riktig link aktiv i menyen (husk ID i meny må være lik denne) -->
      <li class="active">Vis destinasjoner</li>
    </ol>
  </section>
 <!-- Main content -->
  <section class="content">

    <!-- Your Page Content Here -->

        <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Liste over destinasjoner</h3>
                        
          </div>
          <!-- /.box-header -->
          <div class="box-body">
          <?php echo $errorMelding; ?>
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
                        <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="DestinasjonsID">Destinasjons ID</th>
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="FlyplassID">Flyplass ID</th>
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Navn">Navn</th>
                        
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Landskode">Landskode</th>
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Stedsnavn">Stedsnavn</th>
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Geo_lat">Geo_lat</th>
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Geo_lng">Geo_lng</th>
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Endret">Endret</th>
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Handling">Handling</th>            
                     
                      </tr>
                    </thead>
                    <tbody>
<?php 

include('../php/AdminClasses.php');
include('../php/Destinasjon.php');
$destination = new Destinasjon();


print( $destination->ShowAllDestinations() );


?> 


                    </tbody>
                    <tfoot>
                      <tr>
                        <th rowspan="1" colspan="1">Destinasjons ID</th>
                        <th rowspan="1" colspan="1">Flyplass ID</th>
                        <th rowspan="1" colspan="1">Navn</th>
                        
                        <th rowspan="1" colspan="1">Landskode</th>
                        <th rowspan="1" colspan="1">Stedsnavn</th>
                        <th rowspan="1" colspan="1">Geo_lat</th>
                        <th rowspan="1" colspan="1">Geo_lng</th>
                        <th rowspan="1" colspan="1">Endret</th>
                        <th rowspan="1" colspan="1">Handling</th>
                        </tr>
                    </tfoot>
                  </table>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-5">
                  <div class="dataTables_info" id="example2_info" role="status" aria-live="polite"><?php $rader = new Count; print( $rader->AntallRader('destinasjon') ); ?></div>
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
<?php 
$title = "AVGANG - Admin ";

include('../html/start.php');

include('../html/header.html');

include('../html/admin-start.html');


$errorMeldingBitch ="";

if (@$_GET["deleteRows"] && @$_GET["deleteRows"] == -1)
{
  $errorMeldingBitch= $html->errorMsg("Kan ikke slette data grunnet fremmednøkler. Alle tilhørende avganger må slettes først.");
}

?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
      <h1>
        Vis alle avganger
        <small>Viser en oversikt over alle avganger.</small>
      </h1>
    <ol class="breadcrumb">
      <li><a href="../"><i class="fa fa-dashboard"></i> Start</a></li>
      <li>Avgang</li>
      <!-- Denne lese av script for å sette riktig link aktiv i menyen (husk ID i meny må være lik denne) -->
      <li class="active">Vis alle avganger</li>
    </ol>
  </section>
 <!-- Main content -->
  <section class="content">

    <!-- Your Page Content Here -->

        <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Liste over avganger</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <?php echo $errorMeldingBitch; ?>
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
                        <!--<th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="avgangID">ID</th>-->
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="avgFlyId">Fly</th>
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="avgfraDestId">Fra </th>
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="avgTilDestId">Til</th>
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="avgDato">Dato</th>
                        <!--<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="avgDirekte">Direkte</th>-->
                        <!--<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="avgReiseTid">Reise tid</th>-->
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="avgkl">Klokkeslett</th>
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="avgfastpris">Fastpris</th>
                        <!--<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="endret">Endret</th>-->
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="hendelser">Handlinger</th>
  

                      
                    </thead>
                    <tbody>
<?php 

include('../php/AdminClasses.php');
include('../php/Avgang.php');


$avgang = new Avgang;


print ($avgang->GetAllAvganger() );

?> 


                    </tbody>

                    <tfoot>
                      <tr>
                        <th rowspan="1" colspan="1">Fly</th>
                        <th rowspan="1" colspan="1">Fra</th>
                        <th rowspan="1" colspan="1">Til</th>                        
                        <th rowspan="1" colspan="1">Dato</th>
                        <th rowspan="1" colspan="1">Klokkeslett</th>
                        <th rowspan="1" colspan="1">Fastpris</th>

                        <th rowspan="1" colspan="1">Handling</th>
                        </tr>
                    </tfoot>

                  </table>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-5">
                  <div class="dataTables_info" id="example2_info" role="status" aria-live="polite"><?php $rader = new Count; print( $rader->AntallRader('avgang') );?></div>
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
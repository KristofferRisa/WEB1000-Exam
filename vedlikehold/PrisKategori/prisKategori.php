<?php 
$title = "PRISKATEGORIER - Admin ";

include('../html/start.php');

include('../html/header.html');

include('../html/admin-start.html');
$errorMelding = "";

?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
      <h1>
        Vis alle priskategorier
        <small>Viser en oversikt over alle priskategorier.</small>
      </h1>
    <ol class="breadcrumb">
      <li><a href="../"><i class="fa fa-dashboard"></i> Start</a></li>
      <li>Priskategorier</li>
      <!-- Denne lese av script for å sette riktig link aktiv i menyen (husk ID i meny må være lik denne) -->
      <li class="active">Vis alle priskategorier</li>
    </ol>
  </section>
 <!-- Main content -->
  <section class="content">

    <!-- Your Page Content Here -->

        <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header"><?php echo $errorMelding; ?><div id="melding"></div>
            <h3 class="box-title">Liste over priskategorier</h3>
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
                        <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="PrisKatId">ID</th>
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="PrisKatNavn">Priskategori navn</th>
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="PrisKatProsentPaaslag">Priskategori prosentpåslag</th>

                      
                    </thead>
                    <tbody>
<?php 

include('../php/AdminClasses.php');
include('../php/prisKat.php');


$prisKat = new PrisKat;


$data = $prisKat->GetAllPrisKategorier($logg);
echo $html -> LagTabell($data, 3, $logg);
print_r ($data);


?> 


                    </tbody>

                  </table>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-5">
                  <div class="dataTables_info" id="example2_info" role="status" aria-live="polite"><?php $rader = new Count; print( $rader->AntallRader('prisKategori') ); ?></div>
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
<?php 
$title = "BILLETTER - VIS - Admin ";

include('../html/start.php');
include('../html/header.html');
include('../html/admin-start.html');
include('../php/Billett.php');

?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
      <h1>
        Vis alle billetter
        <small>Viser en oversikt over alle billetter.</small>
      </h1>
    <ol class="breadcrumb">
      <li><a href="../"><i class="fa fa-dashboard"></i> Start</a></li>
      <li>Billetter</li>
      <!-- Denne lese av script for å sette riktig link aktiv i menyen (husk ID i meny må være lik denne) -->
      <li class="active">Vis billetter</li>
    </ol>
  </section>
 <!-- Main content -->
  <section class="content">

    <!-- Your Page Content Here -->

        <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Liste over billetter</h3>
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
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="billettId">Billett ID</th>
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="bestillingId">Bestillings ID</th>
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="avgangId">Avgang ID</th>
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="seteId">Sete ID</th>
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="fornavn">Fornavn</th>
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="etternavn">Etternavn</th>
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="kjonn">Kjønn</th>
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="antBagasje">Antall bagasje</th>
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Handling">Handling</th>                      
                      </tr>
                    </thead>
                    <tbody>
<?php 

include('../php/AdminClasses.php');

$biletter = new Billett;


print( $biletter->ShowAllBilletter() );


?> 


                    </tbody>

                    <tfoot>
                      <tr>
                        <th rowspan="1" colspan="1">Billett ID</th>
                        <th rowspan="1" colspan="1">Bestillings ID</th>
                        <th rowspan="1" colspan="1">Avgang ID</th>                        
                        <th rowspan="1" colspan="1">Sete ID</th>
                        <th rowspan="1" colspan="1">Fornavn</th>
                        <th rowspan="1" colspan="1">Etternavn</th>
                        <th rowspan="1" colspan="1">Kjønn</th>
                        <th rowspan="1" colspan="1">Antall bagasje</th>
                        <th rowspan="1" colspan="1">Handling</th>
                        </tr>
                    </tfoot>
                  </table>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-5">
                  <div class="dataTables_info" id="example2_info" role="status" aria-live="polite"><?php $rader = new Count; print( $rader->AntallRader('billett') ); ?></div>
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
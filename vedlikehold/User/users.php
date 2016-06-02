<?php 
$title = "FLY - Admin";

include('./../html/start.php');

include('./../html/header.html');

include('./../html/admin-start.html');

?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
      <h1>
        Brukere
        <small>Oversikt over alle brukere</small>
      </h1>
    <ol class="breadcrumb">
      <li><a href="./"><i class="fa fa-dashboard"></i> Start</a></li>
      <li >Brukere</li>
      <!-- Denne brukes av javascript for å sette riktig link aktiv i menyen (husk ID i meny må være lik denne) -->
      <li class="active">Vis</li> 
    </ol>
  </section>
 <!-- Main content -->
  <section class="content">

    <!-- Your Page Content Here -->
    <div class="row">
   <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Brukere
           </h3>
            
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
                        <!-- Legg inn kolonner -->
                        <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="id">ID</th>
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Firstname">Fornavn</th>
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Lastname">Etternavn</th>
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Mail">epost</th>
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Tittle">Tittel</th>
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Phone.">Tlf</th>
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="DOB.">Bursdag</th>
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Type">Type</th>
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Type">Status</th>
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Type">Handling</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php 

                      // PHP kode for å hente tabell HTML kode
                      include('./../php/Logg.php');
                      $user = new User();

                      error_reporting(0);
                      $sidenr = $_GET['p'];

                      if(!$sidenr){
                        $sidenr = 1;
                      }

                      $logg = new Logg();

                      print($user->VisAlle($sidenr,$logg));
                      $antallMeldinger = $user->AntallBrukere;
                      
                      $antallSider = ceil($antallMeldinger / 100);

                      // print($antallMeldinger);

                    ?> 
                    </tbody>
                    <tfoot>
                      <tr>
                        <!-- Legg inn kolonner -->
                        <th rowspan="1" colspan="1">ID</th>
                        <th rowspan="1" colspan="1">Fornavn</th>
                        <th rowspan="1" colspan="1">Etternavn</th>
                        <th rowspan="1" colspan="1">Epost</th>
                        <th rowspan="1" colspan="1">Tittel</th>
                        <th rowspan="1" colspan="1">Tlf</th>
                        <th rowspan="1" colspan="1">Bursdag</th>
                        <th rowspan="1" colspan="1">Type</th>
                        <th rowspan="1" colspan="1">Status</th>
                        <th rowspan="1" colspan="1">Handling</th>
                      </tr>
                    </tfoot>
                  </table>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-5">
                  <div class="dataTables_info" id="example2_info" role="status" aria-live="polite">Showing 1 to 100 of <?php print($antallMeldinger);?> entries</div>
                </div>
                <div class="col-sm-7">
                  <div class="dataTables_paginate paging_simple_numbers" id="example2_paginate">
                    <ul class="pagination">
 
                      
                    <?php 
                    //Håndtering av sideantall
                    //printer li element pr side og finner hvilken side og hvilken knapp som er aktiv.
                    for($i = 1; $i <= $antallSider; $i++){
                      if($i == $sidenr) { 
                        print('<li class="paginate_button active"><a href="./User/users.php?p='.$i.'" aria-controls="example2" data-dt-idx="1" tabindex="0">'.$i.'</a></li>');  
                      } else {
                        print('<li class="paginate_button"><a href="./User/users.php?p='.$i.'" aria-controls="example2" data-dt-idx="1" tabindex="0">'.$i.'</a></li>');  
                      }
                    } 
                    ?>
                    
                    
                   </ul>
                  </div>
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
include('./../html/admin-slutt.html');

include('./../html/script.html');

?>
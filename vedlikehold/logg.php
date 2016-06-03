<?php 
$title = "FLY - Admin";

include('./html/start.php');

include('./html/header.html');

include('./html/admin-start.html');

?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
       
       <h1>
        Logg<small>Se alle loggmeldinger</small>
      </h1>
       
       
       <ol class="breadcrumb">
         <li>
            <a href="#">
                <i class="fa fa-dashboard"></i> Start
            </a>
        </li>
        <li class="active">Logg</li>
      </ol>
    
  </section>
  
  <!-- Main content -->
  <section class="content">

    <!-- Your Page Content Here -->
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Meldinger</h3>
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
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Nivå: Sortert etter meldingsnivået, INFO, ERROR, DEBUG.">Nivå</th>
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Melding: Sortert etter meldingsinnhold.">Melding</th>
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Module: Sortert etter modul meldingen opprettet i.">Modul</th>
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="BrukerId: sortert etter bruker id">Bruker ID</th>
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Datotid: Sortering etter opprettet tidspunkt.">Opprettet</th>
                      </tr>
                    </thead>
                    <tbody>
<?php 
// PHP kode for å hente tabell HTML kode


$logg = new Logg();
//Logger
// $logg->Ny('Laster LOGG side', 'INFO','/vedlikehold/logg.php', 'ikke logget inn');

//Logikk for å finne side tallet
$antallMeldinger = $logg->AntallMeldinger();
$antallSider = ceil($antallMeldinger / 100);
error_reporting(1);

$sidenr = $_GET['p'];

if(!$sidenr){
  $sidenr = 1;
}

// print('sidenr = '.$sidenr);
print($logg->AltPrSide(100,$sidenr));

?> 
                    </tbody>
                    <tfoot>
                      <tr>
                        <th rowspan="1" colspan="1">ID</th>
                        <th rowspan="1" colspan="1">Nivå</th>
                        <th rowspan="1" colspan="1">Melding</th>
                        <th rowspan="1" colspan="1">Modul</th>
                        <th rowspan="1" colspan="1">Bruker ID</th>
                        <th rowspan="1" colspan="1">Opprettet</th>
                      </tr>
                    </tfoot>
                  </table>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-5">
                  <div class="dataTables_info" id="example2_info" role="status" aria-live="polite">Totalt <?php print($antallMeldinger);?> logg meldinger.</div>
                </div>
                <div class="col-sm-7">
                  <div class="dataTables_paginate paging_simple_numbers" id="example2_paginate">
                    <ul class="pagination">
 
                      
<?php 
//Håndtering av sideantall
//printer li element pr side og finner hvilken side og hvilken knapp som er aktiv.
for($i = 1; $i <= $antallSider; $i++){
  if($i == $sidenr) { 
    print('<li class="paginate_button active"><a href="logg.php?p='.$i.'" aria-controls="example2" data-dt-idx="1" tabindex="0">'.$i.'</a></li>');  
  } else {
    print('<li class="paginate_button"><a href="logg.php?p='.$i.'" aria-controls="example2" data-dt-idx="1" tabindex="0">'.$i.'</a></li>');  
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
include('./html/admin-slutt.html');

include('./html/script.html');

?>
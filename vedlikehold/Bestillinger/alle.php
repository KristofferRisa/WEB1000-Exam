<?php 
$title = "FLY - Admin";

include('./../html/start.php');
include('./../html/header.html');
include('./../html/admin-start.html');
include('../php/Bestilling.php');

$bestillinger = new Bestilling();

$errorMeldingBitch ="";

if (@$_GET["deleteRows"] && @$_GET["deleteRows"] == -1)
{
  $errorMeldingBitch= $html->errorMsg("Kan ikke slette data grunnet fremmednøkler. Alle tilhørende billetter må slettes først.");
}

?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
      <h1>
        Alle bestillinger
        <small>Oversikt over alle bestillinger</small>
      </h1>
    <ol class="breadcrumb">
      <li><a href="./"><i class="fa fa-dashboard"></i> Start</a></li>
      <li >Billetter og bestillinger</li>
      <!-- Denne brukes av javascript for å sette riktig link aktiv i menyen (husk ID i meny må være lik denne) -->
      <li class="active">Bestillinger</li> 
    </ol>
  </section>
 <!-- Main content -->
  <section class="content">

    <!-- Your Page Content Here -->
    <div class="row">
   <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Nyeste først
           </h3>
            
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
                        <!-- Legg inn kolonner -->
                        <th class="sorting_desc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="descending" aria-label="id">Id</th>
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="UserID">Bestillingsdato</th>
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="UserID">Ref no</th>
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Firstname">Utreise dato</th>
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Lastname">Retur dato</th>
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Mail">Fornavn</th>
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Tittle">Etternavn</th>
                        <th class="hidden-xs sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Phone.">e-post</th>
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="DOB.">TLF</th>
                        <th class="hidden-xs sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Type">Antall Reisende</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php 
                    
                      $data = $bestillinger->GetAllBestilling($logg);
                      echo $html->LagTabell($data, 10,$logg);
                    
                    ?> 
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-5">
                  <div class="dataTables_info" id="example2_info" role="status" aria-live="polite"><?php include('../php/AdminClasses.php'); $rader = new Count; print( $rader->AntallRader('bestilling') ); ?> rader</div>
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
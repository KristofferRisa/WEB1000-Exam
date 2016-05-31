<?php  // FORM POST

if($_POST){
  include('./../php/Logg.php');
  $logg = new Logg();
  $logg->Ny('POST av ny bruker skjema', 'DEBUG','users/add.php', 'NA');
  //Sjekk input parametere
  if($_POST["inputFornavn"]
    && $_POST["inputEtternavn"]
    && $_POST["inputDato"]
    && $_POST["inputKjonn"]
    && $_POST["inputEmail"]
    && $_POST["inputPassword3"]
    && $_POST["inputPassword4"]
    && $_POST["inputTlf"]){
      
      $logg->Ny('Alle input felter funnet', 'DEBUG','users/add.php', 'NA');
      
      //Input parametere
      $fornavn = $_POST["inputFornavn"];
      $etternavn = $_POST["inputEtternavn"];
      $fødselsdato = $_POST["inputDato"];
      $kjonn = $_POST["inputKjonn"];
      $mail = $_POST["inputEmail"];
      $pass1 = $_POST["inputPassword3"];
      $pass2 = $_POST["inputPassword4"];
      $tlf = $_POST["inputTlf"];
      
      //RegEx pattern
      $klassekodepattern = "/^[A-Z]{2,}[0-9]{1,}$/";
      $klassenavnpattern = "/^[A-Za-z]{1,}/";

      //Validering av felter ved RegEx kode
      //http://php.net/manual/en/function.ereg.php 
      if(preg_match($klassekodepattern, $klassekode)) {
        
      }
      
    }
  
}

?>

<?php 
$title = "FLY - Admin";

include('./../html/header.html');

include('./../html/admin-start.html');

?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
      <h1>
        [Header]
        <small>[Description]</small>
      </h1>
    <ol class="breadcrumb">
      <li><a href="./"><i class="fa fa-dashboard"></i> Start</a></li>
      <li>Brukere</li>
      <!-- Denne brukes av javascript for å sette riktig link aktiv i menyen (husk ID i meny må være lik denne) -->
      <li class="active">Ny</li> 
    </ol>
  </section>
 <!-- Main content -->
  <section class="content">

    <!-- Your Page Content Here -->
    <div class="row">
   <div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Ny bruker</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" method="POST" id="nybruker">
              <div class="box-body">
               
               <!-- Fornav -->
                <div class="form-group">
                  <label for="inputFornavn" class="col-sm-2 control-label">Fornavn</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="inputFornavn" name="inputFornavn" placeholder="Fornavn">
                  </div>
                </div>
                
                <!-- Etternav -->
                <div class="form-group">
                  <label for="inputEtternavn" class="col-sm-2 control-label">Etternavn</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="inputEtternavn" name="inputEtternavn" placeholder="Etternavn">
                  </div>
                </div>
               
               <!-- Dato -->
                <div class="form-group">
                <label class="col-sm-2 control-label">Fødselsdag:</label>
                <div class="col-sm-10">
                  <div class="input-group date">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" class="form-control" id="datepicker" name="inputDato">
                  </div>
                 </div>
                <!-- /.input group -->
                </div>
                
                <!-- Kjønn -->
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Kjønn:</label>
                    <div class="col-sm-2">
                      <select class="form-control select2 select2-hidden-accessible" name="inputKjonn" form="nybruker" style="width: 100%;" tabindex="-1" aria-hidden="true">
                        <option>Mann</option>
                        <option>Kvinne</option>
                      </select>
                      <span class="dropdown-wrapper" aria-hidden="true"></span>
                    </div>
                  </div>
               
               <!-- Email -->
                <div class="form-group">
                  <label for="inputEmail" class="col-sm-2 control-label">Email</label>
                  <div class="col-sm-10">
                    <input type="email" class="form-control" id="inputEmail" name="inputEmail" placeholder="Email">
                  </div>
                </div>
                
                <!-- Passord -->
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Password</label>
                  <div class="col-sm-10">
                    <input type="password" class="form-control" id="inputPassword3" name="inputPassword3" placeholder="Password">
                  </div>
                </div>
                
                <!-- Passord 2 -->
                <div class="form-group">
                  <label for="inputPassword4" class="col-sm-2 control-label">Password</label>
                  <div class="col-sm-10">
                    <input type="password" class="form-control" id="inputPassword4" name="inputPassword4" placeholder="Password">
                  </div>
                </div>
                
                <!-- TLF -->
                <div class="form-group">
                  <label for="inputTlf" class="col-sm-2 control-label">Tlf</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="inputTlf" name="inputTlf" placeholder="Telefon nummer">
                  </div>
                </div>
                
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" class="btn btn-default" onclick="location.href='./';return false;">Tilbake</button>

                <button type="submit" class="btn btn-info pull-right">Opprett</button>
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
include('./../html/admin-slutt.html');

include('./../html/script.html');

?>
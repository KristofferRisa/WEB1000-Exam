<?php
$title = "FLY - Admin";
include('./../html/start.php');
include('./../html/header.html');
include('./../html/admin-start.html');
include('./../php/Tittel.php');

$t = new Tittel();

if($_POST){
  include('./../php/Logg.php');
  include('./../php/User.php');
  $logg = new Logg();
  $logg->Ny('POST av ny bruker skjema', 'DEBUG',htmlspecialchars($_SERVER['PHP_SELF']), 'NA');
  
  $brukernavn = $_POST["inputBrukernavn"];
  $fornavn = $_POST["inputFornavn"];
  $etternavn = $_POST["inputEtternavn"];
  $DOB = $_POST["inputDato"];
  $kjonn = $_POST["inputKjonn"];
  $mail = $_POST["inputEmail"];
  $pass1 = $_POST["inputPassword3"];
  $pass2 = $_POST["inputPassword4"];
  $tlf = $_POST["inputTlf"];
  $tittel = $_POST["inputTittel"];
  
  //Input parametere
  $logg->Ny('Parameter Fornavn: '.$fornavn, 'DEBUG',htmlspecialchars($_SERVER['PHP_SELF']), '');
  $logg->Ny('Parameter Etternav: '.$etternavn, 'DEBUG',htmlspecialchars($_SERVER['PHP_SELF']), '');
  $logg->Ny('Parameter DOB: '.$DOB, 'DEBUG',htmlspecialchars($_SERVER['PHP_SELF']), '');
  $logg->Ny('Parameter kjønn: '.$kjonn, 'DEBUG',htmlspecialchars($_SERVER['PHP_SELF']), '');
  $logg->Ny('Parameter tittel: '.$tittel, 'DEBUG',htmlspecialchars($_SERVER['PHP_SELF']), '');
  $logg->Ny($pass1.' - '.$pass2, 'DEBUG',htmlspecialchars($_SERVER['PHP_SELF']), '');
  $logg->Ny('Parameter tlf: '.$tlf, 'DEBUG',htmlspecialchars($_SERVER['PHP_SELF']), '');
  //Sjekk input parametere
  if($brukernavn
    && $fornavn
    && $etternavn
    && $DOB
    && $kjonn
    && $mail
    && $pass1
    && $pass2
    && $tlf
    && $tittel
    && $pass1 == $pass2){
      
      $logg->Ny('Alle input felter funnet', 'DEBUG','users/add.php', 'NA');
      
      //RegEx pattern
      $klassekodepattern = "/^[A-Z]{2,}[0-9]{1,}$/";
      $klassenavnpattern = "/^[A-Za-z]{1,}/";

      //Validering av felter ved RegEx kode
      //http://php.net/manual/en/function.ereg.php 
      // if(preg_match($klassekodepattern, $klassekode)) {
        
      // }
      
      $user = new User();
      
      $user->NewUser($brukernavn, $fornavn, $etternavn, $DOB, $kjonn, $mail, $pass1, $tlf, $tittel,$logg);
      
    }
  
}

?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
      <h1>
        Opprett ny bruker
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
              <h3 class="box-title">Bruker</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" method="POST" id="nybruker">
              <div class="box-body">
               
               <!--TODO:  Sjekke at brukernavn ikke finnes fra før! NB! Husk update.php-->
               
               <!-- Brukernavn -->
                <div class="form-group">
                  <label for="inputBrukernavn" class="col-md-2 control-label">Brukernavn</label>
                  <div class="col-md-10">
                    <input type="text" class="form-control" id="inputBrukernavn" name="inputBrukernavn" required placeholder="">
                  </div>
                </div>
                
               
               <!-- Fornav -->
                <div class="form-group">
                  <label for="inputFornavn" class="col-md-2 control-label">Fornavn</label>
                  <div class="col-md-10">
                    <input type="text" class="form-control" id="inputFornavn" name="inputFornavn" required
                    placeholder="Ola">
                  </div>
                </div>
                
                <!-- Etternav -->
                <div class="form-group">
                  <label for="inputEtternavn" class="col-md-2 control-label">Etternavn</label>
                  <div class="col-md-10">
                    <input type="text" class="form-control" id="inputEtternavn" name="inputEtternavn" required 
                    placeholder="Norman">
                  </div>
                </div>
                
               <!-- Email -->
                <div class="form-group">
                  <label for="inputEmail" class="col-md-2 control-label">Email</label>
                  <div class="col-md-10">
                    <input type="email" class="form-control" id="inputEmail" name="inputEmail" placeholder=""
                      required>
                  </div>
                </div>
             
               
               <!-- Dato -->
                <div class="form-group">
                <label class="col-md-2 control-label">Fødselsdag:</label>
                <div class="col-md-2">
                  <div class="input-group date">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" class="form-control" id="datepicker" name="inputDato">
                  </div>
                 </div>
                <!-- /.input group -->
                <!--</div>-->
                
                <!-- Kjønn -->
                  <!--<div class="form-group">-->
                    <label class="col-md-1 control-label">Kjønn:</label>
                    <div class="col-md-2">
                      <select class="form-control select2 select2-hidden-accessible" name="inputKjonn" 
                        form="nybruker" style="width: 100%;" tabindex="-1" aria-hidden="true">
                        <option>Mann</option>
                        <option>Kvinne</option>
                      </select>
                      <span class="dropdown-wrapper" aria-hidden="true"></span>
                    </div>
                  <!--</div>-->
                  
                  
                  <!-- Tittel -->
                <!--<div class="form-group">-->
                  <label for="inputTittel" class="col-md-1 control-label">Tittel</label>
                  <div class="col-md-2">
                      
                      <select class="form-control select2 select2-hidden-accessible" name="inputTittel"  form="nybruker" style="width: 100%;" tabindex="-1" aria-hidden="true">
                          <?php print($t->TittelSelectOptions()); ?>
                      </select>
                      
                  </div>
                </div>
                
                <!-- TLF -->
                <div class="form-group">
                  <label for="inputTlf" class="col-md-2 control-label">Tlf</label>
                  <div class="col-md-10">
                    <input type="text" class="form-control" id="inputTlf" name="inputTlf" placeholder="+47 999 99 999">
                  </div>
                </div>
                
                  
                <!-- Passord -->
                <div class="form-group">
                  <label for="inputPassword3" class="col-md-2 control-label">Passord</label>
                  <div class="col-md-10">
                    <input type="password" class="form-control" id="inputPassword3" name="inputPassword3" >
                  </div>
                </div>
                
                <!-- Passord 2 -->
                <div class="form-group">
                  <label for="inputPassword4" class="col-md-2 control-label">Gjenta passord</label>
                  <div class="col-md-10">
                    <input type="password" class="form-control" id="inputPassword4" name="inputPassword4" >
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
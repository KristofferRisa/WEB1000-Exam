<?php  

//Includes
include('./../php/Logg.php');
include('./../php/User.php');

//Globale variabler
$user = new User();
$logg = new Logg();

$responseMsg = "";

if($_POST){

  $logg->Ny('POST av ny bruker skjema', 'DEBUG',htmlspecialchars($_SERVER['PHP_SELF']), 'NA');
  
  $fornavn = $_POST["inputFornavn"];
  $etternavn = $_POST["inputEtternavn"];
  $DOB = $_POST["inputDato"];
  $kjonn = $_POST["inputKjonn"];
  $mail = $_POST["inputEmail"];
  $tlf = $_POST["inputTlf"];
  $tittel = $_POST["inputTittel"];
  
  //Input parametere
  $logg->Ny('Parameter Fornavn: '.$fornavn, 'DEBUG',htmlspecialchars($_SERVER['PHP_SELF']), '');
  $logg->Ny('Parameter Etternav: '.$etternavn, 'DEBUG',htmlspecialchars($_SERVER['PHP_SELF']), '');
  $logg->Ny('Parameter DOB: '.$DOB, 'DEBUG',htmlspecialchars($_SERVER['PHP_SELF']), '');
  $logg->Ny('Parameter kjønn: '.$kjonn, 'DEBUG',htmlspecialchars($_SERVER['PHP_SELF']), '');
  $logg->Ny('Parameter tittel: '.$tittel, 'DEBUG',htmlspecialchars($_SERVER['PHP_SELF']), '');
  $logg->Ny('Parameter tlf: '.$tlf, 'DEBUG',htmlspecialchars($_SERVER['PHP_SELF']), '');
  //Sjekk input parametere
  if($fornavn
    && $etternavn
    && $DOB
    && $kjonn
    && $mail
    && $tlf
    && $tittel){
      
      $logg->Ny('Alle input felter funnet', 'DEBUG','users/add.php', 'NA');
      
      //RegEx pattern
      $klassekodepattern = "/^[A-Z]{2,}[0-9]{1,}$/";
      $klassenavnpattern = "/^[A-Za-z]{1,}/";

      //Validering av felter ved RegEx kode
      //http://php.net/manual/en/function.ereg.php 
      // if(preg_match($klassekodepattern, $klassekode)) {
        
      // }

      $userId = $_GET['id'];
      
      $result = $user->UpdateUser($userId, $fornavn, $etternavn, $DOB, $kjonn, $mail, $tlf, $tittel, $logg);     
      
      if($result == 1){
        $responseMsg = "<div class='alert alert-success alert-dismissible'><strong>Success!</strong> Brukeren ble oppdatert.</div>";
      } else {
        $responseMsg = "<div class='alert alert-error'><strong>Error!</strong> Klarte ikke å oppdatere bruker</div>";
      } 
    }
  
} 


if($_GET && $_GET['id']){
  
  $id = $_GET['id'];
  
  header('x-uid:'.$id);
  
  //returnerer en array med bruker info    
  $userinfo = $user->GetUser($id, $logg);
  
  //DEBUG
  //print_r($userinfo);
  
} else {
  header('location: ./users.php');
  exit;
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
        Oppdater bruker
        <small></small>
      </h1>
    <ol class="breadcrumb">
      <li><a href="./"><i class="fa fa-dashboard"></i> Start</a></li>
      <li>Brukere</li>
      <!-- Denne brukes av javascript for å sette riktig link aktiv i menyen (husk ID i meny må være lik denne) -->
      <li class="active">Endre</li> 
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
              <?php echo $responseMsg ?>
              <h3 class="box-title">Bruk feltene under for å oppdatere.</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" method="POST" id="nybruker">
              <div class="box-body">
               
               <!-- Fornav -->
                <div class="form-group">
                  <label for="inputId" class="col-sm-2 control-label">Id</label>
                  <div class="col-sm-10">
                    <input type="text" disabled class="form-control" id="inputId" name="inputId" value="<?php echo $id ?>">
                  </div>
                </div>
               
               <!-- Fornav -->
                <div class="form-group">
                  <label for="inputFornavn" class="col-sm-2 control-label">Fornavn</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="inputFornavn" name="inputFornavn" 
                    value="<?php echo $userinfo[0][1]; ?>">
                  </div>
                </div>
                
                <!-- Etternav -->
                <div class="form-group">
                  <label for="inputEtternavn" class="col-sm-2 control-label">Etternavn</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="inputEtternavn" name="inputEtternavn" 
                    value="<?php echo $userinfo[0][2]; ?>">
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
                    <input type="text" class="form-control" id="datepicker" name="inputDato"
                    value="<?php echo $userinfo[0][6]; ?>">
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
                  
                  
                  <!-- Tittel -->
                <div class="form-group">
                  <label for="inputTittel" class="col-sm-2 control-label">Tittel</label>
                  <div class="col-sm-2">
                    <!--<input type="text" class="form-control" id="inputTittel" name="inputTittel" placeholder="Tittel">-->
                    <select class="form-control select2 select2-hidden-accessible" name="inputTittel" form="nybruker" style="width: 100%;" tabindex="-1" aria-hidden="true">
                    <?php
                      include('./../php/Tittel.php');
                      $t = new Tittel();
                      
                      print($t->TittelSelectOptions());
                      
                      ?>
                      </select>
                    
                  </div>
                </div>
               
               <!-- Email -->
                <div class="form-group">
                  <label for="inputEmail" class="col-sm-2 control-label">Email</label>
                  <div class="col-sm-10">
                    <input type="email" class="form-control" id="inputEmail" name="inputEmail" 
                    value="<?php echo $userinfo[0][3]; ?>">
                  </div>
                </div>
                
              
                <!-- TLF -->
                <div class="form-group">
                  <label for="inputTlf" class="col-sm-2 control-label">Tlf</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="inputTlf" name="inputTlf" 
                    value="<?php echo $userinfo[0][4]; ?>">
                  </div>
                </div>
                
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" class="btn btn-default" onclick="location.href='./User/users.php';return false;">Tilbake</button>
                
                <button type="submit" class="btn btn-default" onclick="location.href='./User/users.php';return false;">Nullstill</button>
                
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
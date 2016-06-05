<?php  
$title = "FLY - Admin";

//Includes
include('./../html/start.php');
include('./../html/header.html');
include('./../html/admin-start.html');
include('./../php/Tittel.php');
include('./../php/UserType.php');

$t = new Tittel();
$ut = new UserType();
$types = $ut->GetUserTypes($logg);

$responseMsg = "";
//RegEx pattern
$brukernavnPattern = "/^[A-Za-z0-9]{2,}$/";
$navnPattern = "/^[A-Za-z]{2,}$/";
$passordPattern = "/^[A-Za-z0-9#$@!%&*?]{3,}$/";
$inputDatoPattern = "/(^(((0[1-9]|1[0-9]|2[0-8])[\/](0[1-9]|1[012]))|((29|30|31)[\/](0[13578]|1[02]))|((29|30)[\/](0[4,6,9]|11)))[\/](19|[2-9][0-9])\d\d$)|(^29[\/]02[\/](19|[2-9][0-9])(00|04|08|12|16|20|24|28|32|36|40|44|48|52|56|60|64|68|72|76|80|84|88|92|96)$)/";

if($_GET['id']){
  
  //returnerer en array med bruker info
  //brukes av både GET OG POST    
  $id = $_GET['id'];
  $userinfo = $user->GetUser($id, $logg);
  print_r($userinfo);
  
}

if($_POST){
  // Forsøker å oppdater bruker
  
  $brukernavn = $_POST["inputBrukernavn"];
  $fornavn = $_POST["inputFornavn"];
  $etternavn = $_POST["inputEtternavn"];
  $DOB = $_POST["inputDato"];
  $kjonn = $_POST["inputKjonn"];
  $mail = $_POST["inputEmail"];
  $tlf = $_POST["inputTlf"];
  $tittel = $_POST["inputTittel"];
  $brukerType = $_POST['inputUserTypeId'];
  
  
  //Input parametere
  $logg->Ny('Parameter Fornavn: '.$fornavn, 'DEBUG',htmlspecialchars($_SERVER['PHP_SELF']), '');
  $logg->Ny('Parameter Etternav: '.$etternavn, 'DEBUG',htmlspecialchars($_SERVER['PHP_SELF']), '');
  $logg->Ny('Parameter DOB: '.$DOB, 'DEBUG',htmlspecialchars($_SERVER['PHP_SELF']), '');
  $logg->Ny('Parameter kjønn: '.$kjonn, 'DEBUG',htmlspecialchars($_SERVER['PHP_SELF']), '');
  $logg->Ny('Parameter tittel: '.$tittel, 'DEBUG',htmlspecialchars($_SERVER['PHP_SELF']), '');
  $logg->Ny('Parameter brukterType: '.$brukerType);
  $logg->Ny('Parameter tlf: '.$tlf, 'DEBUG',htmlspecialchars($_SERVER['PHP_SELF']), '');
  
  //sjekk om brukernavn finnes fra før
  if($brukernavn != $userinfo[0][9]
  && $user->Exsits($brukernavn)) {
    
    $responseMsg = $html->errorMsg('Brukernavnet opptatt.');
    $logg->Ny('Feilet ved oppdatering av bruker da brukernavn er opptatt. Org brukernavn: '.$userinfo[0][9].' forsøker å oppdatere til '.$brukernavn.'.');
    
  } elseif ($brukernavn //Påkrevde felter
    && $fornavn
    && $etternavn
    && $DOB
    && $kjonn
    && $mail
    && $brukerType
    && $tittel){
      
      $logg->Ny('Alle input felter funnet', 'DEBUG','users/add.php', 'NA');
      
      $validert = FALSE;
      /*
        Validering start!!
      */
      
      /* Validering brukernavn */
      if(!preg_match($brukernavnPattern, $brukernavn)){
        //validering feilet for brukernavn
        $validert = FALSE;
        $responseMsg .= $html->errorMsg('Brukernavn må være minst 2 karakterer langt.');
        $logg->Ny('Ny bruker: Validering av brukernavn feilet.', 'WARNING');
      } else {
        $logg->Ny('Ny bruker: Brukernavn validering var vellykket.');
        $validert = TRUE;
      }
      
      /* Validering fornavn og etternavn */
      if(!preg_match($navnPattern, $fornavn) || !preg_match($navnPattern, $etternavn)){
        //validering feilet for fornavn eller etternavn
        $validert = FALSE;
        $responseMsg .= $html->errorMsg('Navn må være minst 2 karakterer langt og kan ikke innholde tall.');
        $logg->Ny('Ny bruker: Navn validering feilet.', 'WARNING');
      } else {
        $logg->Ny('Ny bruker: Navn validering var vellykket.');
      }
      
      /* Validering epost med PHP funksjon  */
      if (!filter_var($mail, FILTER_VALIDATE_EMAIL) === false) {
        $logg->Ny("email is a valid email address");
      } else {
        $validert = FALSE;
        $responseMsg .= $html->errorMsg('Vennligst angi en korrekt epost adresse.');
        $logg->Ny("email is not a valid email address");
      }
      
      if(!preg_match($inputDatoPattern, $DOB)){
        $validert = FALSE;
        $responseMsg .= $html->errorMsg('Feil dato format i fødselsdag felt.');
        $logg-Ny('Feil dato format i fødselsdags felt.', 'WARNING');
      } else {
        $logg->Ny('Ny bruker:Vellykket validering av dato.');
      }
      
      //Validere brukerType?
      
      /*
        Validering slutt
      */
      if($validert){
        //Alle påkrevde felter er blitt validert, forsøker å legge inn ny bruker
        $logg->Ny('Validering OK. Forsøker å oppdatere bruker.');
        
        $result = $user->UpdateUser($id, $brukernavn, $fornavn, $etternavn, $DOB, $kjonn, $mail, $tlf, $tittel, $brukerType, $logg);     
        
        $userinfo = $user->GetUser($id, $logg);
        
        if($result == 1){
          $responseMsg .= $html->successMsg("Brukeren ble oppdatert.");
        } else {
          $responseMsg .= $html->errorMsg("Noe feilet, klarte ikke å opprette bruker!");
        }
      }
    }  
  } 

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
 
  <?php 
  //Viser skjema dersom det både er en GET request med querstring id
  if($_GET && $_GET['id']){ ?>
  
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
               
               <!-- ID -->
               <input type="hidden" disabled class="form-control" id="inputId" name="inputId" value="<?php echo $id ?>">
               
               <!-- Brukernavn -->
                <div class="form-group">
                  <label for="inputBrukernavn" class="col-md-2 control-label">Brukernavn</label>
                  <div class="col-md-10">
                    <input type="text" class="form-control" id="inputBrukernavn" name="inputBrukernavn"
                    pattern="<?php echo str_replace('/', '',$brukernavnPattern); ?>" 
                    value="<?php echo $userinfo[0][9]; ?>">
                  </div>
                </div>
               
               <!-- Fornav -->
                <div class="form-group">
                  <label for="inputFornavn" class="col-md-2 control-label">Fornavn</label>
                  <div class="col-md-10">
                    <input type="text" class="form-control" id="inputFornavn" name="inputFornavn"
                    pattern="<?php echo str_replace('/', '',$navnPattern); ?>" 
                    value="<?php echo $userinfo[0][1]; ?>">
                  </div>
                </div>
                
                <!-- Etternav -->
                <div class="form-group">
                  <label for="inputEtternavn" class="col-md-2 control-label">Etternavn</label>
                  <div class="col-md-10">
                    <input type="text" class="form-control" id="inputEtternavn" name="inputEtternavn"
                    pattern="<?php echo str_replace('/', '',$navnPattern); ?>" 
                    value="<?php echo $userinfo[0][2]; ?>">
                  </div>
                </div>
               
                <!-- Bruker type -->
                <div class="form-group">
                  <label for="inputUserTypeId" class="col-md-2 control-label">Type</label>
                  <div class="col-md-10">
                    
                    <?php
                      $textBrukerType = '';
                      $valueBrukerType = 0;
                      if(@!$userinfo[0][7]){
                        $textBrukerType = 'Velg brukertype';
                      } else {
                          $last = count($types) - 1;
                         foreach ($types as $i => $row)
                          {
                              $isFirst = ($i == 0);
                              $isLast = ($i == $last);
                              if($userinfo[0][7] == $row[1]){
                                //konverterer brukertype ID til brukertype navn
                                $valueBrukerType = $row[0];
                              }                  
                          }
                      }
                      
                      echo $html->GenerateSearchSelectionbox($types, 'userTypes', 'inputUserTypeId',@$userinfo[0][7], '','required', $valueBrukerType); 
                      ?>
                    
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
                    <input type="text" class="form-control" id="datepicker" name="inputDato"
                    pattern="<?php echo str_replace('/', '',$inputDatoPattern); ?>" 
                    value="<?php echo $userinfo[0][5]; ?>" >
                  </div>
                 </div>
                
                <!-- Kjønn -->
                  <label class="col-md-1 control-label">Kjønn:</label>
                  <div class="col-md-2">
                    <select class="form-control select2 select2-hidden-accessible" name="inputKjonn" 
                      form="nybruker" style="width: 100%;" tabindex="-1" aria-hidden="true">
                  
                      <option <?php if($userinfo[0][8] == 'Mann') {echo 'selected'; } ?>>Mann</option>
                      <option <?php if($userinfo[0][8] == 'Kvinne') {echo 'selected'; } ?>>Kvinne</option>
                      
                    </select>
                    <span class="dropdown-wrapper" aria-hidden="true"></span>
                  </div>
                  
                  
                <!-- Tittel -->
                <label for="inputTittel" class="col-md-1 control-label">Tittel</label>
                <div class="col-md-2">
                    
                    <select class="form-control select2 select2-hidden-accessible" name="inputTittel"  form="nybruker" style="width: 100%;" tabindex="-1" aria-hidden="true">
                        <?php print($t->TittelSelectOptions($userinfo[0][6])); ?>
                    </select>  
                  </div>
                </div>
                
               
               <!-- Email -->
                <div class="form-group">
                  <label for="inputEmail" class="col-md-2 control-label">Email</label>
                  <div class="col-md-10">
                    <input type="email" class="form-control" id="inputEmail" name="inputEmail" 
                    value="<?php echo $userinfo[0][3]; ?>">
                  </div>
                </div>
                
              
                <!-- TLF -->
                <div class="form-group">
                  <label for="inputTlf" class="col-md-2 control-label">Tlf</label>
                  <div class="col-md-10">
                    <input type="text" class="form-control" id="inputTlf" name="inputTlf" 
                    value="<?php echo $userinfo[0][4]; ?>">
                  </div>
                </div>
                
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <div class="btn btn-default" onclick="location.href='./User/users.php';">Tilbake</div>
                
                <div class="btn btn-default" onclick="location.href='./User/users.php';">Nullstill</div>
                
                <div class="btn btn-default" onclick="location.href='./User/changepassword.php?id=<?php echo $id; ?>';">Bytt passord</div>
                
                <button type="submit" class="btn btn-info pull-right">Oppdater</button>
              </div>
              <!-- /.box-footer -->
            </form>
          </div>
          <!-- /.box -->
          </div>
      <!-- /.col -->
    </div>

  
<?php  
  } else {
    //lister en select box med brukere 
?>
<!-- Your Page Content Here -->
<form class="form-horizontal" method="GET" id="nybruker">
    <div class="row">
      <div class="col-md-12">
        
         <div class="box box-info">
            <div class="box-body">

               <div class="form-group col-md-6">
                  <select class="form-control select2 select2-hidden-accessible" name="id" style="width: 100%;" tabindex="-1" aria-hidden="true">
              
                      <?php print($user->UsersSelectOptions()); ?>
                
                  </select>
              </div>
              
              <div class="form-group col-md-2">
                <button type="submit" class="btn btn-info pull-right">Hent</button>
              </div>
          
      </div>
    </div>
  </form>


<?php } ?>
  
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<?php

include('./../html/admin-slutt.html');
include('./../html/script.html');
?>
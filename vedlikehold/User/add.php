<?php
$title = "FLY - Admin";
include('./../html/start.php');
include('./../html/header.html');
include('./../html/admin-start.html');
include('./../php/Tittel.php');
include('./../php/UserType.php');

//Felles objekter
$t = new Tittel();
$ut = new UserType();
$types = $ut->GetUserTypes($logg);
$responseMsg = "";
//RegEx pattern
$brukernavnPattern = "/^[A-Za-z0-9]{2,}$/";
$navnPattern = "/^[A-Za-z]{2,}$/";
$passordPattern = "/^[A-Za-z0-9#$@!%&*?]{3,}$/";
$inputDatoPattern = "/(^(((0[1-9]|1[0-9]|2[0-8])[\/](0[1-9]|1[012]))|((29|30|31)[\/](0[13578]|1[02]))|((29|30)[\/](0[4,6,9]|11)))[\/](19|[2-9][0-9])\d\d$)|(^29[\/]02[\/](19|[2-9][0-9])(00|04|08|12|16|20|24|28|32|36|40|44|48|52|56|60|64|68|72|76|80|84|88|92|96)$)
/";


if($_POST){
    $logg->Ny('POST av ny bruker skjema', 'DEBUG',htmlspecialchars($_SERVER['PHP_SELF']), 'NA');
    
    //Input parametere
    $brukernavn = $_POST["inputBrukernavn"];
    $fornavn = $_POST["inputFornavn"];
    $etternavn = $_POST["inputEtternavn"];
    $DOB = $_POST["inputDato"];
    $kjonn = $_POST["inputKjonn"];
    $mail = $_POST["inputEmail"];
    $pass1 = $_POST["inputPassword3"];
    $pass2 = $_POST["inputPassword4"];
    $tlf = $_POST["inputTlf"];
    $brukerType = $_POST['inputUserTypeId'];
    $tittel = $_POST["inputTittel"];
    
    //Logging av input parametere
    $logg->Ny('Parameter Fornavn: '.$fornavn, 'DEBUG',htmlspecialchars($_SERVER['PHP_SELF']), '');
    $logg->Ny('Parameter Etternav: '.$etternavn, 'DEBUG',htmlspecialchars($_SERVER['PHP_SELF']), '');
    $logg->Ny('Parameter DOB: '.$DOB, 'DEBUG',htmlspecialchars($_SERVER['PHP_SELF']), '');
    $logg->Ny('Parameter kjønn: '.$kjonn, 'DEBUG',htmlspecialchars($_SERVER['PHP_SELF']), '');
    $logg->Ny('Parameter tittel: '.$tittel, 'DEBUG',htmlspecialchars($_SERVER['PHP_SELF']), '');
    $logg->Ny($pass1.' - '.$pass2, 'DEBUG',htmlspecialchars($_SERVER['PHP_SELF']), '');
    $logg->Ny('Parameter brukterType: '.$brukerType);
    $logg->Ny('Parameter tlf: '.$tlf, 'DEBUG',htmlspecialchars($_SERVER['PHP_SELF']), '');
    
    //Sjekk input parametere
   if($user->Exsits($brukernavn)) {
        $logg->Ny('Brukernavnet '.$brukernavn.' er opptatt.','ERROR');
        $responseMsg = $html->errorMsg('Brukernavnet er allerede i bruk.');
        // $logg->Ny('POST brukernavn= '.$brukernavn);
        $brukernavn = NULL;
    }
    elseif ($brukernavn //Påkrevde felter
        && $fornavn
        && $etternavn
        && $mail
        && $pass1
        && $pass2
        && $brukerType
        ){
        
        $logg->Ny('Alle input felter funnet', 'DEBUG','users/add.php', 'NA');
        
        $validert = FALSE;
        
        //Validering start
        if(!preg_match($brukernavnPattern, $brukernavn)){
          //validering feilet for brukernavn
          $validert = FALSE;
          $responseMsg .= $html->errorMsg('Brukernavn må være minst 2 karakterer langt.');
          $logg->Ny('Ny bruker: Validering av brukernavn feilet.', 'WARNING');
        } else {
          $logg->Ny('Ny bruker: Brukernavn validering var vellykket.');
          $validert = TRUE;
        }
        
        if(!preg_match($navnPattern, $fornavn) || !preg_match($navnPattern, $etternavn)){
          //validering feilet for fornavn eller etternavn
          $validert = FALSE;
          $responseMsg .= $html->errorMsg('Navn må være minst 2 karakterer langt og kan ikke innholde tall.');
          $logg->Ny('Ny bruker: Navn validering feilet.', 'WARNING');
        } else {
          $logg->Ny('Ny bruker: Navn validering var vellykket.');
        }
        
        if($pass1 != $pass2){
          $validert = FALSE;
          $responseMsg .= $html->errorMsg('Passordene må være like');
          $logg->Ny('Passordene var ikke like', 'WARNING');
        } else {
          $logg->Ny('Passordene var like.');
        }
        
        if(!preg_match($passordPattern, $pass1)){
          //validering av passord feilet
          $validert = FALSE;
          $responseMsg .= $html->errorMsg('Passord må være minst 3 karakterer langt.');
          $logg->Ny('Ny bruker: Passord validering feilet.', 'WARNING');
        }  else {
          $logg->Ny('Ny bruker: Passord validering var vellykket');
        }
        
        if (!filter_var($mail, FILTER_VALIDATE_EMAIL) === false) {
          $logg->Ny("$email is a valid email address");
        } else {
          $validert = FALSE;
          $responseMsg .= $html->errorMsg('Vennligst angi en korrekt epost adresse.');
          $logg->Ny("$email is not a valid email address");
        }

        //Validere brukerType?
        
        if($validert){
          //Alle påkrevde felter er blitt validert, forsøker å legge inn ny bruker
          
          $result = $user->NewUser($brukernavn, $fornavn, $etternavn, $DOB, $kjonn, $mail, $pass1, $tlf, $tittel, $brukerType, $logg);
          $logg->Ny('Resultat fra NewUser funksjon. '.$result);
          if($result == 1){
              $responseMsg .= $html->successMsg("Ny bruker ble opprettet.");
              $logg->Ny('Ny bruker ble opprettet!');
              
              $brukernavn = "";
              $mail = "";
              $DOB = "";
              $fornavn = "";
              $etternavn = "";
              $kjonn = "";
              $tlf = "";
              $brukerType = "";
              
          }
          else {
              $responseMsg .= $html->errorMsg("Noe feilet, klarte ikke å opprette bruker!");
              $logg->Ny('Klarte ikke å opprette ny bruker, noe feilet ved insert av ny data.', 'ERROR');
          }  
        } else {
          $logg->Ny('Validering av ny bruker feilet, SQL blir ikke kjørt.', 'ERROR');
        }
        
    } else {
      $responseMsg .= $html->errorMsg('Mangler påkrevde felter.');
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
              <?php echo $responseMsg ?>
              <h3 class="box-title">Bruker</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" method="POST" id="nybruker">
              <div class="box-body">
               
               <!-- Brukernavn -->
                <div class="form-group">
                  <label for="inputBrukernavn" class="col-md-2 control-label">Brukernavn</label>
                  <div class="col-md-10">
                    <input type="text" class="form-control" id="inputBrukernavn" name="inputBrukernavn" pattern="<?php echo str_replace('/', '',$brukernavnPattern); ?>" required value="<?php echo @$brukernavn ?>">
                  </div>
                </div>
              
               <!-- Fornav -->
                <div class="form-group">
                  <label for="inputFornavn" class="col-md-2 control-label">Fornavn</label>
                  <div class="col-md-10">
                    <input type="text" class="form-control" id="inputFornavn" name="inputFornavn" pattern="<?php echo str_replace('/', '',$navnPattern); ?>" required placeholder="Ola" value="<?php echo @$fornavn ?>">
                  </div>
                </div>
                
                <!-- Etternavn -->
                <div class="form-group">
                  <label for="inputEtternavn" class="col-md-2 control-label">Etternavn</label>
                  <div class="col-md-10">
                    <input type="text" class="form-control" id="inputEtternavn" name="inputEtternavn" pattern="<?php echo str_replace('/', '',$navnPattern); ?>" required placeholder="Norman" value="<?php echo @$etternavn ?>">
                  </div>
                </div>
                
               <!-- Email -->
                <div class="form-group">
                  <label for="inputEmail" class="col-md-2 control-label">Email</label>
                  <div class="col-md-10">
                    <input type="email" class="form-control" id="inputEmail" name="inputEmail" placeholder="" required value="<?php echo @$mail ?>">
                  </div>
                </div>
                
             <!-- Bruker type -->
                <div class="form-group">
                  <label for="inputUserTypeId" class="col-md-2 control-label">Type</label>
                  <div class="col-md-10">
                    
                    <?php
                      if(@!$brukerType){
                        $textBrukerType = 'Velg brukertype';
                      } else {
                          $last = count($types) - 1;
                         foreach ($types as $i => $row)
                          {
                              $isFirst = ($i == 0);
                              $isLast = ($i == $last);
                              if($brukerType == $row[0]){
                                //konverterer brukertype ID til brukertype navn
                                $textBrukerType = $row[1];
                              }                  
                          }
                      }
                      echo $html->GenerateSearchSelectionbox($types, 'userTypes', 'inputUserTypeId',$textBrukerType, '','required',@$brukerType); 
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
                    <input type="text" class="form-control" id="datepicker" name="inputDato" pattern="<?php echo str_replace('/', '',$inputDatoPattern); ?>" value="<?php echo @$DOB ?>">
                  </div>
                 </div>
                
                    <!-- Kjønn -->
                    <label class="col-md-1 control-label">Kjønn:</label>
                    <div class="col-md-2">
                      <select class="form-control select2 select2-hidden-accessible" name="inputKjonn" 
                        form="nybruker" style="width: 100%;" tabindex="-1" aria-hidden="true">
                        <option <?php if(@$kjonn == 'Mann') echo 'selected'; ?>>Mann</option>
                        <option <?php if(@$kjonn == 'Kvinne') echo 'selected'; ?>>Kvinne</option>
                      </select>
                      <span class="dropdown-wrapper" aria-hidden="true"></span>
                    </div>
                 
                  <!-- Tittel -->
                  <label for="inputTittel" class="col-md-1 control-label">Tittel</label>
                  <div class="col-md-2">
                      <select class="form-control select2 select2-hidden-accessible" name="inputTittel"  form="nybruker" style="width: 100%;" tabindex="-1" aria-hidden="true">
                          <?php print($t->TittelSelectOptions(@$tittel));?>
                      </select>
                  </div>
                </div>
                
                <!-- TLF -->
                <div class="form-group">
                  <label for="inputTlf" class="col-md-2 control-label">Tlf</label>
                  <div class="col-md-10">
                    <input type="text" class="form-control" id="inputTlf" name="inputTlf" placeholder="+47 999 99 999" value="<?php echo @$tlf ?>">
                  </div>
                </div>
                
                <!-- Passord -->
                <div class="form-group">
                  <label for="inputPassword3" class="col-md-2 control-label">Passord</label>
                  <div class="col-md-10">
                    <input type="password" class="form-control" id="inputPassword3" name="inputPassword3" required >
                  </div>
                </div>
                
                <!-- Passord 2 -->
                <div class="form-group">
                  <label for="inputPassword4" class="col-md-2 control-label">Gjenta passord</label>
                  <div class="col-md-10">
                    <input type="password" class="form-control" id="inputPassword4" name="inputPassword4" required >
                  </div>
                </div>
              </div>
              
              <!-- /.box-body -->
              <div class="box-footer">
                <div type="submit" class="btn btn-default" onclick="location.href='./';">Tilbake</div>
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
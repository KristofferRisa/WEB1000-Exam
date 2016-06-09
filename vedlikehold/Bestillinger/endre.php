<?php  
$title = "FLY - Admin";

//Includes
include('./../html/start.php');
include('./../html/header.html');
include('./../html/admin-start.html');
include('../php/Bestilling.php');

$bestillinger = new Bestilling();

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
  $bestilling = $bestillinger->GetBestilling($id, $logg);
  
  
}

if($_POST){
  // Forsøker å oppdater bruker
  @$fornavn = $_POST["fornavn"];
  @$etternavn = $_POST["etternavn"];
  @$email = $_POST["email"];
  @$tlf = $_POST["tlf"];
  
  
  if ($fornavn // Påkrevde felter
    && $etternavn
    && $email
    && $tlf){
      $navnPattern = "/^[A-Za-z]{2,}$/";
      $logg->Ny('Alle input felter funnet for oppdatering av bestilling');
      
      $validert = TRUE;
      /*
        Validering start!!
      */
  
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
      if (!filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
        $logg->Ny("email is a valid email address");
      } else {
        $validert = FALSE;
        $responseMsg .= $html->errorMsg('Vennligst angi en korrekt epost adresse.');
        $logg->Ny("Epost adresse validerer ikke.$_COOKIE");
      }
      
      /* Validering av TLF, minimum 4 tegn  */
      if (strlen($tlf) < 4  && !preg_match('/^[0-9]{4,}$/',$tlf)) {
        $validert = FALSE;
        $responseMsg .= $html->errorMsg('TLF må være minimum 4 siffer.');
      }
      
      /*
        Validering slutt
      */
      if($validert){
        //Alle påkrevde felter er blitt validert, forsøker å legge inn ny bruker
        $logg->Ny('Validering OK. Forsøker å oppdatere bestilling informasjon.');
        
        $result = $bestillinger->UpdateBestilling ($id, $fornavn,$etternavn, $email, $tlf,$logg);
                                      
        $bestilling = $bestillinger->GetBestilling($id, $logg);
        
        if($result == 1){
          $responseMsg .= $html->successMsg("Brukeren ble oppdatert.");
        } else {
          $responseMsg .= $html->errorMsg("Noe feilet, klarte ikke å opprette bruker eller så var ingen av feltene endret!");
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
      <li>Billetter og bestillinger</li>
      <!-- Denne brukes av javascript for å sette riktig link aktiv i menyen (husk ID i meny må være lik denne) -->
      <li class="active">Bestilling</li> 
    </ol>
  </section>
 <!-- Main content -->
  <section class="content">
 
  <?php if($_GET && $_GET['id']){  //Viser skjema dersom det både er en GET request med querstring id?>
  
    <!-- SKJEMA FOR Å ENDRE BILLETT -->
    <div class="row">
      <div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box box-info">
            <div class="box-header with-border">
              <?php echo $responseMsg ?>
              <h3 class="box-title">Bruk feltene under for å oppdatere informasjonen på billetten.</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" method="POST" id="billett">
              <div class="box-body">
               
               <!-- ID -->
               <input type="hidden" disabled class="form-control" id="inputId" name="inputId" required value="<?php echo $id ?>">
               <!-- REF NO -->
                <div class="form-group">
                  <label for="refno" class="col-md-2 control-label">Ref no</label>
                  <div class="col-md-2">
                    <input type="text" class="form-control" disabled id="refno" name="refno" required value="<?php echo $bestilling[0][2]; ?>">
                  </div>
                  <label for="refno" class="col-md-2 control-label">Antall reisende</label>
                  <div class="col-md-2">
                    <input type="text" class="form-control" disabled name="antall" required value="<?php echo $bestilling[0][9] + $bestilling[0][10] + $bestilling[0][11] ; ?>">
                  </div>
                </div>
               <!-- DETALJER-->
                <div class="form-group">
                  <label for="bestillingsDato" class="col-md-2 control-label">Bestillings dato</label>
                  <div class="col-md-2">
                    <input type="text" class="form-control" disabled name="bestillingsDato" required
                    value="<?php echo $bestilling[0][1]; ?>">
                  </div>
                  <label for="reiseDato" class="col-md-2 control-label">Reise dato</label>
                  <div class="col-md-2">
                    <input type="text" class="form-control" disabled name="reiseDato" required
                    value="<?php echo $bestilling[0][3]; ?>">
                  </div>
                  <label for="returDato" class="col-md-2 control-label">Retur dato</label>
                  <div class="col-md-2">
                    <input type="text" class="form-control" disabled name="returDato" required
                    value="<?php echo $bestilling[0][4]; ?>">
                  </div>
                </div>
               
               <!-- Fornav -->
                <div class="form-group">
                  <label for="fornavn" class="col-md-2 control-label">Fornavn</label>
                  <div class="col-md-10">
                    <input type="text" class="form-control" id="fornavn" name="fornavn" required
                    
                    value="<?php echo $bestilling[0][5]; ?>">
                  </div>
                </div>
                
                <!-- Etternav -->
                <div class="form-group">
                  <label for="etternavn" class="col-md-2 control-label">Etternavn</label>
                  <div class="col-md-10">
                    <input type="text" class="form-control" id="etternavn" name="etternavn" required
                    value="<?php echo $bestilling[0][6]; ?>">
                  </div>
                </div>
           
               <!-- Email -->
                <div class="form-group">
                  <label for="email" class="col-md-2 control-label">Email</label>
                  <div class="col-md-10">
                    <input type="email" class="form-control" id="email" name="email" required
                    value="<?php echo $bestilling[0][7]; ?>">
                  </div>
                </div>
                
              
                <!-- TLF -->
                <div class="form-group">
                  <label for="tlf" class="col-md-2 control-label">Tlf</label>
                  <div class="col-md-10">
                    <input type="text" class="form-control" id="tlf" name="tlf" required pattern="^[0-9]{4,}$"
                    value="<?php echo $bestilling[0][8]; ?>">
                  </div>
                </div>
                
                
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <div class="btn btn-default" onclick="location.href='./alle.php';">Tilbake</div>
                <a  href="./Bestillinger/slett.php?id=<?php echo $id; ?>" class="btn btn-danger" onclick="return confirm('Er du sikker du ønsker å slette denne bestillingen?');">Slett</a>
                <button type="submit" class="btn btn-info pull-right">Oppdater</button>
              </div>
              <!-- /.box-footer -->
            </form>
          </div>
          <!-- /.box -->
          </div>
      <!-- /.col -->
    </div>

  
<?php  } else { //viser soek felt for ref no 
?>
<!-- SKJEMA FOR Å SØKE ETTER BESTILLINGER -->
<form class="form-horizontal" method="GET" id="nybruker">
    <div class="row">
      <div class="col-md-12">
                
         <div class="box box-info">
            <div class="box-body">

              
             <div class="form-group">
                  <label for="id" class="col-md-2 control-label">Søk etter billetter</label>
                  <div class="col-md-10">
                    <input type="text" class="form-control" id="sok" name="id" required placeholder="REF NO" >
                  </div>
                </div>
              
          
        </div>
       <div class="box-footer">
          <div type="submit" class="btn btn-default" onclick="location.href='./';">Tilbake</div>
          <button type="submit" class="btn btn-info pull-right">Søk</button>
        </div>
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
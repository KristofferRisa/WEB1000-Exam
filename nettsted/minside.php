<?php
$title = 'Bjarum Airlines';
include('./html/start.php');
include('./html/header.html');
include('./html/nav.html');

$bestillinger = new Bestilling();
$billetter = new Billett();

$brukernavnPattern = "/^[A-Za-z0-9]{2,}$/";
$navnPattern = "/^[A-Za-z]{2,}$/";


@$innloggetBruker=$_SESSION["brukernavn"];
        
 if (!$innloggetBruker)
{
    //CHANGE ON DEPLOYMENT
    // header('Location: '.$_SERVER['SERVERNAME'].'/web-is-gr13w/dev/vedlikehold/login.php');
    header('Location: ./login.php');
    exit;
}
if($_GET['id']){
  
  //returnerer en array med bruker info
  //brukes av både GET OG POST    
  $id = $_GET['id'];
  $bestilling = $bestillinger->GetBestilling($id, $logg);
  $billetterData = $billetter->GetBillettByBestillingId($bestilling[0][0],$logg);
  
}

print_r($bestilling[0]);
echo '<br>';
print_r($billetterData);

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
<div class="container">


 <?php if($_GET && $_GET['id']){  //Viser skjema dersom det både er en GET request med querstring id?>
  
    <!-- SKJEMA FOR Å ENDRE bestilling -->
    <div class="row">
      
      <form class="form-horizontal" method="POST" id="bestilling">
          <!-- Horizontal Form -->
          <div class="panel panel-default">
            <div class="panel-heading">
              <?php echo @$responseMsg ?>
              <h3 class="panel-title">Bruk feltene under for å oppdatere informasjonen på bestillingen.</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            
              <div class="panel-body">
               
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
                    <input type="text" class="form-control" disabled name="antall" required value="<?php echo $bestilling[0][9] + $bestilling[0][10] ; ?>">
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
                
                <h3>Billetter:</h3>
                <div class="list-group">
                    <?php 
                    if(count($billetterData) >0 ){
                        foreach ($billetterData as $i => $row) { ?>
                    <a href="#" class="list-group-item">
                        <?php echo $row[2]; ?>
                    </a>
                    <?php } ?>
                    <?php  } else { ?>
                        <div class="text-warning">Ingen billetter funnet</div>
                    <?php } ?> 
                </div>
              </div>
              <!-- /.box-body -->
              <div class="panel-footer">
                <div class="btn btn-default" onclick="location.href='./alle.php';">Tilbake</div>
                <a  href="./Bestillinger/slett.php?id=<?php echo $id; ?>" class="btn btn-danger" onclick="return confirm('Er du sikker du ønsker å slette denne bestillingen?');">Slett</a>
                <button type="submit" class="btn btn-info pull-right">Oppdater</button>
              </div>
              <!-- /.box-footer -->
            </div>
          </form>
          <!-- /.box -->
          
      <!-- /.col -->
    </div>

<?php  } else { ?>


<div class="container">
    <div class="row top-buffer">
        <h1 class="page-header">Velkommen tilbake <?php echo $userInfo[0][1]; echo ' ';?> <?php echo $userInfo[0][2]; ?></h1>
    </div>
    
<form class="form-horizontal" method="GET" id="nybruker">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">Søk bestillinger</div>
            <div class="panel-body">
                
                <div class="row">    
                    <label for="id" class="col-md-2 control-label">Søk etter billetter</label>
                    <div class="col-md-5">
                        <input type="text" class="form-control" id="sok" name="id" required placeholder="REF NO" >
                    </div>
                </div>

            </div>
            <div class="panel-footer">
                <div type="submit" class="btn btn-default" onclick="location.href='./';">Tilbake</div>
                <button type="submit" class="btn btn-info pull-right">Søk</button>
            </div>
        </div>
    </div>
</form>


    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">Mine bestillinger</div>
            <div class="panel-body">
                <div class="list-group">
                    <a href="#" class="list-group-item">
                        Cras justo odio
                    </a>
                    <a href="#" class="list-group-item">Dapibus ac facilisis in</a>
                    <a href="#" class="list-group-item">Morbi leo risus</a>
                    <a href="#" class="list-group-item">Porta ac consectetur ac</a>
                    <a href="#" class="list-group-item">Vestibulum at eros</a>
                </div>
            </div>
            <div class="panel-footer">
                
            </div>
        </div>
    </div>

</div>


<?php } ?>

<?php include ("./html/footer.html"); ?>

</body>
</html>
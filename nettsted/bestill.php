<?php
$title = 'Bjarum Airlines';
include('./html/start.php');
include('./html/header.html');
include('./html/nav.html');

@$innloggetBruker=$_SESSION["brukernavn"];
        
if (!$innloggetBruker && !@$_GET['innlogget'] && !$_POST)
{ //Viser skjema for logg inn / registre eller fortsett uten registrering
?>
    <div class="container">
        
        
        <!--Logg inn-->
        <div class="row top-buffer">
            <div class="col-md-7 col-md-offset-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Fortsett bestilling som innlogget bruker</h3>
                    </div>
                    <div class="panel-body">
                        Dersom du allerede har bruker kan du fortsette bestillingen etter du har logget inn.
                    </div>
                    <div class="panel-footer">
                        <a class="btn btn-primary" href="./login.php?returnUrl=<?php echo $_SERVER['REQUEST_URI']; ?>">Logg inn</a>
                    </div>
                </div>
            </div>
            
        </div>
            
        <!--Registre ny bruker -->
        <div class="row top-buffer">
            <div class="col-md-7 col-md-offset-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Registre ny bruker</h3>
                    </div>
                    <div class="panel-body">
                        Få alle fordelene med å være innlogget, skaff deg en konto hos oss i dag!
                    </div>
                    <div class="panel-footer">
                        <a class="btn btn-primary" href="./registrer.php?returnUrl=<?php echo $_SERVER['REQUEST_URI']; ?>">Registre ny bruker</a>
                    </div>
                </div>
            </div>
        </div>
            
       <!--Forsett uten å logge inn-->
       <div class="row top-buffer">
            <div class="col-md-7 col-md-offset-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Fortsett uten konto</h3>
                    </div>
                    <div class="panel-body">
                        Trykk på knappen under for å fullføre bestillingen uten konto. 
                    </div>
                    <div class="panel-footer">
                        <a href="<?php echo $_SERVER['REQUEST_URI'].'&innlogget=false'; ?>" class="btn btn-primary" onclick="">Fortsett</a>
                    </div>
                </div>
            </div>
        </div>
            
    
    </div>
    
        
  
<?php }


//?reise=2&retur=&antall=1
if($_GET 
    && ($innloggetBruker || @$_GET['innlogget'] == 'false')
    && $_GET['reise']
    && $_GET['antall']
    ){
        $fra = $saner->data($_GET["reise"]);
        @$til = $saner->data($_GET["retur"]);
        $antallReisende = $saner->data($_GET["antall"]);
        
        
        //Avgang
        $utreiseInfo = $reiseInfo = $avganger->GetAvgang($fra, $logg);
        // print_r($utreiseInfo);
        //  echo '<br>';
        // print_r($userInfo);
        //FRA
        $utreiseFra = $dest->GetDestinasjon($reiseInfo[0][1],$logg);
        // $utreise($utreiseFra);
        // echo '<br>';
        //TIL
        $utreiseTil = $dest->GetDestinasjon($reiseInfo[0][2],$logg);
        // $utreise($utreiseTil);
        // echo '<br>';
        if(@$_GET['retur'])
        {
            
            //HENTER HJEMREISE INFO
            $hjemreiseInfo = $avganger->GetAvgang($til, $logg);
            $hjemreiseFra = $dest->GetDestinasjon($hjemreiseInfo[0][1],$logg);
            $hjemreiseTil = $dest->GetDestinasjon($hjemreiseInfo[0][2],$logg); 
        }
        
        
        //Vis Skjema for bestilling
        if(!$_POST){
        ?>
     <div class="container">
       <form method="POST" class="form-horizontal">
           
            <div class="container">
                <div class="row top-buffer">
                    <h1>Utreise</h1>
                    <hr>
                    <!--UTREISE FLY DETALJER-->
                    <div class="form-group">
                        <label for="flyplassID" class="col-xs-2 control-label billett">Fra:</label>
                        <div class="col-xs-4">
                            <input type="hidden" disabled name="fra"  value="<?php echo $fra; ?>">
                            <div class=""><?php echo  $utreiseFra[0][1]; ?></div>
                        </div>
                        <div class="col-xs-4">
                            <input type="hidden" disabled name="til"  value="<?php echo $til; ?>">
                            <label>til: </label>
                            <?php echo  $utreiseTil[0][1]; ?>
                        </div>
                    </div>
                </div>
                
                <!--UTREISE DATO DETALJER-->
                <div class="row">
                   <div class="form-group">
                        <label for="flyplassID" class="col-xs-2 control-label billett">Dato:</label>
                        <div class="col-xs-4">
                            <input type="hidden" disabled name="dato"  value="<?php echo $utreiseInfo[0][3]; ?>">
                            <?php echo  $utreiseInfo[0][3]; ?>
                        </div>
                        <div class="col-xs-6">
                            <label>kl:</label>
                            <?php echo  $utreiseInfo[0][5]; ?> (reisetid: <?php echo  $utreiseInfo[0][6]; ?>)
                        </div>
                        
                    </div> 
                </div>

                <!--UTREISE PRIS-->
                <div class="row">
                   <div class="form-group">
                        <label for="flyplassID" class="col-xs-2 control-label billett">Pris:</label>
                        <div class="col-xs-4">
                            <?php echo  $utreiseInfo[0][7]*$antallReisende; ?>
                        </div>
                    </div> 
                </div>
                
            <?php if(@$_GET['retur']) { ?>
            
                
                <div class="row top-buffer">
                    <h1>Hjemreise</h1>
                    <hr>
                    
                    <!--HJEMREISE INFO -->
                    <div class="form-group">
                        <label for="flyplassID" class="col-xs-2 control-label billett">Fra:</label>
                        <div class="col-xs-4">
                            <input type="hidden" disabled name="returfra"  value="<?php echo $fra; ?>">
                            <?php echo  $hjemreiseFra[0][1]; ?>
                        </div>
                        <div class="col-xs-4">
                            <input type="hidden" disabled name="returtil"  value="<?php echo $til; ?>">
                            <label>til: </label>
                            <div class=""><?php echo  $hjemreiseTil[0][1]; ?></div>
                        </div>
                    </div>
                    
                    
                    <!--HJEMREISE DATO DETALJER-->
                    <div class="row">
                    <div class="form-group">
                            <label for="flyplassID" class="col-xs-2 control-label billett">Dato:</label>
                            <div class="col-xs-4">
                                <input type="hidden" disabled name="returdato"  value="<?php echo $hjemreiseInfo[0][3]; ?>">
                                <?php echo  $hjemreiseInfo[0][3]; ?>
                            </div>
                            <div class="col-xs-6">
                                <label>kl:</label>
                                <?php echo  $hjemreiseInfo[0][5]; ?> (reisetid: <?php echo  $hjemreiseInfo[0][6]; ?>)
                            </div>
                            
                        </div> 
                    </div>

                    <!--HJEMRISER PRIS-->
                    <div class="row">
                    <div class="form-group">
                            <label for="flyplassID" class="col-xs-2 control-label billett">Pris:</label>
                            <div class="col-xs-4">
                                <?php echo  $hjemreiseInfo[0][7]*$antallReisende; ?>
                            </div>
                        </div> 
                    </div>
                    
                   
                </div>
                
             <?php } ?>
                
                
                <?php 
                if(!@$innloggetBruker){ ?>
                    <div class="row top-buffer">
                        <h2>Bestiller informasjon</h2>
                        
                        <div class="form-group">
                            <label for="flyplassID" class="col-sm-2 control-label">Fornavn</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="bestillerFornavn" placeholder="fornavn" requried>
                            </div>
                        </div>
                         
                    </div>
                    <div class="row">
                    <div class="form-group">
                            <label for="flyplassID" class="col-sm-2 control-label">Etternavn</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="bestillerEtternavn" placeholder="etternavn" required>
                            </div>
                        </div> 
                    </div>
                    
                    
                    <div class="row">
                    <div class="form-group">
                            <label for="flyplassID" class="col-sm-2 control-label">epost</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="bestillerEpost" placeholder="epost" required>
                            </div>
                        </div> 
                    </div>
                    
                    
                    <div class="row">
                    <div class="form-group">
                            <label for="flyplassID" class="col-sm-2 control-label">Tlf</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="bestillerTlf" placeholder="TLF" required>
                            </div>
                        </div> 
                    </div>
               <?php  } ?>
                
        <?php for ($i=1; $i <= $antallReisende; $i++) { //Start LOOP skjema ?>
    
                <div class="row">
                    <h2>Kunde info passasjer <?php echo $i; ?> </h2>  
                    <hr>  
                   <div class="form-group">
                        <label for="flyplassID" class="col-sm-2 control-label">Fornavn</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="kundeFornavn<?php echo $i; ?>" placeholder="fornavn" required pattern="^[A-Za-z]{2,}">
                        </div>
                    </div> 
                </div>
                
                <div class="row">
                   <div class="form-group">
                        <label for="flyplassID" class="col-sm-2 control-label">Etternavn</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="kundeEtternavn<?php echo $i; ?>" placeholder="etternavn" required pattern="^[A-Za-z]{2,}">
                        </div>
                    </div> 
                </div>
                
                <div class="row">
                   <div class="form-group">
                        <label for="flyplassID" class="col-sm-2 control-label">Kjønn</label>
                        <div class="col-sm-6">
                            <select class="form-control select2 select2-hidden-accessible" name="kjonn<?php echo $i; ?>" style="width: 100%;" tabindex="-1" aria-hidden="true" required>
                                <option value="Mann">Mann</option>
                                <option value="Kvinne">Kvinne</option>
                            </select>
                        </div>
                    </div> 
                </div>
                
                <!--Antall bagasje-->
                <div class="row">
                   <div class="form-group">
                        <label for="flyplassID" class="col-sm-2 control-label">Antall bagasje</label>
                        <div class="col-sm-6">
                            <select class="form-control select2 select2-hidden-accessible" name="bagasje<?php echo $i; ?>" style="width: 100%;" tabindex="-1" aria-hidden="true">
                                <option value="0">Kun håndbagasje</option>
                                <option value="1">1 kolli (100 NOK)</option>
                                <option value="2">2 kolli (200 NOK)</option>
                            </select>
                        </div>
                    </div> 
                </div>
                
                
            <?php } ?>
            
            

            
            
                <div class="row col-md-2 col-md-offset-6 top-buffer">
                    <a href="./" class="btn btn-flat btn-link">Tilbake</a>
                    <input type="submit" class="btn btn-primary pull-right btn-flat" onclick="" value="Bestill">
                </div>    
            </div>
            
        </form>
      </div>
       
        
<?php
        }
    }
    
    if($_POST){
        
        $bestilling = new Bestilling();
        $billett = new Billett();
        $bestillingsDato = date("Y-m-d H:i:s");
        $refNo = uniqid();
        $reiseDato=$reiseInfo[0][3];
        $antallVoksne = $antallReisende;
        $antallBarn = 0;
        
        if(!@$innloggetBruker){

            $bestillerFornavn = $saner->data($_POST["bestillerFornavn"]);
            $bestillerEtternavn = $saner->data($_POST["bestillerEtternavn"]);
            $bestillerEpost = $saner->data($_POST["bestillerEpost"]);
            $bestillerTlf = $saner->data($_POST["bestillerTlf"]);
 
        } else {
            $bestillerFornavn = $userInfo[0][1];
            $bestillerEtternavn = $userInfo[0][2];
            $bestillerEpost = $userInfo[0][3];
            $bestillerTlf = $userInfo[0][4];
        }
        
        $reisende = array();
        
        //mapper reisende til ett array 
        for ($i=1; $i <= $antallReisende; $i++) { 
            $reisende[] = array('Fornavn' => $saner->data($_POST['kundeFornavn'.$i])
                                ,'Etternavn' => $saner->data($_POST['kundeEtternavn'.$i])
                                , 'Kjonn' =>$saner->data($_POST['kjonn'.$i])
                                , 'Bagasje' => $saner->data($_POST['bagasje'.$i])
                                );
            
        }
        
        // print_r($reisende);
        $ledig = $avganger->SjekkLedigKapasitetAvgangId($utreiseInfo[0][0],$antallReisende,$logg);
        
        $returAvgangId = 0;
        
        
        if(@$_GET['retur'])
        {
            
            $ledigRetur = $avganger->SjekkLedigKapasitetAvgangId($_GET['retur'],$antallReisende,$logg); 
            $returDato = $hjemreiseInfo[0][3];
            $returAvgangId = $_GET['retur'];
        } 
        
        // print_r($ledig);
        
        //Sjekker først om det fortsatt er ledige plasser på avgangen
        if(@$ledig[0][1] >= $antallReisende && (!$_GET['retur'] || @$ledigRetur[0][1] >= $antallReisende))
        {
            $result = $bestilling->NewBestilling($bestillingsDato, $refNo, $reiseDato, @$returDato, $bestillerFornavn,$bestillerEtternavn, $bestillerEpost, $bestillerTlf,$antallVoksne
            , $antallBarn
            , $reisende
            , $utreiseInfo[0][0]
            , $returAvgangId
            ,$logg);
        
        
            if($result == 1){ 
                $response = $html->successMsg('Vellykket bestilling, refno: '.$refNo);
            } else {
                $response = $html->errorMsg('Noe feilet ved bestillingen, kontakt vårt service kontor umiddelbart.');
            }    
        } else {
            //Fant ikke ledige plasser på avgangen
            $response = $html->errorMsg('Klarte ikke å fullføre bestillingen. Ikke ledig kapasitet på flyet.');
        }
        
         ?>
        <div class="container">
            <div class="row top-buffer">
                <div class="col-md-12">
                    <?php echo $response; ?>
                    <a href="./" class="btn btn-flat btn-link">Tilbake</a>
                </div>
            </div>
        </div>
        
        <?php } ?>
 <?php include ("./html/footer.html"); ?>

</body>
</html>
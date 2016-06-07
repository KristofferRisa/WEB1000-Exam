<?php
$title = 'Bjarum Airlines';
include('./html/start.php');
include('./html/header.html');
include('./html/nav.html');

@$innloggetBruker=$_SESSION["brukernavn"];
        
if (!$innloggetBruker)
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
                        <a class="btn btn-primary" href="./register.php?returnUrl=<?php echo $_SERVER['REQUEST_URI']; ?>">Registre ny bruker</a>
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
                        <button class="btn btn-primary" onclick="">Fortsett</button>
                    </div>
                </div>
            </div>
        </div>
            
    
    </div>
    
        
  
<?php }


//?reise=2&retur=&antall=1&bebis=0
if($_GET 
    && $innloggetBruker
    && $_GET['reise']
    && $_GET['antall']
    // && $_GET['bebis']
    ){
        $fra = $_GET['reise'];
        @$til = $_GET['retur'];
        $antallReisende = $_GET['antall'];
        
        if($_GET['bebis']){
           $bebis = $_GET['bebis']; 
        } else {
            $bebis = 0;
        }
        
        //Avgang
        $utreiseInfo = $reiseInfo = $avganger->GetAvgang($fra, $logg);
        print_r($utreiseInfo);
        echo '<br>';
        //FRA
        $utreiseFra = $dest->GetDestinasjon($reiseInfo[0][1],$logg);
        print_r($utreiseFra);
        echo '<br>';
        //TIL
        $utreiseTil = $dest->GetDestinasjon($reiseInfo[0][2],$logg);
        print_r($utreiseTil);
        echo '<br>';
        
        //Vis Skjema for bestilling
        
        ?>
       <form method="POST" class="form-horizontal">
           
            <div class="container">
                <div class="row top-buffer">
                    <h1>Utreise</h1>
                    <hr>
                    <div class="form-group">
                        <label for="flyplassID" class="col-sm-2 control-label billett">Fra:</label>
                        <div class="col-sm-4">
                            <input type="hidden" disabled name="fra"  value="<?php echo $fra; ?>">
                            <div class=""><?php echo  $utreiseFra[0][1]; ?></div>
                        </div>
                        <div class="col-sm-4">
                            <input type="hidden" disabled name="til"  value="<?php echo $til; ?>">
                            <label>til: </label>
                            <?php echo  $utreiseTil[0][1]; ?>
                        </div>
                    </div>
                   
                </div>
                
                <div class="row">
                   <div class="form-group">
                        <label for="flyplassID" class="col-sm-2 control-label billett">Dato:</label>
                        <div class="col-sm-4">
                            <input type="hidden" disabled name="dato"  value="<?php echo $utreiseInfo[0][3]; ?>">
                            <?php echo  $utreiseInfo[0][3]; ?>
                        </div>
                        <div class="col-sm-6">
                            <label>kl:</label>
                            <?php echo  $utreiseInfo[0][5]; ?> (reisetid: <?php echo  $utreiseInfo[0][6]; ?>)
                        </div>
                        
                    </div> 
                </div>

                <div class="row">
                   <div class="form-group">
                        <label for="flyplassID" class="col-sm-2 control-label billett">Pris:</label>
                        <div class="col-sm-4">
                            <i class="fa fa-dollar"></i>
                            <?php echo  $utreiseInfo[0][7]; ?>
                        </div>
                    </div> 
                </div>
                
                <div class="row">
                    <h2>Kunde info</h2>
                   <div class="form-group">
                        <label for="flyplassID" class="col-sm-2 control-label">Fornavn</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="kundeFornavn1" placeholder="fornavn" requried>
                        </div>
                    </div> 
                </div>
                
                <div class="row">
                   <div class="form-group">
                        <label for="flyplassID" class="col-sm-2 control-label">Etternavn</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="kundeEtternavn1" placeholder="etternavn" required>
                        </div>
                    </div> 
                </div>
                
                <div class="row">
                   <div class="form-group">
                        <label for="flyplassID" class="col-sm-2 control-label">Kjønn</label>
                        <div class="col-sm-6">
                            <select class="form-control select2 select2-hidden-accessible" name="kjonn" style="width: 100%;" tabindex="-1" aria-hidden="true" required>
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
                            <select class="form-control select2 select2-hidden-accessible" name="bagasje1" style="width: 100%;" tabindex="-1" aria-hidden="true">
                                <option value="0">Kun håndbagasje</option>
                                <option value="1">1 kolli (100 NOK)</option>
                                <option value="2">2 kolli (200 NOK)</option>
                            </select>
                        </div>
                    </div> 
                </div>
                
                <?php if(@$_GET['avgangIdRetur']) { ?>
                <!--Antall bagasje retur-->
                <div class="row">
                   <div class="form-group">
                        <label for="flyplassID" class="col-sm-2 control-label">Antall bagasje</label>
                        <div class="col-sm-6">
                            <select class="form-control select2 select2-hidden-accessible" name="bagasje1" style="width: 100%;" tabindex="-1" aria-hidden="true">
                                <option value="0">Kun håndbagasje</option>
                                <option value="1">1 kolli (100 NOK)</option>
                                <option value="2">2 kolli (200 NOK)</option>
                            </select>
                        </div>
                    </div> 
                </div>
                
                <?php } ?>
            
            
                <div class="row col-md-2 col-md-offset-6 top-buffer">
                    <input type="submit" class="btn btn-primary pull-right" onclick="return false;" value="Bestill">
                </div>    
            </div>
            
        </form>
       
        
<?php
    }
    

 

/*
    TODO
        1. Send fra, til, dato og antall reisende som parameter fra soeket.$_COOKIE
        2. Vise valg om å logg in, registre ny bruker eller fortsette uten innlogging eller fortsette dersom bruker er innlogget.
        3. Lage skjema for å registrere ny bruker
        4. Lage skjema for registre kunde info


*/


?>


<hr>
 <?php include ("./html/footer.html"); ?>

</body>
</html>
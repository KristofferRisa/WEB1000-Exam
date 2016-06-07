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
        //Vis Skjema for bestilling
        ?>
        <h1>test</h1>
        
        
<?php
    }

// $ledigeAvganger = $avganger->SokLedigeAvganger($fra,$til,$dato,$antallReisende,$logg);

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
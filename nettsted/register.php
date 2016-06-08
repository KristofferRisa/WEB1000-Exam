<?php 
session_start();

##Hent brukernavn og passord ved POST#Sjekk brukerinfo - Logg inn om bruker finnes
if ($_POST) {

    $brukernavn = $saner->data($_POST["brukernavn"]);
    $password = $saner->data($_POST["passord"]);
    $password2 = $saner->data($_POST["passord2"]);
    include('../brukere.php');

    if ($password == $password2) {
        $user = new Bruker();
        if ($user->validerBrukernavn($brukernavn)) {
            if ($user->Finnes($brukernavn)) {
                //Bruker finnes fra før
                $error = '<div class="text-error">Feil</div>';
            } else {
                //Sjekk av brukernavn og passord
                //Kan flyttes til en egen function i egen php fil slik som i eks til Geir
                $user->Ny($brukernavn, $password);
                $_SESSION["brukernavn"] = $brukernavn;
                $user->setUserCookie($brukernavn);

                if ($DEBUG) print('Logget inn!');
                header("Location:".$HOSTING_URL."index.php?User=true");
            }
        } else {
            $error = '<div class="text-error">Feil brukernavn.</div>';
        }
    } else {
        // Ikke like passord
        $error = '<div class="text-error">Passordene er ikke like.</div>';
    }
}

$error = "";

$print = 1;
$main_page_content = '
<h2>Opprett inn</h2>
<hr>
<form method="POST">
    <div class="form-group">
        <input type="text" name="brukernavn" id="brukernavn" class="form-control" placeholder="Brukernavn" aria-describedby="basic-addon1" required="required" onfocus="fokus(this)" onblur="mistetFokus(this)" onmouseover="visMelding(\'Brukernavn må minimum være 1 karakterer langt.\')" style="cursor: auto; background: white;">
    </div>

    <div class="form-group">
        <input type="password" name="passord" id="passord" class="form-control" placeholder="Passord" aria-describedby="basic-addon1" required="required">
    </div>

    <div class="form-group">
        <input type="password" name="passord2" id="passord2" class="form-control" placeholder="Skriv inn passordet på nytt" aria-describedby="basic-addon1" required="required">
    </div>
    
    <div class="pull-right">
        <input type="reset" id="nullstill" name="nullstill" class="btn btn-dangeer">
        <input type="submit" id="logginn" value="Opprett bruker" class="btn btn-primary">

    </div>
</form>';

$main_page_content .= $error;

include('../template.php');

?>
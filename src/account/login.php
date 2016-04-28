<?php 
session_start();
include('../AppSettings.php');

##Hent brukernavn og passord ved POST#Sjekk brukerinfo - Logg inn om bruker finnes
if ($_POST) {
    include("../AppSettings.php");
    include("../user.php");
    
    $brukernavn = $_POST["brukernavn"];
    $password = $_POST["passord"];
    $user = new Bruker();
    if ($user->Login($brukernavn, $password)) {
        $user->setUserCookie($brukernavn);
        $_SESSION["brukernavn"] = $brukernavn;
        if ($DEBUG) print('Logget inn!');
        header("Location:".$HOSTING_URL."index.php");

    } else {
        if ($DEBUG) print('Feilet innlogging - ukjent brukernavn eller passord');
    }
}

$print = 1;
$login = 1;

$main_page_content = '
<h2>Logg inn</h2>
<hr>
<form method="POST">
    <div class="form-group">
        <input type="text" name="brukernavn" id="brukernavn" class="form-control" placeholder="Brukernavn" aria-describedby="basic-addon1">
    </div>

    <div class="form-group">
        <input type="password" name="passord" id="passord" class="form-control" placeholder="Passord" aria-describedby="basic-addon1">
    </div>
    
     <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
        <!--div class="checkbox">
            <label>
            <input type="checkbox"> Husk meg
            </label>
        </div-->
        </div>
    </div>

    <div class="pull-right">
        <input type="reset" id="nullstill" name="nullstill" class="btn btn-dangeer">
        <a href="'.$HOSTING_URL.'bruker/register.php" class="btn btn-default">Ny bruker</a>
        <input type="submit" id="logginn" value="Logg inn" class="btn btn-primary">

    </div>
</form>';

include('../template.php');

?>
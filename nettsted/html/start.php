<?php
    //Husk å endre når man laster opp til skolen
    //Includes
    
    //MAC + linux
    include_once $_SERVER['DOCUMENT_ROOT'] . "/WEB1000-Exam/vedlikehold/php/Logg.php";
    include_once $_SERVER['DOCUMENT_ROOT'] . "/WEB1000-Exam/vedlikehold/php/HtmlHelperClass.php";
    include_once $_SERVER['DOCUMENT_ROOT'] . "/WEB1000-Exam/vedlikehold/php/User.php";
    include_once $_SERVER['DOCUMENT_ROOT'] . "/WEB1000-Exam/vedlikehold/php/Destinasjon.php";
    include_once $_SERVER['DOCUMENT_ROOT'] . "/WEB1000-Exam/vedlikehold/php/Avgang.php";
    include_once $_SERVER['DOCUMENT_ROOT'] . "/WEB1000-Exam/vedlikehold/php/Bestilling.php";
    include_once $_SERVER['DOCUMENT_ROOT'] . "/WEB1000-Exam/vedlikehold/php/Billett.php";
    include_once $_SERVER['DOCUMENT_ROOT'] . "/WEB1000-Exam/vedlikehold/php/SanerData.php";
        
    // SKOLE
    // include_once $_SERVER['DOCUMENT_ROOT'] . "/web-is-gr13w/dev/vedlikehold/php/Logg.php";
    // include_once $_SERVER['DOCUMENT_ROOT'] . "/web-is-gr13w/dev/vedlikehold/php/User.php";
    // include_once $_SERVER['DOCUMENT_ROOT'] . "/web-is-gr13w/dev/vedlikehold/php/HtmlHelperClass.php";
    // include_once $_SERVER['DOCUMENT_ROOT'] . "/web-is-gr13w/dev/vedlikehold/php/Destinasjon.php";
    // include_once $_SERVER['DOCUMENT_ROOT'] . "/web-is-gr13w/dev/vedlikehold/php/Avgang.php";
    // include_once $_SERVER['DOCUMENT_ROOT'] . "/web-is-gr13w/dev/vedlikehold/php/Bestilling.php";
    // include_once $_SERVER['DOCUMENT_ROOT'] . "/web-is-gr13w/dev/vedlikehold/php/Billett.php";
    // include_once $_SERVER['DOCUMENT_ROOT'] . "/web-is-gr13w/dev/vedlikehold/php/SanerData.php";

    
    //Sesjon håndtering
    @session_start();
    
    @$innloggetBruker=$_SESSION["brukernavn"];
  
    //Globale variabler
    $user = new User();
    $dest = new Destinasjon();
    $avganger = new Avgang();
    $logg = new Logg();
    $html = new HtmlHelperClass();

    $saner = new Saner; // Sanerer data fra brukerinput(motvirker injection osv)

    
    if($innloggetBruker){
       $userInfo = $user->GetUserFromUsername($_SESSION['brukernavn']); 
       
    }
    
    
?>              
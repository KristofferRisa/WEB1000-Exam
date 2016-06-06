<?php
    //Husk å endre når man laster opp til skolen
    //Includes
    include_once $_SERVER['DOCUMENT_ROOT'] . "/WEB1000-Exam/vedlikehold/php/Logg.php";
    include_once $_SERVER['DOCUMENT_ROOT'] . "/WEB1000-Exam/vedlikehold/php/HtmlHelperClass.php";
    include_once $_SERVER['DOCUMENT_ROOT'] . "/WEB1000-Exam/vedlikehold/php/User.php";
    include_once $_SERVER['DOCUMENT_ROOT'] . "/WEB1000-Exam/vedlikehold/php/Destinasjon.php";
    include_once $_SERVER['DOCUMENT_ROOT'] . "/WEB1000-Exam/vedlikehold/php/Avgang.php";
    
    //Sesjon håndtering
    @session_start();
    
    @$innloggetBruker=$_SESSION["brukernavn"];

    // if (!$innloggetBruker)
    // {
    //     header('Location: '.$_SERVER['SERVERNAME'].'/WEB1000-Exam/vedlikehold/login.php');
    //     exit;
    // }
  
    //Globale variabler
    $user = new User();
    $dest = new Destinasjon();
    $avganger = new Avgang();
    $logg = new Logg();
    $html = new HtmlHelperClass();
    
    // $userInfo = $user->GetUsername($_SESSION['brukernavn']);
    
?>              
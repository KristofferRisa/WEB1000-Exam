<?php
      //Husk å endre når man laster opp til skolen
    include_once $_SERVER['DOCUMENT_ROOT'] . "/WEB1000-Exam/vedlikehold/php/User.php";
    include $_SERVER['DOCUMENT_ROOT'] . "/WEB1000-Exam/vedlikehold/php/Logg.php";

    @session_start();
    
    @$innloggetBruker=$_SESSION["brukernavn"];

    if (!$innloggetBruker)
    {
        header('Location: '.$_SERVER['SERVERNAME'].'/WEB1000-Exam/vedlikehold/login.php');
        exit;
    }
  
    $user = new User();
    $userInfo = $user->GetUsername($_SESSION['brukernavn']);

    $logg = new Logg();


    $logg->Ny('Laster side', 'INFO', htmlspecialchars($_SERVER['PHP_SELF']) , $innloggetBruker);
    
?>              
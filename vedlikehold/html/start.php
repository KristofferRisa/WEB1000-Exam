<?php
      //Husk å endre når man laster opp til skolen
    include_once $_SERVER['DOCUMENT_ROOT'] . "/WEB1000-Exam/vedlikehold/php/User.php";
    @session_start();
    
    @$innloggetBruker=$_SESSION["brukernavn"];

    if (!$innloggetBruker)
    {
        header('Location: '.$_SERVER['SERVERNAME'].'/WEB1000-Exam/vedlikehold/login.php');
        exit;
    }
  
    $user = new User();
    $userInfo = $user->GetUsername($_SESSION['brukernavn']);
    
?>              
<?php
    //CHANGE ON DEPLOYMENT
    include_once $_SERVER['DOCUMENT_ROOT'] . "/WEB1000-Exam/vedlikehold/php/User.php";
<<<<<<< HEAD
    // include_once $_SERVER['DOCUMENT_ROOT'] . "/web-is-gr13w/dev/vedlikehold/php/User.php";
=======
    include $_SERVER['DOCUMENT_ROOT'] . "/WEB1000-Exam/vedlikehold/php/Logg.php";

>>>>>>> master
    @session_start();
    
    @$innloggetBruker=$_SESSION["brukernavn"];

    if (!$innloggetBruker)
    {
        //CHANGE ON DEPLOYMENT
        // header('Location: '.$_SERVER['SERVERNAME'].'/web-is-gr13w/dev/vedlikehold/login.php');
        header('Location: '.$_SERVER['SERVERNAME'].'/WEB1000-Exam/vedlikehold/login.php');
        exit;
    }
  
    $user = new User();
    $userInfo = $user->GetUsername($_SESSION['brukernavn']);

    $logg = new Logg();


    $logg->Ny('Laster side', 'INFO', htmlspecialchars($_SERVER['PHP_SELF']) , $innloggetBruker);
    
?>
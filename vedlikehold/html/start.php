<?php
    //Global includes
    //CHANGE ON DEPLOYMENT
    // include_once $_SERVER['DOCUMENT_ROOT'] . "/WEB1000-Exam/vedlikehold/php/user.php";
    // include_once $_SERVER['DOCUMENT_ROOT'] . "/WEB1000-Exam/vedlikehold/php/Logg.php";
    // include_once $_SERVER['DOCUMENT_ROOT'] . "/WEB1000-Exam/vedlikehold/php/HtmlHelperClass.php";
    // include_once $_SERVER['DOCUMENT_ROOT'] . "/WEB1000-Exam/vedlikehold/php/SanerData.php";
    
    //Skole    
    include_once $_SERVER['DOCUMENT_ROOT'] . "/web-is-gr13w/vedlikehold/php/User.php";
    include_once $_SERVER['DOCUMENT_ROOT'] . "/web-is-gr13w/vedlikehold/php/Logg.php";
    include_once $_SERVER['DOCUMENT_ROOT'] . "/web-is-gr13w/vedlikehold/php/HtmlHelperClass.php";
    include_once $_SERVER['DOCUMENT_ROOT'] . "/web-is-gr13w/vedlikehold/php/SanerData.php";
    @session_start();
    
    @$innloggetBruker=$_SESSION["brukernavn"];
        
  if (!$innloggetBruker)
    {
        //CHANGE ON DEPLOYMENT
        // header('Location: '.$_SERVER['SERVERNAME'].'/web-is-gr13w/dev/vedlikehold/login.php');
        header('Location: '.$_SERVER['SERVERNAME'].'/WEB1000-Exam/vedlikehold/login.php');
        exit;
    }

    //Global variables
    $user = new User();
    $userInfo = $user->GetUserFromUsername($_SESSION['brukernavn']);
    $logg = new Logg();
    $html = new HtmlHelperClass();

    $saner = new Saner; // Sanerer data fra brukerinput(motvirker injection osv)
    
    if(!$user->ValidateAdminCookie($innloggetBruker,$logg)){
        $logg->Ny('Feil med Admin cookie.', 'ERROR', htmlspecialchars($_SERVER['PHP_SELF']), $innloggetBruker);    
        $innloggetBruker = NULL;
    }
    
?>
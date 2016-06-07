<?php

    // Utlogging
    session_start();
    setcookie(session_name(), '', 100);
    session_unset();
    session_destroy();
    $_SESSION = array();

    # Todo: Fjern cookie

    // Sendes tilbake til hjemmeside
    header('Location: ./');

?>
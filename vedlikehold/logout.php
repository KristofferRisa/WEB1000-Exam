<?php

    // Utlogging
    session_start();
    session_destroy();

    # Todo: Fjern cookie

    // Sendes tilbake til hjemmeside
    header('Location: ../?logout=true');

?>
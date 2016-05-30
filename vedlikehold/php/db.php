<?php

    $config = require('./../config.php');
    $host = $config['db_host'];
    $usr = $config['db_usr'];
    $pass = $config['db_pass'];
    $db_name = $config['db_name'];
    $debug = $config['debug'];
    
    if ($debug) print('Hentet db tilkopling.');

    // MYSQL tilkopling
    // Opprett tilkopling mot database
    $db_connection = new mysqli($host, $usr, $pass, $db_name);
    
    // sjekk UTF8 mode!
    if (!$db_connection->set_charset("utf8")) {
        if($debug) die("Error loading character set utf8: %s\n. ".$db_connection->error);
    } else {
        if($debug)  printf("Current character set: %s\n", $db_connection->character_set_name());
    }
    
    // Sjekk databasetilkpling
    if ($db_connection->connect_error) {
        die("Ikke kontakt med databaseserver: ".$db_connection->connect_error);
}
<?php 
    if ($DEBUG) print('Hentet db tilkopling.');

    // MYSQL tilkopling
    // Opprett tilkopling mot database
    $db_connection = new mysqli($DB_HOST, $DB_USER, $DB_PASSWORD, $DATABASE);
    // make sure we're in UTF8 mode!
    if (!$db_connection->set_charset("utf8")) {
        if($DEBUG) die("Error loading character set utf8: %s\n. ".$db_connection->error);
    } else {
        if($DEBUG)  printf("Current character set: %s\n", $db_connection->character_set_name());
    }
    // Sjekk databasetilkpling
    if ($db_connection->connect_error) {
        die("Ikke kontakt med databaseserver: ".$db_connection->connect_error);
}
?>
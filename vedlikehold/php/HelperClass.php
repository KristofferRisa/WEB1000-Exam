<?php 


class HelperClass{
    //Finner antall rader i tabellen
    public function AntallRader($tabell){
        include('../php/db.php');
        
        $query = $db_connection->query('SELECT COUNT(*) FROM ' . $tabell .'');
        $query = $query->fetch_row();
        
        $antallRader = $query[0];
        
        $antallRader->close();
        $db_connection->close();
        
        return $antallRader;       
    }
}    
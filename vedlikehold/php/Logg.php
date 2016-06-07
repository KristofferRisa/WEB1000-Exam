<?php

class Logg {
    public function Logg(){
    }
    
    public function Alt(){
        include('db.php');
        $html =  '';
        //CSS Styling
        $oddOrEven = TRUE;
        $printOddOrEven = '';
        
        //db-tilkopling
        $query = $db_connection->prepare("SELECT loggId,melding,nivaa,modul,bruker,opprettet FROM logg ORDER BY loggId DESC");
        $query->execute();

        $query->bind_result($id,$melding, $nivaa, $modul, $bruker, $opprettet);
        
        //henter data
        while ($query->fetch()) {
            
            if($oddOrEven){
                $oddOrEven = FALSE;
                $printOddOrEven = 'even';
            } 
            else {
                $oddOrEven = TRUE;
                $printOddOrEven = 'odd';
            }
            $html .= '<tr role="row" class="'.$printOddOrEven.'"><td>'.$id.'</td><td>'.$melding.'</td><td>'.$nivaa.'</td><td>'.$modul.'
            </td><td>'.$bruker.'</td><td>'.$opprettet.'</td></tr>';
        }
        //Lukker databasetilkopling
        $query->close();
        $db_connection->close();
        
        return $html;
    }
    
    public function AltPrSide($antallMeldinger,$sideNr){
        include('db.php');
        $html =  '';
        //CSS Styling
        $oddOrEven = TRUE;
        $printOddOrEven = '';
        
        $offset = 0;
        
        if ($sideNr > 1) {
            $sideNr = $sideNr-1;
            $offset = $sideNr*$antallMeldinger;    
        } else {
            $offset = $sideNr-1;
        }
        
        // $html .= '<p>offset = '.$offset.'</p>';
        
        $sql = "SELECT loggId,melding,nivaa,modul,bruker,opprettet FROM logg ORDER BY loggId DESC LIMIT ?,?";
        
        $queryPrSide = $db_connection->prepare($sql);
        
        $queryPrSide->bind_param('ss', $offset, $antallMeldinger);
        $queryPrSide->execute();

        $queryPrSide->bind_result($id,$melding, $nivaa, $modul, $bruker, $opprettet);
        
        //henter data
        while ($queryPrSide->fetch()) {
            
            if($oddOrEven){
                $oddOrEven = FALSE;
                $printOddOrEven = 'even';
            } 
            else {
                $oddOrEven = TRUE;
                $printOddOrEven = 'odd';
            }
            $html .= '<tr role="row" class="'.$printOddOrEven.'"><td>'.$id.'</td><td>'.$melding.'</td><td>'.$nivaa.'</td><td>'.$modul.'
            </td><td>'.$bruker.'</td><td>'.$opprettet.'</td></tr>';
        }
        
        
        //Lukker databasetilkopling
        $queryPrSide->close();
        $db_connection->close();
        
        return $html;
    }
    
    public function AntallMeldinger(){
        include('db.php');
        $returnAntall = -1;
        $query = "SELECT count(*) as ANTALL FROM logg";

        if ($result = $db_connection->query($query)) {

            /* fetch associative array */
            while ($row = $result->fetch_assoc()) {
                //printf ("%s (%s)\n", $row["Name"], $row["CountryCode"]);
                $returnAntall = $row["ANTALL"];
            }

            /* free result set */
            $result->free();
        }

        /* close connection */
        $db_connection->close();
        
        return $returnAntall;

    }
    
    //Slik bruker du logg modul
    // include('./php/Logg.php');
    // $logg = new Logg();
    // $logg->Ny('test melding', 'INFO',htmlspecialchars($_SERVER['PHP_SELF']), 'UserID');
    public function Ny($melding, $nivå = NULL, $modul = NULL, $bruker = NULL) {
        // include('db.php');
        include (realpath(dirname(__FILE__)).'/db.php');
        // include_once $_SERVER['DOCUMENT_ROOT'] . "/WEB1000-Exam/vedlikehold/php/db.php" ;
        $datotid = date('Y-m-d H:i:s');
        
        if(!$nivå) {
            $nivå = 'INFO';
        }
        if(!$modul){
            $modul = 'NA';
        }
        if(!$bruker){
            $bruker = 'NA';
        }
        
        //Bygger SQL statement
        $queryNy = $db_connection->prepare("INSERT INTO logg(melding,nivaa,modul,bruker,opprettet) VALUES(?,?,?,?,?)");
        $queryNy->bind_param('sssss', $melding, $nivå, $modul, $bruker, $datotid);

        $queryNy->execute();

        $result = $queryNy->num_rows;
        
        //Lukker databasetilkopling
        $queryNy->close();
        $db_connection->close();
    }
    
}
<?php
include('db.php');

class Logg {
    
    public function Alt(){
        $html =  '';
        //CSS Styling
        $oddOrEven = TRUE;
        $printOddOrEven = '';
        
        //db-tilkopling
        $query = $db_connection->prepare("SELECT loggId,melding,nivaa,modul,brukerId,opprettet FROM logg ORDER BY loggId DESC");
        $query->execute();

        $query->bind_result($id,$melding, $nivaa, $modul, $brukerId, $opprettet);
        
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
            </td><td>'.$brukerId.'</td><td>'.$opprettet.'</td></tr>';
        }
        //Lukker databasetilkopling
        $query->close();
        $db_connection->close();
        
        return $html;
    }
    
    
    public function Search(){
        
    }
    
}
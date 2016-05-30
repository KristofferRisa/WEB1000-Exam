<?php
class Logg{
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
    
    
    public function Siste($antallMeldinger,$sideNr){
        include('db.php');
        $html =  '';
        //CSS Styling
        $oddOrEven = TRUE;
        $printOddOrEven = '';
        
        $start = $sideNr * $antallMeldinger;
        
        //db-tilkopling
        $query = $db_connection->prepare("SELECT loggId,melding,nivaa,modul,bruker,opprettet FROM logg ORDER BY loggId DESC LIMIT ?,?"); // Retrieve rows 6-15
        $queryNy->bind_param('ss', $start, $antallMeldinger);
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
    
    
    
    //Slik bruker du logg modul
    // include('./php/Logg.php');
    // $logg = new Logg();
    // $logg->Ny('test melding', 'INFO','Der du er i programmet', '1')
    public function Ny($melding, $nivå, $modul, $bruker) {
        include('db.php');
        $datotid = date('Y-m-d H:i:s');
        
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
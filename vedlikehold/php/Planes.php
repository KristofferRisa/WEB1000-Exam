<?php
class Planes {



  
    public function ShowAllPlanes(){

        include('db.php');
        $html =  '';
        //CSS Styling
        $oddOrEven = TRUE;
        $printOddOrEven = '';
        
        //db-tilkopling
        $query = $db_connection->prepare("SELECT flyId,flyNr,modell,type,plasser,laget,startet,opprettet,statusKodeId FROM fly");
        $query->execute();

        $query->bind_result($id, $flyNr, $modell, $type, $plasser, $laget, $startet, $opprettet, $statusKodeId);
        
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

            $html .= '<tr role="row" class="'.$printOddOrEven.'"><td>'.$id.'</td><td>'.$flyNr.'</td><td>'.$modell.'</td><td>'.$type.'
            </td><td>'.$plasser.'</td><td>'.$laget.'</td><td>'.$startet.'</td><td>'.$opprettet.'</td><td>'.$statusKodeId.'</td></tr>';
        
    }
        //Lukker databasetilkopling
        $query->close();
        $db_connection->close();
        
        return $html;
    }
    
}
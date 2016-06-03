<?php

class ValiderData {

    public function valider($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
}

class Planes {
  
    public function ShowAllPlanes(){

        include('db.php');
        $html =  '';
        //CSS Styling
        $oddOrEven = TRUE;
        $printOddOrEven = '';
        
        //db-tilkopling
        $query = $db_connection->prepare("SELECT flyId,flyNr,modell,type,plasser,aarsmodell,statusKodeId FROM fly");
        $query->execute();

        $query->bind_result($id, $flyNr, $modell, $type, $plasser, $flyAarsmodell, $statusKodeId);
        
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
            </td><td>'.$plasser.'</td><td>'.$flyAarsmodell.'</td><td>'.$statusKodeId.'</td></tr>';
        
        }
        //Lukker databasetilkopling
        $query->close();
        $db_connection->close();
        
        return $html;
    }

    
    public function AddNewPlane($flyNr, $flyModell,$flyType,$flyAntallPlasser,$flyAarsmodell,$flyStatusKode) {
        include('../php/db.php');
        
        //Bygger SQL statementt
        $query = $db_connection->prepare("INSERT INTO fly (flyNr,modell,type,plasser,aarsmodell,statusKodeId) VALUES (?,?,?,?,?,?)");
        $query->bind_param('ssssss', $flyNr, $flyModell,$flyType,$flyAntallPlasser,$flyAarsmodell,$flyStatusKode);  

            if ( $query->execute()) { 
                $affectedRows = $query->affected_rows;
                $query->close();
        $db_connection->close();

         return $affectedRows;           
} 
    }
}


class Airport {
  
    public function ShowAllAirports(){

        include('db.php');
        $html =  '';
        //CSS Styling
        $oddOrEven = TRUE;
        $printOddOrEven = '';
        
       
        //  db-tilkopling
        $query = $db_connection->prepare("SELECT flyplassId,navn,land,statusKodeId,endret FROM flyplass");
        $query->execute();
        $queryFlyplass->bind_result($id, $navn, $land, $statuskode, $endret);


            if($oddOrEven){
                $oddOrEven = FALSE;
                $printOddOrEven = 'even';
            } 
            else {
                $oddOrEven = TRUE;
                $printOddOrEven = 'odd';
            }

            $html .= '<tr role="row" class="'.$printOddOrEven.'"><td>'.$id.'</td><td>'.$navn.'</td><td>'.$land.'</td><td>'.$statuskode.'
            </td><td>'.$endret.'</td></tr>';
        
    
        //Lukker databasetilkopling
        $query->close();
        $db_connection->close();
        
        return $html;
    }

    public function ShowAllAirportsDataset(){

            include('db.php');
            $sql = "SELECT flyplassId,navn,land,statusKodeId,endret FROM flyplass";
            
            $queryFlyplass = $db_connection->prepare($sql);
            
            $queryFlyplass->execute();
            
            //henter result set
            $resultSet = $queryFlyplass->get_result();
            
            $flyplasser =  $resultSet->fetch_all();
            
            //Error logging
            if($queryFlyplass == false){
                $logg->Ny('Failed to get from db: '.mysql_error($db_connection), 'ERROR', htmlspecialchars($_SERVER['PHP_SELF']), '');    
            }
            
            $resultSet->free();
            $queryFlyplass->close();
            $db_connection->close(); 
            
            return $flyplasser;
    }

    
    public function AddNewAirport($flyplassNavn, $flyplassLand,$flyplassStatusKode) {
        include('../php/db.php');
        
        //Bygger SQL statementt
        $query = $db_connection->prepare("INSERT INTO flyplass (navn,land,statusKodeId) VALUES (?,?,?)");
        $query->bind_param('sss', $flyplassNavn, $flyplassLand,$flyplassStatusKode);  

            if ( $query->execute()) { 
                $affectedRows = $query->affected_rows;
                $query->close();
        $db_connection->close();

         return $affectedRows;  
         }

         }         
 
    
}

class Count {


        public function AntallRader($tabell){
        include('../php/db.php');  
  

        $query = $db_connection->query('SELECT COUNT(*) FROM ' . $tabell .'');
        $query = $query->fetch_row();

        $antallRader = 'Antall rader i tabellen: ' . $query[0]  ;   


         return $antallRader;

    }



}
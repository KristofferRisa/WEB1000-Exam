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
        $query = $db_connection->prepare("SELECT flyId,flyNr,flyModell,type,plasser,aarsmodell,endret FROM fly");
        $query->execute();

        $query->bind_result($id, $flyNr, $modell, $type, $plasser, $flyAarsmodell,$endret);
        
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
            </td><td>'.$plasser.'</td><td>'.$flyAarsmodell.'</td><td>'.$endret.'</td><td><a href="../vedlikehold/Plane/planesEdit.php?id='.$id.'"">Endre</a></td></tr>';
        
        }
        //Lukker databasetilkopling
        $query->close();
        $db_connection->close();
        
        return $html;
    }

    
    public function AddNewPlane($flyNr, $flyModell,$flyType,$flyAntallPlasser,$flyAarsmodell) {
        include('../php/db.php');
        
        //Bygger SQL statementt
        $query = $db_connection->prepare("INSERT INTO fly (flyNr,flyModell,type,plasser,aarsmodell) VALUES (?,?,?,?,?)");
        $query->bind_param('sssss', $flyNr, $flyModell,$flyType,$flyAntallPlasser,$flyAarsmodell);  

            if ( $query->execute()) { 
                $affectedRows = $query->affected_rows;
                $query->close();
        $db_connection->close();

         return $affectedRows;           
} 
    }

    public function UpdatePlane($flyId,$flyNr, $flyModell,$flyType,$flyAntallPlasser,$flyAarsmodell, $logg){
            include('db.php');
            
            $sql = "
            update fly 
            set flynr = ?, flyModell = ?, type = ?, plasser = ?, aarsmodell = ?
            where flyId = ?;";
            
            $insertFly = $db_connection->prepare($sql);
            $insertFly->bind_param('sssiii'
                                    , $flyNr,$flyModell,$flyType,$flyAntallPlasser,$flyAarsmodell
                                    , $flyId);
                                    
            $insertFly->execute();

            $affectedRows = $insertFly->affected_rows;
            
            $insertFly->close();
            $db_connection->close(); 
            
            
            $logg->Ny('Rows affected: '.$affectedRows, 'DEBUG', htmlspecialchars($_SERVER['PHP_SELF']), '');

            if($insertFly == false){
                $logg->Ny('Failed to update: '.mysql_error($db_connection), 'ERROR', htmlspecialchars($_SERVER['PHP_SELF']), '');
                exit;    
            }
            
            if ($affectedRows == 1) {
                $logg->Ny('Fly ble oppdatert.', 'DEBUG',htmlspecialchars($_SERVER['PHP_SELF']), '');
            } else {
                $logg->Ny('Klarte ikke å oppdatere fly.', 'ERROR',htmlspecialchars($_SERVER['PHP_SELF']), '');
            } 
                
            //Lukker databasetilkopling
            
            return $affectedRows;
        }
        
            public function GetPlane($flyId, $logg){
            include('db.php');
            
            
            $sql = "select * FROM fly WHERE flyId=?;";
            
            $queryPlanes = $db_connection->prepare($sql);
            
            $queryPlanes->bind_param('i', $flyId);
            $queryPlanes->execute();
            
            //henter result set
            $resultSet = $queryPlanes->get_result();
            
            $fly =  $resultSet->fetch_all();
            
            //Error logging
            if($queryPlanes == false){
                $logg->Ny('Failed to get from db: '.mysql_error($db_connection), 'ERROR', htmlspecialchars($_SERVER['PHP_SELF']), '');    
            }
            
            $resultSet->free();
            $queryPlanes->close();
            $db_connection->close(); 
            
            return $fly;
        } 

            public function PlaneSelectOptions(){
            include('db.php');
             $listBox = "";
            
            $sql="SELECT flyId, flyNr, flyModell from fly";
            
            $queryPlanes = $db_connection->prepare($sql);
            
            $queryPlanes->execute();

            $queryPlanes->bind_result($id, $flyNr, $flyModell);
                        
            while ($queryPlanes->fetch()) {
                
                 $listBox .= "<option value=".$id. ">ID:".$id." Flynr:".$flyNr." Modell:".$flyModell."</option>";
            }
            
            //$htmlSelect .= '</select>';
            //Error logging
            if($queryPlanes == false){
                $logg->Ny('Failed to get from db: '.mysql_error($db_connection), 'ERROR', htmlspecialchars($_SERVER['PHP_SELF']), '');    
            }
            
            $queryPlanes->close();
            $db_connection->close();  

            return $listBox;        
         
}
}

class Airport {
  
    public function ShowAllAirports(){

        include('../php/db.php');  
        $html =  '';
        //CSS Styling
        $oddOrEven = TRUE;
        $printOddOrEven = '';
        
       
        //  db-tilkopling
        $query = $db_connection->prepare("SELECT flyplassId,navn,land,endret FROM flyplass");
        $query->execute();
        $query->bind_result($id, $navn, $land, $endret);



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

            $html .= '<tr role="row" class="'.$printOddOrEven.'"><td>'.$id.'</td><td>'.$navn.'</td><td>'.$land.'</td><td>'.$endret.'</td></tr>';

        }
        
    
        //Lukker databasetilkopling
        $query->close();
        $db_connection->close();
        
        return $html;
    }

    public function ShowAllAirportsDataset(){

            include('db.php');
            $sql = "SELECT flyplassId,navn,land,endret FROM flyplass";
            
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

    
    public function AddNewAirport($flyplassNavn, $flyplassLand) {
        include('../php/db.php');
        
        //Bygger SQL statementt
        $query = $db_connection->prepare("INSERT INTO flyplass (navn,land) VALUES (?,?)");
        $query->bind_param('ss', $flyplassNavn, $flyplassLand);  

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


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
            </td><td>'.$plasser.'</td><td>'.$flyAarsmodell.'</td><td>'.$endret.'</td><td><a href="./Plane/planesAdd.php">Nytt fly</a> | <a href="../vedlikehold/Plane/planesEdit.php?id='.$id.'"">Endre</a> | <a onclick="return confirm(\'Er du sikker du ønsker å slette dette flyet?\')" href="./Plane/delete.php?id='.$id.'">Slett</a> </td></tr>';
        
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
        public function DeletePlane($planeId, $logg){
            include('db.php');
            
            $sql = "delete from fly where flyId = ?;";
            
            $logg->Ny('Forsøker å slette flyId: '.$planeId);
            
            $deletePlane = $db_connection->prepare($sql);
            $deletePlane->bind_param('i'
                                    , $planeId);
                                    
            $deletePlane->execute();

            $affectedRows = $deletePlane->affected_rows;
            
            $deletePlane->close();
            $db_connection->close(); 
            
            
            $logg->Ny('Rows affected: '.$affectedRows, 'DEBUG', htmlspecialchars($_SERVER['PHP_SELF']), '');

            if($deletePlane == false){
                $logg->Ny('Klarte ikke slette fly, feilmelding: '.mysql_error($db_connection), 'ERROR', htmlspecialchars($_SERVER['PHP_SELF']), '');
                exit;       
            }
            
            if ($affectedRows == 1) {
                $logg->Ny('Fly ble slettet.', 'DEBUG',htmlspecialchars($_SERVER['PHP_SELF']), '');
            } else {
                $logg->Ny('Klarte ikke å slette fly.', 'ERROR',htmlspecialchars($_SERVER['PHP_SELF']), '');
            } 
                
            //Lukker databasetilkopling
            
            return $affectedRows;
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
        $query = $db_connection->prepare("SELECT flyplassId,navn,endret FROM flyplass");
        $query->execute();
        $query->bind_result($id, $navn, $endret);



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

            $html .= '<tr role="row" class="'.$printOddOrEven.'"><td>'.$id.'</td><td>'.$navn.'</td><td>'.$endret.'</td><td><a href="./Airport/airportsAdd.php">Nytt fly</a> | <a href="./Airport/airportsEdit.php?id='.$id.'"">Endre</a> | <a onclick="return confirm(\'Er du sikker du ønsker å slette denne flyplassen?\')" href="./Airport/delete.php?id='.$id.'">Slett</a> </td></tr>';

        }
        
    
        //Lukker databasetilkopling
        $query->close();
        $db_connection->close();
        
        return $html;
    }

    public function ShowAllAirportsDataset(){

            include('db.php');
            $sql = "SELECT flyplassId,navn,endret FROM flyplass";
            
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

    
    public function AddNewAirport($flyplassNavn) {
        include('../php/db.php');
        
        //Bygger SQL statementt
        $query = $db_connection->prepare("INSERT INTO flyplass (navn) VALUES (?)");
        $query->bind_param('s', $flyplassNavn);  

            if ( $query->execute()) { 
                $affectedRows = $query->affected_rows;
                $query->close();
        $db_connection->close();

         return $affectedRows;  
         }
     }


         public function AirportSelectOptions(){
            include('db.php');
             $listBox = "";
            
            $sql="SELECT flyplassId, navn from flyplass";
            
            $queryPlanes = $db_connection->prepare($sql);
            
            $queryPlanes->execute();

            $queryPlanes->bind_result($id, $flyplassNavn);
                        
            while ($queryPlanes->fetch()) {
                
                 $listBox .= "<option value=".$id. ">ID: ".$id.", Flyplassnavn: ".$flyplassNavn."</option>";
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

         public function DeleteAirport($flyplassId, $logg){
            include('db.php');
            include('../html/start.php');
            
            $sql = "delete from flyplass where flyplassId =?;";
            
            $logg->Ny('Forsøker å slette flyId: '.$flyplassId);
            
            $deleteFlyplass = $db_connection->prepare($sql);
            $deleteFlyplass->bind_param('i'
                                    , $flyplassId);
                                    
            $deleteFlyplass->execute();

            $affectedRows = $deleteFlyplass->affected_rows;
            
            $deleteFlyplass->close();
            $db_connection->close(); 
            
            
            $logg->Ny('Rows affected: '.$affectedRows, 'DEBUG', htmlspecialchars($_SERVER['PHP_SELF']), '');

            

            if($deleteFlyplass == false){
                $logg->Ny('Klarte ikke slette flyplass, feilmelding: '.mysql_error($db_connection), 'ERROR', htmlspecialchars($_SERVER['PHP_SELF']), '');
                
                
                exit;    
            }
            
            if ($affectedRows == 1) {
                $logg->Ny('Flyplass ble slettet.', 'DEBUG',htmlspecialchars($_SERVER['PHP_SELF']), '');
            } else {
                $logg->Ny('Klarte ikke å slette flyplassss.', 'ERROR',htmlspecialchars($_SERVER['PHP_SELF']), '');
                
                
            } 
                
            //Lukker databasetilkopling
            
            return $affectedRows;
                       
        }

        public function GetAirport($flyplassId, $logg){
            include('db.php');
            
            
            $sql = "select * FROM flyplass WHERE flyplassId=?;";
            
            $queryAirport = $db_connection->prepare($sql);
            
            $queryAirport->bind_param('i', $flyplassId);
            $queryAirport->execute();
            
            //henter result set
            $resultSet = $queryAirport->get_result();
            
            $airport =  $resultSet->fetch_all();
            
            //Error logging
            if($queryAirport == false){
                $logg->Ny('Failed to get from db: '.mysql_error($db_connection), 'ERROR', htmlspecialchars($_SERVER['PHP_SELF']), '');    
            }
            
            $resultSet->free();
            $queryAirport->close();
            $db_connection->close(); 
            
            return $airport;
        } 

        public function UpdateAirport($flyplassId, $navn, $logg){
            include('db.php');
            
            $logg->Ny('Forsoeker å oppdatere flyplass (id='.$flyplassId.') med navnet '.$navn);
            
            $sql = "
            update flyplass 
            set navn = ? where flyplassId = ?;";
            
            $insertFlyplass = $db_connection->prepare($sql);
            $insertFlyplass->bind_param('si'
                                    , $navn,$flyplassId);
                                    
            $insertFlyplass->execute();

            $affectedRows = $insertFlyplass->affected_rows;
            
            $insertFlyplass->close();
            $db_connection->close(); 
            
            
            $logg->Ny('Rows affected: '.$affectedRows, 'DEBUG', htmlspecialchars($_SERVER['PHP_SELF']), '');

            if($insertFlyplass == false){
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



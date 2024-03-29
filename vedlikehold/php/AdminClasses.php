<?php

class ValiderData {

    public function valider($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
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

            $html .= '<tr role="row" class="'.$printOddOrEven.'"><td>'.$id.'</td><td>'.$navn.'</td><td>'.$endret.'</td><td><a href="./Airport/airportsAdd.php">Ny flyplass</a> | <a href="./Airport/airportsEdit.php?id='.$id.'"">Endre</a> | <a onclick="return confirm(\'Er du sikker du ønsker å slette denne flyplassen?\')" href="./Airport/delete.php?id='.$id.'">Slett</a> </td></tr>';

        }
        
    
        //Lukker databasetilkopling
        $query->close();
        $db_connection->close();
        
        return $html;
    }

    public function ShowAllAirportsDataset(){

            include (realpath(dirname(__FILE__)).'/db.php');;
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
            include (realpath(dirname(__FILE__)).'/db.php');;
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
            include (realpath(dirname(__FILE__)).'/db.php');;
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
            include (realpath(dirname(__FILE__)).'/db.php');;
            
            
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
            include (realpath(dirname(__FILE__)).'/db.php');;
            
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



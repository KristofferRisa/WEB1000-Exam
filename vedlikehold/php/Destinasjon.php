<?php
    class Destinasjon
    {
        
        // OPPRETTE NY DESTINASJON
        public function Destinasjon()
        {
            
        }
    
        public function ShowAllDestinations() {

        include (realpath(dirname(__FILE__)).'/db.php');;
         $html =  '';
         $id = '';
        //CSS Styling
        $oddOrEven = TRUE;
        $printOddOrEven = '';
        
       
        //  db-tilkopling
        $query = $db_connection->prepare("SELECT destinasjonId, flyplassId, navn, landskode, stedsnavn, geo_lat, geo_lng, endret  FROM destinasjon");
        $query->execute();
        $query->bind_result($dId, $fId, $navn, $landskode,$stedsnavn,$geo_lat,$geo_lng,$endret);



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

            $html .= '<tr role="row" class="'.$printOddOrEven.'"><td>'.$dId.'</td><td>'.$fId.'</td><td>'.$navn.'</td><td>'.$landskode.'</td><td>'.$stedsnavn.'</td><td>'.$geo_lat.'</td><td>'.$geo_lng.'</td>
            <td>'.$endret.'</td><td><a href="./Destinations/destinationsAdd.php">Ny destinasjon</a> | <a href="./Destinations/destinationsEdit.php?id='.$dId.'"">Endre</a> | <a onclick="return confirm(\'Er du sikker du ønsker å slette denne destinasjonen?\')" href="./Destinations/delete.php?id='.$dId.'">Slett</a> </td></tr>';

        }
        
    
        //Lukker databasetilkopling
        $query->close();
        $db_connection->close();
        
        return $html;

    }

    public function AddNewDestination($fId,$navn,$landskode,$stedsnavn,$geo_lat,$geo_lng) {
        include('../php/db.php');
        
        //Bygger SQL statementt
        $query = $db_connection->prepare("INSERT INTO destinasjon (flyplassId,navn,landskode,stedsnavn,geo_lat,geo_lng) VALUES (?,?,?,?,?,?)");
        $query->bind_param('isssss', $fId,$navn,$landskode,$stedsnavn,$geo_lat,$geo_lng);  

            if ( $query->execute()) { 
                $affectedRows = $query->affected_rows;
                $query->close();
        $db_connection->close();

         return $affectedRows;  
         }
     }


      public function GetDestDataset($logg){
            include (realpath(dirname(__FILE__)).'/db.php');
            
            
            $sql = "select destinasjonId, navn ,flyplassId  FROM destinasjon;";
            
            $queryDestinasjon = $db_connection->prepare($sql);
        
            $queryDestinasjon->execute();
            
            //henter result set
            $resultSet = $queryDestinasjon->get_result();
            
            $dest =  $resultSet->fetch_all();
            
            //Error logging
            if($queryDestinasjon == false){
                $logg->Ny('Failed to get from db: '.mysql_error($db_connection), 'ERROR', htmlspecialchars($_SERVER['PHP_SELF']), '');    
            }
            
            $resultSet->free();
            $queryDestinasjon->close();
            $db_connection->close(); 
            
            return $dest;
        }   

     public function GetDestination($destinationId, $logg){
            include (realpath(dirname(__FILE__)).'/db.php');;
            
            
            $sql = "select * FROM destinasjon WHERE destinasjonId=?;";
            
            $queryDestination = $db_connection->prepare($sql);
            
            $queryDestination->bind_param('i', $destinationId);
            $queryDestination->execute();
            
            //henter result set
            $resultSet = $queryDestination->get_result();
            
            $destinasjon =  $resultSet->fetch_all();
            
            //Error logging
            if($queryDestination == false){
                $logg->Ny('Failed to get from db: '.mysql_error($db_connection), 'ERROR', htmlspecialchars($_SERVER['PHP_SELF']), '');    
            }
            
            $resultSet->free();
            $queryDestination->close();
            $db_connection->close(); 
            
            return $destinasjon;
        } 

        public function DestinationSelectOptions(){
            include (realpath(dirname(__FILE__)).'/db.php');;
             $listBox = "";
            
            $sql="SELECT destinasjonId, navn from destinasjon";
            
            $queryDestinasjon = $db_connection->prepare($sql);
            
            $queryDestinasjon->execute();

            $queryDestinasjon->bind_result($id, $navn);
                        
            while ($queryDestinasjon->fetch()) {
                
                 $listBox .= "<option value=".$id. ">ID: ".$id.", Destinasjonsnavn: ".$navn."</option>";
            }
            
            //$htmlSelect .= '</select>';
            //Error logging
            if($queryDestinasjon == false){
                $logg->Ny('Failed to get from db: '.mysql_error($db_connection), 'ERROR', htmlspecialchars($_SERVER['PHP_SELF']), '');    
            }
            
            $queryDestinasjon->close();
            $db_connection->close();  

            return $listBox;

         }
         public function UpdateDestination($id,$flyplassID, $navn,$landskode,$stedsnavn,$geo_lat,$geo_lng, $logg){
            include (realpath(dirname(__FILE__)).'/db.php');
            
            $logg->Ny('Forsøker å oppdatere destinasjon med destinasjonsID '.$id.', med disse data '.$navn.', '.$landskode.', '.$stedsnavn.', '.$geo_lat.', '.$geo_lng);
            
            $sql = "
            update destinasjon 
            set navn= ?, landskode = ?, stedsnavn = ?, geo_lat = ?, geo_lng = ?  = ? where destinsjonId = ?;";
            
            $insertFlyplass = $db_connection->prepare($sql);
            $insertFlyplass->bind_param('isssssi'
                                    ,$flyplassID, $navn,$landskode,$stedsnavn,$geo_lat,$geo_lng,$id);
                                    
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
    

        public function NewDestinasjon($flyplassId, $navn, $landskode, $stedsnavn, $geo_lat, $geo_lng)
        {   
            include (realpath(dirname(__FILE__)).'/db.php');;
            
            $logg->Ny('Forsøker å opprette ny destinasjon.', 'DEBUG', htmlspecialchars($_SERVER['PHP_SELF']), '');
         
            
            $sql = "
                INSERT INTO destinasjon (flyplassId, navn, landskode, stedsnavn, geo_lat, geo_lng)
                            values  (?, ?, ?, ?, ?, ?)";
            
            $insertDestinasjon = $db_connection->prepare($sql);
            $insertDestinasjon->bind_param('ssssss'
                                    , $flyplassId, $navn, $landskode, $stedsnavn, $geo_lat, $geo_lng);
                                    
            $insertDestinasjon->execute();
            $affectedrows=$insertDestinasjon->affected_rows;
        
            
            $logg->Ny('Rows affected: '.$affectedrows, 'DEBUG', htmlspecialchars($_SERVER['PHP_SELF']), '');

            if($insertDestinasjon == false){
                $logg->Ny('Mislyktes å insert: '.mysql_error($db_connection), 'ERROR', htmlspecialchars($_SERVER['PHP_SELF']), '');
                exit;    
            }
            
            if ($affectedrows == 1) {
                $logg->Ny('Ny destinasjon opprettet.', 'DEBUG',htmlspecialchars($_SERVER['PHP_SELF']), '');
            } else {
                $logg->Ny('Klarte ikke å opprette ny destinasjon.', 'ERROR',htmlspecialchars($_SERVER['PHP_SELF']), '');
            } 
                
            //Lukker databasetilkopling
            $insertDestinasjon->close();
            $db_connection->close(); 
            
            return $affectedrows;
        }
        
        
        // OPPDATERER EN DESTINASJON
        public function UpdateDestinasjon ($id, $flyplassId, $navn, $landskode, $stedsnavn, $geo_lat, $geo_lng, $logg)
        {
            include (realpath(dirname(__FILE__)).'/db.php');;
            
            $sql = 
            "UPDATE destinasjon
            SET flyplassId = ?, navn = ?, landskode = ?, stedsnavn =?, geo_lat =?, geo_lng=?
            WHERE destinasjonId = ?;";
            
            $insertDestinasjon = $db_connection->prepare($sql);
            $insertDestinasjon->bind_param('isssssi'
                                    , $flyplassId, $navn, $landskode, $stedsnavn, $geo_lat, $geo_lng, $id);
                                                                        
            $insertDestinasjon->execute();
            $affectedRows = $insertDestinasjon->affected_rows;
            
            $insertDestinasjon->close();
            $db_connection->close(); 
            
            
            $logg->Ny('Rows affected: '.$affectedRows, 'DEBUG', htmlspecialchars($_SERVER['PHP_SELF']), '');

            if($insertDestinasjon == false){
                $logg->Ny('Mislyktes å oppdatere destinasjon informasjon'.mysql_error($db_connection), 'ERROR', htmlspecialchars($_SERVER['PHP_SELF']), '');
                exit;    
            }
            
            if ($affectedRows == 1) {
                $logg->Ny('Destinasjonen ble oppdatert.', 'DEBUG',htmlspecialchars($_SERVER['PHP_SELF']), '');
            } else {
                $logg->Ny('Klarte ikke å oppdatere destinasjonen.', 'ERROR',htmlspecialchars($_SERVER['PHP_SELF']), '');
            } 
                
            //Lukker databasetilkopling
            
            return $affectedRows;
        }
        
        
        // VISE ALLE DESTINASJONER
        public function GetAllDestinasjoner($logg)
        {
            include (realpath(dirname(__FILE__)).'/db.php');;
            
            $sql = "SELECT destinasjonId, navn, flyplassId, landskode, geo_lat, geo_lng FROM destinasjon;";
            
            $queryDestinasjon = $db_connection->prepare($sql);
            
            $queryDestinasjon->execute();
            
            //henter result set
            $resultSet = $queryDestinasjon->get_result();
            
            $destinasjon =  $resultSet->fetch_all();
            
            //Error logging
            if($queryDestinasjon == false){
                $logg->Ny('Mislyktes å hente fra db: '.mysql_error($db_connection), 'ERROR', htmlspecialchars($_SERVER['PHP_SELF']), '');    
            }
            
            $resultSet->free();
            $queryDestinasjon->close();
            $db_connection->close(); 
            
            return $destinasjon;
        }
        
        
        //VISE EN DESTINASJON WHERE destinasjonId = ?
        public function GetDestinasjon($destinasjonId, $logg)
        {
            include (realpath(dirname(__FILE__)).'/db.php');;
            
            $sql = "SELECT destinasjonId, navn, flyplassId, landskode, stedsnavn, geo_lat, geo_lng 
                    FROM destinasjon WHERE destinasjonId=?;";
            
            $queryDestinasjon = $db_connection->prepare($sql);
            
            $queryDestinasjon->bind_param('i'
                                    , $destinasjonId);
            
            $queryDestinasjon->execute();
            
            //henter result set
            $resultSet = $queryDestinasjon->get_result();
            
            $destinasjon =  $resultSet->fetch_all();
            
            //Error logging
            if($queryDestinasjon == false){
                $logg->Ny('Mislyktes å hente fra db: '.mysql_error($db_connection), 'ERROR', htmlspecialchars($_SERVER['PHP_SELF']), '');    
            }
            
            $resultSet->free();
            $queryDestinasjon->close();
            $db_connection->close(); 
            
            return $destinasjon;
        } 
        
        //VISER DESTINASJONER BASERT PÅ RUTER WHERE fraDestId = ?
        public function GetDestinasjoner($destinasjonId, $logg)
        {
            include (realpath(dirname(__FILE__)).'/db.php');;
            
            $sql = "
                    SELECT distinct a.tilDestId,d.navn as til
                    FROM avgang a
                    inner join destinasjon d on a.tilDestId = d.destinasjonId
                    where fraDestId = ?;";
            
            $queryDestinasjoner = $db_connection->prepare($sql);
            
            $queryDestinasjoner->bind_param('i'
                                    , $destinasjonId);
            
            $queryDestinasjoner->execute();
            
            //henter result set
            $resultSet = $queryDestinasjoner->get_result();
            
            $destinasjoner =  $resultSet->fetch_all();
            
            //Error logging
            if($queryDestinasjoner == false){
                $logg->Ny('Mislyktes å hente fra db: '.mysql_error($db_connection), 'ERROR', htmlspecialchars($_SERVER['PHP_SELF']), '');    
            }
            
            $resultSet->free();
            $queryDestinasjoner->close();
            $db_connection->close(); 
            
            return $destinasjoner;
        } 
        
        //SLETTE EN DESTINASJON WHERE destinasjonId = ?
         public function DeleteDestinasjon($destinasjonId, $logg)
         {
            include (realpath(dirname(__FILE__)).'/db.php');;
            
            $sql = "DELETE FROM destinasjon WHERE destinasjonId=?;";
            
            $deleteDestinasjon = $db_connection->prepare($sql);
            
            $deleteDestinasjon->bind_param('i'
                                    , $destinasjonId);
            
            $deleteDestinasjon->execute();
            
            $paavirkedeRader = $deleteDestinasjon->affected_rows;

            
            //Error logging
            if($deleteDestinasjon == false)
            {
                $logg->Ny('Mislyktes å slette data fra db: '.mysql_error($db_connection), 'ERROR', htmlspecialchars($_SERVER['PHP_SELF']), '');    
            }
            
            // Lukker databasen
            $deleteDestinasjon->close();
            $db_connection->close(); 
            
            return $paavirkedeRader;
            
         }

    }
    
    
    
<?php
    class Destinasjon
    {
        
        // OPPRETTE NY DESTINASJON
        public function Destinasjon()
        {
            
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
        public function UpdateDestinasjon ($flyplassId, $navn, $landskode, $stedsnavn, $geo_lat, $geo_lng)
        {
            include (realpath(dirname(__FILE__)).'/db.php');;
            
            $sql = 
            "UPDATE destinasjon
            SET navn = ?
            WHERE destinasjonId = ?;";
            
            $insertDestinasjon = $db_connection->prepare($sql);
            $insertDestinasjon->bind_param('ssssss'
                                    , $flyplassId, $navn, $landskode, $stedsnavn, $geo_lat, $geo_lng);
                                                                        
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
    
    
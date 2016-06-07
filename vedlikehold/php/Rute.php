<?php
    class Rute
{
        
        // OPPRETTE NY RUTE
        public function Rute()
        {
            
        }
      
        public function NewRute($fraDestId, $tilDestid, $sesongId, $navn)
        {   
            include (realpath(dirname(__FILE__)).'/db.php');;
            
            $logg->Ny('Forsøker å opprette ny rute.', 'DEBUG', htmlspecialchars($_SERVER['PHP_SELF']), '');
         
            
            $sql = "
                INSERT INTO rute (fraDestId, tilDestId, sesongId, navn)
                            values (?, ?, ?, ?)";
            
            $insertRute = $db_connection->prepare($sql);
            $insertRute->bind_param('ssss'
                                    , $fraDestId, $tilDestid, $sesongId, $navn);
                                    
            $insertRute->execute();
            $affectedrows=$insertRute->affected_rows;
           
            
            $logg->Ny('Rows affected: '.$affectedrows, 'DEBUG', htmlspecialchars($_SERVER['PHP_SELF']), '');

            if($insertRute == false){
                $logg->Ny('Mislyktes å insert: '.mysql_error($db_connection), 'ERROR', htmlspecialchars($_SERVER['PHP_SELF']), '');
                exit;    
            }
            
            if ($affectedrows == 1) {
                $logg->Ny('Ny rute opprettet.', 'DEBUG',htmlspecialchars($_SERVER['PHP_SELF']), '');
            } else {
                $logg->Ny('Klarte ikke å opprette ny rute.', 'ERROR',htmlspecialchars($_SERVER['PHP_SELF']), '');
            } 
                
            //Lukker databasetilkopling
            $insertRute->close();
            $db_connection->close(); 
            
            return $affectedrows;
        }
        
        
        // OPPDATERER EN RUTE
        public function UpdateAvgang ($fraDestId, $tilDestid, $sesongId, $navn)
        {
            include (realpath(dirname(__FILE__)).'/db.php');;
            
            $sql = 
            "UPDATE rute
            SET navn = ?
            WHERE ruteId = ?;";
            
            $insertRute = $db_connection->prepare($sql);
            $insertRute->bind_param('ssss'
                                    , $fraDestId, $tilDestid, $sesongId, $navn);
                                                                        
            $insertRute->execute();
            $affectedRows = $insertRute->affected_rows;
            
            $insertRute->close();
            $db_connection->close(); 
            
            
            $logg->Ny('Rows affected: '.$affectedRows, 'DEBUG', htmlspecialchars($_SERVER['PHP_SELF']), '');

            if($insertRute == false){
                $logg->Ny('Mislyktes å oppdatere rute informasjon'.mysql_error($db_connection), 'ERROR', htmlspecialchars($_SERVER['PHP_SELF']), '');
                exit;    
            }
            
            if ($affectedRows == 1) {
                $logg->Ny('Ruten ble oppdatert.', 'DEBUG',htmlspecialchars($_SERVER['PHP_SELF']), '');
            } else {
                $logg->Ny('Klarte ikke å oppdatere ruten.', 'ERROR',htmlspecialchars($_SERVER['PHP_SELF']), '');
            } 
                
            //Lukker databasetilkopling
            
            return $affectedRows;
        }
        
        
        // VISE ALLE RUTER
        public function GetAllRuter($logg)
        {
            include (realpath(dirname(__FILE__)).'/db.php');;
            
            $sql = "SELECT ruteId, fraDestId, tilDestId, sesongId, navn FROM rute;";
            
            $queryRute = $db_connection->prepare($sql);
            
            $queryRute->execute();
            
            //henter result set
            $resultSet = $queryRute->get_result();
            
            $rute =  $resultSet->fetch_all();
            
            //Error logging
            if($queryRute == false){
                $logg->Ny('Mislyktes å hente fra db: '.mysql_error($db_connection), 'ERROR', htmlspecialchars($_SERVER['PHP_SELF']), '');    
            }
            
            $resultSet->free();
            $queryRute->close();
            $db_connection->close(); 
            
            return $rute;
        }
        
        
        //VISE EN RUTE WHERE ruteId = ?
        public function getRute($ruteId, $logg)
        {
            include (realpath(dirname(__FILE__)).'/db.php');;
            
            $sql = "SELECT ruteId, fraDestId, tilDestId, sesongId, navn FROM rute WHERE ruteId=?;";
            
            $queryRute = $db_connection->prepare($sql);
            
            $queryRute->bind_param('i'
                                    , $ruteId);
            
            $queryRute->execute();
            
            //henter result set
            $resultSet = $queryRute->get_result();
            
            $rute =  $resultSet->fetch_all();
            
            //Error logging
            if($queryRute == false){
                $logg->Ny('Mislyktes å hente fra db: '.mysql_error($db_connection), 'ERROR', htmlspecialchars($_SERVER['PHP_SELF']), '');    
            }
            
            $resultSet->free();
            $queryRute->close();
            $db_connection->close(); 
            
            return $rute;
        } 
        
        
        //SLETTE EN RUTE WHERE ruteId = ?
         public function DeleteRute($ruteId, $logg)
         {
            include (realpath(dirname(__FILE__)).'/db.php');;
            
            $sql = "DELETE from rute WHERE ruteId=?;";
            
            $deleteRute = $db_connection->prepare($sql);
            
            $deleteRute->bind_param('i'
                                    , $ruteId);
            
            $deleteRute->execute();
            
            $paavirkedeRader = $deleteRute->affected_rows;

            
            //Error logging
            if($deleteRute == false)
            {
                $logg->Ny('Mislyktes å slette data fra db: '.mysql_error($db_connection), 'ERROR', htmlspecialchars($_SERVER['PHP_SELF']), '');    
            }
            
            // Lukker databasen
            $deleteRute->close();
            $db_connection->close(); 
            
            return $paavirkedeRader;
            
         }
       
 }    
    
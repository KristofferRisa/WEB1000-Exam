<?php
    class Avgang
{
        
        // OPPRETTE NY AVGANG
        public function Avgang()
        {
            
        }
      
        public function NewAvgang($ruteId, $fraFlyplassId, $tilFlyplassId, $direkte, $avgang, $reiseTid, $ukedagNr, $klokkeslett,
                                  $fastPris)
        {   
            include('db.php');
            
            $logg->Ny('Forsøker å opprette ny avgang.', 'DEBUG', htmlspecialchars($_SERVER['PHP_SELF']), '');
         
            
            $sql = "
                INSERT INTO avgang (ruteId, fraFlyplassId, tilFlyplassId, direkte, avgang, reiseTid, ukedagNr, klokkeslett,
                                    fastPris)
                            values (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            
            $insertAvgang = $db_connection->prepare($sql);
            $insertAvgang->bind_param('sssssssss'
                                    , $ruteId, $fraFlyplassId, $tilFlyplassId, $direkte, $avgang, $reiseTid, $ukedagNr, $klokkeslett,
                                      $fastPris);
                                    
            $insertAvgang->execute();
            $affectedrows=$insertAvgang->affected_rows;
           
            
            $logg->Ny('Rows affected: '.$affectedrows, 'DEBUG', htmlspecialchars($_SERVER['PHP_SELF']), '');

            if($insertAvgang == false){
                $logg->Ny('Mislyktes å insert: '.mysql_error($db_connection), 'ERROR', htmlspecialchars($_SERVER['PHP_SELF']), '');
                exit;    
            }
            
            if ($affectedrows == 1) {
                $logg->Ny('Ny avgang opprettet.', 'DEBUG',htmlspecialchars($_SERVER['PHP_SELF']), '');
            } else {
                $logg->Ny('Klarte ikke å opprette ny avgang.', 'ERROR',htmlspecialchars($_SERVER['PHP_SELF']), '');
            } 
                
            //Lukker databasetilkopling
            $insertAvgang->close();
            $db_connection->close(); 
            
            return $affectedrows;
        }
        
        
        // OPPDATERER EN AVGANG
        public function UpdateAvgang ($ruteId, $fraFlyplassId, $tilFlyplassId, $direkte, $avgang, $reiseTid, $ukedagNr, $klokkeslett,
                                     $fastPris)
        {
            include('db.php');
            
            $sql = 
            "UPDATE avgang
            SET navn = ?
            WHERE avgangId = ?;";
            
            $insertAvgang = $db_connection->prepare($sql);
            $insertAvgang->bind_param('sssssssss'
                                    , $ruteId, $fraFlyplassId, $tilFlyplassId, $direkte, $avgang, $reiseTid, $ukedagNr, $klokkeslett,
                                     $fastPris);
                                                                        
            $insertAvgang->execute();
            $affectedRows = $insertAvgang->affected_rows;
            
            $insertAvgang->close();
            $db_connection->close(); 
            
            
            $logg->Ny('Rows affected: '.$affectedRows, 'DEBUG', htmlspecialchars($_SERVER['PHP_SELF']), '');

            if($insertAvgang == false){
                $logg->Ny('Mislyktes å oppdatere avgangs informasjon'.mysql_error($db_connection), 'ERROR', htmlspecialchars($_SERVER['PHP_SELF']), '');
                exit;    
            }
            
            if ($affectedRows == 1) {
                $logg->Ny('Avgangen ble oppdatert.', 'DEBUG',htmlspecialchars($_SERVER['PHP_SELF']), '');
            } else {
                $logg->Ny('Klarte ikke å oppdatere avgangen.', 'ERROR',htmlspecialchars($_SERVER['PHP_SELF']), '');
            } 
                
            //Lukker databasetilkopling
            
            return $affectedRows;
        }
        
        
        // VISE ALLE AVGANGER
        public function GetAllAvganger($logg)
        {
            include('db.php');
            
            $sql = "SELECT avgangId, ruteId, fraFlyplassId, tilFlyplassId, direkte, avgang, reiseTid, ukedagNr, klokkeslett, fastpris 
                    FROM avgang;";
            
            $queryAvgang = $db_connection->prepare($sql);
            
            $queryAvgang->execute();
            
            //henter result set
            $resultSet = $queryAvgang->get_result();
            
            $avgang =  $resultSet->fetch_all();
            
            //Error logging
            if($queryAvgang == false){
                $logg->Ny('Mislyktes å hente fra db: '.mysql_error($db_connection), 'ERROR', htmlspecialchars($_SERVER['PHP_SELF']), '');    
            }
            
            $resultSet->free();
            $queryAvgang->close();
            $db_connection->close(); 
            
            return $avgang;
        }
        
        
        //VISE EN AVGANG WHERE avgangId = ?
        public function GetAvgang ($avgangId, $logg)
        {
            include('db.php');
            
            $sql = "SELECT avgangId, ruteId, fraFlyplassId, tilFlyplassId, direkte, avgang, reiseTid, ukedagNr, klokkeslett, fastpris 
                    FROM avgang WHERE avgangId= ?;";
            
            $queryAvgang = $db_connection->prepare($sql);
            
            $queryAvgang->bind_param('i'
                                    , $avgangId);
            
            $queryAvgang->execute();
            
            //henter result set
            $resultSet = $queryAvgang->get_result();
            
            $avgang =  $resultSet->fetch_all();
            
            //Error logging
            if($queryAvgang == false){
                $logg->Ny('Mislyktes å hente fra db: '.mysql_error($db_connection), 'ERROR', htmlspecialchars($_SERVER['PHP_SELF']), '');    
            }
            
            $resultSet->free();
            $queryAvgang->close();
            $db_connection->close(); 
            
            return $avgang;
        } 
        
        
        //SLETTE EN AVGANG WHERE avgangId = ?
         public function DeleteAvgang($avgangId, $logg)
         {
            include('db.php');
            
            $sql = "DELETE FROM avgang WHERE avgangId=?;";
            
            $deleteAvgang = $db_connection->prepare($sql);
            
            $deleteAvgang->bind_param('i'
                                    , $avgangId);
            
            $deleteAvgang->execute();
            
            $påvirkedeRader = $deleteAvgang->affected_rows;

            
            //Error logging
            if($deleteAvgang == false)
            {
                $logg->Ny('Mislyktes å slette data fra db: '.mysql_error($db_connection), 'ERROR', htmlspecialchars($_SERVER['PHP_SELF']), '');    
            }
            
            // Lukker databasen
            $deleteAvgang->close();
            $db_connection->close(); 
            
            return $påvirkedeRader;
            
         }
       
 }    
    
    
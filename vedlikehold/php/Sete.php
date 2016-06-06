<?php
    class Sete
{
        
        // OPPRETTE NY SETE
        public function Sete()
        {
            
        }
      
        public function NewSete ($flyId, $prisKategoriId, $seteNr, $nodutgang, $forklaring)
        {   
            include('db.php');
            
            $logg->Ny('Forsøker å opprette ny sete.', 'DEBUG', htmlspecialchars($_SERVER['PHP_SELF']), '');
         
            
            $sql = "
                INSERT INTO sete (flyId, prisKategoriId, seteNr, nodutgang, forklaring)
                            values (?, ?, ?, ?, ?)";
            
            $insertSete = $db_connection->prepare($sql);
            $insertSete->bind_param('sssss'
                                    , $flyId, $prisKategoriId, $seteNr, $nodutgang, $forklaring);
                                    
            $insertSete->execute();
            $affectedrows=$insertSete->affected_rows;
           
            
            $logg->Ny('Rows affected: '.$affectedrows, 'DEBUG', htmlspecialchars($_SERVER['PHP_SELF']), '');

            if($insertSete == false){
                $logg->Ny('Mislyktes å insert: '.mysql_error($db_connection), 'ERROR', htmlspecialchars($_SERVER['PHP_SELF']), '');
                exit;    
            }
            
            if ($affectedrows == 1) {
                $logg->Ny('Ny sete opprettet.', 'DEBUG',htmlspecialchars($_SERVER['PHP_SELF']), '');
            } else {
                $logg->Ny('Klarte ikke å opprette ny sete.', 'ERROR',htmlspecialchars($_SERVER['PHP_SELF']), '');
            } 
                
            //Lukker databasetilkopling
            $insertSete->close();
            $db_connection->close(); 
            
            return $affectedrows;
        }
        
        
        // OPPDATERER EN SETE
        public function UpdateSete ($flyId, $prisKategoriId, $seteNr, $nodutgang, $forklaring)
        {
            include('db.php');
            
            $sql = 
            "UPDATE sete
            SET navn = ?
            WHERE seteId = ?;";
            
            $insertSete = $db_connection->prepare($sql);
            $insertSete->bind_param('sssss'
                                    , $flyId, $prisKategoriId, $seteNr, $nodutgang, $forklaring);
                                                                        
            $insertSete->execute();
            $affectedRows = $insertSete->affected_rows;
            
            $insertSete->close();
            $db_connection->close(); 
            
            
            $logg->Ny('Rows affected: '.$affectedRows, 'DEBUG', htmlspecialchars($_SERVER['PHP_SELF']), '');

            if($insertSete == false){
                $logg->Ny('Mislyktes å oppdatere sete informasjon'.mysql_error($db_connection), 'ERROR', htmlspecialchars($_SERVER['PHP_SELF']), '');
                exit;    
            }
            
            if ($affectedRows == 1) {
                $logg->Ny('Sete ble oppdatert.', 'DEBUG',htmlspecialchars($_SERVER['PHP_SELF']), '');
            } else {
                $logg->Ny('Klarte ikke å oppdatere setet.', 'ERROR',htmlspecialchars($_SERVER['PHP_SELF']), '');
            } 
                
            //Lukker databasetilkopling
            
            return $affectedRows;
        }
        
        
        // VISE ALLE SETER
        public function GetAllSeter($logg)
        {
            include('db.php');
            
            $sql = "SELECT seteId, flyId, prisKategoriId, SeteNr, nodutgang, forklaring FROM sete;";
            
            $querySete = $db_connection->prepare($sql);
            
            $querySete->execute();
            
            //henter result set
            $resultSet = $querySete->get_result();
            
            $sete =  $resultSet->fetch_all();
            
            //Error logging
            if($querySete == false){
                $logg->Ny('Mislyktes å hente fra db: '.mysql_error($db_connection), 'ERROR', htmlspecialchars($_SERVER['PHP_SELF']), '');    
            }
            
            $resultSet->free();
            $querySete->close();
            $db_connection->close(); 
            
            return $sete;
        }
        
        
        //VISE EN SETE WHERE seteId = ?
        public function getSete($seteId, $logg)
        {
            include('db.php');
            
            $sql = "SELECT seteId, flyId, prisKategoriId, seteNr, nodutgang, forklaring FROM sete WHERE seteId=?;";
            
            $querySete = $db_connection->prepare($sql);
            
            $querySete->bind_param('i'
                                    , $seteId);
            
            $querySete->execute();
            
            //henter result set
            $resultSet = $querySete->get_result();
            
            $sete =  $resultSet->fetch_all();
            
            //Error logging
            if($querySete == false){
                $logg->Ny('Mislyktes å hente fra db: '.mysql_error($db_connection), 'ERROR', htmlspecialchars($_SERVER['PHP_SELF']), '');    
            }
            
            $resultSet->free();
            $querySete->close();
            $db_connection->close(); 
            
            return $sete;
        } 
        
        
        //SLETTE ET SETE WHERE seteId = ?
         public function DeleteSete($seteId, $logg)
         {
            include('db.php');
            
            $sql = "DELETE FROM sete WHERE seteId=?;";
            
            $deleteSete = $db_connection->prepare($sql);
            
            $deleteSete->bind_param('i'
                                    , $seteId);
            
            $deleteSete->execute();
            
            $paavirkedeRader = $deleteSete->affected_rows;

            
            //Error logging
            if($deleteSete == false)
            {
                $logg->Ny('Mislyktes å slette data fra db: '.mysql_error($db_connection), 'ERROR', htmlspecialchars($_SERVER['PHP_SELF']), '');    
            }
            
            // Lukker databasen
            $deleteSete->close();
            $db_connection->close(); 
            
            return $paavirkedeRader;
            
         }
       
 }    
    
<?php
    class Bestilling
{
        
        // OPPRETTE NY BESTILLING
        public function Bestilling()
        {
            
        }
      
        public function NewBestilling($bestillingsDato, $refNo, $reiseDato, $returDato, $bestillerFornavn,$bestillerEtternavn, $bestillerEpost, $bestillerTlf,
                                      $antallVoksne, $antallBarn, $antallBebis)
        {   
            include('db.php');
            
            $logg->Ny('Forsøker å opprette ny bestilling.', 'DEBUG', htmlspecialchars($_SERVER['PHP_SELF']), '');
         
            
            $sql = "
                INSERT INTO bestilling (bestillingsDato, refNo, reiseDato, returDato, bestillerFornavn, bestillerEtternavn, bestillerEpost, bestillerTlf,
                                       antallVoksne, antallBarn, antallBebis) 
                            values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            
            $insertBestilling = $db_connection->prepare($sql);
            $insertBestilling->bind_param('sssssssssss'
                                    , $bestillingsDato, $refNo, $reiseDato, $returDato, $bestillerFornavn,$bestillerEtternavn, $bestillerEpost, $bestillerTlf,
                                      $antallVoksne, $antallBarn, $antallBebis);
                                    
            $insertBestilling->execute();
            $affectedrows=$insertBestilling->affected_rows;
           
            
            $logg->Ny('Rows affected: '.$affectedrows, 'DEBUG', htmlspecialchars($_SERVER['PHP_SELF']), '');

            if($insertCustomer == false){
                $logg->Ny('Mislyktes å insert: '.mysql_error($db_connection), 'ERROR', htmlspecialchars($_SERVER['PHP_SELF']), '');
                exit;    
            }
            
            if ($affectedrows == 1) {
                $logg->Ny('Ny bestilling opprettet.', 'DEBUG',htmlspecialchars($_SERVER['PHP_SELF']), '');
            } else {
                $logg->Ny('Klarte ikke å opprette ny bestilling.', 'ERROR',htmlspecialchars($_SERVER['PHP_SELF']), '');
            } 
                
            //Lukker databasetilkopling
            $insertBestilling->close();
            $db_connection->close(); 
            
            return $affectedrows;
        }
        
        
        // OPPDATERER EN BESTILLING
        public function UpdateBestilling ($bestillingsDato, $refNo, $reiseDato, $returDato, $bestillerFornavn,$bestillerEtternavn, $bestillerEpost, $bestillerTlf,
                                      $antallVoksne, $antallBarn, $antallBebis)
        {
            include('db.php');
            
            $sql = 
            "UPDATE bestilling
            SET navn = ?
            WHERE bestillingId = ?;";
            
            $insertBestilling = $db_connection->prepare($sql);
            $insertBestilling->bind_param('sssssssssss'
                                    , $bestillingDato, $refNo, $reiseDato, $returDato, $bestillerFornavn, $bestillerEtternavn, $bestillerEpost, $bestillerTlf,
                                      $antallVoksne, $antallBarn, $antallBebis);
                                                                        
            $insertCustomer->execute();
            $affectedRows = $insertCustomer->affected_rows;
            
            $insertCustomer->close();
            $db_connection->close(); 
            
            
            $logg->Ny('Rows affected: '.$affectedRows, 'DEBUG', htmlspecialchars($_SERVER['PHP_SELF']), '');

            if($insertCustomer == false){
                $logg->Ny('Mislyktes å oppdatere bestilling informasjon'.mysql_error($db_connection), 'ERROR', htmlspecialchars($_SERVER['PHP_SELF']), '');
                exit;    
            }
            
            if ($affectedRows == 1) {
                $logg->Ny('Bestillingen ble oppdatert.', 'DEBUG',htmlspecialchars($_SERVER['PHP_SELF']), '');
            } else {
                $logg->Ny('Klarte ikke å oppdatere bestilling.', 'ERROR',htmlspecialchars($_SERVER['PHP_SELF']), '');
            } 
                
            //Lukker databasetilkopling
            
            return $affectedRows;
        }
        
        
        // VISE ALLE BESTILLINGER
        public function GetAllBestilling($logg)
        {
            include('db.php');
            
            $sql = "SELECT bestillingId, bestillingDato, refNo, reiseDato, returDato, bestillerFornavn, bestillerEtternavn, bestillerEpost, bestillerTlf, antallVoksne, antallBarn, antallBebis
                    FROM bestilling;";
            
            $queryBestilling = $db_connection->prepare($sql);
            
            $queryBestilling->execute();
            
            //henter result set
            $resultSet = $queryBestilling->get_result();
            
            $bestilling =  $resultSet->fetch_all();
            
            //Error logging
            if($queryBestilling == false){
                $logg->Ny('Mislyktes å hente fra db: '.mysql_error($db_connection), 'ERROR', htmlspecialchars($_SERVER['PHP_SELF']), '');    
            }
            
            $resultSet->free();
            $queryBestilling->close();
            $db_connection->close(); 
            
            return $bestilling;
        }
        
        
        //VISE EN BESTILLING WHERE bestillingId = ?
        public function GetBestilling($bestillingId, $logg)
        {
            include('db.php');
            
            $sql = "SELECT bestillingId, bestillingDato, refNo, reiseDato, returDato, bestillerFornavn, bestillerEtternavn, bestillerEpost, bestillerTlf, antallVoksne, antallBarn, antallBebis
                    FROM bestilling WHERE bestillingId=?;";
            
            $queryBestilling = $db_connection->prepare($sql);
            
            $queryBestilling->bind_param('i'
                                    , $bestillingId);
            
            $queryBestilling->execute();
            
            //henter result set
            $resultSet = $queryBestilling->get_result();
            
            $bestilling =  $resultSet->fetch_all();
            
            //Error logging
            if($queryBestilling == false){
                $logg->Ny('Mislyktes å hente fra db: '.mysql_error($db_connection), 'ERROR', htmlspecialchars($_SERVER['PHP_SELF']), '');    
            }
            
            $resultSet->free();
            $queryBestilling->close();
            $db_connection->close(); 
            
            return $customer;
        } 
        
        
        //SLETTE EN BESTILLING WHERE bestillingId = ?
         public function DeleteBestilling($bestillingId, $logg)
         {
            include('db.php');
            
            $sql = "DELETE from bestilling WHERE bestillingId=?;";
            
            $deleteBestilling = $db_connection->prepare($sql);
            
            $deleteBestilling->bind_param('i'
                                    , $bestillingId);
            
            $deleteBestilling->execute();
            
            $påvirkedeRader = $deleteBestilling->affected_rows;

            
            //Error logging
            if($deleteBestilling == false)
            {
                $logg->Ny('Mislyktes å slette data fra db: '.mysql_error($db_connection), 'ERROR', htmlspecialchars($_SERVER['PHP_SELF']), '');    
            }
            
            // Lukker databasen
            $deleteBestilling->close();
            $db_connection->close(); 
            
            return $påvirkedeRader;
            
         }
       
 }    
    
    
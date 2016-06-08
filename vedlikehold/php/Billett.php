<?php
    class Billett
{
        
        // OPPRETTE NY BILLETT
        public function Billett()
        {
            
        }
      
        // public function NewBillett($bestillingId, $avgangId, $seteId, $fornavn, $etternavn, $kjonn, $antBagasje)
        // {   
        //     include (realpath(dirname(__FILE__)).'/db.php');;
            
        //     $logg->Ny('Forsøker å opprette ny billett.', 'DEBUG', htmlspecialchars($_SERVER['PHP_SELF']), '');
         
            
        //     $sql = "
        //         INSERT INTO billett (bestillingId, avgangId, seteId, fornavn, etternavn, kjonn, antBagasje)
        //                     values  (?, ?, ?, ?, ?, ?, ?)";
            
        //     $insertBillett = $db_connection->prepare($sql);
        //     $insertBillett->bind_param('sssssss'
        //                             , $bestillingId, $avgangId, $seteId, $fornavn, $etternavn, $kjonn, $antBagasje);
                                    
        //     $insertBillett->execute();
        //     $affectedrows=$insertBillett->affected_rows;
           
            
        //     $logg->Ny('Rows affected: '.$affectedrows, 'DEBUG', htmlspecialchars($_SERVER['PHP_SELF']), '');

        //     if($insertBillett == false){
        //         $logg->Ny('Mislyktes å insert: '.mysql_error($db_connection), 'ERROR', htmlspecialchars($_SERVER['PHP_SELF']), '');
        //         exit;    
        //     }
            
        //     if ($affectedrows == 1) {
        //         $logg->Ny('Ny billett opprettet.', 'DEBUG',htmlspecialchars($_SERVER['PHP_SELF']), '');
        //     } else {
        //         $logg->Ny('Klarte ikke å opprette ny billett.', 'ERROR',htmlspecialchars($_SERVER['PHP_SELF']), '');
        //     } 
                
        //     //Lukker databasetilkopling
        //     $insertBillett->close();
        //     $db_connection->close(); 
            
        //     return $affectedrows;
        // }
        
        
        // OPPDATERER EN BILLETT
        public function UpdateBillett ($bestillingId, $avgangId, $seteId, $fornavn, $etternavn, $kjonn, $antBagasje)
        {
            include (realpath(dirname(__FILE__)).'/db.php');;
            
            $sql = 
            "UPDATE billett
            SET navn = ?
            WHERE billettId = ?;";
            
            $insertBillett = $db_connection->prepare($sql);
            $insertBillett->bind_param('sssssss'
                                    , $bestillingId, $avgangId, $seteId, $fornavn, $etternavn, $kjonn, $antBagasje);
                                                                        
            $insertBillett->execute();
            $affectedRows = $insertBillett->affected_rows;
            
            $insertBillett->close();
            $db_connection->close(); 
            
            
            $logg->Ny('Rows affected: '.$affectedRows, 'DEBUG', htmlspecialchars($_SERVER['PHP_SELF']), '');

            if($insertBillett == false){
                $logg->Ny('Mislyktes å oppdatere billett informasjon'.mysql_error($db_connection), 'ERROR', htmlspecialchars($_SERVER['PHP_SELF']), '');
                exit;    
            }
            
            if ($affectedRows == 1) {
                $logg->Ny('Billetten ble oppdatert.', 'DEBUG',htmlspecialchars($_SERVER['PHP_SELF']), '');
            } else {
                $logg->Ny('Klarte ikke å oppdatere billetten.', 'ERROR',htmlspecialchars($_SERVER['PHP_SELF']), '');
            } 
                
            //Lukker databasetilkopling
            
            return $affectedRows;
        }
        
        
        // VISE ALLE BILLETTER
        public function GetAllBillett($logg)
        {
            include (realpath(dirname(__FILE__)).'/db.php');;
            
            $sql = "SELECT billettId, bestillingId, avgangId, seteId, fornavn, etternavn, kjonn, antBagasje FROM billett;";
            
            $queryBillett = $db_connection->prepare($sql);
            
            $queryBillett->execute();
            
            //henter result set
            $resultSet = $queryBillett->get_result();
            
            $billett =  $resultSet->fetch_all();
            
            //Error logging
            if($queryBillett == false){
                $logg->Ny('Mislyktes å hente fra db: '.mysql_error($db_connection), 'ERROR', htmlspecialchars($_SERVER['PHP_SELF']), '');    
            }
            
            $resultSet->free();
            $queryBillett->close();
            $db_connection->close(); 
            
            return $billett;
        }
        
        
        //VISE EN BILLETT WHERE billettId = ?
        public function GetBillett($billettId, $logg)
        {
            include (realpath(dirname(__FILE__)).'/db.php');;
            
            $sql = "SELECT billettId, bestillingId, avgangId, seteId, fornavn, etternavn, kjonn, antBagasje 
                    FROM billett WHERE billettId=?;";
            
            $queryBillett = $db_connection->prepare($sql);
            
            $queryBillett->bind_param('i'
                                    , $billettId);
            
            $queryBillett->execute();
            
            //henter result set
            $resultSet = $queryBillett->get_result();
            
            $billett =  $resultSet->fetch_all();
            
            //Error logging
            if($queryBillett == false){
                $logg->Ny('Mislyktes å hente fra db: '.mysql_error($db_connection), 'ERROR', htmlspecialchars($_SERVER['PHP_SELF']), '');    
            }
            
            $resultSet->free();
            $queryBillett->close();
            $db_connection->close(); 
            
            return $billett;
        } 
        
        
        //SLETTE EN BILLETT WHERE billettId = ?
         public function DeleteBillett($billettId, $logg)
         {
            include (realpath(dirname(__FILE__)).'/db.php');;
            
            $sql = "DELETE from billett WHERE billettId=?;";
            
            $deleteBillett = $db_connection->prepare($sql);
            
            $deleteBillett->bind_param('i'
                                    , $billettId);
            
            $deleteBillett->execute();
            
            $paavirkedeRader = $deleteBillett->affected_rows;

            
            //Error logging
            if($deleteBillett == false)
            {
                $logg->Ny('Mislyktes å slette data fra db: '.mysql_error($db_connection), 'ERROR', htmlspecialchars($_SERVER['PHP_SELF']), '');    
            }
            
            // Lukker databasen
            $deleteBillett->close();
            $db_connection->close(); 
            
            return $paavirkedeRader;
            
         }
       
 }    
    
    
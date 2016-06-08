<?php
    class Bestilling
{
        
        // OPPRETTE NY BESTILLING
        public function Bestilling()
        {
            
        }
      
        //Lager en bestilling rad og setter inn billetter pr reisene
        public function NewBestilling($bestillingsDato, $refNo, $reiseDato, $returDato, $bestillerFornavn,$bestillerEtternavn, $bestillerEpost, $bestillerTlf,
                                      $antallVoksne, $antallBarn, $antallBebis,$logg, $reisende)
        {   
            include (realpath(dirname(__FILE__)).'/db.php');;
            
            $logg->Ny('Reisende: '.print_r($reisende));
            
            $sql = "
            start transaction;

            INSERT INTO bestilling (bestillingsDato, refNo, reiseDato, returDato, bestillerFornavn, bestillerEtternavn, bestillerEpost, bestillerTlf,
                    antallVoksne, antallBarn, antallBebis) 
            values ( ?
                    , ?
                    , ?
                    , ?
                    , ?
                    , ?
                    , ?
                    , ?
                    , ?
                    , ?
                    , ?);

            select @bestillingId := max(bestillingId) from bestilling;";

            
            foreach ($reisende as $key => $person) {
                $sql .= "
                INSERT INTO billett (bestillingId, avgangId, seteId, fornavn, etternavn, kjonn, antBagasje)  
                VALUES  (@bestillingId, '".$person[0]."','".$person[1]."', '".$person[2]."', '".$person[3]."', '".$person[4]."', '".$person[5]."', '".$person[6]."');
                ";
            }
            
            $logg->Ny('Generer SQL for billetter, SQL: '.$sql);
            
            $sql .= "commit;";
            
            $logg->Ny('Forsøker å opprette ny bestilling.', 'DEBUG', htmlspecialchars($_SERVER['PHP_SELF']), '');
           
            $insertBestilling = $db_connection->prepare($sql);
            
            $insertBestilling->bind_param('sssssssssss'
                                        , $bestillingsDato
                                        , $refNo
                                        , $reiseDato
                                        , $returDato
                                        , $bestillerFornavn
                                        , $bestillerEtternavn
                                        , $bestillerEpost
                                        , $bestillerTlf
                                        , $antallVoksne
                                        , $antallBarn
                                        , $antallBebis);
                                    
            $insertBestilling->execute();
            $affectedrows=$insertBestilling->affected_rows;
            
            
            //hent bestillingID?
            //lag billett pr kunde?
            //sjekk av ledig kapasistet...?
            
            $logg->Ny('Rows affected: '.$affectedrows, 'DEBUG', htmlspecialchars($_SERVER['PHP_SELF']), '');

            if($insertBestilling == false){
                $logg->Ny('Mislyktes å insert: '.mysql_error($db_connection), 'ERROR', htmlspecialchars($_SERVER['PHP_SELF']), '');
                exit;    
            }
            
            if ($affectedrows == 1) {
                $logg->Ny('Ny bestilling opprettet.', 'DEBUG',htmlspecialchars($_SERVER['PHP_SELF']), '');
            } else {
                
                $logg->Ny('Klarte ikke å opprette ny bestilling.', 'ERROR',htmlspecialchars($_SERVER['PHP_SELF']), '');
                $logg->Ny('BestillingDato = '.$bestillingDato.' & refNo = '.$refNo,'ERROR');
                $logg->Ny('ReiseDato = '.$reiseDato.' & returDato = '.$returDato,'ERROR');
                $logg->Ny('Navn = '.$bestillerFornavn.' '.$bestillerEtternavn.' epost '.$bestillerEpost.' tlf '.$bestillerTlf,'ERROR');
                $logg->Ny($antallVoksne.' Voksne '.$antallBarn.' barn '.$antallBebis.'bebis');
                
            } 
            
            $db_connection->commit();
            
            //Lukker databasetilkopling
            $insertBestilling->close();
            $db_connection->close(); 
            
            return $affectedrows;
        }
        
        
        // OPPDATERER EN BESTILLING
        public function UpdateBestilling ($bestillingsDato, $refNo, $reiseDato, $returDato, $bestillerFornavn,$bestillerEtternavn, $bestillerEpost, $bestillerTlf,
                                      $antallVoksne, $antallBarn, $antallBebis)
        {
            include (realpath(dirname(__FILE__)).'/db.php');;
            
            $sql = 
            "UPDATE bestilling
            SET navn = ?
            WHERE bestillingId = ?;";
            
            $insertBestilling = $db_connection->prepare($sql);
            $insertBestilling->bind_param('sssssssssss'
                                    , $bestillingDato, $refNo, $reiseDato, $returDato, $bestillerFornavn, $bestillerEtternavn, $bestillerEpost, $bestillerTlf,
                                      $antallVoksne, $antallBarn, $antallBebis);
                                                                        
            $insertBestilling->execute();
            $affectedRows = $insertBestilling->affected_rows;
            
            $insertBestilling->close();
            $db_connection->close(); 
            
            
            $logg->Ny('Rows affected: '.$affectedRows, 'DEBUG', htmlspecialchars($_SERVER['PHP_SELF']), '');

            if($insertBestilling == false){
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
            include (realpath(dirname(__FILE__)).'/db.php');;
            
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
            include (realpath(dirname(__FILE__)).'/db.php');;
            
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
            
            return $bestilling;
        } 
        
        public function GetBestillingFromUserInfo($fornavn,$etternavn,$epost,$tlf, $logg)
        {
            include (realpath(dirname(__FILE__)).'/db.php');;
            
            $sql = "SELECT bestillingId, bestillingDato, refNo, reiseDato, returDato, bestillerFornavn, bestillerEtternavn, bestillerEpost, bestillerTlf, antallVoksne, antallBarn, antallBebis
                    FROM bestilling 
                    WHERE bestillerFornavn = ? 
                        AND bestillerEtternav = ?
                        AND bestillerEpost = ?
                        AND bestillerTlf = ?;";
            
            $queryBestilling = $db_connection->prepare($sql);
            
            $queryBestilling->bind_param('ssss'
                                    , $fornavn,$etternavn,$epost,$tlf);
            
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
        
        //SLETTE EN BESTILLING WHERE bestillingId = ?
         public function DeleteBestilling($bestillingId, $logg)
         {
            include (realpath(dirname(__FILE__)).'/db.php');;
            
            $sql = "DELETE FROM bestilling WHERE bestillingId=?;";
            
            $deleteBestilling = $db_connection->prepare($sql);
            
            $deleteBestilling->bind_param('i'
                                    , $bestillingId);
            
            $deleteBestilling->execute();
            
            $paavirkedeRader = $deleteBestilling->affected_rows;

            
            //Error logging
            if($deleteBestilling == false)
            {
                $logg->Ny('Mislyktes å slette data fra db: '.mysql_error($db_connection), 'ERROR', htmlspecialchars($_SERVER['PHP_SELF']), '');    
            }
            
            // Lukker databasen
            $deleteBestilling->close();
            $db_connection->close(); 
            
            return $paavirkedeRader;
            
         }
       
 }    
    
    
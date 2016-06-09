<?php
    class Bestilling
{
        
        // OPPRETTE NY BESTILLING
        public function Bestilling()
        {
            
        }
      
        //Lager en bestilling rad og setter inn billetter pr reisene
        public function NewBestilling($bestillingsDato, $refNo, $reiseDato, $returDato, $bestillerFornavn,$bestillerEtternavn, $bestillerEpost, $bestillerTlf,$antallVoksne, $antallBarn, $reisende, $avgangId, $returavgangID, $logg)
        {
            include (realpath(dirname(__FILE__)).'/db.php');;
            
            $logg->Ny('Reisende: '.print_r($reisende));
            
            if(!$returDato){
                $returDato = '';
            }            
            
            $logg->Ny('Klarte ikke å opprette ny bestilling.', 'ERROR',htmlspecialchars($_SERVER['PHP_SELF']), '');
            $logg->Ny('Bestillingsdato = '.$bestillingsDato.' & refNo = '.$refNo,'ERROR');
            $logg->Ny('ReiseDato = '.$reiseDato.' & returDato = '.$returDato,'ERROR');
            $logg->Ny('Navn = '.$bestillerFornavn.' '.$bestillerEtternavn.' epost '.$bestillerEpost.' tlf '.$bestillerTlf,'ERROR');
            $logg->Ny($antallVoksne.' Voksne '.$antallBarn.' barn ');
            
            try {
                $db_connection ->begin_transaction();
            
                $sqlInsertBestilling = "
                INSERT INTO bestilling (bestillingsDato, refNo, reiseDato, returDato, bestillerFornavn, bestillerEtternavn, bestillerEpost, bestillerTlf,antallVoksne, antallBarn) 
                values ( ?
                        , ?
                        , ?
                        , ?
                        , ?
                        , ?
                        , ?
                        , ?
                        , ?
                        , ?);";

                $sqlBillett = "select @bestillingId := max(bestillingId) from bestilling;";

                
                //Utreise
                foreach ($reisende as $key => $person) {
                    $sqlBillett .= "
                    
                    select @seteID := MAX(seteId) from LedigePlasser where avgangId = '".$avgangId."';
                    
                    INSERT INTO billett (bestillingId, avgangId, seteId, fornavn, etternavn, kjonn, antBagasje)  
                    VALUES  (@bestillingId, '".$avgangId."',  @seteId, '".$person['Fornavn']."' , '".$person['Etternavn']."' , '".$person['Kjonn']."', ".$person['Bagasje'].");";
                }
                
                if ($returavgangID != 0) 
                {
                    $logg->Ny('Fant retur avgang ID '.$returavgangID);
                    $logg->Ny('Lager billetter for hjem reise');
                    foreach ($reisende as $key => $person) {
                    $sqlBillett .= "
                    
                    select @seteID := MAX(seteId) from LedigePlasser where avgangId = '".$returavgangID."';
                    
                    INSERT INTO billett (bestillingId, avgangId, seteId, fornavn, etternavn, kjonn, antBagasje)  
                    VALUES  (@bestillingId, '".$returavgangID."',  @seteId, '".$person['Fornavn']."' , '".$person['Etternavn']."' , '".$person['Kjonn']."', ".$person['Bagasje'].");";
                    }
                }
                
                
                $logg->Ny('Generer SQL for billetter, SQL: '.$sqlBillett);
                
                $logg->Ny('Forsøker å opprette ny bestilling.', 'DEBUG', htmlspecialchars($_SERVER['PHP_SELF']), '');
            
                $insertBestilling = $db_connection->prepare($sqlInsertBestilling);
                
                $insertBestilling->bind_param('ssssssssss'
                                            , $bestillingsDato
                                            , $refNo
                                            , $reiseDato
                                            , $returDato
                                            , $bestillerFornavn
                                            , $bestillerEtternavn
                                            , $bestillerEpost
                                            , $bestillerTlf
                                            , $antallVoksne
                                            , $antallBarn);
                
                $insertBestilling->execute();
                
                
                $affectedrows = $insertBestilling->affected_rows;
                
                $insertBestilling->close();
                
                if ($affectedrows == 1) {
                    $logg->Ny('Ny bestilling opprettet.', 'DEBUG',htmlspecialchars($_SERVER['PHP_SELF']), '');
                    
                    
                     /* execute multi query */
                    if ($db_connection->multi_query($sqlBillett)) {
                        do {
                            /* store first result set */
                            if ($result = $db_connection->store_result()) {
                                while ($row = $result->fetch_row()) {
                                    $logg->Ny('Legger inn billett, antall rader lagt inn: '.$row[0]);
                                }
                                $result->free();
                            }
                            /* print divider */
                            if ($db_connection->more_results()) {
                                //$logg->Ny('Forsøker å leg')
                            }
                        } while ($db_connection->next_result());
                    }
                    
                    $db_connection->commit();
                    
                } else {
                    
                    $logg->Ny('Klarte ikke å opprette ny bestilling.', 'ERROR',htmlspecialchars($_SERVER['PHP_SELF']), '');
                    $logg->Ny('Bestillingsdato = '.$bestillingsDato.' & refNo = '.$refNo,'ERROR');
                    $logg->Ny('ReiseDato = '.$reiseDato.' & returDato = '.$returDato,'ERROR');
                    $logg->Ny('Navn = '.$bestillerFornavn.' '.$bestillerEtternavn.' epost '.$bestillerEpost.' tlf '.$bestillerTlf,'ERROR');
                    
                    $db_connection->rollback();
                    
                } 
                
                
                $logg->Ny('Rows affected for bestilling: '.$affectedrows, 'DEBUG', htmlspecialchars($_SERVER['PHP_SELF']), '');
            
            } catch (Exception $e) {
                // An exception has been thrown
                // We must rollback the transaction
                $db_connection->rollback();
                $logg->Ny('SQL feilet, rollback av transkasjon utføres.', 'ERROR');
                
                //Lukker databasetilkopling
                 
            } finally {
                if(!$affectedrows){
                    $affectedrows = 0;
                }
                $db_connection->close();
                
            }
            
            return $affectedrows;
        }
        
        
        // OPPDATERER EN BESTILLING
        public function UpdateBestilling ($id,$fornavn,$etternavn, $bestillerEpost, $bestillerTlf,$logg)
        {
            include (realpath(dirname(__FILE__)).'/db.php');;
            
            $sql = 
            "UPDATE bestilling
            SET bestillerFornavn = ?,bestillerEtternavn =? ,bestillerEpost = ?,bestillerTlf = ? 
            WHERE bestillingId = ?;";
            
            $updateBestilling = $db_connection->prepare($sql);
            $updateBestilling->bind_param('ssssi'
                                    ,$fornavn,$etternavn
                                    , $bestillerEpost, $bestillerTlf, $id);
                                                                        
            $updateBestilling->execute();
            $affectedRows = $updateBestilling->affected_rows;
            
            $updateBestilling->close();
            $db_connection->close(); 
            
            
            $logg->Ny('Rows affected: '.$affectedRows, 'DEBUG', htmlspecialchars($_SERVER['PHP_SELF']), '');

            if($updateBestilling == false){
                $logg->Ny('Mislyktes å oppdatere bestilling informasjon'.mysql_error($db_connection), 'ERROR', htmlspecialchars($_SERVER['PHP_SELF']), '');
                exit;    
            }
            
            if ($affectedRows == 1) {
                $logg->Ny('Bestilling id '.$id.' ble oppdatert.', 'INFO',htmlspecialchars($_SERVER['PHP_SELF']), '');
            } else {
                $logg->Ny('Klarte ikke å oppdatere bestilling.', 'ERROR',htmlspecialchars($_SERVER['PHP_SELF']), '');
            } 
            
            return $affectedRows;
        }
        
        
        // VISE ALLE BESTILLINGER
        public function GetAllBestilling($logg)
        {
            include (realpath(dirname(__FILE__)).'/db.php');;
            
            $sql = "SELECT bestillingId, bestillingsDato, refNo, reiseDato, returDato, bestillerFornavn, bestillerEtternavn, bestillerEpost, bestillerTlf, antallVoksne + antallBarn, antallVoksne, antallBarn
                    FROM bestilling
                    ORDER BY bestillingId DESC;";
            
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
            
            $sql = "SELECT bestillingId, bestillingsDato, refNo, reiseDato, returDato, bestillerFornavn, bestillerEtternavn, bestillerEpost, bestillerTlf, antallVoksne, antallBarn
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
            
            $sql = "SELECT bestillingId, bestillingDato, refNo, reiseDato, returDato, bestillerFornavn, bestillerEtternavn, bestillerEpost, bestillerTlf, antallVoksne, antallBarn
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
    
    
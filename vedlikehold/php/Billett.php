<?php
    class Billett
{
        
        // OPPRETTE NY BILLETT
        public function Billett()
        {
            
        }
        
        // OPPDATERER EN BILLETT
        public function UpdateBillett ($id, $fornavn, $etternavn, $kjonn, $antBagasje, $logg)
        {
            include (realpath(dirname(__FILE__)).'/db.php');;
            
            $sql = 
            "UPDATE billett
            SET  fornavn = ?, etternavn = ?, kjonn = ?, antBagasje = ?
            WHERE billettId = ?;";
            
            $insertBillett = $db_connection->prepare($sql);
            $insertBillett->bind_param('sssii'
                                    , $fornavn, $etternavn, $kjonn, $antBagasje, $id);
                                                                        
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
        
        public function GetBillettByBestillingId($id, $logg)
        {
            include (realpath(dirname(__FILE__)).'/db.php');;
            
            $sql = "SELECT billettId, bestillingId, avgangId, seteId, fornavn, etternavn, kjonn, antBagasje 
                    FROM billett WHERE bestillingId=?;";
            
            $queryBillett = $db_connection->prepare($sql);
            
            $queryBillett->bind_param('i'
                                    , $id);
            
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
        public function ShowAllBilletter(){

        include('../php/db.php');  
        $html =  '';
       
        //CSS Styling
        $oddOrEven = TRUE;
        $printOddOrEven = '';
        
       
        //  db-tilkopling
        $query = $db_connection->prepare("SELECT billettId, bestillingId, avgangId, seteId, fornavn, etternavn, kjonn, antBagasje FROM billett");
        $query->execute();
        $query->bind_result($billettId, $bestillingId, $avgangId,$seteId, $fornavn, $etternavn,$kjonn,$antBagasje);



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

            $html .= '<tr role="row" class="'.$printOddOrEven.'"><td>'.$billettId.'</td><td>'.$bestillingId.'</td><td>'.$avgangId.'</td><td>'.$seteId.'</td><td>'.$fornavn.'</td><td>'.$etternavn.'</td><td>'.$kjonn.'</td><td>'.$antBagasje.'</td><td><a href="./Billetter/billetterEdit.php?id='.$billettId.'"">Endre</a> | <a onclick="return confirm(\'Er du sikker du ønsker å kansellere denne billetten?\')" href="./Billetter/delete.php?id='.$billettId.'">Slett</a> </td></tr>';

        }
        
    
        //Lukker databasetilkopling
        $query->close();
        $db_connection->close();
        
        return $html;
    }
    public function BillettSelectOptions(){
            include (realpath(dirname(__FILE__)).'/db.php');;
             $listBox = "";
            
            $sql="SELECT billettId, fornavn, etternavn from billett";
            
            $queryDestinasjon = $db_connection->prepare($sql);
            
            $queryDestinasjon->execute();

            $queryDestinasjon->bind_result($id, $fornavn, $etternavn);
                        
            while ($queryDestinasjon->fetch()) {
                
                 $listBox .= "<option value=".$id. ">Billett ID: ".$id.", Fornavn: ".$fornavn.", Etternavn: ".$fornavn."</option>";
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
 }    
    
    
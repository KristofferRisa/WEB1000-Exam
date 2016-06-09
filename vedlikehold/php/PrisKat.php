<?php

    class PrisKat
{
        
        // OPPRETTE NY PRIS KATEGORI      
        public function NewPrisKat($prisKatNavn, $prisKatKroner, $logg)
        {   
            include (realpath(dirname(__FILE__)).'/db.php');
            
            // $logg = new Logg;
            
            $logg->Ny('Forsøker å opprette ny priskategori.', 'DEBUG', htmlspecialchars($_SERVER['PHP_SELF']), '');
         
            
            $sql = "
                INSERT INTO prisKategori (navn, kroner)
                            VALUES (?, ?)";
            
            $insertPrisKat = $db_connection->prepare($sql);
            $insertPrisKat->bind_param('ss'
                                    , $prisKatNavn, $prisKatKroner);
                                    
            $insertPrisKat->execute();
            $affectedrows=$insertPrisKat->affected_rows;
           

            $logg->Ny('Rows affected: '.$affectedrows, 'DEBUG', htmlspecialchars($_SERVER['PHP_SELF']), '');

            if($insertPrisKat == false){
                $logg->Ny('Mislyktes å insert: '.mysql_error($db_connection), 'ERROR', htmlspecialchars($_SERVER['PHP_SELF']), '');
                exit;    
            }
            
            if ($affectedrows == 1) {
                $logg->Ny('Ny priskategori opprettet.', 'DEBUG',htmlspecialchars($_SERVER['PHP_SELF']), '');
            } else {
                $logg->Ny('Klarte ikke å opprette ny priskategori.', 'ERROR',htmlspecialchars($_SERVER['PHP_SELF']), '');
            } 
                
            //Lukker databasetilkopling
            $insertPrisKat->close();
            $db_connection->close(); 
            
            return $affectedrows;
        }
        
        
        // OPPDATERER EN PRISKATEGORI
        public function UpdatePrisKat ($id, $navn, $kroner, $logg)
        {
            include (realpath(dirname(__FILE__)).'/db.php');;
            
            $sql = 
            "UPDATE prisKategori
            SET navn = ?, kroner = ?
            WHERE prisKategoriId = ?;";
            
            $insertPrisKat = $db_connection->prepare($sql);
            $insertPrisKat->bind_param('sii'
                                    , $navn, $kroner, $id);
                                                                        
            $insertPrisKat->execute();
            $affectedRows = $insertPrisKat->affected_rows;
            
            $insertPrisKat->close();
            $db_connection->close(); 
            
            
            $logg->Ny('Rows affected: '.$affectedRows, 'DEBUG', htmlspecialchars($_SERVER['PHP_SELF']), '');

            if($insertPrisKat == false){
                $logg->Ny('Mislyktes å oppdatere priskategori informasjon'.mysql_error($db_connection), 'ERROR', htmlspecialchars($_SERVER['PHP_SELF']), '');
                exit;    
            }
            
            if ($affectedRows == 1) {
                $logg->Ny('Priskategorien ble oppdatert.', 'DEBUG',htmlspecialchars($_SERVER['PHP_SELF']), '');
            } else {
                $logg->Ny('Klarte ikke å oppdatere priskategorien.', 'ERROR',htmlspecialchars($_SERVER['PHP_SELF']), '');
            } 
                
            //Lukker databasetilkopling
            
            return $affectedRows;
        }
        
        public function GetAllePrisKategoriDataset($logg)
        {
            include (realpath(dirname(__FILE__)).'/db.php');;
        
            $logg->Ny('Forsoeker å alle pris kategorier.');
            
            $sql = "SELECT prisKategoriId, navn, kroner FROM prisKategori;";
            
            $prisKatQuery = $db_connection->prepare($sql);
            
            $prisKatQuery->execute();
            
            //henter result set
            $resultSet = $prisKatQuery->get_result();
            
            $prisKategorier =  $resultSet->fetch_all();
            
            //Error logging
            if($prisKatQuery == false){
                $logg->Ny('Klarte ikke å hente pris kategorier fra db: '.mysql_error($db_connection), 'ERROR', htmlspecialchars($_SERVER['PHP_SELF']), '');    
            }
            
            $resultSet->free();
            $prisKatQuery->close();
            $db_connection->close(); 
            
            return $prisKategorier;
        }
        
        // VISE ALLE PRISKATEGORIER LISTBOX
        public function GetAllPrisKategorierLB($logg)
        {
            include (realpath(dirname(__FILE__)).'/db.php');;
            $listBox= "";

            $sql = "SELECT prisKategoriId, navn, kroner FROM prisKategori;";
            
            $queryPrisKat = $db_connection->prepare($sql);
            
            $queryPrisKat->execute();

            $queryPrisKat ->bind_result($id, $prisKatNavn, $kroner);
            
            while ($queryPrisKat->fetch ())
            {
                $listBox .="<option value=".$id. ">".$prisKatNavn." (".$kroner.")</option>";
            }

            
            //Error logging
            if($queryPrisKat == false){
                $logg->Ny('Mislyktes å hente fra db: '.mysql_error($db_connection), 'ERROR', htmlspecialchars($_SERVER['PHP_SELF']), '');    
            }
            
            $queryPrisKat->close();
            $db_connection->close(); 
            
            return $listBox;
        }

        
        //VISE ALLE PRISKATEGORIER 
        public function GetAllPrisKat()
        {
            include('../php/db.php');  
            $html =  '';
            $id = "";
            //CSS Styling
            $oddOrEven = TRUE;
            $printOddOrEven = '';
            
        
            //  db-tilkopling
            $query = $db_connection->prepare

            ("SELECT prisKategoriId, navn, endret, kroner FROM prisKategori");

            $query->execute();
            $query->bind_result($prisKatId, $navn, $endret, $kroner);
            
            //henter data
            while ($query->fetch()) 
            {
                if($oddOrEven){
                    $oddOrEven = FALSE;
                    $printOddOrEven = 'even';
                } 
                else {
                    $oddOrEven = TRUE;
                    $printOddOrEven = 'odd';
                }

                $html .= '<tr role="row" class="'.$printOddOrEven.'">
                <td>'.$navn.'</td>  
                <td>'.$kroner.'</td><td>
                <a href="./PrisKategori/prisKategoriAdd.php">Ny priskategori</a> | <a href="./PrisKategori/prisKategoriEdit.php?id='.$prisKatId.'"">Endre</a> | <a onclick="return confirm(\'Er du sikker du ønsker å slette denne priskategorien?\')" href="./PrisKategori/delete.php?id='.$id.'">Slett</a> </td></tr>';

            }
            return $html;
        }
        
        //VISE EN PRIS WHERE prisKatId = ?
        public function getPrisKat($prisKatId, $logg)
        {
            include (realpath(dirname(__FILE__)).'/db.php');;
            

            $sql = "SELECT prisKategoriId, navn, kroner FROM prisKategori WHERE prisKategoriId=?;";

            $queryPrisKat = $db_connection->prepare($sql);
            
            $queryPrisKat->bind_param('i'
                                    , $prisKatId);
            
            $queryPrisKat->execute();
            
            //henter result set
            $resultSet = $queryPrisKat->get_result();
            
            $prisKat =  $resultSet->fetch_all();
            
            //Error logging
            if($queryPrisKat == false){
                $logg->Ny('Mislyktes å hente fra db: '.mysql_error($db_connection), 'ERROR', htmlspecialchars($_SERVER['PHP_SELF']), '');    
            }
            
            $resultSet->free();
            $queryPrisKat->close();
            $db_connection->close(); 
            
            return $prisKat;
        } 
        
        
        //SLETTE EN PRISKATEGORI WHERE prisKatId = ?
         public function DeletePrisKat($prisKatId, $logg)
         {
            include (realpath(dirname(__FILE__)).'/db.php');;
            
            $sql = "DELETE FROM prisKategori WHERE prisKategoriId=?;";
            
            $deletePrisKat = $db_connection->prepare($sql);
            
            $deletePrisKat->bind_param('i'
                                    , $prisKatId);
            
            $deletePrisKat->execute();
            
            $paavirkedeRader = $deletePrisKat->affected_rows;

            
            //Error logging
            if($deletePrisKat == false)
            {
                $logg->Ny('Mislyktes å slette data fra db: '.mysql_error($db_connection), 'ERROR', htmlspecialchars($_SERVER['PHP_SELF']), '');    
            }
            
            // Lukker databasen
            $deletePrisKat->close();
            $db_connection->close(); 
            
            return $paavirkedeRader;
            
         }
       
 }    
    
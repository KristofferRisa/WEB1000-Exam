<?php
    class PrisKat
{
        
        // OPPRETTE NY PRIS KATEGORI
        public function PrisKat()
        {
            
        }
      
        public function NewPrisKat($navn, $prosentPaaslag)
        {   
            include('db.php');
            
            $logg->Ny('Forsøker å opprette ny priskategori.', 'DEBUG', htmlspecialchars($_SERVER['PHP_SELF']), '');
         
            
            $sql = "
                INSERT INTO prisKategori (navn, prosentPaaslag)
                            VALUES (?, ?)";
            
            $insertPrisKat = $db_connection->prepare($sql);
            $insertPrisKat->bind_param('ss'
                                    , $navn, $posentPaaslag);
                                    
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
        public function UpdatePrisKat ($navn, $prosentPaaslag)
        {
            include('db.php');
            
            $sql = 
            "UPDATE prisKategori
            SET navn = ?
            WHERE prisKategoriId = ?;";
            
            $insertPrisKat = $db_connection->prepare($sql);
            $insertPrisKat->bind_param('ss'
                                    , $navn, $prosentPaaslag);
                                                                        
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
        
        
        // VISE ALLE PRISKATEGORIER
        public function GetAllPrisKategorier($logg)
        {
            include('db.php');
            
            $sql = "SELECT prisKategoriId, navn, prosentPaaslag FROM prisKategori;";
            
            $queryPrisKat = $db_connection->prepare($sql);
            
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
        
        
        //VISE EN PRIS WHERE prisKatId = ?
        public function getPrisKat($prisKatId, $logg)
        {
            include('db.php');
            
            $sql = "SELECT prisKategoriId, navn, prosentPaaslag FROM prisKategori WHERE prisKategoriId=?;";
            
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
            include('db.php');
            
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
    
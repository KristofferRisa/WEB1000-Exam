<?php
    class Sesong
{
        
        // OPPRETTE NY SESONG
        public function Sesong()
        {
            
        }
      
        public function NewSesong ($navn)
        {   
            include (realpath(dirname(__FILE__)).'/db.php');;
            
            $logg->Ny('Forsøker å opprette ny sesong.', 'DEBUG', htmlspecialchars($_SERVER['PHP_SELF']), '');
         
            
            $sql = "
                INSERT INTO sesong (navn)
                            values (?)";
            
            $insertSesong = $db_connection->prepare($sql);
            $insertSesong->bind_param('s'
                                    , $navn);
                                    
            $insertSesong->execute();
            $affectedrows=$insertSesong->affected_rows;
           
            
            $logg->Ny('Rows affected: '.$affectedrows, 'DEBUG', htmlspecialchars($_SERVER['PHP_SELF']), '');

            if($insertSesong == false){
                $logg->Ny('Mislyktes å insert: '.mysql_error($db_connection), 'ERROR', htmlspecialchars($_SERVER['PHP_SELF']), '');
                exit;    
            }
            
            if ($affectedrows == 1) {
                $logg->Ny('Ny sesong opprettet.', 'DEBUG',htmlspecialchars($_SERVER['PHP_SELF']), '');
            } else {
                $logg->Ny('Klarte ikke å opprette ny sesong.', 'ERROR',htmlspecialchars($_SERVER['PHP_SELF']), '');
            } 
                
            //Lukker databasetilkopling
            $insertSesong->close();
            $db_connection->close(); 
            
            return $affectedrows;
        }
        
        
        // OPPDATERER EN SESONG
        public function UpdateSesong ($navn)
        {
            include (realpath(dirname(__FILE__)).'/db.php');;
            
            $sql = 
            "UPDATE sesong
            SET navn = ?
            WHERE sesongId = ?;";
            
            $insertSesong = $db_connection->prepare($sql);
            $insertSesong->bind_param('s'
                                    , $navn);
                                                                        
            $insertSesong->execute();
            $affectedRows = $insertSesong->affected_rows;
            
            $insertSesong->close();
            $db_connection->close(); 
            
            
            $logg->Ny('Rows affected: '.$affectedRows, 'DEBUG', htmlspecialchars($_SERVER['PHP_SELF']), '');

            if($insertSesong == false){
                $logg->Ny('Mislyktes å oppdatere sesong informasjon'.mysql_error($db_connection), 'ERROR', htmlspecialchars($_SERVER['PHP_SELF']), '');
                exit;    
            }
            
            if ($affectedRows == 1) {
                $logg->Ny('Sesong ble oppdatert.', 'DEBUG',htmlspecialchars($_SERVER['PHP_SELF']), '');
            } else {
                $logg->Ny('Klarte ikke å oppdatere sesong.', 'ERROR',htmlspecialchars($_SERVER['PHP_SELF']), '');
            } 
                
            //Lukker databasetilkopling
            
            return $affectedRows;
        }
        
        
        // VISE ALLE SESONGER
        public function GetAllSesonger($logg)
        {
            include (realpath(dirname(__FILE__)).'/db.php');;
            
            $sql = "SELECT sesongId, navn FROM sesong;";
            
            $querySesong = $db_connection->prepare($sql);
            
            $querySesong->execute();
            
            //henter result set
            $resultSet = $querySesong->get_result();
            
            $sesong =  $resultSet->fetch_all();
            
            //Error logging
            if($querySesong == false){
                $logg->Ny('Mislyktes å hente fra db: '.mysql_error($db_connection), 'ERROR', htmlspecialchars($_SERVER['PHP_SELF']), '');    
            }
            
            $resultSet->free();
            $querySesong->close();
            $db_connection->close(); 
            
            return $sesong;
        }
        
        
        //VISE EN SESONG WHERE sesongId = ?
        public function getSesong($sesongId, $logg)
        {
            include (realpath(dirname(__FILE__)).'/db.php');;
            
            $sql = "SELECT sesongId, navn FROM sesong WHERE sesongId=?;";
            
            $querySesong = $db_connection->prepare($sql);
            
            $querySesong->bind_param('i'
                                    , $sesongId);
            
            $querySesong->execute();
            
            //henter result set
            $resultSet = $querySesong->get_result();
            
            $sesong =  $resultSet->fetch_all();
            
            //Error logging
            if($querySesong == false){
                $logg->Ny('Mislyktes å hente fra db: '.mysql_error($db_connection), 'ERROR', htmlspecialchars($_SERVER['PHP_SELF']), '');    
            }
            
            $resultSet->free();
            $querySesong->close();
            $db_connection->close(); 
            
            return $sesong;
        } 
        
        
        //SLETTE ET SESONG WHERE sesongId = ?
         public function DeleteSesong($sesongId, $logg)
         {
            include (realpath(dirname(__FILE__)).'/db.php');;
            
            $sql = "DELETE FROM sesong WHERE sesongId=?;";
            
            $deleteSesong = $db_connection->prepare($sql);
            
            $deleteSesong->bind_param('i'
                                    , $sesongId);
            
            $deleteSesong->execute();
            
            $paavirkedeRader = $deleteSesong->affected_rows;

            
            //Error logging
            if($deleteSesong == false)
            {
                $logg->Ny('Mislyktes å slette data fra db: '.mysql_error($db_connection), 'ERROR', htmlspecialchars($_SERVER['PHP_SELF']), '');    
            }
            
            // Lukker databasen
            $deleteSesong->close();
            $db_connection->close(); 
            
            return $paavirkedeRader;
            
         }
       
 }    
    
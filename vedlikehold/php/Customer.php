<?php
    class Customer{
        public function Customer()
        {
            
        }
      
        public function NewCustomer($fornavn,$etternavn, $kjonn, $telefon, $epost, $logg)
        {   
            include('db.php');
            
            $logg->Ny('Forsøker å opprette ny kunde.', 'DEBUG', htmlspecialchars($_SERVER['PHP_SELF']), '');
         
            
            $sql = "
                insert into kunde (fornavn, etternavn, kjonn, telefon, epost) 
                            values (?, ?, ?, ?, ?)";
            
            $insertCustomer = $db_connection->prepare($sql);
            $insertCustomer->bind_param('sssss'
                                    , $fornavn, $etternavn, $kjonn, $telefon, $epost);
                                    
            $insertCustomer->execute();
            $affectedrows=$insertCustomer->affected_rows;
           
            
            $logg->Ny('Rows affected: '.$affectedrows, 'DEBUG', htmlspecialchars($_SERVER['PHP_SELF']), '');

            if($insertCustomer == false){
                $logg->Ny('Failed to insert: '.mysql_error($db_connection), 'ERROR', htmlspecialchars($_SERVER['PHP_SELF']), '');
                exit;    
            }
            
            if ($affectedrows == 1) {
                $logg->Ny('Ny kunde opprettet.', 'DEBUG',htmlspecialchars($_SERVER['PHP_SELF']), '');
            } else {
                $logg->Ny('Klarte ikke å opprette ny kunde.', 'ERROR',htmlspecialchars($_SERVER['PHP_SELF']), '');
            } 
                
            //Lukker databasetilkopling
            $insertCustomer->close();
            $db_connection->close(); 
            
            return $affectedrows;
        }
        
        public function UpdateCustomer($fornavn, $etternavn, $kjonn, $telefon$, $epost)
        {
            include('db.php');
            
            $sql = "
            update kunde
            set navn = ?
            where kundeId = ?;";
            
            $insertCustomer = $db_connection->prepare($sql);
            $insertCustomer->bind_param('sssss'
                                    , $fornavn, $etternavn, $kjonn, $telefon, $epost);
                                                                        
            $insertCustomer->execute();
            $affectedRows = $insertCustomer->affected_rows;
            
            $insertCustomer->close();
            $db_connection->close(); 
            
            
            $logg->Ny('Rows affected: '.$affectedRows, 'DEBUG', htmlspecialchars($_SERVER['PHP_SELF']), '');

            if($insertCustomer == false){
                $logg->Ny('Mislyktes å oppdatere kunde informasjon'.mysql_error($db_connection), 'ERROR', htmlspecialchars($_SERVER['PHP_SELF']), '');
                exit;    
            }
            
            if ($affectedRows == 1) {
                $logg->Ny('Kunden ble oppdatert.', 'DEBUG',htmlspecialchars($_SERVER['PHP_SELF']), '');
            } else {
                $logg->Ny('Klarte ikke å oppdatere brukeren.', 'ERROR',htmlspecialchars($_SERVER['PHP_SELF']), '');
            } 
                
            //Lukker databasetilkopling
            
            return $affectedRows;
        }
        
        public function GetAllCustomer($logg){
            include('db.php');
            
            $sql = "select kundeId, navn, etternavn, kjonn, telefon, epost from kunde;";
            
            $queryCustomer = $db_connection->prepare($sql);
            
            $queryCustomer->execute();
            
            //henter result set
            $resultSet = $queryCustomer->get_result();
            
            $customer =  $resultSet->fetch_all();
            
            //Error logging
            if($queryCustomer == false){
                $logg->Ny('Mislyktes å hente fra db: '.mysql_error($db_connection), 'ERROR', htmlspecialchars($_SERVER['PHP_SELF']), '');    
            }
            
            $resultSet->free();
            $queryCustomer->close();
            $db_connection->close(); 
            
            return $customer;
        } 
        
         public function GetCustomer($customerId, $logg){
            include('db.php');
            
            $sql = "select kundeId, navn, etternavn, kjonn, telefon, epost from kunde WHERE kundeId=?;";
            
            $queryCustomer = $db_connection->prepare($sql);
            
            $queryCustomer->bind_param('i'
                                    , $customerId);
            
            $queryCustomer->execute();
            
            //henter result set
            $resultSet = $queryCustomer->get_result();
            
            $customer =  $resultSet->fetch_all();
            
            //Error logging
            if($queryCustomer == false){
                $logg->Ny('Mislyktes å hente fra db: '.mysql_error($db_connection), 'ERROR', htmlspecialchars($_SERVER['PHP_SELF']), '');    
            }
            
            $resultSet->free();
            $queryCustomer->close();
            $db_connection->close(); 
            
            return $customer;
        } 
        
        
         public function DeleteCustomer($customerId, $logg){
            include('db.php');
            
            $sql = "DELETE from kunde WHERE kundeId=?;";
            
            $deleteCustomer = $db_connection->prepare($sql);
            
            $deleteCustomer->bind_param('i'
                                    , $customerId);
            
            $deleteCustomer->execute();
            
            $påvirkedeRader = $deleteCustomer->affected_rows;

            
            //Error logging
            if($deleteCustomer == false){
                $logg->Ny('Mislyktes å slette data fra db: '.mysql_error($db_connection), 'ERROR', htmlspecialchars($_SERVER['PHP_SELF']), '');    
            }
            
            // Lukker databasen
            $deleteCustomer->close();
            $db_connection->close(); 
            
            return $påvirkedeRader;
        } 
        
    }    
    
    
<?php
    class UserType{
        public function UserType()
        {
            
        }
      
        public function NewUserType($name,$logg)
        {   
            include('db.php');
            
            $logg->Ny('Forsøker å opprette ny bruker.', 'DEBUG', htmlspecialchars($_SERVER['PHP_SELF']), '');
            
            $logg->Ny('PASSORD = '.$new_pass, 'DEBUG', htmlspecialchars($_SERVER['PHP_SELF']), '');
            
            $sql = "
                insert into brukerType (navn) 
                            values (?,)";
            
            $insertUserType = $db_connection->prepare($sql);
            $insertUserType->bind_param('s'
                                    , $name);
                                    
            $insertUser->execute();
            
            $logg->Ny('Rows affected: '.$insertUserType->affected_rows, 'DEBUG', htmlspecialchars($_SERVER['PHP_SELF']), '');

            if($insertUserType == false){
                $logg->Ny('Failed to insert: '.mysql_error($db_connection), 'ERROR', htmlspecialchars($_SERVER['PHP_SELF']), '');
                exit;    
            }
            
            if ($insertUserType->affected_rows == 1) {
                $logg->Ny('Ny bruker opprettet.', 'DEBUG',htmlspecialchars($_SERVER['PHP_SELF']), '');
            } else {
                $logg->Ny('Klarte ikke å opprette ny bruker.', 'ERROR',htmlspecialchars($_SERVER['PHP_SELF']), '');
            } 
                
            //Lukker databasetilkopling
            $insertUserType->close();
            $db_connection->close(); 
        }
        
        public function UpdateUserType($id, $navn, $logg){
            include('db.php');
            
            $sql = "
            update brukerType 
            set navn = ?
            where brukerTypeId = ?;";
            
            $insertUser = $db_connection->prepare($sql);
            $insertUserType->bind_param('si'
                                    , $name
                                    , $id);
                                    
            $insertUserType->execute();

            $affectedRows = $insertUserType->affected_rows;
            
            $insertUserType->close();
            $db_connection->close(); 
            
            
            $logg->Ny('Rows affected: '.$affectedRows, 'DEBUG', htmlspecialchars($_SERVER['PHP_SELF']), '');

            if($insertUserType == false){
                $logg->Ny('Failed to update user: '.mysql_error($db_connection), 'ERROR', htmlspecialchars($_SERVER['PHP_SELF']), '');
                exit;    
            }
            
            if ($affectedRows == 1) {
                $logg->Ny('Bruker ble oppdatert.', 'DEBUG',htmlspecialchars($_SERVER['PHP_SELF']), '');
            } else {
                $logg->Ny('Klarte ikke å oppdatere bruker.', 'ERROR',htmlspecialchars($_SERVER['PHP_SELF']), '');
            } 
                
            //Lukker databasetilkopling
            
            return $affectedRows;
        }
        
        public function GetUserTypes($logg){
            include('db.php');
            
            $sql = "select brukerTypeId,navn from brukerType;";
            
            $queryUserType = $db_connection->prepare($sql);
            
            $queryUserType->execute();
            
            //henter result set
            $resultSet = $queryUserType->get_result();
            
            $userType =  $resultSet->fetch_all();
            
            //Error logging
            if($queryUserType == false){
                $logg->Ny('Failed to get from db: '.mysql_error($db_connection), 'ERROR', htmlspecialchars($_SERVER['PHP_SELF']), '');    
            }
            
            $resultSet->free();
            $queryUserType->close();
            $db_connection->close(); 
            
            return $userType;
        } 
        
    }    
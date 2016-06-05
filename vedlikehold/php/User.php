<?php
    class User{
        public function User()
        {
            
        }
        
        #public $AntallBrukere;
        
        public function VisAlle($sideNr,$logg){
            include('db.php');
            $html =  '';
            $antallMeldinger = 100;
            //CSS Styling
            $oddOrEven = TRUE;
            $printOddOrEven = '';
            
            $offset = 0;
            
            if ($sideNr > 1) {
                $sideNr = $sideNr-1;
                $offset = $sideNr*$antallMeldinger;    
            } else {
                $offset = $sideNr-1;
            }
            
            $sql = "
            select 
                brukerId
                , brukernavn
                ,fornavn
                ,etternavn
                ,epost
                ,tlf
                ,isAdmin
            from bruker b
            LIMIT ?,?;";
            
            $queryPrSide = $db_connection->prepare($sql);
            
            $queryPrSide->bind_param('ss', $offset, $antallMeldinger);
            $queryPrSide->execute();

            $queryPrSide->bind_result(
                $id
                , $brukernavn
                , $fornavn
                , $etternavn
                , $epost
                , $tlf
                , $isAdmin);
            
            //henter data
            while ($queryPrSide->fetch()) {
                
                if($oddOrEven){
                    $oddOrEven = FALSE;
                    $printOddOrEven = 'even';
                } 
                else {
                    $oddOrEven = TRUE;
                    $printOddOrEven = 'odd';
                }
                $html .= '
                    <tr role="row" class="'.$printOddOrEven.'">
                        <td>'.$id.'</td>
                        <td>'.$brukernavn.'</td>
                        <td>'.$fornavn.'</td>
                        <td>'.$etternavn.'</td>
                        <td>'.$epost.'</td>'
                        .'<td class="hidden-xs">'.$tlf.'</td>'
                        .'<td class="hidden-xs">'.$isAdmin.'</td>'
                        .'<td>
                            <a href="./User/add.php">Ny</a> | <a href="./User/update.php?id='.$id.'">Endre</a> | <a href="./User/changepassword.php?id='.$id.'">Bytt passord</a> 
                        </td>
                   </tr>';
            }
            
            $this->AntallBrukere = $queryPrSide->num_rows;
            
            //Error logging
            if($queryPrSide == false){
                $logg->Ny('Failed to get from db: '.mysql_error($db_connection), 'ERROR', htmlspecialchars($_SERVER['PHP_SELF']), '');    
            }
            
            $queryPrSide->close();
            $db_connection->close(); 
            
            return $html;
        }
        
        public function NewUser($brukernavn, $fname, $lname, $mail, $new_pass, $phone, $isAdmin ,$logg)
        {   
            include('db.php');
            
             $logg->Ny('Forsøker å opprette ny bruker.', 'DEBUG', htmlspecialchars($_SERVER['PHP_SELF']), '');
             
             $logg->Ny('PASSORD = '.$new_pass, 'DEBUG', htmlspecialchars($_SERVER['PHP_SELF']), '');
            
            $statusKodeId = 1; //Opprettet (lese fra database?) Fjernes!
            
            $salt = uniqid(mt_rand(), true);

            $options = [
                'cost' => 11,
                'salt' => $salt,
            ];
            $pass_hash = password_hash($new_pass, PASSWORD_BCRYPT, $options);
            
            $sql = "
                insert into bruker (brukernavn
                                    , fornavn
                                    , etternavn
                                    , epost
                                    , tlf
                                    , passord
                                    , isAdmin) 
                            values (?,?,?,?,?,?,?)";
            
            $insertUser = $db_connection->prepare($sql);
            $insertUser->bind_param('ssssssssiis'
                                    , $brukernavn
                                    , $fname
                                    , $lname
                                    , $mail
                                    , $phone
                                    , $pass_hash
                                    , $isAdmin);
                                    
            $insertUser->execute();
            $affectedRows = $insertUser->affected_rows;
            
            $logg->Ny('Rows affected: '.$affectedRows, 'DEBUG', htmlspecialchars($_SERVER['PHP_SELF']), '');

            if($insertUser == false){
                $logg->Ny('Failed to insert: '.mysql_error($db_connection), 'ERROR', htmlspecialchars($_SERVER['PHP_SELF']), '');
                exit;    
            }
            
            if ($affectedRows == 1) {
                $logg->Ny('Ny bruker opprettet.', 'DEBUG',htmlspecialchars($_SERVER['PHP_SELF']), '');
            } else {
                $logg->Ny('Klarte ikke å opprette ny bruker.', 'ERROR',htmlspecialchars($_SERVER['PHP_SELF']), '');
            } 
                
            //Lukker databasetilkopling
            $insertUser->close();
            $db_connection->close(); 
            
            return $affectedRows;
            
        }
        
        public function UpdateUser($userid, $brukernavn, $fname, $lname, $mail, $phone, $isAdmin, $logg){
            include('db.php');
            
            $statusKodeId = 1; //Opprettet (lese fra database?)
            
            //TODO: Sjekk om brukeren finnes fra før
            
            $sql = "
            update bruker 
            set brukernavn = ?
                , fornavn = ?
                , etternavn = ?
                , epost = ?
                , tlf = ?
                , isAdmin = ?
            where brukerId = ?;";
            
            $insertUser = $db_connection->prepare($sql);
            $insertUser->bind_param('sssssii'
                                    , $brukernavn
                                    , $fname
                                    , $lname
                                    , $mail
                                    , $phone
                                    , $isAdmin
                                    , $userid);
                                    
            $insertUser->execute();

            $affectedRows = $insertUser->affected_rows;
            
            $insertUser->close();
            $db_connection->close(); 
            
            
            $logg->Ny('Rows affected: '.$affectedRows, 'DEBUG', htmlspecialchars($_SERVER['PHP_SELF']), '');

            if($insertUser == false){
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
        
        public function Exsits($brukernavn)
        {
            include('db.php');
        
            $query = $db_connection->prepare("SELECT brukerId FROM bruker WHERE brukernavn = ?");
            $query->bind_param('s', $brukernavn);
            $query->execute();

            $query->bind_result($userid);
            $query->fetch();

            //Lukker databasetilkopling
            $query->close();
            $db_connection->close();
            
            if($userid)
            {
                return TRUE;
            }
            else 
            {
                return FALSE;
            }
        }
        
        public function Login($username, $password, $logg)
        {
            include('db.php');
        
            $query = $db_connection->prepare("SELECT passord FROM bruker WHERE brukernavn = ?;");
            $query->bind_param('s', $username);
            $query->execute();

            $query->bind_result($pass_stored);
            $query->fetch();

            //Lukker databasetilkopling
            $query->close();
            $db_connection->close();
            
            if(password_verify($password, $pass_stored))
            {
                    
                if($logg) {
                    $logg->Ny('Vellykket validering av passord. ', 'DEBUG',htmlspecialchars($_SERVER['PHP_SELF']), '');    
                }
                return TRUE;
            }
            else 
            {
                if($logg) {
                    $logg->Ny('Validering av passord feilet. ', 'DEBUG',htmlspecialchars($_SERVER['PHP_SELF']), '');    
                }
                return FALSE;
            }
        }
        
        public function ValidateUsername($username)
        {
            return preg_match('/[a-zA-Z0-9]{1,}/', $username);
        }
        
        public function setUserCookie($uid)
        {
            setcookie("uid", md5($uid), time() + 21600, '/', NULL, 0); /* expire in 5 hour */ 
        }
        
        public function sjekkUserCookie()
        {
            // GET cocike
            // Print an individual cookie - http://php.net/manual/en/function.setcookie.php
            // echo $_COOKIE["TestCookie"];

            // // Another way to debug/test is to view all cookies
            // print_r($_COOKIE);
   
        }
        
        public function GetUser($userId, $logg){
            include('db.php');
            
            
            $sql = "select brukerId,fornavn,etternavn,epost,tlf,brukernavn,isAdmin from bruker WHERE brukerId = ?;";
            
            $queryPrSide = $db_connection->prepare($sql);
            
            $queryPrSide->bind_param('i', $userId);
            $queryPrSide->execute();
            //$queryPrSide->bind_result($id,$fornavn, $etternavn, $epost, $tlf, $dob, $tittel, $type);

            //henter data
            //http://php.net/manual/en/pdostatement.fetchall.php
            //http://stackoverflow.com/questions/13297094/how-do-i-use-fetchall-in-php
            
            //henter result set
            $resultSet = $queryPrSide->get_result();
            
            $user =  $resultSet->fetch_all();
            
            //Error logging
            if($queryPrSide == false){
                $logg->Ny('Failed to get from db: '.mysql_error($db_connection), 'ERROR', htmlspecialchars($_SERVER['PHP_SELF']), '');    
            }
            
            $resultSet->free();
            $queryPrSide->close();
            $db_connection->close(); 
            
            return $user;
        } 
        
        public function GetUserFromUsername($username){
            include('db.php');
            
            $sql = "select brukerId,fornavn,etternavn,epost,tlf,isAdmin from bruker WHERE brukernavn = ?;";
            
            $queryPrSide = $db_connection->prepare($sql);
            
            $queryPrSide->bind_param('s', $username);
            $queryPrSide->execute();

            //henter result set
            $resultSet = $queryPrSide->get_result();
            
            $user =  $resultSet->fetch_all();
            
            $queryPrSide->close();
            $db_connection->close(); 
            
            return $user;
        }
        
        public function ChangePassword($userId, $password, $logg){
            include('db.php');
            
            //TODO: Sjekk om brukeren finnes fra før
            $salt = uniqid(mt_rand(), true);

            $options = [
                'cost' => 11,
                'salt' => $salt,
            ];
            $pass_hash = password_hash($password, PASSWORD_BCRYPT, $options);

            $sql = "
            update bruker 
            set passord = ?
            where brukerId = ?;";
            
            $updateUser = $db_connection->prepare($sql);
            $updateUser->bind_param('si'
                                    , $pass_hash
                                    , $userId);
                                    
            $updateUser->execute();
            
            $affectedRows = $updateUser->affected_rows;
            
            $logg->Ny('Rows affected: '.$affectedRows, 'DEBUG', htmlspecialchars($_SERVER['PHP_SELF']), '');
            
            if($updateUser == false){
                $logg->Ny('Failed to update user: '.mysql_error($db_connection), 'ERROR', htmlspecialchars($_SERVER['PHP_SELF']), '');
            }
            if ($affectedRows == 1) {
                $logg->Ny('Bruker ble oppdatert.', 'DEBUG',htmlspecialchars($_SERVER['PHP_SELF']), '');
            } else {
                $logg->Ny('Klarte ikke å oppdatere bruker.', 'ERROR',htmlspecialchars($_SERVER['PHP_SELF']), '');
            } 
                
            //Lukker databasetilkopling
            $updateUser->close();
            $db_connection->close(); 
            
            return $affectedRows;
        }
        
        public function UsersSelectOptions(){
            include('db.php');
            $htmlSelect =  '';
            
            $sql = "
            select 
                brukerId
                , brukernavn
            from bruker;";
            
            $queryUsers = $db_connection->prepare($sql);
            
            $queryUsers->execute();

            $queryUsers->bind_result($id, $bnavn);
                        
            //$htmlSelect .=  '<select class="form-control select2 select2-hidden-accessible" name="userid" form="nybruker" style="width: 100%;" tabindex="-1" aria-hidden="true">';
            
            //henter data
            while ($queryUsers->fetch()) {
                
                $htmlSelect .= "<option value=".$id. ">".$bnavn."</option>";
            }
            
            //$htmlSelect .= '</select>';
            //Error logging
            if($queryUsers == false){
                $logg->Ny('Failed to get from db: '.mysql_error($db_connection), 'ERROR', htmlspecialchars($_SERVER['PHP_SELF']), '');    
            }
            
            $queryUsers->close();
            $db_connection->close(); 
            
            return $htmlSelect;
        }
    }    
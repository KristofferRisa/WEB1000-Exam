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
                $offset = $sideNr;
            }
            
            // $html .= '<p>offset = '.$offset.'</p>';
            
            $sql = "select brukerId,fornavn,etternavn,epost,tlf,dob,t.navn as tittel,bt.navn as type from bruker b
                    inner join tittel t on t.tittelId = b.tittelId
                    inner join brukerType bt on bt.brukertypeId = b.brukerTypeId
                    LIMIT ?,?;";
            
            $queryPrSide = $db_connection->prepare($sql);
            
            $queryPrSide->bind_param('ss', $offset, $antallMeldinger);
            $queryPrSide->execute();

            $queryPrSide->bind_result($id,$fornavn, $etternavn, $epost, $tlf, $dob, $tittel, $type);
            
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
                        <td>'.$fornavn.'</td>
                        <td>'.$etternavn.'</td>
                        <td>'.$epost.'</td>
                        <td>'.$tittel.'</td>
                        <td>'.$tlf.'</td>
                        <td>'.$dob.'</td>
                        <td>'.$type.'</td>
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
        
        function NewUser($fname, $lname, $DOB, $sex, $mail, $pass, $phone, $tittel, $logg)
        {
            include('db.php');
            
            $brukerTypeId = 1; //Må hentes fra FORM listbox
            $statusKodeId = 1; //Opprettet (lese fra database?)
            $salt = uniqid(mt_rand(), true);

            if($logg) {
                $logg->Ny('Salt opprettet: '.$salt, 'DEBUG',htmlspecialchars($_SERVER['PHP_SELF']), '');    
            }
            
            $options = [
                'cost' => 11,
                'salt' => $salt,
            ];
            $pass_hash = password_hash($pass, PASSWORD_BCRYPT, $options);

            if($logg) {
                $logg->Ny('Hashet passord: '.$pass_hash, 'DEBUG',htmlspecialchars($_SERVER['PHP_SELF']), '');
            }
            
            $sql = "insert into bruker (fornavn, etternavn, epost, tlf, dob, tittelId, passord, salt, brukerTypeId, statusKodeId) values (?,?,?,?,?,?,?,?,?,?)";
            
            $insertUser = $db_connection->prepare($sql);
            $insertUser->bind_param('ssssssssii'
                                    , $fname
                                    , $lname
                                    , $mail
                                    , $phone
                                    , $DOB
                                    , $tittel
                                    , $pass_hash
                                    , $salt
                                    , $brukerTypeId
                                    , $statusKodeId);
                                    
            $insertUser->execute();
            
            $logg->Ny('Rows affected: '.$insertUser->affected_rows, 'DEBUG', htmlspecialchars($_SERVER['PHP_SELF']), '');

            if($insertUser == false){
                $logg->Ny('Failed to insert: '.mysql_error($db_connection), 'ERROR', htmlspecialchars($_SERVER['PHP_SELF']), '');
                exit;    
            }
            
            if ($insertUser->affected_rows == 1) {
                $logg->Ny('Ny bruker opprettet.', 'DEBUG',htmlspecialchars($_SERVER['PHP_SELF']), '');
            } else {
                $logg->Ny('Klarte ikke å opprette ny bruker.', 'ERROR',htmlspecialchars($_SERVER['PHP_SELF']), '');
            } 
                
            //Lukker databasetilkopling
            $insertUser->close();
            $db_connection->close(); 
        }
        
        function Exsits($username)
        {
            include('db.php');
        
            $query = $db_connection->prepare("SELECT brukerId FROM BRUKER WHERE epost = ?");
            $query->bind_param('s', $username);
            $query->execute();

            $query->bind_result($bnavn);
            $query->fetch();

            //Lukker databasetilkopling
            $query->close();
            $db_connection->close();
            
            if($bnavn)
            {
                return TRUE;
            }
            else 
            {
                return FALSE;
            }
        }
        
        function Login($username, $password)
        {
            include('db.php');
        
            $query = $db_connection->prepare("SELECT passord FROM BRUKER WHERE brukernavn = ?");
            $query->bind_param('s', $username);
            $query->execute();

            $query->bind_result($pass);
            $query->fetch();

            //Lukker databasetilkopling
            $query->close();
            $db_connection->close();
            
            if($pass && md5($password) == $pass)
            {                
                return TRUE;
            }
            else 
            {
                return FALSE;
            }
        }
        
        function ValidateUsername($username)
        {
            return preg_match('/[a-zA-Z0-9]{1,}/', $username);
        }
        
        function setUserCookie($uid)
        {
            setcookie("uid", md5($uid), time() + 21600, '/', NULL, 0); /* expire in 5 hour */ 
        }
        
        function sjekkUserCookie()
        {
            // GET cocike
            // Print an individual cookie - http://php.net/manual/en/function.setcookie.php
            // echo $_COOKIE["TestCookie"];

            // // Another way to debug/test is to view all cookies
            // print_r($_COOKIE);
   
        }
        
    }    
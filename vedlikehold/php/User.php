<?php
    class User{
        function User()
        {
            
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
            
            if (!mysqli_query($db_connection,"INSERT INTO Persons (FirstName) VALUES ('Glenn')"))
            {
                $logg->Ny('Failed to insert: '.mysqli_error($db_connection), 'ERROR', htmlspecialchars($_SERVER['PHP_SELF']), '');
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


?>
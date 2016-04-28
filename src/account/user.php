<?php
    class User{
        function User()
        {
            
        }
        
        
        function NewUser($username,$password)
        {
            include('AppSettings.php');
            include('db-tilkopling.php');
        
            ##Må oppdateres til SHA256 eller mCrypt!
            $hashetPass = md5($password);
                
            $insertUser = $db_connection->prepare("INSERT INTO BRUKER (brukernavn,passord) VALUES (?,?)");
            $insertUser->bind_param('ss', $brukernavn,$hashetPass);
            $insertUser->execute();

            //Lukker databasetilkopling
            $insertUser->close();
            $db_connection->close(); 
        }
        
        function Exsits($username)
        {
            include('AppSettings.php');
            include('db-tilkopling.php');
        
            $query = $db_connection->prepare("SELECT brukernavn FROM BRUKER WHERE brukernavn = ?");
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
            include('AppSettings.php');
            include('db-tilkopling.php');
        
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
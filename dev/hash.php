<?php


// $hash = "%242y%2411%2465178500757547f8a427buvrPnabPWM0prBaB%2FR5CXrvAC8lMFv6e";

$md = "1c55ad157755fa0456b89cd8a89a4d35";

$username = "adminisAdmin123";


if(md5($username) == $md)
{
echo 'Riktig';    
} else {
    echo 'feil';
}


?>
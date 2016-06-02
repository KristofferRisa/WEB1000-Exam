<?php
// See the password_hash() example to see where this came from.
$hash = '$2y$11$823585545574f3043e9fceu8CM9V8XqaGUIJ7pO7s31Re3VXqebNe';
$pass = '123';

if (password_verify($pass, $hash)) {
    echo 'Password is valid!';
} else {
    echo 'Invalid password.';
}

$salt = uniqid(mt_rand(), true);

$options = [
    'cost' => 11,
    'salt' => $salt,
];
$pass_hash = password_hash($pass, PASSWORD_BCRYPT, $options);

echo '<p>ny hash:</p>';
echo $pass_hash.'<br>';


if (!function_exists('base_url')) {
    function base_url($atRoot=FALSE, $atCore=FALSE, $parse=FALSE){
        if (isset($_SERVER['HTTP_HOST'])) {
            $http = isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off' ? 'https' : 'http';
            $hostname = $_SERVER['HTTP_HOST'];
            $dir =  str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);

            $core = preg_split('@/@', str_replace($_SERVER['DOCUMENT_ROOT'], '', realpath(dirname(__FILE__))), NULL, PREG_SPLIT_NO_EMPTY);
            $core = $core[0];

            $tmplt = $atRoot ? ($atCore ? "%s://%s/%s/" : "%s://%s/") : ($atCore ? "%s://%s/%s/" : "%s://%s%s");
            $end = $atRoot ? ($atCore ? $core : $hostname) : ($atCore ? $core : $dir);
            $base_url = sprintf( $tmplt, $http, $hostname, $end );
        }
        else $base_url = 'http://localhost/';

        if ($parse) {
            $base_url = parse_url($base_url);
            if (isset($base_url['path'])) if ($base_url['path'] == '/') $base_url['path'] = '';
        }

        return $base_url;
    }
}
echo base_url().'<br>';  

echo base_url(TRUE).'<br>';    //  will produce something like: http://stackoverflow.com/
echo base_url(TRUE, TRUE).'<br>';
echo base_url(NULL, TRUE).'<br>';

echo '<p>Paths</p>';
echo "http://" . $_SERVER['SERVER_NAME'];


echo '<p>baner:</p>';

//require_once(realpath($_SERVER["DOCUMENT_ROOT"]) .'/mysite/php/includes/dbconn.inc');

echo realpath($_SERVER["DOCUMENT_ROOT"]);

echo  '<p>relative baner</p>';

echo realpath(dirname(__FILE__)); //

?>



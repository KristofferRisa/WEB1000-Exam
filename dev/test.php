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
echo $pass_hash;

?>

<br>

<?php

echo '<p>baner:</p>';

//require_once(realpath($_SERVER["DOCUMENT_ROOT"]) .'/mysite/php/includes/dbconn.inc');

echo realpath($_SERVER["DOCUMENT_ROOT"]);

echo  '<p>relative baner</p>';

echo realpath(dirname(__FILE__)); //

?>
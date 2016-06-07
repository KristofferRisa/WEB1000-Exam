<?php

$url = $_SERVER['QUERY_STRING'];
$url = substr($url, 10);
echo $url;

?>
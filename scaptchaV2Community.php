<?php
//Autor: edwin velasquez jimenez
//validacion del lado del servidor con la llave secreta
//print_r($_POST);
$produccion = false;
$produccionSecret = '';
$devSecret = '';
$secret = $produccion ? $produccionSecret : $devSecret;

$cu = curl_init();
curl_setopt($cu, CURLOPT_URL, 'https://www.google.com/recaptcha/api/siteverify?response='.$_POST['response'].'&secret='.$secret);
curl_setopt($cu, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($cu);
curl_close($cu);
echo $response;
?>
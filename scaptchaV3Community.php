<?php
//Autor: edwin velasquez jimenez
//validacion del lado del servidor con la llave secreta
//print_r($_POST);
$produccion = false;
$produccionSecret = '';
$devSecret = '';
$secret = $produccion ? $produccionSecret : $devSecret;
$valores = array(
    'secret' => $secret,
    'response' => $_POST['response']
);

$cu = curl_init();
curl_setopt($cu, CURLOPT_URL, 'https://www.google.com/recaptcha/api/siteverify');
curl_setopt($cu, CURLOPT_POST, 1);
curl_setopt($cu, CURLOPT_POSTFIELDS, http_build_query($valores));
curl_setopt($cu, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($cu);
curl_close($cu);
echo $response;
?>
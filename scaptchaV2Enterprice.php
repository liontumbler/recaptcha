<?php
//Autor: edwin velasquez jimenez
//validacion del lado del servidor con la llave secreta
//print_r($_POST);
$produccion = false;
$produccionSecret = '';
$devSecret = '';
$secret = $produccion ? $produccionSecret : $devSecret;
$produccionPublic = '';
$devPublic = '';
$public = $produccion ? $produccionPublic : $devPublic;
$url = "https://recaptchaenterprise.googleapis.com/v1/projects/recaptcha-compensar-pruebas/assessments?key=$secret";
$jsonData = '{
    "event": {
        "token": "'.$_POST['response'].'",
        "siteKey": "'.$public.'",
        "expectedAction": "'.$_POST['accion'].'"
    }
}';
$parts = parse_url($_SERVER['HTTP_REFERER']);
$protocol = $parts['scheme'];
$domain = $parts['host'];
$fullDomain = $protocol . '://' . $domain;

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json; charset=utf-8',
        'Referer: '.$fullDomain
    )
);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);
echo $response;
?>
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
$options = array( 
    CURLOPT_URL => $url, 
    CURLOPT_POST => true, 
    CURLOPT_POSTFIELDS => $jsonData, 
    CURLOPT_HTTPHEADER => array( 
        "Content-Type: application/json; charset=utf-8",
        "Referer: ".$fullDomain
    ),
    CURLOPT_RETURNTRANSFER => true
);

$curl = curl_init();
curl_setopt_array($curl, $options); 
$response = curl_exec($curl);
if (curl_errno($curl)) {
    $response = curl_error($curl);
}
curl_close($curl);
echo $response;
?>
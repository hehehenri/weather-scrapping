<?php

require 'vendor/autoload.php';
use GuzzleHttp\Client;

function body($url){
    $client = new Client();

    $res = $client->request('GET', $url);

    $status = $res->getStatusCode();
    
    if($status != 200){
        throw new Exception('Status Code: '.$status);
    }

    $body = $res->getBody();
    return $body;
};

$c = "porto-alegre";
$e = "rs";

$url = "http://tempo.clic.com.br/".$e."/".$c;;


try{
    $content = body($url);

} catch (Exception $x) {
    echo "Erro: ", $x->getMessage(), "\n";
}

function clear($content){
    $body = substr($content, strpos($content, "temperature_now"));
    $body = substr($body, 0, 41);
    $body = substr($body, -4);
    return $body;
}

$t = clear($content);

function weather($t, $c, $e){
    $d = date("H:i");
    $c = str_replace("-", " ", $c);
    echo "Temperatura: ".$t."\n".ucwords($c).", ".$d."\n";
}

weather($t, $c, $e);
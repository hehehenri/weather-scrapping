<?php

require 'vendor/autoload.php';
use GuzzleHttp\Client;

/*
1. Pegar os parametros passados no cli
2. Coisar os parametros na url /estado/cidade
3. Pegar o conteudo da pagina pertencente a PORRA da url
4. Achar a desgraca da tempertura dentro do conteudo da pagina
5. Retornar a temperatura
6. Retornar o horario da requisicao
7. Retornar o local

eh isso!!!
*/

function getLocal($params, $local){
    for($i=0; $i<count($params); $i++){
        if($params[$i]=="-c" && $local=="city"){
            $local = $params[$i+1];
        }
        else if($params[$i] == "-s" && $local=="state"){
            $local = $params[$i+1];
        }
    }
    return $local;
}

function getLocalUrl($params){
    return "http://tempo.clic.com.br/".getLocal($params, "state")."/".getLocal($params, "city");
}

function getPageContent($localUrl){
    $client = new Client();
    $app = $client->request('GET', $localUrl);

    return $app->getBody();
}

function getTemperature($pageContent){
    $temperature = substr($pageContent, strpos($pageContent, "temperature_now"));
    $temperature = substr($temperature, 0, 41);
    $temperature = substr($temperature, -4);
    return $temperature;
}

function returnContent($temperature, $params){
    $city = ucwords(str_replace("-", " ", getLocal($params, "city")));
    $requestTime = date("H:i");
    echo "Temperatura: ".$temperature."C\n".$city.", ".$requestTime."\n";
}

$temperature = getTemperature(getPageContent(getLocalUrl($argv)));

echo returnContent($temperature, $argv);
<?php
function pegarJson($url) {
    $json = file_get_contents($url);
    $dados = json_decode($json);
    return $dados;
}

function descriptografar($frase, $casas) {
    $fraseDescriptografada = array();
    for ($i=0; $i < strlen($frase) ; $i++) { 
        if (ord($frase[$i])>=97 && ord($frase[$i])<=122) {
            $letra = ord($frase[$i])-$casas; 
                if($letra<97){
                    $fraseDescriptografada[$i]= chr(122 - (97 - ($letra + 1)));
                }
                else {
                    $fraseDescriptografada[$i]= chr((ord($frase[$i])-$casas));
                }
        }
        else {
            $fraseDescriptografada[$i]= chr(ord($frase[$i]));
        }
    }
    return implode($fraseDescriptografada);
}

function gerarResumoCriptografico($texto) {
    return sha1($texto);
}

$url = "https://api.codenation.dev/v1/challenge/dev-ps/generate-data?token=db07c0e4e7095d327489bc43e4d2f0a64c348b85";
$json = pegarJson($url);
$frase = $json -> cifrado;
$casas = $json -> numero_casas;
$textodecifrado = descriptografar($frase, $casas);

$resposta = $json;
$resposta -> decifrado = $textodecifrado;
$resposta -> resumo_criptografico = gerarResumoCriptografico($textodecifrado);
$arquivoAberto = fopen('resposta.json', 'w');
fwrite($arquivoAberto, json_encode($resposta));
fclose($arquivoAberto);

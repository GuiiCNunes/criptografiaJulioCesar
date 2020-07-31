<?php
function pegarJson($url) {
    $json = file_get_contents($url);
    $dados = json_decode($json);
    return $dados;
}

function descriptografar($frase, $casas) {
    $criptografia = array();
    for ($i=0; $i < strlen($frase) ; $i++) { 
        if (ord($frase[$i])>=97 && ord($frase[$i])<=122) {
            $resultado = ord($frase[$i])-$casas; 
                if($resultado<97){
                    $criptografia[$i]= chr(122 - (97 - ($resultado + 1)));
                }
                else {
                    $criptografia[$i]= chr((ord($frase[$i])-$casas));
                }
        }
        else {
            $criptografia[$i]= chr(ord($frase[$i]));
        }
    }
    return implode($criptografia);
}

function resumo_crip($texto) {
    return sha1($texto);
}

$url = "https://api.codenation.dev/v1/challenge/dev-ps/generate-data?token=db07c0e4e7095d327489bc43e4d2f0a64c348b85";
$json = pegarJson($url);
$frase = $json -> cifrado;
$casas = $json -> numero_casas;
$textodecifrado = descriptografar($frase, $casas);

$resposta = $json;
$resposta -> decifrado = $textodecifrado;
$resposta -> resumo_criptografico = resumo_crip($textodecifrado);
$arquivoAberto = fopen('resposta.json', 'w');
fwrite($arquivoAberto, json_encode($resposta));
fclose($arquivoAberto);

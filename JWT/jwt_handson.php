<?php
//para executar isso aqui
//php -S localhost:3030
//acessar no browser
//http://localhost:3030/jwt_handson.php

//Application key
//somente minha aplicação conhece essa chave
$key = '123456789';

//Header Token
$header = [
    'typ' => 'JWT',
    'alg' => 'HS256'
];

//Payload - Conteudo
$payload = [
    'exp' => (new DateTime("now"))->getTimestamp(),
    'uid' => 1,
    'email' => 'email@email.com'
];

//JSON
$header = json_encode($header);
$payload = json_encode($payload);

//Base 64
$header = base64_encode($header);
$payload = base64_encode($payload);

//Sing - minha assinatura
//true significa que é um hash binário
$sing = hash_hmac('sha256', $header.'.'.$payload, $key, true);
$sing = base64_encode($sing);

//Token
$token = $header.'.'.$payload.'.'.$sing;

print $token;
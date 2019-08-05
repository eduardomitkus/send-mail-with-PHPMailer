<?php

require __DIR__ . "/vendor/autoload.php";

use Source\Suport\Email;

$email = new Email;

$subject  = "Primeiro email";
$body = "Email enviado usando PHPMailer";
$recipient_name = " Teste";
$recipient_email = "teste@gmail.com";
$email->add($subject, $body, $recipient_name, $recipient_email)->send();

if(!$email->error()){
    var_dump("Email enviado!");
}else{
    var_dump($email->error());
}
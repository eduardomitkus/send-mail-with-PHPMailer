<?php

require __DIR__ . "/vendor/autoload.php";

use Source\Suport\Email;

$email = new Email;

$subject  = "Primeiro email";
$body = "Email enviado usando PHPMailer";
$recipientName = " Teste";
$recipientEmail = "teste@gmail.com";
$email->add($subject, $body, $recipientName, $recipientEmail)->send();

if(!$email->error()){
    var_dump("Email enviado!");
}else{
    var_dump($email->error());
}
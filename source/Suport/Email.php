<?php

namespace Source\Suport;

use stdClass;
use Exception;
use PHPMailer\PHPMailer\PHPMailer;

class Email
{
    /** @var PHPMailer */
    private $mail;
    
    /** @var stdClass */
    private $data;

    /** @var Exception */
    private $error;

    public function __construct()
    {
        $this->mail = new PHPMailer(true);
        $this->data = new stdClass;

        $this->mail->isSMTP();
        $this->mail->isHTML();
        $this->mail->setLanguage("br");

        $this->mail->SMTPAuth = true;
        $this->mail->SMTPSecure = "tls";
        $this->mail->CharSet = "utf-8";

        $this->mail->Host = MAIL['host'];
        $this->mail->Port = MAIL['port'];
        $this->mail->Username = MAIL['user'];
        $this->mail->Password = MAIL['passwd'];
    }

    public function add(string $subject, string $body, string $recipient_name, string $recipient_email): Email
    {
            $this->data->subject = $subject = $subject;
            $this->data->body = $body;
            $this->data->recipient_name = $recipient_name;
            $this->data->recipient_email = $recipient_email;        
            
            return $this;
    }

    public function attach(string $filePath, string $fileName): Email 
    {
        $this->data->attach[$filePath] = $fileName;
    }

    public function send(string $fromName = MAIL['from_name'], string $fromEmail = MAIL['from_mail']): bool
    {
        try {
            $this->mail->Subject = $this->data->subject;
            $this->mail->msgHTML($this->data->body);
            $this->mail->addAddress($this->data->recipient_email, $this->data->recipient_name);
            $this->mail->setFrom($fromEmail, $fromName);

            if(!empty($this->data->attach)){
                foreach ($this->data->attach as $path => $name) {
                    $this->mail->addAttachment($path, $name);
                }                
            }

            $this->mail->send();

            return true;
        } catch (Exception $exception) {
            $this->error = $exception;

            return false;
        }        
    }

    public function error(): ?Exception
    {
        return $this->error;
    }
}
<?php

namespace BeerApi\Shopping\Users\Infrastucture;


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mailer
{
    private string $sender;
    private string $recipient;
    private string $CCrecipient;
    private string $path;

    public function __construct(string $sender, string $recipient, string $CCrecipient = '', string $path = '')
    {
        $this->sender = $sender;
        $this->recipient = $recipient;
        $this->CCrecipient = $CCrecipient;
        $this->path = $path;
    }

    public function sendEmail($emailBody, $noHtmlBody)
    {
        if ($this->CCrecipient != '' && $this->path != '') {
            $mail = $this->auxEmail($emailBody, $noHtmlBody);
            try {
                $mail->addCC($this->CCrecipient);
                $mail->addAttachment($this->path);
                $mail->send();
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        } elseif ($this->CCrecipient == '' && $this->path != '') {
            $mail = $this->auxEmail($emailBody, $noHtmlBody);
            try {
                $mail->addAttachment($this->path);
                $mail->send();
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        } elseif ($this->CCrecipient == '' && $this->path == '') {
            $mail = $this->auxEmail($emailBody, $noHtmlBody);
            try {
                $mail->send();
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        } elseif ($this->CCrecipient != '' && $this->path == '') {
            $mail = $this->auxEmail($emailBody, $noHtmlBody);
            try {
                $mail->addCC($this->CCrecipient);
                $mail->send();
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        }
    }

    public function auxEmail($emailBody, $noHtmlBody)
    {
        $mail = new PHPMailer(true);
        try {
            // $mail->SMTPDebug = SMTP::DEBUG_SERVER;
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'alvarolarumbe97@gmail.com';
            $mail->Password = 'jllnrokvlluzdtft';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;
            $mail->setFrom($this->sender, 'Mailer');
            $mail->addAddress($this->recipient, 'Cliente');
            $mail->isHTML(true);
            $mail->Subject = 'Pedido realizado';
            $mail->Body = $emailBody;
            $mail->AltBody = $noHtmlBody;
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
        return $mail;
    }
}
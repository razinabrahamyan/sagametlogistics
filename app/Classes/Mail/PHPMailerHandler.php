<?php


namespace App\Classes\Mail;


use Exception;
use Illuminate\Support\Facades\Config;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class PHPMailerHandler
{
    const CHAR_SET = 'UTF-8';

    private $toAddresses = [];
    private $message = '';
    private $subject = '';

    public function send()
    {
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_OFF;
            $mail->CharSet = self::CHAR_SET;
            $mail->isSMTP();
            $mail->Host = Config::get('mail.mailers.smtp.host');
            $mail->SMTPAuth = true;
            $mail->Username = Config::get('mail.mailers.smtp.username');
            $mail->Password = Config::get('mail.mailers.smtp.password');
            $mail->SMTPSecure = Config::get('mail.mailers.smtp.encryption');
            $mail->Port = Config::get('mail.mailers.smtp.port');
            $mail->setFrom(Config::get('mail.from.address'), Config::get('mail.from.name'));

            //Recipients
            $toAddresses = $this->getToAddresses();
            foreach ($toAddresses as $address) {
                $mail->addAddress($address);
            }

            //Content
            $mail->isHTML(true);
            $mail->Subject = $this->getSubject();
            $mail->Body = $this->getMessage();

            return $mail->send();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * @return array
     */
    public function getToAddresses() : array
    {
        return $this->toAddresses;
    }

    /**
     * @param array $toAddresses
     * @return PHPMailerHandler
     */
    public function setToAddresses(array $toAddresses) : PHPMailerHandler
    {
        $this->toAddresses = array_unique($toAddresses);
        return $this;
    }

    /**
     * @return string
     */
    public function getMessage() : string
    {
        return $this->message;
    }

    /**
     * @param string $message
     * @return PHPMailerHandler
     */
    public function setMessage(string $message) : PHPMailerHandler
    {
        $this->message = $message;
        return $this;
    }

    /**
     * @return string
     */
    public function getSubject() : string
    {
        return $this->subject;
    }

    /**
     * @param string $subject
     * @return PHPMailerHandler
     */
    public function setSubject(string $subject) : PHPMailerHandler
    {
        $this->subject = $subject;
        return $this;
    }
}
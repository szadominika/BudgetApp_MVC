<?php

namespace App;

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

use App\Config;

//Load Composer's autoloader
//require 'vendor/autoload.php';

/**
 * Mail
 */
class Mail {

  /**
   * Send a message
   * 
   * @param string $to Recipient
   * @param string $subject Subject
   * @param string $text text only content message
   * @param string $html HTML content of the message
   * 
   * @return mixed   
   */
  public static function send($to, $subject, $text, $html) {

    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        //Server settings
        //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host        = Config::SMTP_HOST;                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = Config::SMTP_USER;                     //SMTP username
        $mail->Password   = Config::SMTP_PASS;                               //SMTP password
        $mail->SMTPSecure = 'tls';            //Enable implicit TLS encryption
        $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('konto.robocze.dominika@gmail.com', 'BudgetApp');
        $mail->addAddress($to, 'To');     //Add a recipient
        //$mail->addAddress('ellen@example.com');               //Name is optional
        $mail->Subject = $subject;
        //$mail->Body = $text;
        $mail->addReplyTo($to, 'Information');
       // $mail->addCC('cc@example.com');
        //$mail->addBCC('bcc@example.com');

        //Attachments
        //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
        //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        //$mail->Subject = 'Here is the subject';
        $mail->Body    = $html;
        $mail->AltBody = $text;

        $mail->send();
        //echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
  }
}
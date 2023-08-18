<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class HelperServiceProvider extends ServiceProvider
{
    

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Register services.
     */

    public function register()
    {
        require_once app_path() . '/Library/ApiHandler.php';
        require_once app_path() . '/Library/HTMLMinifier.php';

        require_once app_path() . '/Library/PHPMailer.php';
        require_once app_path() . '/Library/SMTP.php';
    }

    public static function api($context,$method='GET',$data=null){
        global $api_client;
        return $api_client->api_query($context,$method,$data);
    }
    public static function api_without_v2($context,$method='GET',$data=null){
        global $api_client;
        return $api_client->api_query_without_v2($context,$method,$data);
    }
    public static function minifyHTML($context=""){
        global $html_client;
        $options = ['compression_mode'=>env('HTML_COMPRESSION_MODE','none')];
        return $html_client->process($context,$options);
    }

    public static function sendCustomEmail($to,$subject,$body){
        //global $mail_client;
        $smtp_client = new \App\SMTP(true);;
        try {
            //Server settings
            $mail_client = new \App\PHPMailer(true);
            $mail_client->SMTPDebug = $smtp_client::DEBUG_SERVER;                      //Enable verbose debug output
            $mail_client->isSMTP();                                            //Send using SMTP
            $mail_client->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail_client->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail_client->Username   = 'info@stream-sense.com';                     //SMTP username
            $mail_client->Password   = 'WelCome@2021';                               //SMTP password
            $mail_client->SMTPSecure = 'TLS';         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail_client->Port       = 587;                                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

            //Recipients
            $mail_client->setFrom('info@stream-sense.com', 'IN10 Media Network');
            //$mail_client->addAddress('prafull.patil@in10media.com', 'Prafull Patil');     //Add a recipient
            $mail_client->addAddress($to);
            //$mail->addAddress('ellen@example.com');               //Name is optional
            //$mail->addReplyTo('info@example.com', 'Information');
            //$mail->addCC('cc@example.com');
            //$mail->addBCC('bcc@example.com');

            //Attachments
            //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

            //Content
            $mail_client->isHTML(true);                                  //Set email format to HTML
            $mail_client->Subject = $subject;
            $mail_client->Body    = $body;
            //$mail_client->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail_client->send();
            echo 'Message has been sent';
            $mail_client->__destruct();
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}

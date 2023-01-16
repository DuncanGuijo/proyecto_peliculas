<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';
require 'admin/inc_config.php';

// RECIBE 3 PARAMETROS PARA PERSONALIZAR ENVIO CORREO
/*
if (isset($_REQUEST['Mailto'])) {$mailto = $_REQUEST['Mailto'];}
else {
    echo 'error01';
    exit;
}
if (isset($_REQUEST['asunto'])) {$MailerAsunto = $_REQUEST['asunto'];}
else {
    echo 'error02';
    exit;
}
if (isset($_REQUEST['cuerpo'])) {$MailerBody = $_REQUEST['cuerpo'];}
else {
    echo 'error03';
    exit;
} 
*/


//Create an instance; passing `true` enables exceptions


$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                         //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                 //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = $MailerUsername;                     //SMTP username
    $mail->Password   = $MailerPassword;                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom($MailerFrom, $sitioTitulo);
    $mail->addAddress($mailto);     //Add a recipient
    
    $mail->addReplyTo($MailerReply, 'Information');
    //$mail->addCC('cc@example.com');
    //$mail->addBCC('bcc@example.com');

    //Attachments
    //$mail->addAttachment('c:/wamp22/www/infinity/admin/img/alberto.gif');         //Add attachments
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = $asunto;
    $mail->Body    = $textomail;
    $mail->Charset = 'UTF-8';                           //UTF-8
    //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
} catch (Exception $e) {
    //echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    echo 'error99';
}

?>
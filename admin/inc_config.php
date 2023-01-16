<?php

/************************** */
/* fichero de configuracion */
/************************** */


//variables de correo
$mailto = "duncan.servicio.correo@gmail.com"; //recibe el mensaje
if(isset($_SESSION['email'])){//en caso de que haya registro se crea esta variable
    $mailtoUser= $_SESSION['email'];//para enviarla al PHPMailer
}
$mailheaders = "From: duncan.servicio.correo@gmail.com\r\n";
$mailheaders .= "Reply-To: duncan.servicio.correo@gmail.com\r\n";
$mailheaders .= "X-Mailer: PHP/".phpversion();// define como se envia el texto
$MailerMail = 'duncan.servicio.correo@gmail.com';
$MailerDebug = 'SMTP::DEBUG_SERVER';
$MailerHost= 'smpt.gmail.com';
$MailerUsername = $MailerMail;
$MailerPassword = 'kolfeacddbyrexuu';
$MailerFrom = $MailerMail;
$MailerReply = $MailerMail;
$sitioTitulo = 'mi página web';
$mailEnvioPie = 'Mensaje recibido mediante contacto.php.';
$headTitle = "";
$headDescription = "";
$headKeywords =""; 




//variables del usuario recogidas en el login (login_validation.php)
if(isset($_SESSION['userId'])){
    $userId = $_SESSION['userId'];
    $username = $_SESSION['usuario'];
    $nombre = $_SESSION['nombre'];
    $apellido = $_SESSION['apellido'];
    $apellido2 = $_SESSION['apellido2'];
    $email = $_SESSION['email'];
    $estado = $_SESSION['estado'];
    $rol = $_SESSION['rol'];
    $create_at = $_SESSION['create_at'];
    $modified_at = $_SESSION['modified_at'];
}

?>
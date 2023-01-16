<?php include "admin/sesion.php"; ?>
<?php include "admin/inc_config.php"; ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <title>Contacto</title>
</head>
<body>
    <!--HEADER START-->
    <?php include("header.php"); ?>
    <!--HEADER END-->
<?php 
if ($_POST){
    $textmail = $mailheaders;
    foreach ($_POST as $key => $valor){
        $$key = $valor;
    }
    $textomail = "<h1>Mensaje Recibido de la web</h1>";
    $textomail .="<p>Asunto  : $asunto </p>";
    $textomail .="<p>Nombre : $nombre </p>";
    $textomail .="<p>email : $email </p>";
    $textomail .="<p>Mensaje</p>";
    $textomail .= "<p>$mensaje</p>";
    $textomail .= $mailEnvioPie;
    //$asunto = 'recepcion de formulario página contacto';
    //echo $textomail;
    echo "<p class='contacto_info'>Gracias $nombre, hemos recibido su mensaje, en breve nos pondremos en contacto con usted a tarvés del correo $email</p> ";


    include ('inc_PHPMailer_contacto.php');
} else { ?>      
<div class="contacto_container">
        <div class="contacto_titulo">Contactanos</div>
            <div class="contacto_info">
            <form class="contacto_info" name="formlogin" action="" method="POST">
                <label for="name">Tu nombre</label>
                <input class="contacto_info_input" type="text" class="form-control" id="nombre" name="nombre"
                placeholder="Tu Nombre">    
                <label for="email">Tu email</label>
                <input class="contacto_info_input" type="email" class="form-control" id="email" name="email" placeholder="Tu  Email">
                <label for="asunto">Asunto</label>
                <input class="contacto_info_input" type="text" class="form-control" id="asunto" name="asunto" placeholder="Escribe tu consulta..">
                <label for="message">Mensaje</label>
                <textarea class="contacto_info_input" placeholder="Dejanos tu consulta" id="message" name="mensaje" style="height: 100px"></textarea>
                <button class="contacto_button" type="submit">Enviar Mensaje</button>
            </form>
            </div>
</div>
</body>
<?php include("footer.php"); ?>
</html>

<?php } ?>
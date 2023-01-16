<?php

  include("sesion.php");
  include("inc_config.php");
  include("../recursos/funciones.php");

  if(isset($_GET['token'])){
    $clave = $_GET['clave'];
    $now = $_GET['now'];
    $email = $_GET['email'];

    //declaramos la query donde cambiamos la contraseña
    $query2 = "UPDATE usuarios SET clave = '$clave', modified_at = '$now'
    WHERE email = '$email'";
    $resultado2 = mysqli_query($con,$query2);
        if($resultado2){
           ?> <script>
                alert("cambio de contraseña correcto");
                </script>
                <?php
                header("location:../login.php?password=si");
                die();
        }else{
            echo 'Error';
        }
    }
    
    
    //comprovamos que hayan llegado correctamente los datos del form
    if (isset($_POST['email']) && !empty($_POST['email'])){
        $email = $_SESSION['email'] = $_POST['email'];
    } else {
       $error = 'Introduzca un correo valido.';
        header("location:../contraseña_nueva.php?error=$error");
        die();

    }

    if(empty($_POST['password'])){
        $error = 'Introduzca una contraseña valida.';
        header("location:../contraseña_nueva.php?error=$error");
        die();
    }

    if($_POST['password'] == $_POST['password2']){
        $clave  = $_SESSION['clave'] = $_POST['password'];
    }else{
        $error = 'Las contraseñas deben coincidir.';
        header("location:../contraseña_nueva.php?error=$error");
        die();
    }


    //declaramos la fecha de la modificacion para reflejarlo en la bd
    $now = $_SESSION['now'] = strtotime("now");
    
    //generamos el token para enviarlo al correo del usuario
    $token_length = strlen($email);
    $permited_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $token = generate_token($permited_chars,$token_length);
    $_SESSION['token'] = $token;//guardamos en session token para más seguridad

    //declaramos la query donde comprovamos que exista el usuario
    $query = "SELECT * FROM usuarios WHERE email = '$email'";
    $resultado = mysqli_query($con,$query);
    if(!$resultado){
        echo "Ha habido un error, contacte con el administrador (error:03)";
        header("location:../index.php");
    }else{

    //Enviamos token de cambio de pass al correo
    $asunto = 'Cambiar contraseña';
    $mailto = $email;
    $textomail = '<h1>Confirmación cambio contraseña</h1>';
    $textomail .= "<p>Para confimar su cambio de contraseña clique en el
    <a href='http://duncanguijo.infinityfreeapp.com/admin/contraseña_nueva_validation.php?token=$token&clave=$clave&now=$now&email=$email'>siguiente enlace. </a></p>";
    //con PHPMailer enviamos el correo con los datos que le enviamos
    include ('../inc_PHPMailer.php');
    header("location:../contraseña_nueva_pendiente.php");
    exit;
    }

    $query = "SELECT * FROM usuarios WHERE usuario = '".$_SESSION['user']."';";
    $sql = mysqli_query($con, $query);
    $fila = mysqli_fetch_assoc($query);
    if($fila['rol'] != 'A'){
        header("location:http://duncanguijo.infinityfreeapp.com");
        exit();
    }

?>
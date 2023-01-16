
<?php

include("admin/sesion.php");
include("admin/inc_config.php");

if(isset($_GET['errorNombre'])){
    $errorNombre = $_GET['errorNombre'];
  }else{
    $errorNombre = "";
}

if(isset($_GET['errorApellido'])){
    $errorApellido = $_GET['errorApellido'];
  }else{
    $errorApellido = "";
}
  
if(isset($_GET['errorApellido2'])){
    $errorApellido2 = $_GET['errorApellido2'];
  }else{
    $errorApellido2 = "";
}

if(isset($_GET['errorUsuario'])){
    $errorUsuario = $_GET['errorUsuario'];
  }else{
    $errorUsuario = "";
}

if(isset($_GET['errorPassword'])){
    $errorPassword = $_GET['errorPassword'];
  }else{
    $errorPassword = "";
}

if(isset($_GET['errorPassword2'])){
    $errorPassword2 = $_GET['errorPassword2'];
  }else{
    $errorPassword2 = "";
}

if(isset($_GET['errorEmail'])){
    $errorEmail = $_GET['errorEmail'];
  }else{
    $errorEmail = "";
}


?>


<!DOCTYPE html>
<html lang="es">

    <!-- Head Start -->
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.9.3/css/bulma.min.css" rel="stylesheet"/>
    <style type="text/css">
        .estrellas {text-shadow: 0 0 1px #F48F0A; cursor: pointer;  }
	    .estrella_dorada { color: gold; }
	    .estrella_normal { color: black; }
    </style>
    <link rel="stylesheet" href="style.css">
    <title>Registro</title>
    <script>
    function funciones(){
        mostrarContrasena();
        mostrarContrasena2();
    }

    function mostrarContrasena(){
        var tipo = document.getElementById("password");
            if(tipo.type == "password"){
                tipo.type = "text";
                }else{
                tipo.type = "password";
                }
            }

    function mostrarContrasena2(){
        var tipo = document.getElementById("password2");
            if(tipo.type == "password"){
                tipo.type = "text";
                console.log("1");
                }else{
                tipo.type = "password";
                console.log("2");
                }
            }

</script>

</head>
    <!-- Head End -->

<body>

<?php include("header.php"); ?>
    <div class="register_container">
        <h1 class="register_titulo">Crear cuenta</h1>
            <form class="user" name='form' action="admin/register_validation.php" method="POST">
                <div class="register_info">
                    <label class="register_info_campo" for="nombreR">Nombre:</label>
                        <input class="register_info_input" type="text"  name="nombreR" placeholder="Nombre" 
                        value="<?php if(isset($_GET['nombre'])){ echo $_GET['nombre'];}?>"/>
                        <?php echo '<p class="error">'.$errorNombre.'</p>';?>

                    <label class="register_info_campo" for="apellidoR">1er Apellido:</label>
                        <input class="register_info_input" type="text"   name="apellidoR"placeholder="1er Apellido" 
                        value="<?php if(isset($_GET['apellido'])){ echo $_GET['apellido'];}?>"/>
                        <?php echo '<p class="error">'.$errorApellido. '</p>';?>

                    <label class="register_info_campo" for="apellido2R">2do Apellido:</label>
                        <input class="register_info_input" type="text"   name="apellido2R"placeholder="2do Apellido" 
                        value="<?php if(isset($_GET['apellido2'])){ echo $_GET['apellido2'];}?>"/>
                        <?php echo '<p class="error">'.$errorApellido2. '</p>';?>

                    <label class="register_info_campo" for="userR">Usuario:</label>
                        <input class="register_info_input" type="text"   name="userR"placeholder="Usuario" 
                        value="<?php if(isset($_GET['user'])){ echo $_GET['user'];}?>"/>
                        <?php echo '<p class="error">'.$errorUsuario. '</p>';?>

                    <label class="register_info_campo" for="claveR">Contraseña:</label>
                        <input class="register_info_input" type="password" id="password" name="claveR"placeholder="Contraseña" />
                        <?php echo '<p class="error">'.$errorPassword. '</p>';?>

                    <label class="register_info_campo" for="claveR2">Repetir contraseña:</label>
                        <input class="register_info_input" type="password" id="password2" name="claveR2"placeholder="Repetir contraseña" />
                        <?php echo '<p class="error">'.$errorPassword2. '</p>';?>
                        <button class="register_button" type="button" onclick="funciones()"><i class="fas fa-eye"></i></span></button>
                    
                    <label class="register_info_campo" for="emailR">Email:</label>
                        <input class="register_info_input" type="text"  name="emailR" placeholder="correo@ejemplo.com" 
                        value="<?php if(isset($_GET['email'])){ echo $_GET['email'];}?>"/>
                        <?php echo '<p class="error">'.$errorEmail. '</p>';?>

                <?php  if(isset($_GET['errorUsuarioRepetido'])){ echo '<p class=error">'.$_GET['errorUsuarioRepetido'].'</p>';} ?> 
                <input class="register_button" type="submit" name="registrar" value="Registrar" class="btn btn-primary btn-user btn-block">
                </div>
            </form>
                <div class="register_info">
                    <a class="login_info" href="contraseña_nueva.php">¿Olvidaste la contraseña?</a>
                </div>
                <div class="register_info">
                    <a class="small" href="login.php">¿Ya tienes una cuenta? ¡Inicia sesión!</a>
                </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

<?php include("footer.php"); ?>

</html>
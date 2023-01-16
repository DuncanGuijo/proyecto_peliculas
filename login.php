<?php
  include("admin/sesion.php");
  include("admin/inc_config.php");

  if(isset($_GET['error'])){
    $error = $_GET['error'];
  }else{
    $error = "";
  }
  if(isset($_GET['registro'])){
    ?>
    <script type="text/javascript">
    alert("¡Registro correcto! Ya puedes iniciar sesión.")
    </script>
    <?php 
    $flag='NO';
   }

   if(isset($_GET['password'])){
    ?>
    <script type="text/javascript">
        alert("¡Cambio de contraseña correcto!")
    </script>
    <?php
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
    <title>Login</title>
    <script>
         function mostrarContrasena(){
            var tipo = document.getElementById("password");
            if(tipo.type == "password"){
                tipo.type = "text";
                    }else{
                tipo.type = "password";
                }
            }
    </script>
</head>
    <!-- Head End -->

<body>
    <?php include("header.php"); ?>

    <div class="container">

        <!-- Outer Row -->
        <div class="login_container">
            <h1 class="login_titulo">¡Bienvenido<?php if(isset($_SESSION['nombre'])){echo " ".$_SESSION['nombre'];} ?>!</h1>
                <form class="user" name="form" action="admin/login_validation.php" method="POST">
                    <div class="login_info">
                        <label class="login_info_campo" for="username">Usuario o email:</label>
                        <input type="text" class="login_info_input"
                        id="username" name="username" aria-describedby="username Help"
                        placeholder="Introduza su usuario o email...">
                        <label class="login_info_campo" for="password">Contraseña:</label>
                        <input type="password" id="password" class="login_info_input"
                        id="password" name="password"aria-describedby="password Help" placeholder="Introduza su contraseña...">
                        <button class="login_button" type="button" onclick="mostrarContrasena()"><span id="icon">
                            <i class="fas fa-eye"></i></span>
                        </button>
                        <?php echo '<p class="error">' .$error. '</p>'; ?>
                        <label class="login_info" for="customCheck">Recordarme<input type="checkbox" class="login_info" id="customCheck"></label>
                        <input type="submit" name="submit" value="Login" class="login_button">
                        <a href="index.html" class="btn btn-google btn-user btn-block">
                </form>
                <a class="login_info" href="contraseña_nueva.php">¿Olvidaste la contraseña?</a>
                <a class="login_info" href="register.php">¡Crea una cuenta!</a>                        
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
<?php
  include("admin/sesion.php");
  include("admin/inc_config.php");

  if(isset($_GET['error'])){
    $error = $_GET['error'];
  }else{
    $error = "";
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
    <style type="text/css">
        .estrellas {text-shadow: 0 0 1px #F48F0A; cursor: pointer;  }
	    .estrella_dorada { color: gold; }
	    .estrella_normal { color: black; }
    </style>
    <link rel="stylesheet" href="style.css">
    <title>Login</title>
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

    <div class="container">

        <!-- Outer Row -->
        <div class="login_container">
            <h1 class="login_titulo">¡Ya casi estamos!</h1>
                <form class="user" name="form" action="admin/contraseña_nueva_validation.php" method="POST">
                    <div class="login_info">
                        <label class="login_info_campo" for="email">Email:</label>
                        <input type="text" class="login_info_input"
                        id="username" name="email" aria-describedby="username Help"
                        placeholder="Introduza su usuario...">
                        <label class="login_info_campo" for="password">Nueva contraseña:</label>
                        <input type="password" class="login_info_input"
                        id="password" name="password" aria-describedby="password Help" placeholder="Introduza su contraseña...">
                        <label class="login_info_campo" for="password2">Introduzca de nuevo su contraseña:</label>
                        <input type="password" class="login_info_input"
                        id="password2" name="password2" aria-describedby="password Help" placeholder="Introduza su contraseña...">
                        <button class="login_button" type="button" onclick="funciones()"><span id="icon">
                            <i class="fas fa-eye"></i></span>
                        </button>
                        <p class="error"><?php echo $error; ?></p><br>
                        <input type="submit" name="submit" value="Enviar" class="login_button">
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
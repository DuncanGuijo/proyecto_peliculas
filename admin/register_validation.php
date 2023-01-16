<?php

include("sesion.php");
include("inc_config.php");

include("../recursos/funciones.php");

//Variables
$nombreR = $apellidoR = $apellido2R = $userR = $emailR = $githubR = $token = "";

//Variables de errores
$errorNombre = $errorApellido = $errorApellido2 = $errorUsuario = $errorPassword = $errorPassword2= $errorEmail = $errorGithub = $errorUsuarioRepetido='';
$errorR = 'NO';

if(isset($_POST['registrar'])){

	//comprovaciones
	//nombre
	if(empty($_POST['nombreR'])){
		$errorNombre ="Este campo no puede estar vacío";
		$errorR = 'SI';
		header("location:../register.php?errorNombre=$errorNombre");
		die();
	}else{
		$_SESSION['nombre'] = $nombre = recogerVar($_POST['nombreR']);
	}

	if(length80($_POST['nombreR'])){
		$errorNombre ="80 carácteres como máximo.";
		$errorR = 'SI';
		header("location:../register.php?errorNombre=$errorNombre");
		die();
	}else{
		$_SESSION['nombre'] = $nombre = recogerVar($_POST['nombreR']);
	}

	//apellidos
	if(empty($_POST['apellidoR'])){
		$errorApellido ="Este campo no puede estar vacío.";
		$errorR = 'SI';
		header("location:../register.php?nombre=$nombre&errorApellido=$errorApellido");
		die();
	}else{
		$_SESSION['apellido'] = $apellido = recogerVar($_POST['apellidoR']);
	}

	if(length80($_POST['apellidoR'])){
		$errorApellido ="80 carácteres como máximo.";
		$errorR = 'SI';
		header("location:../register.php?nombre=$nombre&errorApellido=$errorApellido");
		die();	
	}

	if(empty($_POST['apellido2R'])){
		$errorApellido2 ="Este campo no puede estar vacío.";
		$errorR = 'SI';
		header("location:../register.php?nombre=$nombre&apellido=$apellido&errorApellido2=$errorApellido2");
		die();
	}else{
		$_SESSION['apellido2'] = $apellido2 = recogerVar($_POST['apellido2R']);
	}

	if(length80($_POST['apellido2R'])){
		$errorApellido2 ="80 carácteres como máximo.";
		$errorR = 'SI';
		header("location:../register.php?nombre=$nombre&apellido=$apellido&errorApellido2=$errorApellido2");
		die();	
	}

	//user
	if(empty($_POST['userR'])){
		$errorUsuario ="Este campo no puede estar vacío.";
		$errorR = 'SI';
		header("location:../register.php?nombre=$nombre&apellido=$apellido&apellido2=$apellido2&errorUsuario=$errorUsuario");
		die();
	}else{
		$_SESSION['user'] = $user = recogerVar($_POST['userR']);

	}

	if(length255($_POST['userR'])){
		$errorUsuario ="255 carácteres como máximo.";
		$errorR = 'SI';
		header("location:../register.php?nombre=$nombre&apellido=$apellido&apellido2=$apellido2&errorUsuario=$errorUsuario");
		die();
	}else{
		$_SESSION['user'] = $user = recogerVar($_POST['userR']);

	}


	//clave
	if(empty($_POST['claveR'])){
		$errorPassword ="Este campo no puede estar vacío.";
		$errorR = 'SI';
		header("location:../register.php?nombre=$nombre&apellido=$apellido&apellido2=$apellido2&user=$user&errorPassword=$errorPassword");
		die();
	}else{
		$_SESSION['clave'] = recogerVar($_POST['claveR']);
	}

	if(espaciosEnblanco($_POST['claveR'])){
		$errorPassword ="Este campo no puede estar vacío.";
		$errorR = 'SI';
		header("location:../register.php?nombre=$nombre&apellido=$apellido&apellido2=$apellido2&user=$user&errorPassword=$errorPassword");
		die();
	}else{
		$_SESSION['clave'] = recogerVar($_POST['claveR']);
	}

	if(length269($_POST['claveR'])){
		$errorPassword ="269 carácteres como máximo.";
		$errorR = 'SI';
		header("location:../register.php?nombre=$nombre&apellido=$apellido&apellido2=$apellido2&user=$user&errorPassword=$errorPassword");
		die();
	}else{
		$_SESSION['clave'] = recogerVar($_POST['claveR']);
	}

	if(empty($_POST['claveR2']) && ($_POST['claveR'] != $_POST['claveR2'])){
		$errorPassword2 ="La contraseña no coincide.";
		$errorR = 'SI';
		header("location:../register.php?nombre=$nombre&apellido=$apellido&apellido2=$apellido2&user=$user&errorPassword2=$errorPassword2");
		die();
	}else{
		$_SESSION['clave2'] = recogerVar($_POST['claveR2']);

	}

	//email
	if(empty($_POST['emailR'])){
		$errorEmail ="Este campo no puede estar vacío.";
		$errorR = 'SI';
		header("location:../register.php?nombre=$nombre&apellido=$apellido&apellido2=$apellido2&user=$user&errorEmail=$errorEmail");
		die();
	}else{
		$_SESSION['email'] = $email = recogerVar($_POST['emailR']);
	}

	if(!filter_var($_POST['emailR'],FILTER_VALIDATE_EMAIL)){
		$errorEmail ="Introduzca un formato válido.Ej: peliculas@correo.es";
		$errorR = 'SI';
		header("location:../register.php?nombre=$nombre&apellido=$apellido&apellido2=$apellido2&user=$user&errorEmail=$errorEmail");
		die();
	}else{
		$_SESSION['email'] = $email = recogerVar($_POST['emailR']);
	}

	//asocio valores a las variables a la sesion 
	$nombreR = $_SESSION['nombre'] = recogerVar($_POST['nombreR']);
	$apellidoR = $_SESSION['apellido'] = recogerVar($_POST['apellidoR']);
	$apellido2R = $_SESSION['apellido2'] = recogerVar($_POST['apellido2R']);
	$userR = $_SESSION['user'] = recogerVar($_POST['userR']);
	$passwordR = $_SESSION['clave'] = recogerVar($_POST['claveR']);
	$passwordR2 = $_SESSION['clave2'] = recogerVar($_POST['claveR2']);
	$emailR = $_SESSION['email'] = recogerVar($_POST['emailR']);
	if($errorR =='NO'){

		//saneamiento
		$nombreR = mysqli_real_escape_string($con,$nombreR);
		$apellidoR = mysqli_real_escape_string($con,$apellidoR);
		$apellido2R = mysqli_real_escape_string($con,$apellido2R);
		$userR = mysqli_real_escape_string($con,$userR);
		$passwordR = mysqli_real_escape_string($con,$passwordR);
		$emailR = mysqli_real_escape_string($con,filter_var($emailR,FILTER_SANITIZE_EMAIL));
		$githubR = mysqli_real_escape_string($con,$githubR);
		$fecha_creacion = date_create('Y-m-d');
		$token_length = strlen($passwordR);
		$permited_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$token = generate_token($permited_chars,$token_length);
		$fecha_en_unix = strtotime("now");

		
		$password_encriptada = sha1($passwordR);//tengo que implementar la recepcion con sha1 tambien

		$sqluser = "SELECT usuario, email FROM usuarios WHERE usuario ='$userR' OR email = '$emailR'";

		$resultadouser = $con->query($sqluser);

		$filas = $resultadouser->num_rows;

		if($filas > 0){
			$errorUsuarioRepetido ="Este usuario o email ya existe.";
			header("location:../register.php?nombre=$nombre&apellido=$apellido&apellido2=$apellido2&user=$user&email=$email&errorUsuarioRepetido=$errorUsuarioRepetido");

		}else{
			$sqlusuario = "INSERT INTO usuarios(nombre,apellido,apellido2,usuario,clave,email,estado,rol,token,github,create_at,modified_at) 
							VALUES('$nombreR','$apellidoR','$apellido2R','$userR','$passwordR','$emailR','P','U','$token','$githubR','$fecha_en_unix','$fecha_en_unix')";
        	$resultadousuario = $con->query($sqlusuario);
			$id = mysqli_insert_id($con);
			//$_SESSION['login_user_sys']=$userR;
			if($resultadousuario > 0){
				//Enviar token de activacion al correo
				$_SESSION['email'] = $email;
				//$_SESSION['token'] = $token;
				$asunto =  'Activar usuario.'; // asunto del mensaje
				$mailto = $email; // a quien enviamos el correo
				$textomail = '<h1>Confirmación cuenta</h1>'; 
				$textomail .= "<p>Estimado $nombre : </p>
				<p>Para confirmar su registro clique en el 
				<a href='http://duncanguijo.infinityfreeapp.com/admin/usuario_activar.php?token=$token&id=$id'>siguiente enlace. </a><p>";
				?>

				<?php	
				//con PHPMailer enviamos el correo con los datos que le enviamos
				include ('../inc_PHPMailer.php');
				header("location:../register_pendiente.php");
                //header("location:login.php?registro=si");
                exit;
				?> </form> <?php
			}else{			
				echo "<script>
				alert('Registro incorrecto');
		  	    </script>";
                header("location:login.php");
                exit;
			}
		}
	}
}
?>
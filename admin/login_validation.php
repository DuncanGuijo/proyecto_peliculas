<?php
include("sesion.php");
include("inc_config.php");
     
$username= $password= $error = "";

if(isset($_POST['submit'])){
    if(empty($_POST['username']) || empty($_POST['password'])){
        $error = "No se permiten campos vacios";
        header("location:../login.php?error=$error");
    }else{
        include("conexion.php");
        //declaramos la consulta
        $username = $_SESSION['username'] = $_POST['username'];
        $password = $_SESSION['password'] = $_POST['password'];//esto quizas es una vulnerabilidad
        $sql = "SELECT * FROM usuarios WHERE usuario = '" .$username . "' OR email = '".$username. "' and estado = 'A' and clave = '" .$password. "';";
        //enviamos la consulta con la conexion y los datos que pedimos
        $query = mysqli_query($con,$sql);
        //con rows cuantificamos el numero de filas del resultado
        $counter = mysqli_num_rows($query);
    if($counter==1){
            $fila = mysqli_fetch_assoc($query);
            //guardamos variables en el proceso de iniciar sesion
            $userId = $_SESSION['userId'] = $fila['id'];
            $nombre = $_SESSION['nombre'] = $fila['nombre'];
            $usuario = $_SESSION['usuario'] = $fila['usuario'];
            $apellido = $_SESSION['apellido'] = $fila['apellido'];
            $apellido2 = $_SESSION['apellido2'] = $fila['apellido2'];
            $email = $_SESSION['email'] = $fila['email'];
            $estado = $_SESSION['estado'] = $fila['estado'];
            $rol = $_SESSION['rol'] = $fila['rol'];
            $create_at = $_SESSION['create_at'] = date('d/m/Y',$fila['create_at']);
            $modified_at = $_SESSION['modified_at'] = date('d/m/Y',$fila['modified_at']);
            switch ($fila['rol']){
                case 'U':
                    echo $fila['id'];
                    header("location:../index.php");
                    break;
                case 'A':
                    header("location:index.php");
                    break;
                default:
                    header("location:../index.php");
                    break;
            }
        }else{
            $error = "Usuario o contraseña no validas.";
            header("location:../login.php?error=$error");
        }
    }
}

?>
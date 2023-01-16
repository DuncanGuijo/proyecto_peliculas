<?php
include("sesion.php");


//bloqueamos el acceso a todo aquel que no sea administrador
$username = $_SESSION['usuario'];
$consulta = "SELECT * FROM usuarios WHERE usuario = '".$username."';";
$resultado = mysqli_query($con, $consulta);
$contador = mysqli_num_rows($resultado);
if($contador==1){
    $fila = mysqli_fetch_assoc($resultado);
    if($fila['rol'] != 'A'){
        header("location:../index.php");
        die();
    }
}else{
    header("location:../index.php");
    die();
}


if(isset($_GET['token'])&& isset($_GET['id'])){
    $token = $_GET['token'];
    $id = $_GET['id'];
    $query = "SELECT * from usuarios WHERE id = $id AND token = '$token'";
    $resultado = mysqli_query($con,$query);
    echo '1';
    if($resultado){
        echo'2';
        $query2 = "UPDATE usuarios SET estado = 'A' WHERE id = $id AND token = '$token'";
        $resultado2 = mysqli_query($con,$query2);
        header("location:http://duncanguijo.infinityfreeapp.com/login.php?registro=si");
    }

    }else{
        echo "error";
    }

?>
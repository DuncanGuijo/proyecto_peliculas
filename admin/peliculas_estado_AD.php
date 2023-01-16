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

$id = $_REQUEST['id']; 
$estado = $_REQUEST['estado'];
$query = "update  peliculas set estado = '".$estado."'  where id = $id";
$resultado = mysqli_query($con,$query);
if ($resultado){
    header("location:peliculas_panel.php");
} else {
    echo $query;
}
?>
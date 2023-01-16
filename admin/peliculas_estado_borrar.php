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
$query = "DELETE FROM peliculas WHERE id =$id";
$query2 = "DELETE FROM peli_genero WHERE peliculaid=$id";
$resultado = mysqli_query($con,$query);
$resultado2 = mysqli_query($con,$query2);
if ($resultado AND $resultado2){
    header("location:peliculas_panel.php");
} else {
    echo $query;
    echo $query2;
}
?>

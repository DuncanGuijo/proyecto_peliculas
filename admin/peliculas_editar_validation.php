<!DOCTYPE html>
<?php

include("sesion.php");


//bloqueamos el acceso a todo aquel que no sea administrador
$username = $_SESSION['usuario'];
$consulta = "SELECT * FROM usuarios WHERE usuario = '" . $username . "';";
$resultado = mysqli_query($con, $consulta);
$contador = mysqli_num_rows($resultado);
if ($contador == 1) {
    $fila = mysqli_fetch_assoc($resultado);
    if ($fila['rol'] != 'A') {
        header("location:../index.php");
        die();
    }
} else {
    header("location:../index.php");
    die();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    echo 'No hay nada que modificar';
    exit;
}

foreach ($_REQUEST as $key => $valor) {
    $$key = $valor;
}

$genero = [];
if (isset($_REQUEST['genero'])) {
    $genero = $_REQUEST['genero'];
}

$query =
    "UPDATE peliculas
 SET titulo = '$titulo',
     estreno = '$estreno',
     estado = '$estado',
     overview= '$overview',
     opinion = '$opinion'
 WHERE id = $id";


$resultado = mysqli_query($con, $query);
if ($resultado) {
}
if (!$resultado) {
    echo "<p>error $query </p>";
}

/* borro todos los generos asociados a la peli */
$query = "DELETE FROM peli_genero WHERE peliculaid = $id";
$resultado = mysqli_query($con, $query);
if (!$resultado) {
    echo "<p>error $query </p>";
}


/* inserto los generos que se han enviado */
foreach ($genero as $valor) {
    $query = "INSERT INTO peli_genero
    (peliculaid,generoid) VALUES ($id,$valor)";
    $resultado = mysqli_query($con, $query);
    if ($resultado) {
    }

    if (!$resultado) {
        echo "<p>error $query </p>";
    }
}

mysqli_close($con);
$flag = "ok";
header("location:peliculas_editar.php?id=$id&flag=$flag");
exit;
?>

<a href="peliculas_grabar.php">Ir a lista</a>
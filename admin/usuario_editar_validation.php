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


echo $id;
$now = strtotime("now");
$query =
    "UPDATE usuarios
 SET nombre = '$nombre',
     apellido = '$apellido1',
     apellido2 = '$apellido2',
     usuario = '$usuario',
     clave = '$clave',
     email = '$email',
     estado = '$estado',
     rol = '$rol',
     github = '$github',
     modified_at = '$now'

 WHERE id = $id";


$resultado = mysqli_query($con, $query);
if ($resultado) {
    echo "OK";
}
if (!$resultado) {
    echo "<p>error $query </p>";
}


mysqli_close($con);
$flag = "ok";
header("location:usuario_editar.php?id=$id&flag=$flag");
exit;
?>
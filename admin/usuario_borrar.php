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
?>
    <script>
        alertify.confirm('Confirm Title', 'Confirm Message',
            function() {
                document.miFormulario.submit();
                alertify.success('Ok')
            },
            function() {
                alertify.error('Cancel')

            })
    </script>

<?php
} else {
    echo 'No hay nada que borrar';
    exit;
}

foreach ($_REQUEST as $key => $valor) {
    $$key = $valor;
}

$query = "DELETE FROM usuarios  WHERE id = $id";


$resultado = mysqli_query($con, $query);
if ($resultado) {
    echo "OK";
}
if (!$resultado) {
    echo "<p>error $query </p>";
}


mysqli_close($con);
$flag = "ok";
header("location:usuario_lista.php?flag=$flag");
exit;
?>
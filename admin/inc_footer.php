<?php
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
?>

<footer class="sticky-footer bg-white">
    <div class="container my-auto">
        <div class="copyright text-center my-auto">
            <span>Copyright &copy; Your Website 2021</span>
        </div>
    </div>
</footer>
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

if (isset($_GET['id'])){
    $id=$_GET['id'];
} else {
    echo 'No hay nada que modificar';
    exit;
}

$flag = "";

if(!empty($_GET['flag'])){
    ?>
    <script>
        alert("Usuario editado correctamente");
    </script>
    <?php
}

?>


<!DOCTYPE html>
<html lang="es">

    <!-- Head Start -->
    <?php include("inc_head.php"); ?>
    <!-- Head End -->

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php include("inc_sidebar.php"); ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php include("inc_topbar.php"); ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Administrador de peliculas.</h1>
                    <p class="mb-4">Editar datos de la pelicula: <?php echo $id; ?>.</p>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary"></h6>
                        </div>
                        
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Nombre</th>
                                            <th>1er Apellido</th>
                                            <th>2do Apellido</th>
                                            <th>Usuario</th>
                                            <th>clave</th>
                                            <th>email</th>
                                            <th>Estado</th>
                                            <th>Rol</th>
                                            <th>Github</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php

                                    $query = "select * from usuarios where id = $id";
                                    $resultado = mysqli_query($con,$query);

                                    if(mysqli_num_rows($resultado)!=0){    
                                        echo '<form name="form1" action="usuario_editar_validation.php?id='. $id .'" method="POST">';
                                        while($fila=mysqli_fetch_array($resultado)){  ?>  
                                        <tr>
                                        <input type="hidden" name="id"  value="<?php echo $fila["id"]; ?>">
                                        <td><input type="text" size="7" name="nombre"   id="nombre" value="<?php echo $fila["nombre"]; ?>"  ></td>
                                        <td><input type="text" size="7" name="apellido1" id="apellido1" value="<?php echo $fila["apellido"]; ?>" ></td>
                                        <td><input type="text" size="7" name="apellido2" id="apellido2" value="<?php echo $fila["apellido2"]; ?>" ></td>
                                        <td><input type="text" size="7"name="usuario"   id="usuario" value="<?php echo $fila["usuario"]; ?>" ></td>
                                        <td><input type="text" size="10" name="clave"   id="clave" value="<?php echo $fila["clave"]; ?>" ></td>
                                        <td><input type="text" size="10" name="email"   id="mail" value="<?php echo $fila["email"]; ?>" ></td>
                                        
                                        <?php $chequeado = "checked"; ?>

                                        <td>Activo <input type="radio" name="estado"  value="A" <?php if($fila['estado']=='A') {echo 'CHECKED';}?> >
                                        Desactivado <input type="radio" name="estado"  value="D" <?php if($fila['estado']=='D') {echo 'CHECKED';}?> >
                                        Borrado <input type="radio" name="estado"  value="B" <?php if($fila['estado']=='S') {echo 'CHECKED';}?> >
                                        Impagado <input type="radio" name="estado"  value="D" <?php if($fila['estado']=='I') {echo 'CHECKED';}?> >
                                        Pendiente <input type="radio" name="estado"  value="P" <?php if($fila['estado']=='D') {echo 'CHECKED';}?> ></td>
                                       
                                        <?php $chequeado2 = "checked"; ?>

                                        <td>Administrador <input type="radio" name="rol" value="A" <?php if($fila['rol']=='A'){echo 'CHECKED';}?> >
                                        Usuario <input type="radio" name="rol" value="U" <?php if($fila['rol']=='U'){echo 'CHECKED';} ?> ></td>
                                        <td><input type="text" size="7" name="github" id="github" value="<?php echo $fila["github"]; ?>" ></td>

                                <?php } // FIN WHILE ?> 

                                    <td><input type="submit" name="submit"  value="editar"?></td>
                                    </tr>
                                    </form>      
                                <?php 
                                    }else{ ?>     
                                    <article>
                                    <p class='precio'>Lo siento,  no hay resultados</p>
                                    </article>    
                                <?php } ?>     
                                <?php  mysqli_close($con);
                                ?>
                                   </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <?php include("inc_footer.php"); ?>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/datatables-demo.js"></script>

</body>

</html>
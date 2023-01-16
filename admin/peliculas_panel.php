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
                    <h1 class="h3 mb-2 text-gray-800">Administrador de películas.</h1>
                    <p class="mb-4">Edita,cambia el estado o borra películas desde el panel .</p>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Editar eliculas</h6>
                        </div>
                        
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Tmdb_id</th>
                                            <th>Titulo</th>
                                            <th>Póster</th>
                                            <th>Fecha de estreno</th>
                                            <th>Géneros</th>
                                            <th>Estado</th>
                                            <th>Editar</th>
                                            <th>Borrar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $query = "select * from peliculas";
                                    $resultado = mysqli_query($con,$query);
                                    while($fila=mysqli_fetch_array($resultado)){  ?>   
                                        <tr>
                                            
                                                <td ><?php echo $fila["id"] ?> </td>
                                                 <td><?php echo $fila["tmdb_id"] ?></td>
                                                 <td><?php echo $fila["titulo"] ?></td>
                                                 <td>
                                                    <img src="https://image.tmdb.org/t/p/w154/<?php echo $fila["poster"] ?>" />
                                                    <p>https://image.tmdb.org/t/p/w154/<?php echo $fila["poster"] ?></p> 
                                                 </td>
                                                 <td><?php echo $fila["estreno"] ?></td>
                                                 <td>
                                                 <?php
                                                     $query2= "select genero.genero as generop from genero,peli_genero where peli_genero.peliculaid = ".  $fila['id'] ." and peli_genero.generoid =genero.id";
                                                    $resultado2 = mysqli_query($con,$query2);
                                                    while($fila2=mysqli_fetch_array($resultado2)){
                                                        echo $fila2['generop'] . ' ' ;
                                                    }
                                                 ?>
                                                </td>
                                                <td>
                                                    <?php if ($fila['estado']=='A')
                                                    {
                                                        echo '<a href="peliculas_estado_AD.php?id='. $fila['id'].'&estado=D">Desactivar</a>';
                                                    } else {
                                                        echo '<a href="peliculas_estado_AD.php?id='. $fila['id'].'&estado=A">Activar</a>';
                                                    }
                                                    ?>
                                                </td>
                                                 <td> 
                                                    <?php
                                                 echo '<a href="peliculas_editar.php?id='. $fila['id'].'">Editar</a>';  ?>             
                                                 </td>
                                                 <td>
                                                    <?php
                                                    echo '<a href="peliculas_estado_borrar.php?id='. $fila['id'].'">Borrar</a>';?>
                                                </td>
                                               
                                    </tr>
                                    <?php } // FIN WHILE ?> 
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
                    <h5 class="modal-title" id="exampleModalLabel">¿Estas seguro?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Si desea cerrar sesión pulse "Logout".</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="sesion_cerrar_admin.php">Logout</a>
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
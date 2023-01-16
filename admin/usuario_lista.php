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

$flag = "";

if(!empty($_GET['flag'])){
    ?>
    <script>
        alert("Usuario eliminado correctamente");
    </script>
    <?php
}

?>

<!DOCTYPE html>
<html lang="en">

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
                    <h1 class="h3 mb-2 text-gray-800">Administrador de usuarios</h1>
                    <p class="mb-4">Listado de todos los usuarios y datos.</p>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Usuarios</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Nombre</th>
                                            <th>1er Apellido</th>
                                            <th>2do Apellido</th>
                                            <th>Usuario</th>
                                            <th>Clave</th>
                                            <th>Email</th>
                                            <th>Estado</th>
                                            <th>Rol</th>
                                            <th>Github</th>
                                            <th>Fecha creacion</th>
                                            <th>Fecha modificación</th>
                                            <th>Editar</th>
                                            <th>Eliminar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php

                                    $query = "SELECT * FROM usuarios";
                                    $resultado = mysqli_query($con,$query);
                                    if(mysqli_num_rows($resultado)!=0){
                                        while($fila = mysqli_fetch_array($resultado)){
                                            echo '<tr>';
                                            echo '<td>' .$fila['id']. '</td>';
                                            echo '<td>' .$fila['nombre']. '</td>';
                                            echo '<td>' .$fila['apellido']. '</td>';
                                            echo '<td>' .$fila['apellido2']. '</td>';
                                            echo '<td>' .$fila['usuario']. '</td>';
                                            echo '<td>' .$fila['clave']. '</td>';
                                            echo '<td>' .$fila['email']. '</td>';
                                            echo '<td>' .$fila['estado']. '</td>';
                                            echo '<td>' .$fila['rol']. '</td>';
                                            echo '<td>' .$fila['github']. '</td>';
                                            echo '<td>' .date('d/m/Y',$fila['create_at']). '</td>';
                                            echo '<td>' .date('d/m/Y',$fila['modified_at']). '</td>';
                                            echo '<td> <a href="usuario_editar.php?id=' .$fila['id'].'">Editar</a></td>';
                                            echo '<td> <a href="usuario_borrar.php?id=' .$fila['id'].'">Borrar</a></td>';
                                            echo '</tr>';

                                        }
                                    }
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
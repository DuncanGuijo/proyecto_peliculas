<?php

include("sesion.php");

if(!empty($_GET['flag'])){
    ?>
    <script>
        alert("Pelicula grabada correctamente.");
    </script>
    <?php
}

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
                    <p class="mb-4">Introduzca en el cuadro de busqueda la película quiera encontrar.</p>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Buscar peliculas</h6>

                        </div>
                        
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Fecha de estreno</th>
                                            <th>Titulo</th>
                                            <th>Sinopsis</th>
                                            <th>Puntuación</th>
                                            <th>Grabar</th>
                                            <th>Imagen</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    
                                    if (isset($_POST['search'])){
                                        $search = urlencode( $_POST['search']);
                                        $url = "https://api.themoviedb.org/3/search/movie?api_key=$apikey&language=es&query=$search&page=1&include_adult=false";
                                        if(empty($search)){
                                            exit;
                                        }
                                        $resultado = file_get_contents($url);
                                        $items = json_decode($resultado, true);
                                        $pelis = $items['results']; 
                                    
                                        foreach($pelis as $valor){

                                            if(empty($valor['id'])){
                                                $valor['id']="";
                                            }
                                            if(empty($valor['release_date'])){
                                                $valor['release_date']="";
                                            }  
                                            if(empty($valor['original_title'])){
                                                $valor['original_title']="";
                                            } 
                                            if(empty($valor['overview'])){
                                                $valor['overview']="";
                                            } 
                                            if(empty($valor['vote_average'])){
                                                $valor['vote_average']="";
                                            }
                                            if(empty($valor['poster_path'])){
                                                $valor['poster_path']="";
                                            }  

                                            $tmdbid = $valor['id'];
                                            echo '<tr>';
                                            echo '<td>' .$valor['id']. '</td>';
                                            echo '<td>' .$valor['release_date']. '</td>';
                                            echo '<td>' .$valor['original_title']. '</td>';
                                            echo '<td>' .$valor['overview']. '</td>';
                                            echo '<td>' .$valor['vote_average']. '</td>';
                                            echo '<td> <a href="peliculas_grabar.php?id='.$tmdbid.'">Grabar</a></td>' ;
                                            echo '<td><img src="'.$tmdb_ruta_poster.$valor['poster_path'].'" width="40px"></td>';                                            
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
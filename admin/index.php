<?php


include("sesion.php");
include("inc_config.php");

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
                        <!-- Approach -->
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Bienvenido al panel del administrador</h6>
                            </div>
                            <div class="card-body">
                                <p>Desde el menú lateral podrás acceder al control de usuarios y editar sus datos o bien acceder
                                    a los paneles de edición de peliculas donde podrás añadirlas y editarlas.</p>
                            </div>
                        </div>  
                    <!-- Content Row -->
                    <div class="row">

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Películas activas:</div>
                                            <?php
                                            //query del total de peliculas en estado activo
                                            $query = "SELECT estado FROM peliculas WHERE estado = 'A'";
                                            $resultado = mysqli_query($con, $query);
                                            $total = mysqli_num_rows($resultado);
                                            ?>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $total ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Total de usuarios activos:</div>
                                            <?php
                                            //query del total de usuarios en estado activo
                                            $query2 = "SELECT estado FROM usuarios WHERE estado = 'A'";
                                            $resultado2 = mysqli_query($con, $query2);
                                            $totalUsersActive = mysqli_num_rows($resultado2);
                                            ?>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $totalUsersActive ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total de usuarios:
                                                <?php
                                                $query3 = "SELECT id FROM usuarios";
                                                $resultado3 = mysqli_query($con, $query3);
                                                $totalUsers = mysqli_num_rows($resultado3);
                                                ?>
                                            </div>
                                            <div class="row no-gutters align-items-center">
                                                <div class="col-auto">
                                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo $totalUsers ?></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>




                    </div>
                </div>

            </div>
            <!-- /.container-fluid -->

            <!-- Chart Js -->
            <script src="https://cdn.jsdelivr.net/npm/chart.js@latest/dist/Chart.min.js"></script>
            <!--Puntuación de peliculas -->
            <canvas id="grafica"></canvas>

            <?php 
            
            //SOLICITAMOS LOS DATOS NECESARIOS PARA HACER LAS GRAFICAS
            
            $queryVoto = "SELECT AVG(`valoracion`)valoracion, titulo, id, elemento_votado  FROM `votaciones`, `peliculas` WHERE `id` =`elemento_votado` GROUP BY elemento_votado ORDER BY valoracion DESC";
            $resultadoVoto = mysqli_query($con, $queryVoto);
            $valoracion = array(); //creamos un array para guardar las votaciones
            $titulo = array(); //Creamos un array para guardas los titulos
            $contador = 0;//Creamos un contador para guardar cada dato en una posición diferente
            while($fila = mysqli_fetch_array($resultadoVoto)){
                $valoracion[$contador] = $fila['valoracion'];
                $titulo[$contador] = $fila['titulo'];
                $contador++;
            }
            ?>
            <script>
                // Referencia al elemento canvas del DOM
                const $grafica = document.querySelector("#grafica");
                // Las etiquetas son las que van en el eje X. Mediante el echo json_encode conseguimos que js lea correctamente el array
                const etiquetas = <?php echo json_encode($titulo); ?>;
                const peliculas = {
                    label: "Puntuación de peliculas",
                    data: <?php echo json_encode($valoracion); ?>, // La data es un array con las votaciones
                    backgroundColor: 'rgba(54, 162, 235, 0.2)', // Color de fondo
                    borderColor: 'rgba(54, 162, 235, 1)', // Color del borde
                    borderWidth: 1, // Ancho del borde
                };
                new Chart($grafica, {
                    type: 'horizontalBar', // Tipo de gráfica
                    data: {
                        labels: etiquetas,// Labels es un array con los titutlos
                        datasets: [
                            peliculas, //Los datos del const peliculas
                        ]
                    },
                    options: {
                        scales: {
                            xAxes: [{ //eje x
                                ticks: {
                                    beginAtZero: true //Para que la grafica empiece a 0 en el eje x
                                },
                                    barPercentage: 1 //tamaño de las barras
                            }]
                        },
                        elements: {
                            rectangle: {
                                borderSkipped: 'left',  
                            }
                        }
                    }
                });
            </script>
        </div>
        <!-- End of Main Content -->



    </div>
    <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>

</body>

</html>
<?php
include("admin/sesion.php");

if (isset($_GET['id'])){
    $id=$_GET['id'];
}else{
    header("location:admin/404.php");
    exit;
} 

if (!isset($_SESSION['userId'])){
    header("location:index.php");
}

$queryId = "SELECT * FROM peliculas WHERE id = $id";
$resultadoId = mysqli_query($con,$queryId);
if(mysqli_num_rows($resultadoId)==0){
    header("location:404.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;700&display=swap" rel="stylesheet">
    <style type="text/css">
	    .estrellas {text-shadow: 0 0 1px #F48F0A; cursor: pointer;  }
	    .estrella_dorada { color: gold; }
	    .estrella_normal { color: black; }
    </style>
    <link rel="stylesheet" href="style.css">
    <title>Página principal</title>
    <?php
    // Incluir la clase Votacion desde el fichero votaciones.php
    include './votaciones.php';
    // Activar un objeto de trabajo
    $V = new Votacion();
    ?>
<!-- Incluir jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<!-- Definir la función de puntuación -->
<script type="text/javascript">
    function ratestar($id, $puntuacion){
        $.ajax({
            type: 'GET',
            url: 'votaciones.php',
            data: 'votarElemento='+$id+'&puntuacion='+$puntuacion,
            success: function(data) {
                alert(data);
                location.reload();
            }
        });
    }
</script>
</head>

<body>

    <!--HEADER START-->
    <?php include("header.php");?>
     <!--HEADER END-->

<?php 

    $query = "SELECT * FROM peliculas WHERE id = $id";
    $query2 = "SELECT DISTINCT  genero  FROM genero,peli_genero WHERE peliculaid = $id and id = generoid";
    $resultado = mysqli_query($con,$query);
    $resultado2 = mysqli_query($con,$query2);
    if(mysqli_num_rows($resultado)!=0){
        while($fila = mysqli_fetch_array($resultado)){

            //obtenemos los datos de la pelicula
            $ruta = $fila["poster"];
            $url = "https://image.tmdb.org/t/p/w500/$ruta";
            $estreno = $fila["estreno"];
            $overview = $fila["overview"];
            $titulo = $fila['titulo'];
            $tmdbid = $fila['tmdb_id'];

            //obtenemos el trailer de la pelicula
            $url2 = "https://api.themoviedb.org/3/movie/$tmdbid/videos?api_key=98fee347b91da83932ea8b9daa0edece&language=es";
            $resultado3 = file_get_contents($url2);
            $items = json_decode($resultado3, true);
            $results3 = $items['results'];
            if (isset($results3[0]['key'])){
                $trailer = $results3[0]['key'];
                $youtube = "https://www.youtube.com/embed/$trailer";
            }
            
            //obtenemos los generos
            $contador = 0;
            if(mysqli_num_rows($resultado2)!=0){
                while($fila2 = mysqli_fetch_array($resultado2)){
                    @$generos .= $fila2['genero']. ', ';
                    $contador++;
                    if($contador>= mysqli_num_rows($resultado2)){
                        $generos = substr($generos,0,-2);
                        $generos .= ".";
                        break;
                    }
                }
            }

            //obtenemos los creditos de la pelicula
            //con el contador delimitamos cuantos datos queremos obtener
            $url3 = "https://api.themoviedb.org/3/movie/$tmdbid/credits?api_key=98fee347b91da83932ea8b9daa0edece&language=es";
            $resultado4 = file_get_contents($url3);
            $items2 = json_decode($resultado4, true);
            $cast = $items2['cast'];
            $crew = $items2['crew'];
            $contador = 0;
            foreach ($crew as $key => $valor){
                if($valor['known_for_department']=='Directing'){
                    @$director .= $valor['original_name']. ', ';
                    $contador++;
                    if($contador >1){
                        $director = substr($director,0,-2);
                        $director .=".";
                        break;
                    }

                }
            }

            $contador = 0;
            foreach($cast as $key => $valor){
                if($valor['known_for_department']=='Acting'){           
                        @$actores .= $valor['original_name']. ', ';
                        $contador++;
                        if($contador >2){
                            $actores = substr($actores,0, -2);
                            $actores .=".";
                            break;
                        }
                }
            }


            //insertamos los datos en la pagina
            echo             
                '
                <div class="pelicula_detalle_container">
                
                    <div class="peliculas_detalle_info">
                    <h1 class="peliculas_detalle_titulo"> '.$titulo.'</h1>
                        <p class="peliculas_detalle_overview">'.$overview.'</p>
                        <p class="peliculas_detalle_estreno"> Fecha de estreno: ' .$estreno. '.</p><br>
                        <p class="peliculas_detalle_estreno"> Dirección: '.$director. ' </p><br>
                        <p class="peliculas_detalle_estreno"> Actores: '.$actores.' </p><br>
                        <p class="peliculas_detalle_estreno"> Géneros: '. $generos.'</p><br>'; ?>
                        <p class="peliculas_detalle_estreno">Valoración media: <?php echo $V->obtener_la_puntuacion_de($id);?></p><br>
                        <?php echo $V->mostrar_estrellitas_para($id);?>
                        <?php


                
                if(isset($youtube)){
                    echo '<div class="video">' ?>
                    <iframe src="<?php echo  $youtube; ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    <?php echo '</div></div>';
                }else{ 
                echo '<div class="movie_photo">
                        <img src="'.$url.'">
                     </div> </div>';
                }
        }
    }

?>

<?php  /*include("footer.php");*/?>
</body>

</html>
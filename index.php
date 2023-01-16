<?php
include("admin/sesion.php");
include("admin/inc_config.php");

$_SESSION['IP']=$_SERVER['REMOTE_ADDR'];

//QUERY PARA PONER EL FONDO CON LA ULTIMA PELICULA ACTIVA
$query = "SELECT poster,tmdb_id,id FROM peliculas WHERE estado='A' ORDER BY id DESC LIMIT 1";
$resultado = mysqli_query($con,$query);
if(mysqli_num_rows($resultado)!=0){
    $fila=mysqli_fetch_array($resultado);
    $ruta = $fila["poster"];
    $id = $fila['tmdb_id'];
    //$url = "https://api.themoviedb.org/3/movie/$id/images?api_key=$apikey&language=es/$ruta";
    $url = "https://image.tmdb.org/t/p/w500/$ruta";
    //echo $url;
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
        section{
            height:calc(100vh - 80px);
            display: flex;
            justify-content: center;
            align-items: center;
        }
        section::before{
            content:"";
            background: linear-gradient(rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.5)),url(<?php echo $url;?>);
            background-size:contain;
            background-position:center-center;
            position:absolute;
            top:80px;
            right:0px;
            bottom:0px;
            left:0px;
            opacity:.5;
            z-index: -1;
        }
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
        <?php include("header.php"); ?>
    <!--HEADER END-->

     <?php

//cargamos una pagina u otra depende de si el usuario a iniciado sesion o no
if(isset($_SESSION['userId']) && !empty($_SESSION['userId'])){
    //ESTA PARTE ES LA DEL USUARIO REGISTRADO

    
        //ÚLTIMAS PELICULAS 
        echo '<h3 class="cabecera">ESTRENOS</h3>';
        $query = "SELECT titulo,poster,estreno,overview,id FROM peliculas WHERE estado='A' ORDER BY id DESC LIMIT 4";
        $resultado = mysqli_query($con,$query);
        if(mysqli_num_rows($resultado)!=0){
            echo '<div class="div_last_movies_container_grid">';
            while($fila = mysqli_fetch_array($resultado)){

                //obtenemos los datos de las peliculas
                $ruta = $fila["poster"];
                $url = "https://image.tmdb.org/t/p/w154/$ruta";
                $estreno = $fila["estreno"];
                $overview = $fila["overview"];
                $id = $fila['id'];
                    echo '<div class="div_movies">
                     <div class="div_photo_little">
                     <a href="peliculas_detalle.php?id='. $fila['id']. '"><img src="'.$url.'"></a>
                     </div>
                     <div class="div_movies_info">
                     <p class="fecha_estreno"> Fecha de estreno: ' .$estreno. '</p>
                     <p class="info_pelicula">' .substr($overview,0,150). '...<a class="ref" href="peliculas_detalle.php?id='. $fila['id']. '">Ver más</a></p>' ?>
                     <p class="info_pelicula">Valoración media: <?php echo $V->obtener_la_puntuacion_de($id);?></p>
                     <p class="info_pelicula"> <?php echo $V->mostrar_estrellitas_para($id);?></p>
                     <?php /*<p class="info_pelicula">Valoración personal: <?php echo $V->obtener_la_puntuacion_de_usuario($id,$_SESSION['userId']);?> */?>
                     <?php /*<p class="info_pelicula"> <?php echo $V->mostrar_estrellitas_para_usuario($id,$_SESSION['userId']);?> */ ?>
                     <?php echo'
                     </div>
                     </div>';
            }
        }
        echo '</div>';


        // CATEGORIAS POR GENEROS
        echo '<h3 class="cabecera_categorias id="cat">CATEGORÍAS</h3>';
        $query2 = "SELECT * FROM genero";
        $resultado2 = mysqli_query($con,$query2);
        //print_r($resultado);
        if(mysqli_num_rows($resultado2)!=0){ 
            echo '<div class="div_categories_container_grid">';          
            while($fila=mysqli_fetch_array($resultado2)){                 
                $generoid = $fila['id'];
                $query3 = "select peliculas.* from peliculas,peli_genero where peliculas.id = peli_genero.peliculaid and peli_genero.generoid = $generoid  order by peliculas.titulo";
                $resultado3 = mysqli_query($con,$query3);
                $numpelis = mysqli_num_rows($resultado3);
                //EN CASO DE QUE EXISTAN PELICULAS DE DICHO GENERO 
                //GRABADAS EN LA BD ACCEDEMOS A BUSCAR UNA IMAGEN DE CADA UNA
                if ($numpelis>0){

                //CON ESTA QUERY SELECCIONAMOS UNA IMAGEN DE UNA PELICULA DE CADA GENERO
                $query4 = "SELECT * FROM peliculas, peli_genero WHERE peliculas.id = peli_genero.peliculaid and 
                peli_genero.generoid = $generoid   ORDER BY peliculas.estreno DESC LIMIT 1";
                $resultado4 = mysqli_query($con,$query4);
                $fila4 =mysqli_fetch_array($resultado4);
                $ruta4 = $fila4["poster"];
                $id4 = $fila4['tmdb_id'];
                $url4 = "https://image.tmdb.org/t/p/w154/$ruta4";
                //echo $url4;                
                
                ?> 
                    <div class="div_categories">
                        <?php echo '<p class="cabecera_cat">'.$fila['genero'].'</p>';?>
                            <div class="div_categories_info">
                            <div class="image_category">
                                <a href="peliculas_categoria.php?cat=<?php echo $generoid ?>"><img src="<?php echo $url4?>"/></a>
                            </div>

                                <?php
                                while ($fila3=mysqli_fetch_assoc($resultado3))
                                {  ?>

                          <?php /*  <p><a href="peliculas_detalle.php?id=<?php echo $fila3['id'];?>"><?php echo $fila3['titulo'];?></a></p> */ ?>

                                <?php } ?>
                            </div>
                    </div>
            <?php  }  ?>
        <?php }
        } echo '</div>';

        include("footer.php");
        ?>  

    <?php 

    //USUARIOS NO REGISTRADOS
    }else{ ?>

    <section>
        <div class="div_menu_foto">
            <div class=div_menu_h>
            <h1 class="menu_h1">Las mejores películas y mucho más.</h1>
            <h2 class="menu_h2">Todo el cine a tu alcance.</h2>
            <h3 class="menu_h3">¡Regístrate para no perderte las últimas novedades!</h3>
            <h3 class="menu_h3">Usuario de prueba:</h3>
            <p class="menu_h3">Usuario: user / Contraseña: 1234</p>
            </div>
        </div>
    </section>

    

        <?php include("footer.php"); } ?>

</body>

</html>

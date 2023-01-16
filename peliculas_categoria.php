<?php
include("admin/sesion.php");
include("admin/inc_config.php");

if (isset($_GET['cat'])){
    $cat=$_GET['cat'];
} else{
    header("location:admin/404.php");
    exit;
} 

if(!isset($_SESSION['userId'])){
    header("location:index.php");
}

$queryCat = "SELECT genero FROM genero WHERE id = $cat";
$resultadoCat = mysqli_query($con,$queryCat);
if(mysqli_num_rows($resultadoCat)==0){
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
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <title>Página principal</title>
    
    <?php
    // Incluir la clase Votacion desde el fichero votaciones.php
    include './votaciones.php';
    // Activar un objeto de trabajo
    $V = new Votacion();
    ?>
<!-- Estilo CSS para las estrellas -->
    <style type="text/css">
	    .estrellas {text-shadow: 0 0 1px #F48F0A; cursor: pointer;  }
	    .estrella_dorada { color: gold; }
	    .estrella_normal { color: black; }
</style>

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

    //PELICULAS DE X CATEGORIA

//QUERY PARA SELECCIONAR EL TITULO DE LA CATEROGIA
$query2 = "SELECT genero FROM genero WHERE id = $cat";
$resultado2 = mysqli_query($con,$query2);
$fila2 = mysqli_fetch_array($resultado2);
$categoria = $fila2['genero'];

echo '<h3 class="cabecera"> '.$categoria. '</h3>';

$query = "SELECT * FROM peliculas, peli_genero WHERE peliculas.id = peli_genero.peliculaid and 
peli_genero.generoid = $cat and estado='A' ORDER BY peliculas.titulo";
$resultado = mysqli_query($con,$query);
if(mysqli_num_rows($resultado)!=0){
echo '<div class="div_movies_categories_container">';
while($fila = mysqli_fetch_array($resultado)){ 

    $ruta = $fila['poster'];
    $id = $fila['id'];
    $url ="https://image.tmdb.org/t/p/w154/$ruta";
    //$categoria = $fila['genero'];
    $estreno = $fila['estreno'];
    $overview = $fila['overview'];
    $peliculaid = $fila['peliculaid'];
     ?>     

    <div class="div_movies_categories">
        <div class="div_photo_little_categories">
        <a  href="peliculas_detalle.php?id= <?php echo $peliculaid; ?>"> <img src="<?php echo $url; ?>"> </a>
        </div>
        <div class="div_movies_info_categories">
            <p class="fecha_estreno_categories">Fecha de estreno: <?php echo $estreno; ?> </p>
            <p class="info_pelicula"> <?php echo substr($overview,0,150); ?>...<a class="ref" href="peliculas_detalle.php?id= <?php echo $peliculaid; ?>">
            Ver más </a></p>
            <p class="info_pelicula">Valoración media: <?php echo $V->obtener_la_puntuacion_de($id);?></p>
            <p class="info_pelicula"> <?php echo $V->mostrar_estrellitas_para($id);?></p>
            <?php /*<p class="info_pelicula">Valoración personal: <?php echo $V->obtener_la_puntuacion_de_usuario($id,$_SESSION['userId']);?> */ ?>
            <?php /*<p class="info_pelicula"> <?php echo $V->mostrar_estrellitas_para_usuario($id,$_SESSION['userId']);?> */ ?>
        </div>
    </div>

<?php 

} }
; ?>
</div>
<?php include("footer.php"); ?>
</body>
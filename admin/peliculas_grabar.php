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

$tmdbid = $_REQUEST['id'];
/************************************************
 *   OBTENCION DE DATOS DE API                  *
 ***********************************************/

//EN ESTA URL ENCONTRAMOS DATOS ACERCA DE LA PELICULA
$url = "https://api.themoviedb.org/3/movie/$tmdbid?api_key=98fee347b91da83932ea8b9daa0edece&language=es";
$resultado = file_get_contents($url);
$items = json_decode($resultado, true);


//EN ESTA URL ENCONTRAMOS DATOS DEL TRAILER EN YOUTUBE 
$url2 = "https://api.themoviedb.org/3/movie/$tmdbid/videos?api_key=98fee347b91da83932ea8b9daa0edece&language=es";
$resultado2 = file_get_contents($url2);
$items2 = json_decode($resultado2, true);
$results2 = $items2['results'];

if (isset($results2[0]['key'])) {
    $trailer = $results2[0]['key'];
} else {
    $trailer = '';
}

$url3 = "https://api.themoviedb.org/3/movie/$tmdbid/credits?api_key=98fee347b91da83932ea8b9daa0edece&language=es";
$resultado3 = file_get_contents($url3);
$items3 = json_decode($resultado3, true);

$cast = $items3['cast'];

/*************************************************** *
 * generar registro en peliculas                      *
 *****************************************************/

$query = "INSERT INTO peliculas (tmdb_id,titulo,poster,estado,estreno,overview) values ('" . $items['id'] . "','" . addslashes($items['title']) . "','" . $items['poster_path'] . "','D','" . $items['release_date'] . "','" . $items['overview'] . "')";
echo $query;
$resultado = mysqli_query($con, $query);
if ($resultado) {
    echo 'Ok';
    $lastid = mysqli_insert_id($con); // id del ultimo registro insertado
    // generos  
    echo '<hr>';
    $generos = $items['genres'];
    foreach ($generos as $key => $valor) {
        echo '<p>' . $valor['id'] . ' = ' . $valor['name'] . '</p>';
        $queryi = "INSERT INTO peli_genero (peliculaid,generoid) VALUES ($lastid," . $valor['id'] . ")";
        $resultado1 = mysqli_query($con, $queryi);
        if ($resultado1) {

            $flag = "ok";
            header("location:peliculas_buscar.php?flag=$flag");
        } else {
            echo "<p>$queryi</p>";
        }
    }
} else {
    echo '$query';
}
mysqli_close($con);

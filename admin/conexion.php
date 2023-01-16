<?php
$servidor="";
$bduser="";
$bdclave="";
$bdnombre="";
$con=mysqli_connect($servidor,$bduser,$bdclave,$bdnombre) ; 
if ($con) 
{ 
    mysqli_set_charset($con, 'utf8');

}

/* valores tmdb themovie.org */
$apikey='';
$tmdb_ruta_poster = 'https://image.tmdb.org/t/p/w154/'; // carpetada donde estan las imagenes de poster 

?>
<!DOCTYPE html>
<html>
<head>
<title>Valoraciones</title>

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
function ratestar(id, puntuacion){
	$.ajax({
		type: 'GET',
		url: 'votaciones.php',
		data: 'votarElemento='+id+'&puntuacion='+puntuacion,
		success: function(data) {
			alert(data);
			location.reload();
		}
	});
}
</script>

</head>
<body>
<?php
// Incluir la clase Votacion desde el fichero votaciones.php
include './votaciones.php';

// Activar un objeto de trabajo
$V = new Votacion();
?>

<!-- Ejemplo para un supuesto elemento con ID 1 -->
<h1>Elemento con ID: 1</h1>
<p>Por ejemplo, el artículo, noticia o producto con id = 1</p>

<?php
// Mostrar la valoración media
echo '<p>Valoración media: '.$V->obtener_la_puntuacion_de(1).'</p>';

// Mostrar las estrellas
echo $V->mostrar_estrellitas_para(1);
?>

<!-- Ejemplo para un supuesto elemento con ID 1 -->
<h1>Elemento con ID: 2</h1>
<p>Por ejemplo, otro artículo, noticia o producto con id = 2</p>
<p>Puedes mostrar solo la valoración, si quieres:</p>

<?php
// Mostrar la valoración media
echo '<p>Valoración media: '.$V->obtener_la_puntuacion_de(2).'</p>';
?>

<p>Y si prefieres mostrar solo las estrellas, también puedes hacerlo:</p>

<?php
// Mostrar la valoración media
echo '<p>Valoración media: '.$V->mostrar_estrellitas_para(2).'</p>';
?>
       
</body>
</html>

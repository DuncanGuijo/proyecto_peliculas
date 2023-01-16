<?php
// Abrir sesión para evitar votos múltiples
//session_start();
if (session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

include("admin/inc_config.php");

// Definir la clase Votación
class Votacion{

	// Datos de acceso a la base de datos
	private $host        = 'sql205.epizy.com';
	private $usuario     = 'epiz_33227734';
	private $clave       = 'RPuV70yW9W';
	private $basededatos = 'epiz_33227734_peliculas';
/* 	private $host        = 'sql305.epizy.com'; */
/* 	private $usuario     = 'epiz_30918323'; */
/* 	private $clave       = 'MI6hODcUFSm'; */
/* 	private $basededatos = 'epiz_30918323_peliculas'; */
	public  $db;



	public function __construct(){
		if(!isset($this->db)){
			// Conectar a la base de datos    
			try {
			$this->db = new mysqli($this->host, $this->usuario, $this->clave, $this->basededatos);
			$this->db->set_charset("utf8");
			}catch (Exception $e){
			$error = $e->getMessage();
			echo $error;
			}
		}
	}

	// Método para pillar la puntuación de un elemento
	public function obtener_la_puntuacion_de($elemento){

		// Asegurar la variable para evitar ataques SQL
		$elemento=$this->db->real_escape_string($elemento);

		// Consultar la media de valoraciónes
		$sql = "SELECT AVG(`valoracion`) FROM `votaciones` WHERE `elemento_votado`='".$elemento."'";

		// Hacer la consulta y guardar el resultado
		$resultado = $this->db->query($sql);

		// Asignar el resultado a una variable
		list($puntuacion_media)=$resultado->fetch_row();

		// Devolver la puntuación
		return $puntuacion_media;
		
	}

	// Método para mostrar las estrellitas
	public function mostrar_estrellitas_para($elemento){

		// Pillamos la puntuación
		$puntuacion_media = $this->obtener_la_puntuacion_de($elemento);

		// Generar el HTML resultante
		$HTML_output='<div class="estrellas">';
 
 			// Generamos un bucle de 5 iteraciones (1 por estrella)
			for($i = 1; $i <= 5; $i++) {

				// Si esta estrella está por debajo de la puntuación, está dorada
				if($i <= $puntuacion_media) {
					$clase_css_estrella='estrella_dorada';

				//Si está por encima de la puntuación, está normal
				}else{
					$clase_css_estrella='estrella_normal';
				}

				// Añadir la estrella con su clase CSS y su función para puntuar
				$HTML_output.='<span class="'.$clase_css_estrella.'" onclick="ratestar('.$elemento.','.$i.')">&#x2605;</span>';
			}
		
		// Cerrar DIV estrella
		$HTML_output.='</div>';

		// Devolver el HTML resultante final
		return $HTML_output;

	}

		// Método para mostrar las estrellitas por usuario
		public function mostrar_estrellitas_para_usuario($elemento,$userId){

			// Pillamos la puntuación
			$puntuacion_media = $this->obtener_la_puntuacion_de_usuario($elemento,$userId);
	
			// Generar el HTML resultante
			$HTML_output='<div class="estrellas">';
	 
				 // Generamos un bucle de 5 iteraciones (1 por estrella)
				for($i = 1; $i <= 5; $i++) {
	
					// Si esta estrella está por debajo de la puntuación, está dorada
					if($i <= $puntuacion_media) {
						$clase_css_estrella='estrella_dorada';
	
					//Si está por encima de la puntuación, está normal
					}else{
						$clase_css_estrella='estrella_normal';
					}
	
					// Añadir la estrella con su clase CSS y su función para puntuar
					$HTML_output.='<span class="'.$clase_css_estrella.'" onclick="ratestar('.$elemento.','.$i.')">&#x2605;</span>';
				}
			
			// Cerrar DIV estrella
			$HTML_output.='</div>';
	
			// Devolver el HTML resultante final
			return $HTML_output;
	
		}

// Método para pillar la puntuación de un elemento
public function obtener_la_puntuacion_de_usuario($elemento,$userId){

	// Asegurar la variable para evitar ataques SQL
	$elemento=$this->db->real_escape_string($elemento);

	// Consultar la media de valoraciónes
	 $sql = "SELECT valoracion FROM `votaciones` WHERE `elemento_votado`='".$elemento."' and usuarioid = $userId";

	// Hacer la consulta y guardar el resultado
	$resultado = $this->db->query($sql);

	// Asignar el resultado a una variable
	list($puntuacion_media)=$resultado->fetch_row();

	// Devolver la puntuación
	return $puntuacion_media;
	
}

	// Método para añadir una votación nueva
	public function insertar_puntuacion($elemento_votado, $puntuacion){

		$puede_votar=true;

		// Comprobar si ya ha votado durante esta sesión
		if( isset($_SESSION['elementos_votados']) ){

			if( in_array($elemento_votado,$_SESSION['elementos_votados']) ){
				echo 'Ya has votado';
				$puede_votar=false;
			}else{

				// Agregar este elemento a la lista
				$_SESSION['elementos_votados'][]=$elemento_votado;

			}

		}else{

			$_SESSION['elementos_votados']=array($elemento_votado);

		}


		// Si aún no ha votado, permitir que lo haga

		if($puede_votar){
			// Asegurar la variable para evitar ataques SQL
			$elemento_votado=$this->db->real_escape_string($elemento_votado);
			$puntuacion=$this->db->real_escape_string($puntuacion);

			// Realizar la inserción en la BD
			$sql = "INSERT INTO `votaciones` (`usuarioid`,`elemento_votado`,`valoracion`) VALUES ('".$_SESSION['userId']."','".$elemento_votado."','".$puntuacion."')";

			// Comprobar si ha fallado la consulta
			$result = $this->db->query($sql);
			if($result) { 
				echo 'Votación correcta';
			}
		}
	}
 
}


// Comprobar si hay que insertar una votacion
if(isset($_GET['votarElemento'])){
	if (!isset($_SESSION['userId'])){ // controla los usuarios registrados
		echo("Debes estar registrado \r\nPara poder votar"); 
	} else {
		$V = new Votacion();
		$V->insertar_puntuacion($_GET['votarElemento'], $_GET['puntuacion']);
	}
}

?>
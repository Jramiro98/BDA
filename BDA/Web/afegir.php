<?php
$id = $_POST["idAdd"];
$empresa = $_POST["nombre1"];
$accions = $_POST["acciones"];
$preu = $_POST["preu"];
$noSQL = true;

try {
	$conn = new PDO("mysql:dbname=imdb_small;host=localhost", "root");
	#Parem el autocommit, així el fem manualment quan sabem que tot ha anat correctament
	$create = "CREATE TABLE IF NOT EXISTS `empresas2` (`idEmpresa` varchar(80) DEFAULT NULL,`nombreEmpresa` varchar(80) DEFAULT NULL,`accionesEmpresa` int DEFAULT NULL, `precioAcciones` int DEFAULT NULL) ENGINE=InnoDB DEFAULT CHARSET=latin1"; 
	$conn->exec($create);
	$conn->beginTransaction();
   	$sql = "INSERT INTO `empresas2`(`idEmpresa`,`nombreEmpresa`, `accionesEmpresa`, `precioAcciones`) VALUES ('$id','$empresa','$accions','$preu')";
    $conn->exec($sql);
}catch(PDOException $e){
	echo $sql . "<br>" . $e->getMessage();
	$noSQL = false;
}
if ($noSQL){
	try{
		$host = "localhost";
		$port = 8086;
		#inicialitzem un nou client, en host i port on tenim la base de dades.
		$client = new InfluxDB\Client($host, $port);
		#ens connectem a la base de dades que volem, en el nostre cas es presentació
		$database = $client->selectDB('Empresas');
		#afegim dades a partir d'una array de punts que passarem al mètode de writePOints
		$points = array(new Point(
		'Borsa', // the name of the measurement
		null, // measurement value
		['idEmpresa' => $id, 'nombreEmpresa' => $empresa], // measurement tags
		['accionsEmpresa' => $accions, 'preuAccions' => $preu], // measurement fields
		exec('date +%s%N') // timestamp in nanoseconds on Linux ONLY
		)
		);
		#escribim a la base de dades
		$result = $database->writePoints($points, Database::PRECISION_SECONDS);
		$conn->commit();

	}catch(PDOException $e){
	echo $sql . "<br>" . $e->getMessage();
	#Si hem tingut algun problema fem rollback
	$conn->rollback();
	}
}
?>

<?php
$id = $_POST["idEdit"];
$empresa = $_POST["nombreEdit"];
$accions = $_POST["accionesEdit"];
$preu = $_POST["preuEdit"];
$noSQL = true;

try {
	$conn = new PDO("mysql:dbname=imdb_small;host=localhost", "root");
	#Parem el autocommit, així el fem manualment quan sabem que tot ha anat correctament
	$conn->beginTransaction();
	$sql = "UPDATE empresas2 SET nombreEmpresa = '$empresa', accionesEmpresa = '$accions' , precioAcciones = '$preu' WHERE idEmpresa = '$id'";
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

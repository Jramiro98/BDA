<?php
$id = $_POST["idDelete"];
$noSQL = true;

try {
	$conn = new PDO("mysql:dbname=imdb_small;host=localhost", "root");
	#Parem el autocommit, així el fem manualment quan sabem que tot ha anat correctament
	$conn->beginTransaction();
	$sql = "DELETE FROM empresas2 WHERE idEmpresa = '$id'";
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
		$points = array(new Point(
		'Borsa', // the name of the measurement
		null, // measurement value
		['idEmpresa' => $id, 'nombreEmpresa' => "Empresa Borrada"], // measurement tags
		['accionsEmpresa' => 0, 'preuAccions' => 0], // measurement fields
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

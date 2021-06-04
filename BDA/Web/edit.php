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
			#NOSQL

		#fem el commit
		$conn->commit();
		echo "S'ha editat la empresa a la base de dades sql";


	}catch(PDOException $e){
	echo $sql . "<br>" . $e->getMessage();
	#Si hem tingut algun problema fem rollback
	$conn->rollback();
	}
}
?>

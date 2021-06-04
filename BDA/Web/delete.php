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
		
		$conn->commit();
		echo "S'ha borrat la empresa de la base de dades sql";

	}catch(PDOException $e){
	echo $sql . "<br>" . $e->getMessage();
	#Si hem tingut algun problema fem rollback
	$conn->rollback();
	}
}
?>

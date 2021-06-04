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

		$conn->commit();
		echo "S'ha afegit la empresa a la base de dades sql";

	}catch(PDOException $e){
	echo $sql . "<br>" . $e->getMessage();
	#Si hem tingut algun problema fem rollback
	$conn->rollback();
	}
}
?>

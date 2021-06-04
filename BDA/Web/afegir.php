<?php
$id = $_POST["idAdd"];
$empresa = $_POST["nombre1"];
$accions = $_POST["acciones"];
$preu = $_POST["preu"];
$noSQL = true;

try {
	$conn = new PDO("mysql:dbname=imdb_small;host=localhost", "root");
	$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
	$conn->beginTransaction();
	$create = "CREATE TABLE IF NOT EXISTS `empresas2` (`idEmpresa` varchar(80) DEFAULT NULL,`nombreEmpresa` varchar(80) DEFAULT NULL,`accionesEmpresa` int DEFAULT NULL, `precioAcciones` int DEFAULT NULL) ENGINE=InnoDB DEFAULT CHARSET=latin1"; 
	$conn->exec($create);
   	$sql = "INSERT INTO `empresas2`(`idEmpresa`,`nombreEmpresa`, `accionesEmpresa`, `precioAcciones`) VALUES ('$id','$empresa','$accions','$preu')";
    $conn->exec($sql);
}catch(PDOException $e){
	echo $sql . "<br>" . $e->getMessage();
	$noSQL = false;
}
if ($noSQL){
	try{
			#NOSQL

	}catch(PDOException $e){
	echo $sql . "<br>" . $e->getMessage();
	$conn->rollback();
	}
}
?>
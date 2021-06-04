<!DOCTYPE html>
<html>
<head>
<title>Borsa d'Empreses</title>
</head>
<body>
	<h2>Borsa d'empreses</h2>
		FORMULARI PER AFEGIR EMPRESES:
	<div class = "row">
		<form role="form" method="POST" action = "afegir.php">
			<div>
				Identificador Empresa: <input type="text" name="idAdd" id="idAdd"/>
				Nom Empresa: <input type="text" name="nombre1" id="nombre1"/>
				Accions Empresa: <input type="text" name="acciones" id= "acciones"/>
				Preu Accions: <input type="text" name="preu" id="preu"/>
				<button id ="enviar_formularioAdd">Afegir Empresa a la Borsa</button>
			</div>
		</form>
	</div>

	<div class = "row">
		FORMULARI PER A MODIFICAR DADES EMPRESES:
		<form role="form" method="POST" action = "edit.php">
			<div>
				Identificador Empresa: <input type="text" name="idEdit" id="idEdit"/>
				Nom Empresa: <input type="text" name="nombreEdit" id="nombreEdit"/>
				Accions Empresa: <input type="text" name="accionesEdit" id= "accionesEdit"/>
				Preu Accions: <input type="text" name="preuEdit" id="preuEdit"/>
				<button id ="enviar_formularioEdit">Editar Empresa a la Borsa</button>
			</div>
		</form>
	</div>

	<div class = "row">
		FORMULARI PER A ELIMINAR UNA EMPRESA:
		<form role="form" method="POST" action = "delete.php">
			<div>
				Identificador Empresa: <input type="text" name="idDelete" id="idAdd"/>
				<button id ="enviar_formularioDelete">Borrar Empresa</button>
			</div>
		</form>
	</div>
</span>
</body>
</html>
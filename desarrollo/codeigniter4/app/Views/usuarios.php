<main>
	<div class="fondo_blanco">
		<div class="titulo_pagina">USUARIOS</div>
		<div class="tituloInfoForm"></div>
		<!-- Mostrar los Usuarios -->
		<div class="table-wrapper listaUsuarios">
			<table id="listaUsuarios">
				<thead>
				<tr>
					<th>Nombre</th>
					<th>Apellidos</th>
					<th>Nickname</th>
					<th>Email</th>
					<th>telefono</th>
					<th>Nivel</th>
					<th>Acceso</th>
					<th>Eliminar</th>
				</tr>
				</thead>
				<tbody>
				<?php foreach ($usuarios as $usuario) : ?>
					<tr>
						<td><?=$usuario['nombre'];?></td>
						<td><?=$usuario['apellido1'];
							$usuario['apellido2'];?></td>
						<td><?=$usuario['nickname'];?></td>
						<td><?=$usuario['email'];?></td>
						<td><?=$usuario['telefono'];?></td>
						<td><label>Admin: </label>
							<input type="checkbox"
									<?php if ($usuario['esAdmin'] == 1) { ?>
										checked
									<?php } ?> disabled>
							<br>
							<form action="http://localhost/esAdmin" method="post">
								<input class="dato" type="hidden" value='<?=$usuario['id'];?>' name="id" readonly>
								<input class="dato" type="hidden" value='<?=$usuario['esAdmin'];?>' name="esAdmin"
								       readonly>
								<input class="boton" type="submit" name="nivelAdmin" value="Change">
							</form>
						</td>
						<td><label>Acceso: </label>
							<input type="checkbox"
									<?php if ($usuario['acceso'] == 1) { ?>
										checked
									<?php } ?> disabled>
							<br>
							<form action="http://localhost/acceso" method="post">
								<input class="dato" type="hidden" value='<?=$usuario['id'];?>' name="id" readonly>
								<input class="dato" type="hidden" value='<?=$usuario['acceso'];?>' name="acceso"
								       readonly>
								<input class="boton" type="submit" name="nivelAcceso" value="Change">
							</form>
						<td>
							<form action="http://localhost/deleteUser" method="post">
								<input class="dato" type="hidden" value='<?=$usuario['id'];?>' name="id" readonly>
								<input class="boton" type="submit" name="delete" value="Eliminar Usuario">
							</form>
						</td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
</main>
<script src="https://cdn.datatables.net/v/dt/dt-1.13.8/datatables.min.js"></script>
<script>
	function init() {

		let table = new DataTable('#listaUsuarios', {
			// config options...
		});
		table.on('draw.dt', function (e) {
			//alert('Table redraw');
			console.log(e);
		});
	}

	document.addEventListener('DOMContentLoaded', function () {
		init();
	});
</script>
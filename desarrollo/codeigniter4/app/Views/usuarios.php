<?php
if (! session("user")) {
	$data['error'] = false;

	return template('login', $data);
} else { ?>
	<main>
		<div class="fondo_blanco">
			<div class="titulo_pagina">USUARIOS</div>
			<div class="tituloInfoForm"></div>
			<!-- Mostrar los Usuarios -->
			<table>
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
								<input class="dato" type="hidden" value='<?=$usuario['esAdmin'];?>' name="esAdmin" readonly>
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
								<input class="dato" type="hidden" value='<?=$usuario['acceso'];?>' name="acceso" readonly>
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
			<!--
            <form method="get" style="margin-top: 12%; text-align: center;"
                  action="http://localhost/">
                <input type='hidden' name='tipo' value=''>
                <input type="hidden" name="pag" value="">
                <input type="hidden" name="numPags" value="">
                <input class="boton" type="submit" name='anteriorEs' value="Anterior"/>
                <input class="boton" type="submit" name='siguienteEs' value="Siguiente"/>
            </form>
            -->
		</div>
	</main>
<?php } ?>
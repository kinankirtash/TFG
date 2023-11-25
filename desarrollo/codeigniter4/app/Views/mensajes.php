<main>
	<div class="fondo_blanco">
		<div class="titulo_pagina">MENSAJES</div>
		<div class="tituloInfoForm"></div>
		<?php
		if (isset($msg)) {
			echo "<div class='error'>".esc($msg)."</div>";
		} ?>
		<!-- Mostrar los Mensajes -->
		<div class="table-wrapper listaUsuarios">
			<table id="listaUsuarios">
				<thead>
				<tr>
					<th>Remitente</th>
					<th>Tipo</th>
					<th>Mensaje</th>
					<th></th>
				</tr>
				</thead>
				<tbody>
				<?php foreach ($mensajes as $mensaje) : ?>
					<tr>
						<td><?=$mensaje['remitente'];?></td>
						<td><?=$mensaje['tipo'];?></td>
						<td class="txt"><?=$mensaje['texto'];?></td>
						<td>
							<form action="/deleteMsg" method="post">
								<input class="dato" type="hidden" value='<?=$mensaje['id'];?>' name="id" readonly>
								<input class="boton" type="submit" name="deleteMsg" value="Eliminar Mensaje">
							</form>
						</td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
		</div>
		<div class="pagination">

		</div>

	</div>
</main>

<script src="https://cdn.datatables.net/v/dt/dt-1.13.8/datatables.min.js"></script>
<script>
	function init() {

		let table = new DataTable('#listaUsuarios', {
			// config options...
			//language: {url: '/Js/DataTablesEspanol.JSON'}
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
<main>
	<div class="fondo_blanco">
		<div class="titulo_pagina">LUGARES</div>
		<div class="tituloInfoForm"></div>

		<!-- Mostrar los pretendientes -->
		<table class="listaUsuarios">
			<thead>
			<tr>
				<th>Nombre</th>
				<th>Apellidos</th>
			</tr>
			</thead>
			<tbody>
			<?php foreach ($datosJson as $lugar) : ?>
				<tr>
					<td>
						<?=$lugar['nombre'];?>
					</td>
					<td>
						<form action="/verLugar" method="post">
							<input class="dato" type="hidden" value='<?=$lugar['id'];?>' name="id" readonly>
							<input class="boton" type="submit" name="look" value="Ver">
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
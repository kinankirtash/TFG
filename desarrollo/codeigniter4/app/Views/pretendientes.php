<main>
	<div class="fondo_blanco">
		<div class="titulo_pagina">PRETENDIENTES</div>
		<div class="tituloInfoForm"></div>

		<table class="listaUsuarios">
			<thead>
			<tr>
				<th>Nombre</th>
				<th>Apellidos</th>
			</tr>
			</thead>
			<tbody>
			<?php
			if ($datosJson !== null) {
				foreach ($datosJson as $pretendiente) : ?>
					<tr>
						<td>
							<?=$pretendiente['nombre'];?>
						</td>
						<td><?=$pretendiente['apellido'];?></td>
						<td>
							<form action="http://localhost/verPretendiente" method="post">
								<input class="dato" type="hidden" value='<?=$pretendiente['id'];?>' name="id" readonly>
								<input class="boton" type="submit" name="look" value="Ver">
							</form>
						</td>
					</tr>
				<?php endforeach;
			} ?>
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
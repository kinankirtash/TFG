<main>
	<div class="fondo_blanco">
		<div class="titulo_pagina">USUARIOS</div>
		<div class="tituloInfoForm"></div>
		<?php
		if (isset($msg)) {
			echo "<div class='error'>".esc($msg)."</div>";
		} ?>
		<!-- Mostrar los Mensajes -->
		<table class="listaUsuarios">
			<thead>
			<tr>
				<th>Remitente</th>
				<th>Tipo</th>
				<th>Mensaje</th>
			</tr>
			</thead>
			<tbody>
			<?php foreach ($mensajes as $mensaje) : ?>
				<tr>
					<td><?=$mensaje['remitente'];?></td>
					<td><?=$mensaje['tipo'];?></td>
					<td class="txt"><?=$mensaje['texto'];?></td>
					<td>
						<form action="http://localhost/deleteMsg" method="post">
							<input class="dato" type="hidden" value='<?=$mensaje['id'];?>' name="id" readonly>
							<input class="boton" type="submit" name="deleteMsg" value="Eliminar Mensaje">
						</form>
					</td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>

		<div class="pagination">
			<?php if (isset($numPags)): ?>
				<?php if ($numPags > 1): ?>
					<form method="get" style="margin-top: 12%; text-align: center;"
					      action="http://localhost/Codeigniter_Foroplatos/foroplatos_Codeigniter/Codeigniter/index.php/users">
						<input type="hidden" name="pag" value="<?php echo $pag; ?>">
						<input type="hidden" name="numPags" value="<?php echo $numPags; ?>">
						<input class="boton" type="submit" name='anterior' value="Anterior"/>
						<input class="boton" type="submit" name='siguiente' value="Siguiente"/>
					</form>
				<?php endif;
			endif; ?>
		</div>

	</div>
</main>

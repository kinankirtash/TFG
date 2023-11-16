<div>
	<?php if (isset($msg)): ?>
		<div class='error'><?=esc($msg)?></div>
	<?php endif; ?>

	<div class="fondo_foro">
		<div class="overflow-scroll">
			<table id="tabla-comentarios" class="comentarios" style="height: <?=session('alturaTabla')?>vh;">
				<tbody>
				<?php if (isset($comentarios)): ?>
					<?php foreach ($comentarios as $comentario): ?>
						<tr>
							<td class="comentario <?=($comentario['id_usuario'] == $idUsuarioActual) ? 'derecha' : 'izquierda';?>">
								<?php if ($comentario['id_usuario'] == $idUsuarioActual): ?>
									<h4><?=$comentario['remitente'];?></h4>
								<?php else: ?>
									<div class="menu-desplegable">
										<button class="nombre-usuario"><?=$comentario['remitente'];?></button>
										<div class="contenido-menu">
											<form action="http://localhost/denunciarComentario" method="post">
												<input type="hidden" name="name_remitente"
												       value="<?=$comentario['remitente'];?>">
												<input name="id" type="hidden" value="<?=$comentario['id'];?>">
												<input type="hidden" name="textoComentario"
												       value="<?=$comentario['texto'];?>">
												<input type="submit" value="Denunciar Comentario">
											</form>
											<form action="http://localhost/verPerfil" method="post">
												<input type="hidden" name="id_remitente"
												       value="<?=$comentario['id_usuario'];?>">
												<input type="submit" value="Ver perfil">
											</form>
											<?php if (session("user")['esAdmin']): ?>
												<form action="http://localhost/borrarComentario" method="post">
													<input name="id" type="hidden" value="<?=$comentario['id'];?>">
													<input type="submit" value="Eliminar">
												</form>
											<?php endif; ?>
										</div>
									</div>
								<?php endif; ?>
								<div class="txtComentario"><?=$comentario['texto'];?></div>
							</td>
						</tr>
					<?php endforeach; ?>
				<?php endif; ?>
				</tbody>
			</table>
		</div>
		<div class="panel_escritura">
			<form class="escritura" action="http://localhost/comenta" method="post">
				<textarea class="bloqueTexto" name="bloqueTexto" placeholder="Escribe" rows="3"></textarea>
				<input class="boton_enviar" type="submit" name="send" value="Enviar">
			</form>
		</div>
	</div>
</div>

<script>
	$(document).ready(function () {
		$('.menu-desplegable').on('click', function (e) {
			e.stopPropagation(); // Evitar que el clic se propague al documento

			// Toggle de la clase 'abierto' para abrir o cerrar el menú
			$(this).toggleClass('abierto');

			// Cerrar otros menús desplegables cuando se abre uno nuevo
			$('.menu-desplegable').not(this).removeClass('abierto');
		});

		// Cerrar el menú cuando se hace clic fuera de él
		$(document).on('click', function () {
			$('.menu-desplegable').removeClass('abierto');
		});

		// Lógica para manejar la acción cuando se hace clic en las opciones del menú
		$('.menu-desplegable .contenido-menu input').click(function (e) {
			e.stopPropagation(); // Evitar que el clic se propague al documento

			// Agrega la lógica específica para cada opción del menú
			var opcionSeleccionada = $(this).val();
			console.log('Clic en la opción del menú: ' + opcionSeleccionada);
		});
	});
</script>
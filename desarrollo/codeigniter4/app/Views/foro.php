<?php
if (! session("user")) {
	$data['error'] = false;

	return template('login', $data);
} else { ?>
	<div class="fondo_blanco">
		<div class="fondo_foro">
			<div class="texto">

			</div>
			<div class="panel_escritura">
				<form class="escritura">
					<input class="bloqueTexto" type="text" placeholder="Escribe">
					<input class="boton_enviar" type="submit" name="send" value="Enviar">
				</form>
			</div>
		</div>
	</div>
<?php } ?>
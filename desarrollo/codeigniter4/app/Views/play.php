<?php
if (! session("user")) {
	$data['error'] = false;

	return template('login', $data);
} else { ?>
	<div class="fondo_blanco">
		<div class="seccion_ayuda" style="width: 30%">
			<img class="img_perfil" src="assets/imagenes/Siluetas/silueta3.png">
			<input class="dato" type="text" value='<?php echo $_SESSION["user"]["nickname"]; ?>'
			       placeholder="Nick"
			       name="nick" id="nick" readonly>
		</div>
		<div class="seccion_principal" style="width: 70%">

		</div>
	</div>
<?php } ?>
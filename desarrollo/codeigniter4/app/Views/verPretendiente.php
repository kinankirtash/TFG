<div class="fondo_blanco">
	<div class="seccion_ayuda">
		<?php if ($pretendiente['sprites']['neutra']) { ?>
			<img class="img_wiki" src="<?=$pretendiente['sprites']['neutra']['imagen'];?>">
		<?php } ?>
	</div>
	<div class="seccion_principal">
		<div class="titulo_pagina"><h2>Pretendiente</h2></div>
		<br>
		<div class="datosWiki">
			<label>Nombre :</label>
			<input class="dato" type="text" value='<?=$pretendiente['nombre'];?>' readonly>
			<label>Apellido :</label>
			<input class="dato" type="text" value='<?=$pretendiente['apellido'];?>' readonly>
			<label>Edad :</label>
			<input class="dato" type="text" value='<?=$pretendiente['edad'];?>' readonly>
			<Label>Personalidad :</Label>
			<input class="dato" type="text" value='<?=$pretendiente['personalidad'];?>' readonly>
			<label>Historia :</label>
			<textarea class="dato" type="text" readonly> <?=$pretendiente['historia'];?> </textarea>
			<label>Dificultad :</label>
			<input class="dato" type="text" value='<?=$bbdd['dificultad'];?>' readonly>
			<?php if (isset($_SESSION['user']) && isset($relacion['interes']) && isset($relacion['nivel'])) { ?>
				<label>Interes :</label>
				<input class="dato" type="text" value='<?=$relacion['interes'];?>' readonly>
				<label>Nivel de Relación :</label>
				<input class="dato" type="text" value='<?=$relacion['nivel'];?>' readonly>
			<?php } ?>
		</div>
	</div>
</div>

<div class="fondo_blanco">
	<div class="seccion_ayuda">
		<img class="img_perfil" src="assets/imagenes/Siluetas/silueta3.png">
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
		</div>
	</div>
</div>

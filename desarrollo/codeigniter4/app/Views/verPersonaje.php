<div class="fondo_blanco">
	<div class="seccion_ayuda">
		<img class="img_wiki" src="<?=$personaje['imagen'];?>">
	</div>
	<div class="seccion_principal">
		<div class="titulo_pagina"><h2>Personaje</h2></div>
		<br>
		<div class="datosWiki">
			<label>Nombre :</label>
			<input class="dato" type="text" value='<?=$personaje['nombre'];?>' readonly>
			<label>Apellido :</label>
			<input class="dato" type="text" value='<?=$personaje['apellido'];?>' readonly>
			<label>Edad :</label>
			<input class="dato" type="text" value='<?=$personaje['edad'];?>' readonly>
			<Label>Personalidad :</Label>
			<input class="dato" type="text" value='<?=$personaje['personalidad'];?>' readonly>
			<label>Historia :</label>
			<textarea class="dato" type="text" readonly> <?=$personaje['historia'];?> </textarea>
		</div>
	</div>
</div>

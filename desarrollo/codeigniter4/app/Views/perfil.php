<div class="fondo_blanco">
	<div class="seccion_ayuda">
		<?php if (isset($_SESSION["user"]["profile_image"]) && isset($_SESSION["user"]["url"])): ?>
			<img id="imagen" class="img_wiki" src="<?=$_SESSION["user"]["url"]?>">
		<?php else: ?>
			<img class="img_perfil" src="assets/imagenes/Siluetas/silueta3.png">
		<?php endif; ?>
	</div>
	<div class="seccion_principal">
		<div class="titulo_pagina"><h2>Perfil</h2></div>
		<div class="tituloInfoForm"></div>
		<?php
		if (esc($error)) {
			echo "<div class='error'>".esc($msg)."</div>";
		}
		?>
		<form class="datos" action="/update" method="post" enctype="multipart/form-data">
			<input class="dato" type="hidden" value='<?php echo $_SESSION["user"]["id"]; ?>' name="id" readonly>
			<input class="dato" type="text" value='<?php echo $_SESSION["user"]["nickname"]; ?>'
			       placeholder="Nick"
			       name="nick" id="nick">

			<input class="dato" type="text" value='<?php echo $_SESSION["user"]["nombre"]; ?>'
			       placeholder="Nombre" name="nombre" id="nombre">

			<input class="dato" type="text" value='<?php echo $_SESSION["user"]["apellido1"]; ?>'
			       placeholder="Apellido 1" name="apellido1"
			       id="apellido1">

			<input class="dato" type="text" value='<?php echo $_SESSION["user"]["apellido2"]; ?>'
			       placeholder="Apellido 2" name="apellido2"
			       id="apellido2">

			<input class="dato" type="text" value='<?php echo $_SESSION["user"]["telefono"]; ?>'
			       placeholder="Teléfono" name="telefono" id="telefono"
			       onfocus="addPrefixNumber()" onchange="validateTlf()">

			<input class="dato" type="text" value='<?php echo $_SESSION["user"]["email"]; ?>'
			       placeholder="email" name="email" id="email"
			       onchange="validateEmail()">

			<input class="dato" type="number" value="<?php echo $_SESSION["user"]["edad"]; ?>" placeholder="edad"
			       id="edad" name="edad" min="7">
			<input class="dato " type="file" name="imagen" id="imagen">
			<br>
			<input class="dato dato_img" type="password" placeholder="Contraseña" id="password"
			       name="password" required>
			<br>
			<div class="botones">
				<input class="boton" type="submit" name="update" value="Actualizar"
				       onclick="return confirm('¿Realmente desea cambiar el registro?');">
			</div>
		</form>
		<br>
		<form class="datos" action="/updatePassword" method="post">
			<div class="botones2">
				<input class="boton" type="submit" name="change_password" value="Cambiar contraseña">
			</div>
		</form>
		<form class="datos" action="/delete" method="post">
			<div class="botones2">
				<input class="boton" type="submit" name="delete_User" value="Eliminar Cuenta">
			</div>
		</form>
		<form class="datos" method="post" onsubmit="generarPdf(); return false;">
			<div class="botones2">
				<input class="boton" type="submit" name="delete_User" value="Descargar Informe">
			</div>
		</form>
	</div>
</div>
<script type="text/javascript" src="JS/jspdf.min.js"></script>
<script type="text/javascript">
	function generarPdf() {
		// Crear instancia de jsPDF
		var doc = new jsPDF();

		// Agregar texto al PDF
		doc.setFont("helvetica");
		doc.setFontSize(14);
		doc.text(20, 20, 'INFORMACIÓN DEL PERFIL');

		// Obtener información del perfil
		var nickname = 'Nick: ' + '<?php echo $_SESSION["user"]["nickname"]; ?>';
		var nombre = 'Nombre: ' + '<?php echo $_SESSION["user"]["nombre"]; ?>';
		var apellido1 = 'Apellido 1: ' + '<?php echo $_SESSION["user"]["apellido1"]; ?>';
		var apellido2 = 'Apellido 2: ' + '<?php echo $_SESSION["user"]["apellido2"]; ?>';
		var telefono = 'Teléfono: ' + '<?php echo $_SESSION["user"]["telefono"]; ?>';
		var email = 'Email: ' + '<?php echo $_SESSION["user"]["email"]; ?>';
		var edad = 'Edad: ' + '<?php echo $_SESSION["user"]["edad"]; ?>';

		// Agregar información al PDF
		doc.setFontSize(12);
		doc.text(20, 30, nickname);
		doc.text(20, 40, nombre);
		doc.text(20, 50, apellido1);
		doc.text(20, 60, apellido2);
		doc.text(20, 70, telefono);
		doc.text(20, 80, email);
		doc.text(20, 90, edad);
		
		doc.save('perfil.pdf');
	}
</script>


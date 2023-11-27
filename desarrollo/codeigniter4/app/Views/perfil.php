<div class="fondo_blanco">
	<div class="seccion_ayuda">
		<?php
		if (isset($_SESSION["user"]["profile_image"]) && isset($_SESSION["user"]["url"])): ?>
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

		// Establecer color de fondo
		doc.setFillColor(253, 243, 243); // Relleno de color azul claro
		doc.rect(0, 0, doc.internal.pageSize.width, doc.internal.pageSize.height, 'F');

		doc.setFont("Playfair Display");
		doc.setTextColor(223, 147, 186);
		doc.setFontSize(16);
		doc.setFontType("bold");
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
		doc.setFont("helvetica");
		doc.setTextColor(35, 34, 30);
		doc.setFontSize(12);
		doc.setFontType("italic");
		doc.text(20, 30, nickname);
		doc.text(80, 30, nombre);
		doc.text(20, 40, apellido1);
		doc.text(80, 40, apellido2);
		doc.text(20, 50, telefono);
		doc.text(80, 50, email);
		doc.text(20, 60, edad);

		doc.setFont("Playfair Display");
		doc.setTextColor(223, 147, 186);
		doc.setFontSize(14);
		doc.setFontType("bold");
		doc.text(20, 80, 'Relaciones del Usuario');

		doc.setFont("helvetica");

		doc.setFontSize(12);
		doc.setFontType("italic");
		<?php $yPosition = 90; ?>
		<?php foreach ($relaciones as $relacion): ?>
		<?php foreach ($pretendientes as $pretendiente): ?>
		<?php if ($pretendiente['id'] == $relacion['id_pretendiente']): ?>

		var nombrePretendiente = 'Nombre del pretendiente: ' + '<?= $pretendiente['nombre']; ?>';
		var interes = 'Interes del pretendiente: ' + '<?= $relacion['interes']; ?>';
		var nivel = 'Nivel de relación: ' + '<?= $relacion['nivel']; ?>';

		doc.setTextColor(27, 190, 215);
		doc.text(20, <?= $yPosition; ?>, nombrePretendiente);
		doc.setTextColor(35, 34, 30);
		doc.text(20, <?= $yPosition + 10; ?>, interes);
		doc.text(80, <?= $yPosition + 10; ?>, nivel);

		<?php $yPosition += 30; ?>

		<?php endif; ?>
		<?php endforeach; ?>
		<?php endforeach; ?>

		// Guardar el PDF
		doc.save('InformeUsuario.pdf');
	}

</script>


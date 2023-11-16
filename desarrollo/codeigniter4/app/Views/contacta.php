<main>
	<div id="contact">
		<div class="enviarMensaje">
			<div class="contenido-ventana">
				<a class="subir" href="#top">
					<img class="logo" src="assets/logo/logo_no_flores2.png">
					<div class="titulo">
						<h1>Envía un mensaje</h1>
					</div>
				</a><br>
				<?php if (isset($msg)) {
					echo "<div class='error'>".esc($msg)."</div><br>";
				} ?>
				<form action="http://localhost/guardarmensajes" method="post">
					<textarea id="mensaje" name="mensaje" class="mensaje"></textarea>
					<br>
					<input class="botonFlotante" type="submit" value="Enviar">
				</form>
			</div>
		</div>
</main>
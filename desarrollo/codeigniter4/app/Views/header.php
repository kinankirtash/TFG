<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" href="assets/logo/logo_no_flores2.png">
	<link rel="stylesheet" href="Style/styles.css">
	<title>Rolleaf</title>
</head>
<body>
<header>
	<nav class="navbar">
		<form method="get" action="http://localhost/" data-tipo="">
			<div class="marca" onclick="submitForm();">
				<img class="logo" src="assets/logo/logo_no_flores2.png">
				<h1 class="rolleaf"><input type="submit" class="name" name="name" value="">
					Rolleaf</input></h1>
			</div>
		</form>

		<ul class="menu">
			<li>
				<a class="opcion" href="/wiki">Wiki</a>
			</li>
			<?php
			if (! session("user")) { ?>
				<li>
					<a class="opcion" href="/login">Log IN</a>
				</li>
				<li>
					<a class="opcion" href="/signUp">Registro</a>
				</li>
			<?php } else { ?>
				<li>
					<a class="opcion" href="/perfil">Perfil</a>
				</li>
				<li>
					<a class="opcion" href="/foro">Foro</a>
				</li>
				<li>
					<a class="opcion" href="/play">Play</a>
				</li>
				<li>
					<a class="opcion" href="/recreativos">Recreativos</a>
				</li>
				<?php if (session("user")['esAdmin']) { ?>
					<li>
						<a class="opcion" href="/control_usuarios">Usuarios</a>
					</li>
					<li>
						<a class="opcion" href="/control_mensajes">Mensajes</a>
					</li>
				<?php } ?>
				<li>
					<a class="opcion" href="/logOut">Log Out</a>
				</li>
			<?php } ?>
			<!--
			<li>
				<a id="botonMostrarVentana" onclick="mostrarVentanaFlotante()">Contactanos</a>
			</li>
			-->
		</ul>
		<div class="menu-icon">
			<div class="bar"></div>
			<div class="bar"></div>
			<div class="bar"></div>
		</div>
	</nav>
</header>
<hr class="separator">
<div id="mensajeFlotante" class="ventana-flotante">
	<div class="contenido-ventana">
		<h2>Envía un mensaje</h2>
		<form id="miFormulario" action="http://localhost/guardarmensajes" method="post">
			<div id="mensaje" name="mensaje" class="mensaje" contenteditable="true"></div>
			<input class="botonFlotante" type="submit" value="Enviar">
		</form>
	</div>
</div>

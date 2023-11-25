<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" href="assets/logo/logo_no_flores2.png">
	<link rel="stylesheet" href="Style/styles.css">
	<link href="https://cdn.datatables.net/v/dt/dt-1.13.8/datatables.min.css" rel="stylesheet">
	<script src="https://code.jquery.com/jquery-3.7.1.slim.min.js"
	        integrity="sha256-kmHvs0B+OpCW5GVHUNjv9rOmY0IvSIRcf7zGUDTDQM8="
	        crossorigin="anonymous"></script>
	<title>Rolleaf</title>
</head>
<body>
<header>
	<nav class="navbar">
		<form method="get" action="/" data-tipo="">
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
			<li>
				<a class="opcion" href="/contacta">Contactanos</a>
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
					<a class="opcion" href="/play">Juega</a>
				</li>
				<li>
					<a class="opcion" href="/recreativos">Recreativos</a>
				</li>
				<li>
					<a class="opcion" href="/foro">Comenta</a>
				</li>
				<li>
					<a class="opcion" href="/perfil">Perfil</a>
				</li>
				<?php if (session("user")['esAdmin']) { ?>
					<li>
						<a class="opcion" href="/control">Control</a>
					</li>
				<?php } ?>
				<li>
					<a class="opcion" href="/logOut">Log Out</a>
				</li>
			<?php } ?>
		</ul>
		<div class="menu-icon">
			<div class="bar"></div>
			<div class="bar"></div>
			<div class="bar"></div>
		</div>
		<?php if (session("user")): ?>
			<div class="profile">
				<?php if (isset($_SESSION["user"]["profile_image"]) && isset($_SESSION["user"]["url"])): ?>
					<img class="profile_image" src="<?=$_SESSION["user"]["url"]?>">
				<?php endif; ?>
				<?php echo $_SESSION["user"]["nickname"]; ?>
			</div>
		<?php endif; ?>
	</nav>
</header>
<hr class="separator">

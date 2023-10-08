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
				<form method="get" action="http://localhost/wiki">
					<input type="submit" class="opcion" name="wiki" value="Wiki">
				</form>
			</li>
			<li>
				<form method="get" action="http://localhost/login">
					<input type="submit" class="opcion" name="login" value="LogIn"/>
				</form>
			</li>
			<li>
				<form method="get" action="http://localhost/signUp">
					<input type="submit" class="opcion" name="signUp" value="Registro"/>
				</form>
			</li>
			<li>
				<form method="get" action="http://localhost/perfil">
					<input type="submit" class="opcion" name="perfil" value="Perfil"/>
				</form>
			</li>
			<li>
				<form method="get" action="http://localhost/foro">
					<input type="submit" class="opcion" name="foro" value="Foro"/>
				</form>
			</li>
			<li>
				<form method="get" action="http://localhost/play">
					<input type="submit" class="opcion" name="play" value="Play"/>
				</form>
			</li>
			<li>
				<form method="get" action="http://localhost/recreativos">
					<input type="submit" class="opcion" name="recreativos" value="Recreativos"/>
				</form>
			</li>
			<li>
				<form method="get" action="http://localhost/">
					<input type="submit" class="opcion" name="#" value="LogOut"/>
				</form>
			</li>
		</ul>
		<div class="menu-icon">
			<div class="bar"></div>
			<div class="bar"></div>
			<div class="bar"></div>
		</div>
	</nav>
</header>
<hr class="separator">


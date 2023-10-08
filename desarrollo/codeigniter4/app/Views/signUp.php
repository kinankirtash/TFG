<div class="fondo_blanco">
<h1 class="titulo_pagina">Sign Up</h1>
<br>
<br>
<div class="modal-content">
	<img class="logoDeco" src="assets/logo/logo_B.png">
	<form id="registro" class="formulario_sesion registro" method="get" action="http://localhost/signUp">
		<input class="formulario" id="nombre" type="text" name="name" placeholder="Nombre" required>
		<input class="formulario" id="nickname" type="text" name="nick" placeholder="Nickname" required>
		<input class="formulario" id="email" type="email" name="email" placeholder="tuemail@email.com"
		       onchange="validateEmail()" required>
		<input class="formulario" id="password" type="password" name="password" placeholder="Contraseña Minimo 6 caracteres"
		       onblur="validatePassword('password')" onchange="validatePassword('password')" required>
		<input class="formulario" id="password" type="password" name="repitePassword"
		       placeholder="Repite la contraseña" required>
		<span id="passwordMatchError" style="color: red;"></span>
		<input type="submit" class="enviar" name="registro" value="Registrarse">
	</form>
</div>
</div>
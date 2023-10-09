<div class="fondo_blanco">
	<div class="seccion_ayuda">
		<img class="img_perfil" src="assets/imagenes/Siluetas/silueta3.png">
	</div>
	<div class="seccion_principal">
		<div class="titulo_pagina"><h2>Perfil</h2></div>
		<div class="tituloInfoForm"></div>
		<form class="datos" action="http://localhost/perfil" method="post">
			
			<input class="dato" type="text" value="Nick" placeholder="Nick" name="nick" id="nick">
			
			<input class="dato" type="text" value="Nombre" placeholder="Nombre" name="nombre" id="nombre">
			
			<input class="dato" type="text" value="Apellido 1" placeholder="Apellido 1" name="apellido1" id="apellido1">
			
			<input class="dato" type="text" value="Apellido 2" placeholder="Apellido 2" name="apellido2" id="apellido2">
			
			<input class="dato" type="text" value="Email" placeholder="Email" name="email" id="email">
			
			<input class="dato" type="text" value="Teléfono" placeholder="Teléfono" name="telefono" id="telefono"
			       onfocus="addPrefixNumber()" onchange="validateTlf()">
			
			<input class="dato" type="text" value="Email" placeholder="email" name="email" id="email"
			       onchange="validateEmail()">
			
			<input class="dato" type="number" value="Edad" placeholder="edad" id="edad">
			
			<input class="dato dato_img" type="file" name="imagen" id="imagen">
			<br>
			<div class="contrasenias">
				<input class="dato" type="text" value="Contraseña" placeholder="Contraseña" id="password"
				       name="password"
				       onblur="validatePassword('password')" onchange="validatePassword('password');">
				
				<input class="dato" type="text" value="Repite Contraseña" placeholder="Repite Contraseña"
				       id="repeatPassword"
				       name="repeatpassword"
				       onblur="validatePassword('password')" onchange="validatePassword('repeatpassword');">
				
				<input class="dato" type="text" value="Nueva Contraseña" placeholder="Nueva Contraseña"
				       id="new_password"
				       name="newPassword"
				       onblur="validatePassword('password')" onchange="validatePassword('newPassword');">
			</div>
			<br>
			<div class="botones">
				<input class="boton" type="submit" name="edit_user" value="Actualizar"
				       onclick="return confirm('¿Realmente desea cambiar el registro?');">
				<input class="boton" type="submit" name="change_password" value="Cambiar contraseña"
				       onclick="return confirm('¿Realmente desea cambiar la contraseña?');">
				<input class="boton" type="submit" name="delete_user1" value="Eliminar usuario"
				       onclick="return confirm('¿Realmente desea eliminar el usuario?');">
			</div>
		</form>
	</div>
</div>
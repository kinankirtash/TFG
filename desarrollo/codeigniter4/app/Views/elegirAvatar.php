<div class="fondo_blanco">
	<form action="http://localhost/saveAvatar" method="post">
		<div class="elegirAvatar">
			<div class="opcionAvatar">
				<label for="opcionA">
					<img class="img_Avatar" src="assets/imagenes/sprites/avatarA.png" alt="Opción A">
				</label>
				<div>
					Opcion A
					<input type="radio" id="opcionA" name="avatar" value="a">
				</div>
			</div>
			<div class="opcionAvatar">
				<label for="opcionB">
					<img class="img_Avatar" src="assets/imagenes/sprites/avatarB.png" alt="Opción B">
				</label>
				<div>
					Opcion B
					<input type="radio" id="opcionB" name="avatar" value="b">
				</div>
			</div>
		</div>
		<input class="botonAvatar" type="submit" name="elegir" value="Guardar Selección"
		       onclick="return confirm('¿Quieres elegir este avatar? No se podrá cambiar.');">
	</form>
</div>

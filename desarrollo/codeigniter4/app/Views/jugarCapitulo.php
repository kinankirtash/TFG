<div class="fondo_blanco">
	<div class="seccion_ayuda" style="width: 30%;border-right: solid 4px #CDFFFF;">
		<?php if ($_SESSION["user"]["avatar"] == "a") { ?>
			<img class="img_wiki" src="assets/imagenes/sprites/avatarA.png">
		<?php } elseif ($_SESSION["user"]["avatar"] == "b") { ?>
			<img class="img_wiki" src="assets/imagenes/sprites/avatarB.png">
		<?php } else { ?>
			<img class="img_perfil" src="assets/imagenes/Siluetas/silueta3.png">
		<?php } ?>
		<input class="dato" type="text" value='<?php echo $_SESSION["user"]["nickname"]; ?>'
		       placeholder="Nick"
		       name="nick" id="nick" readonly>
	</div>
	<div class="escenario" style="background-image: url('<?=$capitulo['imagen'];?>');">
		<div>
			<?php if ($personaje !== null) {
				if (isset($personaje['sprites'])) { ?>
					<img class="personaje" src="<?=$personaje['sprites'][$dialogo_actual['expresion']]['imagen'];?>">
				<?php } else { ?>
					<img class="personaje" src="<?=$personaje['imagen'];?>">
				<?php }
			} ?>
		</div>
		<form action="avanzarDialogo" method="post">
			<div class="dialogo">
				<?php if ($personaje !== null) { ?>
					<h3><?=$personaje['nombre'];?></h3><br>
				<?php } ?>
				<p class="texto-dialogo"><?php echo $dialogo_actual['texto']; ?></p>
				<?php if ($dialogo_actual['tipo'] == 'dialogo') :
					if (isset($dialogo_actual['siguiente_dialogo'])) :?>
						<input class="dato" type="hidden" value='<?=$dialogo_actual['siguiente_dialogo'];?>'
						       name="siguiente_dialogo" readonly>
					<?php endif;
				endif; ?>
				<?php if (! empty($opciones_respuesta)) :
					foreach ($opciones_respuesta as $opcion) :
						?>
						<br><input class="dato" type="hidden" value='<?=$dialogo_actual['id'];?>'
						           name="pregunta" readonly>
						<input class="dato" type="hidden" value='<?=$opcion['id'];?>'
						       name="id_Opcion" readonly>
						<input type="radio" name="respuesta" value="<?=$opcion['id']?>" required>
						<?php echo $opcion['texto'];
					endforeach;
				endif; ?>
			</div>
			<input class="dato" type="hidden" value='<?=$idCapitulo;?>' name="id" readonly>
			<input class="siguiente" type="submit" value="Siguiente">
		</form>
	</div>
</div>

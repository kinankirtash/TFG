<div class="fondo_blanco">
	<div class="seccion_ayuda" style="width: 30%">
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
	<div class="seccion_principal" style="width: 70%">
		<div class="titulo_pagina">CAPITULOS</div>
		<div class="tituloInfoForm"></div>
		<div class="tablaCaps">
			<table>
				<tbody>
				<?php $count = 0; ?>
				<?php foreach ($capitulos

				as $capitulo) :
				// Busca la imagen correspondiente en datosJson para el capítulo actual
				$id = $capitulo['id']; ?>
				<td <?php foreach ($datosJson as $imagen) : if ($capitulo['id'] === $imagen['id']) : ?>
					style="background-image: url('<?=$imagen['imagen'];?>');"
				<?php endif; ?><?php endforeach; ?>>
					<div>
						(<?=$capitulo['numero'];?>) <?=$capitulo['titulo'];?>
						<label>(Jugado : </label>
						<?php foreach ($porcentajes as $porcentaje) : if ($capitulo['id'] === $porcentaje['id_capitulo']) : ?>
							<?=$porcentaje['porcentaje'];?>
						<?php endif; ?><?php endforeach; ?>
						<label>%)</label>
					</div>
					<form action="http://localhost/jugarCapitulo" method="post">
						<input class="dato" type="hidden" value='<?=$capitulo['id'];?>' name="id" readonly>
						<input class="boton" type="submit" name="jugar" value="Jugar Capitulo">
					</form>
				</td>
				<?php $count++; ?>
				<?php if ($count % 4 === 0) : ?>
				</tr>
				<tr>
					<?php endif; ?>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>

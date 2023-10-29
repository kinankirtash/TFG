<?php
if (! session("user")) {
	$data['error'] = false;

	return template('login', $data);
} else { ?>
	<main>
		<div class="fondo_blanco">
			<div class="titulo_pagina">USUARIOS</div>
			<div class="tituloInfoForm"></div>
			<!-- Mostrar los Usuarios -->
			<table class="listaUsuarios">
				<thead>
				<tr>
					<th></th>
				</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
			<!--
            <form method="get" style="margin-top: 12%; text-align: center;"
                  action="http://localhost/">
                <input type='hidden' name='tipo' value=''>
                <input type="hidden" name="pag" value="">
                <input type="hidden" name="numPags" value="">
                <input class="boton" type="submit" name='anteriorEs' value="Anterior"/>
                <input class="boton" type="submit" name='siguienteEs' value="Siguiente"/>
            </form>
            -->
		</div>
	</main>
<?php } ?>
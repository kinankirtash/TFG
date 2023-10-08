<?php

class users_model extends CI_Model
{
	public function getAll()
	{
		$query = $this->db->get('usuario');
		$users = $query->result_array();

		return $users;
	}

	public function getPagina($pag)
	{
		$this->db->limit(7, ($pag - 1) * 7);
		$query = $this->db->get('usuario');
		$users = $query->result_array();

		return $users;
	}

	public function numPaginas()
	{
		$this->db->from('usuario');
		$totalUsuarios = $this->db->count_all_results();
		$numPags = ceil($totalUsuarios / 7);

		return $numPags;
	}

	public function insertUser($name, $nick, $email, $password)
	{
		$query = $this->db->get_where('usuario', ['nick' => $nick]);
		$user = $query->row();

		if ($user) {
			return 'exist';
		} else {
			$newUser = [
				'nombre' => $name,
				'nick' => $nick,
				'email' => $email,
				'contrasenia' => password_hash($password, PASSWORD_BCRYPT),
			];
			$this->db->insert('usuario', $newUser);

			return 'success';
		}
	}

	public function getUser($nick)
	{
		$query = $this->db->get_where('usuario', ['nick' => $nick]);
		$user = $query->row_array();

		// Obtener los detalles de la imagen del usuario
		if (isset($user['profile_image'])) {
			$nombreImagen = $user['profile_image'];
			$rutaImagen = base_url($user['url']);

			// Crear objeto de imagen con propiedades "nombre" y "ruta"
			$imagen = (object) [
				'nombre' => $nombreImagen,
				'ruta' => $rutaImagen,
			];

			// Asignar el objeto de imagen al usuario
			$user['profile_image'] = $imagen;
		}

		return $user;
	}

	public function verifyPassword($identificador, $contrasenia, $tipoIdentificador)
	{
		$this->db->select('contrasenia');
		$this->db->from('usuario');

		if ($tipoIdentificador === 'nick') {
			$this->db->where('nick', $identificador);
		} elseif ($tipoIdentificador === 'id') {
			$this->db->where('id', $identificador);
		}

		$query = $this->db->get();
		$row = $query->row();

		return password_verify($contrasenia, $row->contrasenia);
	}

	public function updatePassword($id, $newPassword)
	{
		$hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

		$this->db->where('id', $id);
		$this->db->update('usuario', ['contrasenia' => $hashedPassword]);
	}

	public function editUser($id, $name, $surname1, $surname2, $nick, $age, $email, $tlf)
	{
		$user = [
			'nombre' => $name,
			'apellido1' => $surname1,
			'apellido2' => $surname2,
			'nick' => $nick,
			'edad' => $age,
			'email' => $email,
			'telefono' => $tlf,
		];

		$user = array_filter($user, function ($value) {
			return $value !== null;
		});

		$this->db->where('id', $id);
		$this->db->update('usuario', $user);
	}

	public function deleteUser($id)
	{
		$this->db->delete('comentario', ['id_usuario' => $id]);
		$this->db->delete('mensaje', ['id_usuario' => $id]);
		$this->db->delete('usuario', ['id' => $id]);
	}

	public function updateAdmin($nick, $newAdminValue)
	{
		$this->db->where('nick', $nick);
		$this->db->update('usuario', ['esAdmin' => $newAdminValue]);
	}

	public function actualizarImagen($idUsuario, $nombreImagen, $rutaImagen)
	{
		$data = [
			'profile_image' => $nombreImagen,
			'url' => $rutaImagen,
		];

		$this->db->where('id', $idUsuario);
		$this->db->update('usuario', $data);
	}

	public function checkNickExists($data)
	{
		$this->db->where('nick', $data);
		$query = $this->db->get('usuario');

		return $query->num_rows() > 0;
	}
}

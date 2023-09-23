drop database if exists rolleaf;
drop user if exists moonChild;
-- por fallo de usuario existente

create database rolleaf;
use rolleaf;

create user 'moonChild' identified by 'moonChild';
grant all privileges on rolleaf.*to desarrollador;


create table if not exists usuario (
id int unsigned primary key auto_increment,
nombre varchar (50) not null,
apellido1 varchar (50),
apellido2 varchar (50),
nick varchar (20) unique not null,
esAdmin tinyint (1) not null,
acceso tinyint (1) not null,
edad int unsigned,
email varchar (200) not null,
telefono varchar (20),
contrasenia varchar (255) not null,
profile_image varchar(255),
url varchar(255)
);


create table if not exists npc (
id int unsigned primary key auto_increment,
nombre varchar (50) not null,
apellido varchar (50),
edad int unsigned,
personalidad varchar (255) not null,
historia varchar(255)
);

create table if not exists pretendiente (
id int unsigned primary key auto_increment,
nombre varchar (50) not null,
apellido varchar (50),
edad int unsigned,
personalidad varchar (255) not null,
dificultad enum ('facil','neutra','dificil') not null,
historia varchar(255)
);

create table if not exists comentario (
id int unsigned primary key auto_increment,
id_usuario int unsigned,
	foreign key (id_usuario)
		references usuario (id),
remitente varchar (50),
texto varchar (1500) not null
);

create table if not exists mensaje (
id int unsigned primary key auto_increment,
id_usuario int unsigned,
	foreign key (id_usuario)
		references usuario (id),
remitente varchar (50),
texto varchar (1500) not null,
leido  tinyint (1) not null
);

create table if not exists capitulo (
id int unsigned primary key auto_increment,
titulo varchar (50) not null,
numero int unsigned not null
);

create table if not exists dialogo (
id int unsigned primary key auto_increment,
id_capitulo int unsigned,
	foreign key (id_capitulo)
		references capitulo (id),
id_npc int unsigned,
	foreign key (id_npc)
		references npc (id),
id_pretendiente int unsigned,
	foreign key (id_pretendiente)
		references pretendiente (id),
texto varchar (1500) not null
);

create table if not exists sprite (
id int unsigned primary key auto_increment,
id_npc int unsigned,
	foreign key (id_npc)
		references npc (id),
id_pretendiente int unsigned,
	foreign key (id_pretendiente)
		references pretendiente (id),
imagen varchar(255),
url varchar(255),
emocion enum ('feliz','neutra','triste','enfadado','sorprendido') not null
);

create table if not exists opcion (
id int unsigned primary key auto_increment,
id_capitulo int unsigned,
	foreign key (id_capitulo)
		references capitulo (id),
texto varchar (1500) not null
);

create table if not exists capitulo_sprite (
id_capitulo int unsigned,
	foreign key (id_capitulo)
		references capitulo (id),
id_sprite int unsigned,
	foreign key (id_sprite)
		references sprite (id),
primary key (id_capitulo, id_sprite)
);

create table if not exists jugado (
id_capitulo int unsigned,
	foreign key (id_capitulo)
		references capitulo (id),
id_usuario int unsigned,
	foreign key (id_usuario)
		references usuario (id),
primary key (id_capitulo, id_usuario),
porcentaje int unsigned not null
);

create table if not exists relacion (
id_pretendiente int unsigned,
	foreign key (id_pretendiente)
		references pretendiente (id),
id_usuario int unsigned,
	foreign key (id_usuario)
		references usuario (id),
primary key (id_pretendiente, id_usuario),
interes int unsigned not null,
nivel int unsigned not null
);

create table if not exists seleccion (
id_opcion int unsigned,
	foreign key (id_opcion)
		references opcion (id),
id_usuario int unsigned,
	foreign key (id_usuario)
		references usuario (id),
primary key (id_opcion, id_usuario)
);

create table if not exists bloqueo (
id_usuarioBlock int unsigned,
	foreign key (id_usuario)
		references usuario (id),
id_usuario int unsigned,
	foreign key (id_usuario)
		references usuario (id),
primary key (id_usuarioBlock, id_usuario)
);
drop database if exists rollife;
drop user if exists moonChild;
-- por fallo de usuario existente

create database rollife;
use rollife;

create user 'moonChild' identified by 'moonChild';
grant all privileges on rollife.*to desarrollador;


create table if not exists usuario (
id int unsigned primary key auto_increment,
nombre varchar (50) not null,
apellido1 varchar (50),
apellido2 varchar (50),
nickname varchar (20) unique not null,
esAdmin tinyint (1) not null,
acceso tinyint (1) not null default 1,
edad int unsigned,
email varchar (200) not null,
telefono varchar (20),
contrasenia varchar (255) not null,
deleted tinyint (1) not null default 0,
profile_image varchar(255),
url varchar(255),
avatar enum ('a','b')
);
ALTER TABLE usuario
ADD avatar enum ('a','b');


create table if not exists pretendiente (
id int unsigned primary key auto_increment,
dificultad enum ('facil','neutra','dificil') not null
);

create table if not exists comentario (
id int unsigned primary key auto_increment,
id_usuario int unsigned,
	foreign key (id_usuario)
		references usuario (id),
remitente varchar (50),
texto varchar (1500) not null
);

drop table mensaje;
create table if not exists mensaje (
id int unsigned primary key auto_increment,
id_usuario int unsigned,
	foreign key (id_usuario)
		references usuario (id),
remitente varchar (50),
tipo enum('Mensaje','Reporte Usuario','Reporte Comentario') not null,
texto varchar (1500) not null
);

create table if not exists capitulo (
id int unsigned primary key auto_increment,
titulo varchar (50) not null,
numero int unsigned not null
);

create table if not exists jugado (
id_capitulo int unsigned,
	foreign key (id_capitulo)
		references capitulo (id),
id_usuario int unsigned,
	foreign key (id_usuario)
		references usuario (id),
primary key (id_capitulo, id_usuario),
porcentaje int unsigned not null check (porcentaje <= 100),
ultimoDialogo varchar (50) not null
);
drop TABLE jugado;

create table if not exists relacion (
id_pretendiente int unsigned,
	foreign key (id_pretendiente)
		references pretendiente (id),
id_usuario int unsigned,
	foreign key (id_usuario)
		references usuario (id),
primary key (id_pretendiente, id_usuario),
interes int unsigned not null check (interes <= 100),
nivel int unsigned not null check (nivel <= 10)
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
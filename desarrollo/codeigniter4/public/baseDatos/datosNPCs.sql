use rollife;

-- Insertar datos de pretendientes
INSERT INTO pretendiente (nombre, apellido, edad, personalidad, dificultad, historia)
VALUES
    ('Barbara', 'Pérez', 16, 'Alegre', 'facil', 'Le gusta viajar y probar nueva comida, dicen que es la reina del instituto.'),
    ('María', 'Gómez', 15, 'Introvertida', 'neutra', 'Le encanta la música, es nueva en el instituto.'),
    ('Carlos', 'Rodríguez', 16, 'Divertido', 'facil', 'Es un apasionado del deporte, le encanta salir con sus amigos y se rumorea que tiene varias relaciones.'),
    ('Patric', 'Nuñez', 16, 'Timido', 'dificil', 'Le cuesta comunicarse con la gente,le gusta leer y no tiene muchos amigos');
    

-- Insertar datos de NPC
INSERT INTO npc (nombre, apellido, edad, personalidad, historia)
VALUES
    ('Laura', 'García', 35, 'Amable', 'Ha vivido en el pueblo toda su vida.'),
    ('Pedro', 'López', 40, 'Serio', 'Es el dueño de la tienda de comestibles.'),
    ('Ana', 'Martínez', 28, 'Extrovertida', 'Es la maestra de la escuela local.');

-- Insertar datos de SPRITE
INSERT INTO sprite (id_npc, id_pretendiente, imagen, url, emocion)
VALUES
    (NULL, 3, 'chico1.png', 'https://localhost/uploads/chico1.png', 'neutra'),
    (NULL, 4, 'chico2-gafas.png', 'https://localhost/uploads/chico2-gafas.png', 'neutra'),
    (NULL, 2, 'chica1.png', 'https://localhost/uploads/chica1.png', 'neutra'),
	(NULL, 1, 'chica2.png', 'https://localhost/uploads/chica2.png', 'neutra');



-- ATENCIÓN La contraseña es admin1 para que puedas trabajar como administrador
-- el correo admin@correo.com


INSERT INTO `roles` (`id_rol`, `nombre`) VALUES
(1, 'admin'),
(2, 'usuario');

INSERT INTO `usuarios` (`id_usuario`, `nombre`, `apellidos`, `correo`, `password`, `id_rol`) VALUES
(1, 'Javier', 'Camarena', 'correo@correo.com', '$2y$10$8G3Fd6SJWL18PGpy2S0Df.OBJflEuh5H0tVMIQyUMWnv77P3/rd9W', 2),
(2, 'Admin', 'Admin', 'admin@correo.com', '$2y$10$7wEHS3Fe69vpXp8ZbaKrJOZEHUevQwIF4pfIOVas9d79RQN2QjZdi', 1),
(4, 'Juan', 'Camarena', 'correo2@correo.com', '$2y$10$/u4iEUvlFgFlWh6Qwx28uuO.aQYKPfGgWaAOa0YUweVhRbM6zzgMW', 2),
(5, 'Javier', 'Camarena', 'javiercorreo@correo.com', '$2y$10$CclBocRiKCyTodVZGf.pP.C8Mpmf6DSW8TPiGYZBzmNQjYfNgsxNW', 2),
(6, 'José', 'Apellidos', 'correo3@correo.com', '$2y$10$7zYoPcs92H6qd/yWhVDAOOwvdVBXrMfZ4Gil9XCYL5m5gTtqVsm5q', 2),
(7, 'Pedro', 'Apellidos', 'pedro@correo.com', '$2y$10$ACnbQvho7v9nAt3o4qYPMOO3RcOSc.GW3zQp0MgGij2YP1mNc8zPK', 2),
(8, 'Charo', 'Lozano', 'charo@correo.com', '$2y$10$Gf2YOAPHhl/.8HXpWFxVFuhvwxgt0qs8MJANw4A1niu4mt/2u.40e', 2),
(9, 'Pepe', 'Apellidos', 'pepe@correo.com', '$2y$10$cbh3ymt06cFP2Qj9/xmUWOZkfgGUB.2/8Y3wNycJTc1csxUyOlP7m', 2),
(12, 'Gabriel', 'Camarena', 'gabriel@correo.com', '$2y$10$s5kAZbHr3OfXoD6uzJzDmuDDAifqEKVtCGl9b6FhDgRnbRmdZq.j6', 2);

INSERT INTO `categorias` (`id_categoria`, `nombre`) VALUES
(2, 'Ciencia Ficción'),
(1, 'Fantasía'),
(5, 'Novela histórica'),
(3, 'Terror'),
(4, 'Thriller');

INSERT INTO `editoriales` (`id_editorial`, `nombre`, `pais`, `anio_fundacion`) VALUES
(1, 'Penguin Random House', 'Estados Unidos', 2013),
(2, 'HarperCollins Publishers', 'Estados Unidos', 1989),
(3, 'Tor Books', 'Estados Unidos', 1980),
(4, 'Orbit Books', 'Reino Unido', 1974),
(5, 'Bloomsbury Publishing', 'Reino Unido', 1986),
(6, 'Minotauro', 'España', 1955),
(7, 'Ediciones B', 'España', 1987),
(8, 'Alfaguara', 'España', 1964),
(9, 'Plaza & Janés', 'España', 1959),
(10, 'Roca Editorial', 'España', 2003);


INSERT INTO `localizaciones` (`id_localizacion`, `nombre`, `direccion`, `coordenadas`) VALUES
(1, 'Gijón', 'Recinto Ferial Luis Adaro, Paseo Doctor Fleming, 481, 33203 Gijón', '43.5341, -5.6370'),
(2, 'Madrid', 'Círculo de Bellas Artes, Calle de Alcalá, 42, 28014 Madrid', '40.4182, -3.6975'),
(3, 'Barcelona', 'CCCB (Centro de Cultura Contemporánea de Barcelona), Carrer de Montalegre, 5, 08001 Barcelona', '41.3839, 2.1669'),
(4, 'Valencia', 'La Nau – Universitat de València, Carrer de la Universitat, 2, 46003 Valencia', '39.4749, -0.3763'),
(5, 'Sevilla', 'Casa de la Provincia, Plaza del Triunfo, 1, 41004 Sevilla', '37.3860, -5.9920'),
(6, 'Zaragoza', 'Biblioteca de Aragón, Calle Doctor Cerrada, 22, 50005 Zaragoza', '41.6483, -0.8896'),
(7, 'Bilbao', 'Azkuna Zentroa (Alhóndiga Bilbao), Arriquíbar Plaza, 4, 48010 Bilbao', '43.2627, -2.9389'),
(8, 'Salamanca', 'Biblioteca Pública de Salamanca, Calle de Santa María, 4, 37008 Salamanca', '40.9644, -5.6636'),
(9, 'Málaga', 'Centro Cultural La Térmica, Av. de los Guindos, 48, 29004 Málaga', '36.6983, -4.4433'),
(10, 'Ciudad Real', 'Antiguo Casino de Ciudad Real, Calle Caballeros, 3, 13001 Ciudad Real', '38.9860, -3.9274');

INSERT INTO `escritores` (`id_escritor`, `nombre`, `biografia`, `nacionalidad`, `imagen`) VALUES
(1, 'Brandon Sanderson', 'Conocido por sagas como El Archivo de las Tormentas y Nacidos de la Bruma. Destaca por sus sistemas de magia complejos, mundos interconectados y ritmo narrativo impecable.', 'Estadounidense', 'a3fe43e9d5ce8d4773b3eb4e60a616ca'),
(2, 'George R. R. Martin', 'Escritor y guionista estadounidense, mundialmente conocido por la saga Canción de Hielo y Fuego, adaptada a televisión como Juego de Tronos. Destaca por su realismo crudo y sus personajes complejos.', 'Estadounidense', 'ccf28fd9c2b0e2c42d1802862d943367'),
(3, 'Patrick Rothfuss', 'Autor de la trilogía Crónica del asesino de reyes. Su prosa poética y su enfoque en la música, la historia y el conocimiento lo han convertido en una de las voces más influyentes de la fantasía moderna.', 'Estadounidense', '38072d62798a84360bd1f4e9630e11de'),
(4, 'Neil Gaiman', 'Escritor británico autor de American Gods, Stardust y The Sandman. Su obra mezcla fantasía, mitología y realismo mágico con una voz única y poética.', 'Británica', '8e6584dfb68e71cb2a7b594764870bd1'),
(5, 'Andrzej Sapkowski', 'Creador de The Witcher, saga que combina mitología eslava, ironía y una visión oscura del héroe. Su obra ha inspirado videojuegos, series y cómics.            ', 'Polaca', '8d7e9ed44bf19653f2fb669cafec88c4'),
(6, 'Margaret Atwood', 'Autora de El cuento de la criada y Oryx y Crake. Su ciencia ficción especulativa reflexiona sobre el poder, la sociedad y el papel de la mujer.', 'Canadiense', '95b369b1d3b1778b6a9baba88d7299c0'),
(7, 'Liu Cixin', 'Ingeniero y escritor chino, autor de El problema de los tres cuerpos, trilogía que combina física teórica y filosofía sobre el futuro de la humanidad.', 'China', '7409b3eba45478c1146a11d4b8f3b10c'),
(8, 'N. K. Jemisin', 'Primera autora en ganar tres Premios Hugo consecutivos por La Tierra Fragmentada. Su obra se centra en el poder, la opresión y la identidad dentro de mundos complejos.', 'Estadounidense', '1855ed834289cf81ee1e79ebdfb0546e'),
(9, 'Stephen King', 'El gran referente del terror moderno, autor de It, El resplandor y Doctor Sueño. Sus obras exploran el miedo cotidiano y lo sobrenatural con enorme éxito internacional.', 'Estadounidense', 'e80782a0729c8454fe5156f00c2be366'),
(10, 'Laura Gallego García', 'Autora valenciana reconocida por sagas como Memorias de Idhún, Crónicas de la Torre y Guardianes de la Ciudadela. Sus obras combinan aventuras, magia y temas de crecimiento personal.    ', 'Española', 'b825274353585605fc72897ecd0dd6e2'),
(11, 'Juan Gómez-Jurado', 'Periodista y novelista madrileño, autor de éxitos como Reina Roja, Cicatriz y El Paciente. Combina thriller, misterio y elementos de ciencia ficción en tramas muy cinematográficas.', 'Española', '8a9076c3db3e87dc5189a5127b233768'),
(12, 'Arturo Pérez-Reverte', 'Escritor y periodista cartagenero, autor de La tabla de Flandes, El club Dumas y la saga Las aventuras del capitán Alatriste. Su obra combina intriga, historia y reflexión sobre la condición humana.', 'Española', '552c70a400c39d5c092a00168967e2e7'),
(13, 'Santiago Posteguillo', 'Escritor valenciano especializado en novela histórica y narrativa épica. Con obras como Africanus: el hijo del cónsul o Yo, Julia, revive el Imperio Romano con rigor y fuerza narrativa.', 'Española', '33fddf7ffe6ef30318320f0a2a2cedb6'),
(14, 'Javier Castillo', 'Autor malagueño de best sellers como El día que se perdió la cordura, El juego del alma y El cuco de cristal. Sus novelas combinan misterio, suspense y giros psicológicos intensos.', 'Española', '0f00133e5313e8cba73cc4d829c4833f');

INSERT INTO `eventos` (`id_evento`, `titulo`, `descripcion`, `id_categoria`, `id_escritor`, `id_localizacion`, `fecha`) VALUES
(3, 'Firma de libros: Brandon Sanderson', 'Sesión de firmas con Brandon Sanderson, autor de \"El Archivo de las Tormentas\" y \"Nacidos de la Bruma\".', 1, 1, 10, '2025-12-06 12:00:00'),
(4, 'Firma de libros: George R. R. Martin', 'Encuentro y firmas con George R. R. Martin, creador de \"Canción de Hielo y Fuego\".', 1, 2, 2, '2025-12-07 18:00:00'),
(5, 'Firma de libros: Patrick Rothfuss', 'Firmas y charla breve sobre música, relato y magia en \"Crónica del asesino de reyes\".', 1, 3, 3, '2025-12-13 17:30:00'),
(6, 'Firma de libros: Neil Gaiman', 'Neil Gaiman firma ejemplares y conversa sobre mitología y fantasía urbana.', 1, 4, 4, '2025-12-14 12:30:00'),
(7, 'Firma de libros: Andrzej Sapkowski', 'El creador de \"The Witcher\" firma y charla sobre folclore eslavo y fantasía oscura.', 1, 5, 5, '2025-12-20 18:30:00'),
(8, 'Firma de libros: Margaret Atwood', 'Firmas y diálogo con lectores sobre distopías contemporáneas y crítica social.', 2, 6, 6, '2025-12-21 11:30:00'),
(9, 'Firma de libros: Liu Cixin', 'Liu Cixin firma ejemplares y comenta ciencia, física teórica y space opera.', 2, 7, 7, '2026-01-10 12:00:00'),
(10, 'Firma de libros: N. K. Jemisin', 'Firma y conversación sobre poder, opresión e identidad en mundos fragmentados.', 2, 8, 8, '2026-01-11 17:00:00'),
(11, 'Firma de libros: Stephen King', 'Stephen King firma y comparte anécdotas sobre el terror cotidiano y lo sobrenatural.', 3, 9, 9, '2026-01-17 18:30:00'),
(12, 'Firma de libros: Laura Gallego', 'Encuentro con lectores de \"Memorias de Idhún\" y \"Guardianes de la Ciudadela\".', 1, 10, 4, '2025-12-27 12:00:00'),
(13, 'Firma de libros: Juan Gómez-Jurado', 'Firma y coloquio sobre la saga de Antonia Scott: ritmo, suspense y tecnología.', 4, 11, 2, '2026-01-25 18:00:00'),
(14, 'Firma de libros: Arturo Pérez-Reverte', 'Firma y charla sobre novela histórica, intriga y aventuras del capitán Alatriste.', 5, 12, 5, '2026-02-07 18:30:00'),
(15, 'Firma de libros: Santiago Posteguillo', 'Firma y conversación sobre el Imperio Romano, documentación y épica narrativa.', 5, 13, 8, '2026-02-08 12:00:00'),
(16, 'Firma de libros: Javier Castillo', 'Firma de best sellers y charla breve sobre giros psicológicos y construcción del suspense.', 4, 14, 9, '2026-02-14 18:00:00'),
(17, 'Conferencia: Sistemas de magia y worldbuilding', 'Brandon Sanderson explica principios de diseño de magia “dura” y coherente con ejemplos de su obra.', 1, 1, 2, '2026-02-15 11:30:00'),
(18, 'Taller de escritura: Suspense narrativo', 'Juan Gómez-Jurado comparte técnicas de ritmo, tensión, giros y cliffhangers aplicadas al thriller.', 4, 11, 6, '2026-03-01 10:00:00');

INSERT INTO `libros` (`id_libro`, `titulo`, `anio_publicacion`, `id_escritor`, `id_editorial`, `id_categoria`) VALUES
(1, 'Juego de Tronos', 1996, 2, 9, 1),
(2, 'El nombre del viento', 2007, 3, 9, 1),
(3, 'El camino de los reyes', 2010, 1, 3, 1),
(4, 'American Gods', 2001, 4, 2, 1),
(5, 'El último deseo', 1993, 5, 4, 1),
(6, 'El cuento de la criada', 1985, 6, 1, 2),
(7, 'El problema de los tres cuerpos', 2008, 7, 3, 2),
(8, 'La quinta estación', 2015, 8, 4, 2),
(9, 'It', 1986, 9, 9, 3),
(10, 'Memorias de Idhún: La Resistencia', 2004, 10, 6, 1),
(11, 'Reina Roja', 2018, 11, 7, 4),
(12, 'El club Dumas', 1993, 12, 8, 4),
(13, 'Africanus: el hijo del cónsul', 2006, 13, 7, 5),
(14, 'El día que se perdió la cordura', 2017, 14, 9, 4);


INSERT INTO `registros` (`id_registros`, `id_usuario`, `id_evento`) VALUES
(2, 1, 4),
(6, 6, 3),
(8, 6, 11),
(10, 7, 3),
(11, 7, 11),
(14, 8, 11),
(16, 8, 13),
(19, 9, 8),
(20, 9, 10),
(21, 9, 16),
(31, 12, 7),
(32, 12, 15);
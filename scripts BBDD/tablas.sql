
CREATE DATABASE IF NOT EXISTS proyectojavier
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_spanish_ci;

USE proyectojavier;

-- 1) ROLES
CREATE TABLE roles (
  id_rol       TINYINT UNSIGNED NOT NULL,
  nombre       VARCHAR(50)      NOT NULL,
  PRIMARY KEY (id_rol),
  UNIQUE KEY uq_roles_nombre (nombre)
) ENGINE=InnoDB;

-- 2) USUARIOS
CREATE TABLE usuarios (
  id_usuario   INT UNSIGNED     NOT NULL AUTO_INCREMENT,
  nombre       VARCHAR(100)     NOT NULL,
  apellidos    VARCHAR(150)     NOT NULL,
  correo       VARCHAR(190)     NOT NULL,
  password     VARCHAR(255)     NOT NULL,
  id_rol       TINYINT UNSIGNED NOT NULL DEFAULT 2,  -- por defecto 'usuario'
  PRIMARY KEY (id_usuario),
  UNIQUE KEY uq_usuarios_correo (correo),
  KEY idx_usuarios_rol (id_rol),
  CONSTRAINT fk_usuarios_roles
    FOREIGN KEY (id_rol) REFERENCES roles (id_rol)
    ON UPDATE CASCADE
    ON DELETE RESTRICT
) ENGINE=InnoDB;

-- 3) EDITORIALES
CREATE TABLE editoriales (
  id_editorial   INT UNSIGNED  NOT NULL AUTO_INCREMENT,
  nombre         VARCHAR(150)  NOT NULL,
  pais           VARCHAR(100)  NOT NULL,
  anio_fundacion SMALLINT      NULL,  -- permite NULL si no se conoce
  PRIMARY KEY (id_editorial),
  KEY idx_editoriales_nombre (nombre)
) ENGINE=InnoDB;

-- 4) CATEGORIAS
CREATE TABLE categorias (
  id_categoria INT UNSIGNED  NOT NULL AUTO_INCREMENT,
  nombre       VARCHAR(120)  NOT NULL,
  PRIMARY KEY (id_categoria),
  UNIQUE KEY uq_categorias_nombre (nombre)
) ENGINE=InnoDB;

-- 5) LOCALIZACIONES
CREATE TABLE localizaciones (
  id_localizacion INT UNSIGNED  NOT NULL AUTO_INCREMENT,
  nombre            VARCHAR(150)  NOT NULL,
  direccion         VARCHAR(255)  NOT NULL,
  coordenadas       VARCHAR(64)   NOT NULL, -- p.ej. "43.3614,-5.8593" (lat,long)
  PRIMARY KEY (id_localizacion),
  KEY idx_localizaciones_nombre (nombre)
) ENGINE=InnoDB;

-- 6) ESCRITORES
CREATE TABLE escritores (
  id_escritor    INT UNSIGNED  NOT NULL AUTO_INCREMENT,
  nombre         VARCHAR(150)  NOT NULL,
  biografia      TEXT          NOT NULL,
  nacionalidad   VARCHAR(100)  NOT NULL,
  imagen           VARCHAR(255)  NULL,  -- URL o ruta de archivo
  PRIMARY KEY (id_escritor),
  KEY idx_escritores_nombre (nombre)
) ENGINE=InnoDB;

-- 7) LIBROS
CREATE TABLE libros (
  id_libro          INT UNSIGNED  NOT NULL AUTO_INCREMENT,
  titulo            VARCHAR(200)  NOT NULL,
  anio_publicacion  SMALLINT      NULL,
  id_escritor       INT UNSIGNED  NOT NULL,
  id_editorial      INT UNSIGNED  NOT NULL,
  id_categoria      INT UNSIGNED  NOT NULL,
  PRIMARY KEY (id_libro),
  KEY idx_libros_titulo (titulo),
  KEY idx_libros_escritor (id_escritor),
  KEY idx_libros_editorial (id_editorial),
  KEY idx_libros_categoria (id_categoria),
  CONSTRAINT fk_libros_escritores
    FOREIGN KEY (id_escritor) REFERENCES escritores (id_escritor)
    ON UPDATE CASCADE
    ON DELETE RESTRICT,
  CONSTRAINT fk_libros_editoriales
    FOREIGN KEY (id_editorial) REFERENCES editoriales (id_editorial)
    ON UPDATE CASCADE
    ON DELETE RESTRICT,
  CONSTRAINT fk_libros_categorias
    FOREIGN KEY (id_categoria) REFERENCES categorias (id_categoria)
    ON UPDATE CASCADE
    ON DELETE RESTRICT
) ENGINE=InnoDB;

-- 8) EVENTO
CREATE TABLE eventos (
  id_evento        INT UNSIGNED  NOT NULL AUTO_INCREMENT,
  titulo           VARCHAR(200)  NOT NULL,
  descripcion      TEXT          NOT NULL,
  id_categoria     INT UNSIGNED  NOT NULL,
  id_escritor      INT UNSIGNED  NOT NULL,
  id_localizacion  INT UNSIGNED  NOT NULL,
  fecha            DATETIME      NOT NULL,
  PRIMARY KEY (id_evento),
  KEY idx_evento_fecha (fecha),
  KEY idx_evento_categoria (id_categoria),
  KEY idx_evento_escritor (id_escritor),
  KEY idx_evento_localizacion (id_localizacion),
  CONSTRAINT fk_evento_categorias
    FOREIGN KEY (id_categoria) REFERENCES categorias (id_categoria)
    ON UPDATE CASCADE
    ON DELETE RESTRICT,
  CONSTRAINT fk_evento_escritores
    FOREIGN KEY (id_escritor) REFERENCES escritores (id_escritor)
    ON UPDATE CASCADE
    ON DELETE RESTRICT,
  CONSTRAINT fk_evento_localizaciones
    FOREIGN KEY (id_localizacion) REFERENCES localizaciones (id_localizacion)
    ON UPDATE CASCADE
    ON DELETE RESTRICT
) ENGINE=InnoDB;

-- 9) REGISTROS (inscripciones de usuarios a eventos)
CREATE TABLE registros (
  id_registros  INT UNSIGNED  NOT NULL AUTO_INCREMENT,
  id_usuario    INT UNSIGNED  NOT NULL,
  id_evento     INT UNSIGNED  NOT NULL,
  PRIMARY KEY (id_registros),
  UNIQUE KEY uq_registro_usuario_evento (id_usuario, id_evento), -- evita duplicados
  KEY idx_registros_usuario (id_usuario),
  KEY idx_registros_evento (id_evento),
  CONSTRAINT fk_registros_usuarios
    FOREIGN KEY (id_usuario) REFERENCES usuarios (id_usuario)
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  CONSTRAINT fk_registros_evento
    FOREIGN KEY (id_evento) REFERENCES eventos (id_evento)
    ON UPDATE CASCADE
    ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE `cctv_plantas`(
    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `id_comuna` INT NOT NULL,
    `id_comisarias` INT NOT NULL,
    `id_tipo_planta` INT NOT NULL,
    `nombre` VARCHAR(255) NOT NULL,
    `grupo` VARCHAR(255) NOT NULL,
    `ubicacion` VARCHAR(255) NOT NULL,
    `encargado_contacto` VARCHAR(255) NOT NULL,
    `encargado_email` VARCHAR(255) NOT NULL,
    `encargado_telefono` VARCHAR(255) NOT NULL,
    `mapa` VARCHAR(255) NOT NULL,
    `estado` BOOLEAN NOT NULL
);
ALTER TABLE
    `cctv_plantas` ADD INDEX `cctv_plantas_id_index`(`id`);
ALTER TABLE
    `cctv_plantas` ADD INDEX `cctv_plantas_id_comuna_index`(`id_comuna`);
ALTER TABLE
    `cctv_plantas` ADD INDEX `cctv_plantas_id_comisarias_index`(`id_comisarias`);
ALTER TABLE
    `cctv_plantas` ADD INDEX `cctv_plantas_id_tipo_planta_index`(`id_tipo_planta`);
CREATE TABLE `cctv_turnos`(
    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `id_plantas` INT NOT NULL,
    `id_jornada` INT NOT NULL,
    `nombre` VARCHAR(255) NOT NULL,
    `estado` BOOLEAN NOT NULL
);
ALTER TABLE
    `cctv_turnos` ADD INDEX `cctv_turnos_id_index`(`id`);
ALTER TABLE
    `cctv_turnos` ADD INDEX `cctv_turnos_id_plantas_index`(`id_plantas`);
ALTER TABLE
    `cctv_turnos` ADD INDEX `cctv_turnos_id_jornada_index`(`id_jornada`);
CREATE TABLE `cctv_operadores`(
    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `id_turnos` INT NOT NULL,
    `id_users` INT NOT NULL,
    `estado` BOOLEAN NOT NULL
);
ALTER TABLE
    `cctv_operadores` ADD INDEX `cctv_operadores_id_index`(`id`);
ALTER TABLE
    `cctv_operadores` ADD INDEX `cctv_operadores_id_turnos_index`(`id_turnos`);
ALTER TABLE
    `cctv_operadores` ADD INDEX `cctv_operadores_id_users_index`(`id_users`);
CREATE TABLE `cctv_users`(
    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `id_perfil` INT NOT NULL,
    `nombres` VARCHAR(255) NOT NULL,
    `apellidos` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `codigo_google_2fa` VARCHAR(255) NOT NULL,
    `fecha_creacion` DATETIME NOT NULL,
    `estado` BOOLEAN NOT NULL
);
ALTER TABLE
    `cctv_users` ADD INDEX `cctv_users_id_index`(`id`);
ALTER TABLE
    `cctv_users` ADD INDEX `cctv_users_id_perfil_index`(`id_perfil`);
CREATE TABLE `cctv_jornada`(
    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `nombre` VARCHAR(255) NOT NULL,
    `estado` BOOLEAN NOT NULL
);
ALTER TABLE
    `cctv_jornada` ADD INDEX `cctv_jornada_id_index`(`id`);
CREATE TABLE `cctv_gestion_plantas_camaras`(
    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `id_camaras` INT NOT NULL,
    `id_gestion_plantas` INT NOT NULL,
    `observacion` VARCHAR(255) NOT NULL,
    `estado` BOOLEAN NOT NULL
);
CREATE TABLE `cctv_tipo_planta`(
    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `nombre` VARCHAR(255) NOT NULL,
    `estado` BOOLEAN NOT NULL
);
ALTER TABLE
    `cctv_tipo_planta` ADD INDEX `cctv_tipo_planta_id_index`(`id`);
CREATE TABLE `cctv_perfil`(
    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `nombre` VARCHAR(255) NOT NULL,
    `estado` BOOLEAN NOT NULL
);
ALTER TABLE
    `cctv_perfil` ADD INDEX `cctv_perfil_id_index`(`id`);
CREATE TABLE `cctv_ciudad`(
    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `nombre` VARCHAR(255) NOT NULL,
    `estado` BOOLEAN NOT NULL
);
ALTER TABLE
    `cctv_ciudad` ADD INDEX `cctv_ciudad_id_index`(`id`);
CREATE TABLE `cctv_gestion_plantas`(
    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `id_users` INT NOT NULL,
    `id_plantas` INT NOT NULL,
    `planta_en_linea` BOOLEAN NOT NULL,
    `con_intermitencia` BOOLEAN NOT NULL,
    `camaras_sin_conexion` INT NOT NULL,
    `camaras_totales` INT NOT NULL,
    `porcentaje_camara_operativa` DOUBLE(8, 2) NOT NULL,
    `observaciones` VARCHAR(255) NOT NULL,
    `fecha_gestion` DATETIME NOT NULL,
    `estado` BOOLEAN NOT NULL
);
ALTER TABLE
    `cctv_gestion_plantas` ADD INDEX `cctv_gestion_plantas_id_index`(`id`);
ALTER TABLE
    `cctv_gestion_plantas` ADD INDEX `cctv_gestion_plantas_id_users_index`(`id_users`);
ALTER TABLE
    `cctv_gestion_plantas` ADD INDEX `cctv_gestion_plantas_id_plantas_index`(`id_plantas`);
CREATE TABLE `cctv_camaras`(
    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `id_plantas` INT NOT NULL,
    `nombre` VARCHAR(255) NOT NULL,
    `estado` BOOLEAN NOT NULL
);
ALTER TABLE
    `cctv_camaras` ADD INDEX `cctv_camaras_id_index`(`id`);
ALTER TABLE
    `cctv_camaras` ADD INDEX `cctv_camaras_id_plantas_index`(`id_plantas`);
CREATE TABLE `cctv_comunas`(
    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `id_ciudad` INT NOT NULL DEFAULT '0',
    `nombre` VARCHAR(255) NOT NULL,
    `estado` BOOLEAN NOT NULL
);
ALTER TABLE
    `cctv_comunas` ADD INDEX `cctv_comunas_id_index`(`id`);
ALTER TABLE
    `cctv_comunas` ADD INDEX `cctv_comunas_id_ciudad_index`(`id_ciudad`);
CREATE TABLE `cctv_comisarias`(
    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `nombre` VARCHAR(255) NOT NULL,
    `direccion` VARCHAR(255) NOT NULL,
    `telefono` VARCHAR(255) NOT NULL,
    `movil` VARCHAR(255) NOT NULL,
    `estado` BOOLEAN NOT NULL
);
ALTER TABLE
    `cctv_comisarias` ADD INDEX `cctv_comisarias_id_index`(`id`);
ALTER TABLE
    `cctv_plantas` ADD CONSTRAINT `cctv_plantas_id_comisarias_foreign` FOREIGN KEY(`id_comisarias`) REFERENCES `cctv_comisarias`(`id`);
ALTER TABLE
    `cctv_gestion_plantas_camaras` ADD CONSTRAINT `cctv_gestion_plantas_camaras_id_gestion_plantas_foreign` FOREIGN KEY(`id_gestion_plantas`) REFERENCES `cctv_gestion_plantas`(`id`);
ALTER TABLE
    `cctv_gestion_plantas` ADD CONSTRAINT `cctv_gestion_plantas_id_users_foreign` FOREIGN KEY(`id_users`) REFERENCES `cctv_users`(`id`);
ALTER TABLE
    `cctv_users` ADD CONSTRAINT `cctv_users_id_perfil_foreign` FOREIGN KEY(`id_perfil`) REFERENCES `cctv_perfil`(`id`);
ALTER TABLE
    `cctv_turnos` ADD CONSTRAINT `cctv_turnos_id_jornada_foreign` FOREIGN KEY(`id_jornada`) REFERENCES `cctv_jornada`(`id`);
ALTER TABLE
    `cctv_comunas` ADD CONSTRAINT `cctv_comunas_id_ciudad_foreign` FOREIGN KEY(`id_ciudad`) REFERENCES `cctv_ciudad`(`id`);
ALTER TABLE
    `cctv_camaras` ADD CONSTRAINT `cctv_camaras_id_plantas_foreign` FOREIGN KEY(`id_plantas`) REFERENCES `cctv_plantas`(`id`);
ALTER TABLE
    `cctv_plantas` ADD CONSTRAINT `cctv_plantas_id_comuna_foreign` FOREIGN KEY(`id_comuna`) REFERENCES `cctv_comunas`(`id`);
ALTER TABLE
    `cctv_turnos` ADD CONSTRAINT `cctv_turnos_id_plantas_foreign` FOREIGN KEY(`id_plantas`) REFERENCES `cctv_plantas`(`id`);
ALTER TABLE
    `cctv_gestion_plantas` ADD CONSTRAINT `cctv_gestion_plantas_id_plantas_foreign` FOREIGN KEY(`id_plantas`) REFERENCES `cctv_plantas`(`id`);
ALTER TABLE
    `cctv_gestion_plantas_camaras` ADD CONSTRAINT `cctv_gestion_plantas_camaras_id_camaras_foreign` FOREIGN KEY(`id_camaras`) REFERENCES `cctv_camaras`(`id`);
ALTER TABLE
    `cctv_operadores` ADD CONSTRAINT `cctv_operadores_id_turnos_foreign` FOREIGN KEY(`id_turnos`) REFERENCES `cctv_turnos`(`id`);
ALTER TABLE
    `cctv_plantas` ADD CONSTRAINT `cctv_plantas_id_tipo_planta_foreign` FOREIGN KEY(`id_tipo_planta`) REFERENCES `cctv_tipo_planta`(`id`);
ALTER TABLE
    `cctv_operadores` ADD CONSTRAINT `cctv_operadores_id_users_foreign` FOREIGN KEY(`id_users`) REFERENCES `cctv_users`(`id`);
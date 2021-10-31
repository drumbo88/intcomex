<?php 
    class DB {
        static private $link;
        static function init() {
            self::$link = @mysqli_connect(DB_URL, DB_USER, DB_PASS);
            if (!self::$link) 
                die("Error: no se pudo conectar a la base de datos.");
            
            if (!mysqli_select_db(self::$link, DB_NAME)) {
                self::query("CREATE DATABASE ".DB_NAME);
                self::query("
                    CREATE TABLE `intcomex`.`contacto`(
                        `id` INT NOT NULL AUTO_INCREMENT,
                        `codigo_cliente` VARCHAR(16) NOT NULL,
                        `usuario` VARCHAR(6) NOT NULL,
                        `nombre` VARCHAR(15) NOT NULL,
                        `cargo` VARCHAR(10) NOT NULL,
                        `telefono` VARCHAR(10) NOT NULL,
                        `celular` VARCHAR(10) NOT NULL,
                        `email` VARCHAR(255) NOT NULL,
                        `tipo_contacto_id` INT NOT NULL,
                        `password` VARCHAR(32) NOT NULL,
                        `webstore` INT NOT NULL,
                        `ordenes_crear` INT NOT NULL,
                        `envio_acceso` INT NOT NULL,
                        PRIMARY KEY(`id`),
                        INDEX(`tipo_contacto_id`),
                        UNIQUE(`usuario`)
                    ) ENGINE = INNODB;
                ");
                mysqli_select_db(self::$link, DB_NAME);
            }
        }
        static function query($query) {
            $result = mysqli_query(self::$link, $query);
            return $result;
        }
    }
    DB::init();
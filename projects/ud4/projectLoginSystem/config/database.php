<?php

class database
{
    //constantes
    private const GESTOR_BASE_DATOS = "pgsql";
    private const CONTRA = "laura";
    private const USUARIO = "lcecilia_loginSystem_user";
    private const NOMBRE_BASE_DATOS = "lcecilia_loginSystem_db";
    private const RUTA_SERVIDOR = "localhost";
    private const PUERTO = "5432";
    private static $privateConnectionDataBase;

    /**
     * connection dataBase
     * @return PDO
     */
    public static function getConnectionDataBase() {
        if (null !== self::$privateConnectionDataBase) {
            return self::$privateConnectionDataBase;
        }
        try {
            return self::$privateConnectionDataBase = new PDO(self::GESTOR_BASE_DATOS . ":host=". self::RUTA_SERVIDOR . ";port=" . self::PUERTO . ";dbname=" . self::NOMBRE_BASE_DATOS, self::USUARIO, self::CONTRA);
        } catch (PDOException $PDOExceptionConnectionBaseDatos) {
            echo "Hubo un error al conectarse ha la base de datos " . $PDOExceptionConnectionBaseDatos->getMessage();
            return self::$privateConnectionDataBase;
        }
    }

}
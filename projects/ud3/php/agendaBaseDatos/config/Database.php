<?php

class Database
{
    private const GESTOR_BASE_DATOS = "pgsql";
    private const CONTRA = "laura";
    private const USUARIO = "lcecilia_usr";
    private const NOMBRE_BASE_DATOS = "lcecilia_agendaDB_db";
    private const RUTA_SERVIDOR = "localhost";
    private const PUERTO = "5432";
    private static $db;

    public static function getConnection()
    {
        if (null !== self::$db) {
            return self::$db;
        }
        try {
            return self::$db = new PDO(self::GESTOR_BASE_DATOS . ":host=". self::RUTA_SERVIDOR . ";port=" . self::PUERTO . ";dbname=" . self::NOMBRE_BASE_DATOS, self::USUARIO, self::CONTRA);
        } catch (PDOException $PDOExceptionConnectionBaseDatos) {
            echo "Hubo un error al conectarse ha la base de datos " . $PDOExceptionConnectionBaseDatos->getMessage();
            return self::$db;
        }
    }
}
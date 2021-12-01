<?php

class User
{
    //Atributos privados estáticos.
    //Conexión a la base de datos.
    private static $baseDatosPgPConnect = pg_pconnect("dbname=lcecilia_loginSystem_db");
    private const NOMBRE_TABLA_BASE_DATOS = "users";

    //Atributos privados constantes estáticos.
    private static $privateStaticConnectionDataBase;
    //Atributos públicos no estáticos.
    public $publicId;
    public $publicName;
    public $publicPassword;
    public $publicEmail;
    public $publicAccessLevel;
    public $publicAccessCode;
    public $publicStatus;
    public $publicCreatedDate;
    public $publicCreatedTime;
    public $publicModifiedDate;
    public $publicModifiedTime;

    public function __construct($baseDatos)
    {
        self::$privateStaticConnectionDataBase = $baseDatos;
    }

    public function emailExists()
    {
        $myQuery = "select id, name, accesslevel, password, status from " . self::NOMBRE_TABLA_BASE_DATOS . " where email = ? limit 0,1";
        $stmt = self::$privateStaticConnectionDataBase->pg_query(self::$baseDatosPgPConnect, $myQuery);
        $this->publicEmail = htmlspecialchars(strip_tags($this->publicEmail));
        $stmt->bindParam(1, $this->publicEmail);
        $stmt->execute();
        $num = $stmt->rowCount();
        if ($num > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->publicId = $row['id'];
            $this->publicName = $row['name'];
            $this->publicAccessLevel = $row['accessLevel'];
            $this->publicPassword = $row['password'];
            $this->publicStatus = $row['status'];
            return true;
        }
        return false;
    }

    public function create()
    {
        $this->publicCreatedDate = date('Y-m-d');
        $this->publicCreatedTime = date('H:i:s');
        $myQuery = "insert into users(name, password, email, accesslevel, status, createddate, createdtime) 
        values (" . $this->publicName . ", " . $this->publicPassword . ", " . $this->publicEmail . ", " . $this->publicAccessLevel .
            ", " . $this->publicStatus . ", " . $this->publicCreatedDate . ", " . $this->publicCreatedTime . ");";
        $stmt = self::$privateStaticConnectionDataBase->pg_query(self::$baseDatosPgPConnect, $myQuery);
        $this->publicName = htmlspecialchars(strip_tags($this->publicName));
        $this->publicEmail = htmlspecialchars(strip_tags($this->publicEmail));
        $this->publicPassword = htmlspecialchars(strip_tags($this->publicPassword));
        $this->publicAccessLevel = htmlspecialchars(strip_tags($this->publicAccessLevel));
        $this->publicStatus = htmlspecialchars(strip_tags($this->publicStatus));
        if ($stmt->execute()) {
            return true;
        } else {
            $this->showError($stmt);
            return false;
        }
    }

    public function showError($stmt)
    {
        echo "<pre>";
        print_r($stmt->errorInfo());
        echo "</pre>";
    }

    public function readAll($from_record_num, $records_per_page)
    {
        $query = "select id, name, email, accesslevel, createddate, createdtime
            from " . self::NOMBRE_TABLA_BASE_DATOS . " order by id desc limit ?,?";
        $stmt = self::$privateStaticConnectionDataBase->pg_query(self::$baseDatosPgPConnect, $query);

        // bind limit clause variables
        $stmt->bindParam(1, $from_record_num, PDO::PARAM_INT);
        $stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);

        // execute query
        $stmt->execute();

        // return values
        return $stmt;
    }

    public function countAll()
    {
        $query = "select id from " . self::NOMBRE_TABLA_BASE_DATOS;
        $stmt = self::$privateStaticConnectionDataBase->pg_prepare(self::$baseDatosPgPConnect, "my_Query", $query);
        $stmt->execute();
        $num = $stmt->rowCount();
        return $num;
    }
}
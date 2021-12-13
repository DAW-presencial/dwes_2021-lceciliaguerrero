<?php

class Contact
{
    private static $conn;
    private $name;
    private $email;
    private $telf;

    public function __construct($db)
    {
        self::setConn($db);
    }

    public static function getConn()
    {
        return self::$conn;
    }

    /**
     * @param $conn
     */
    public static function setConn($conn)
    {
        self::$conn = $conn;
    }

    /**
     * Creo un contrato
     * @param string $name
     * @param $email
     * @param string $telf
     * @return bool
     */
    public function create(string $name, $email, string $telf): bool
    {
        $this->setName($name);
        $this->setEmail($email);
        $this->setTelf($telf);
        //Postgres
        $query = "insert into contact(name, email, telephone_number) values (:name, :email, :telephone_number)";
        $myPrepare = array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY);/**/
        $param = array(':name' => $this->getName(), ':email' => $this->getEmail(), ':telephone_number' => $this->getTelf());
        try {/*$this->exist($this->getName(), $this->getEmail(), $this->getTelf())*/
            if ($this->exist($this->getEmail(), $this->getTelf()) === false) {
                $stmtPrepare = self::getConn()->prepare($query, $myPrepare);
                $stmtPrepare->execute($param);
                $resultado = boolval($stmtPrepare->fetchAll());
                if ($resultado === true) {
                    echo "<p>Usuario creado correctamente<p>";
                    return true;
                } else {
                    $this->showError($stmtPrepare);
                    return false;
                }
            } else {
                echo "<p>Usuario Existente<p>";
                $this->update($this->getName(), $this->getEmail(), $this->getTelf());
                return false;
            }
        } catch (PDOException $PDOExceptionCreate) {
            echo "Error creación del contacto" . $PDOExceptionCreate->getMessage();
            return false;
        }
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getTelf(): string
    {
        return $this->telf;
    }

    /**
     * @param string $telf
     */
    public function setTelf(string $telf)
    {
        $this->telf = $telf;
    }

    /**
     * @param $stmt
     * @return string
     */
    public function showError($stmt): string
    {
        return "<pre>" . $stmt->errorInfo() . "</pre>";
    }

    /**
     * Actualizo el contacto
     * @param string $name
     * @param $email
     * @param string $telf
     * @return bool
     */
    public function update(string $name, $email, string $telf): bool
    {
        //Postgres
        $query = "update contact set name = :newName, telephone_number = :newTelephone_number where email = :email;";
        $myPrepare = array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY);
        $param = array(':newName' => $name, ':newTelephone_number' => $telf, ':email' => $email);
        try {
            $stmtPrepare = self::getConn()->prepare($query, $myPrepare);
            $stmtPrepare->execute($param);
            $resultado = boolval($stmtPrepare->fetchAll());
            if ($resultado === true) {
                echo "<p>Usuario actualizado correctamente<p>";
                return true;
            } else {
                $this->showError($stmtPrepare);
                return false;
            }
        } catch (PDOException $PDOExceptionUpdate) {
            echo "Error actualización del contacto" . $PDOExceptionUpdate->getMessage();
            return false;
        }
    }

    /**
     * Elimino un contacto.
     * @param string $name
     * @param $email
     * @param string $telf
     * @return bool
     */
    public function destroy(string $name, $email, string $telf): bool
    {
        $this->setName($name);
        $this->setEmail($email);
        $this->setTelf($telf);
        $query = "delete from contact where name = :name and email = :email and telephone_number = :telephone_number";
        $myPrepare = array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY);
        $param = array(':name' => $this->getName(), ':email' => $this->getEmail(), ':telephone_number' => $this->getTelf());
        try {
            if ($this->exist($this->getEmail(), $this->getTelf()) === true) {
                $stmtPrepare = self::getConn()->prepare($query, $myPrepare);
                $stmtPrepare->execute($param);
                $resultado = boolval($stmtPrepare->fetchAll());
                if ($resultado === true) {
                    echo "<p>Usuario eliminado correctamente<p>";
                    return true;
                } else {
                    return false;
                }
            } else {
                echo "<p>Usuario no existe y no fue eliminado<p>";
                return false;
            }
        } catch (PDOException $PDOExceptionDestroy) {
            echo "Error eliminación del contacto" . $PDOExceptionDestroy->getMessage();
            return false;
        }
    }

    /**
     * Verifico si existe el contacto.
     * @param $email
     * @param string $telf
     * @return bool
     */
    public function exist($email, string $telf): bool
    {
        $query = "select name, email, telephone_number from contact where email = :email or telephone_number = :telephone_number;";
        $myPrepare = array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY);
        $param = array(':email' => $email, ':telephone_number' => $telf);
        /*$myExecute = array(':name' => $this->getName(), ':email' => $this->getEmail(), ':telephone_number' => $this->getTelf());*/
        try {
            $stmtPrepare = self::getConn()->prepare($query, $myPrepare);
            $stmtPrepare->execute($param);
            $resultado = boolval($stmtPrepare->fetchAll());
            if ($resultado === true) {
                $stmtPrepare->rowCount();
                return true;
            } else {
                return false;
            }
        } catch (PDOException $PDOExceptionExist) {
            echo "Error exist del contacto" . $PDOExceptionExist->getMessage();
            return false;
        }
    }

    /**
     * Listo los contactos con un límite.
     * @param $limiteInicio
     * @param $limiteFin
     * @return string
     */
    public function list($limiteInicio, $limiteFin)
    {
        //Postgres
        $query = "select id, name, email, telephone_number from contact order by name limit $limiteFin offset $limiteInicio;";
        try {
            return self::getConn()->query($query);
        } catch (PDOException $PDOExceptionList) {
            return "Error listado de contactos" . $PDOExceptionList->getMessage();
        }
    }

    /**
     * Listo todos los contactos.
     * @return string
     */
    public function listComplete()
    {
        //Postgres
        $query = "select id, name, email, telephone_number from contact order by name;";
        try {
            return self::getConn()->query($query);
        } catch (PDOException $PDOExceptionListComplete) {
            return "Error listado de contactos" . $PDOExceptionListComplete->getMessage();
        }
    }
}
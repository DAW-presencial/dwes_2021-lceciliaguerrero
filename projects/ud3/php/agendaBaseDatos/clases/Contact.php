<?php

class Contact
{
    private $conn;
    private string $name;
    private string $email;
    private string $telf;

    /**/public function __construct(mixed $db)
    {
        $this->conn = $db;
    }
    /*public function __construct(mixed $db, string $name, mixed $email, string $telf)
    {
        self::setDb($db);
        $this->name = $name;
        $this->email = $email;
        $this->telf = $telf;
    }*/
    /**
     * @return string
     */
    public function index(): string
    {
        //Postgres
        $query = "select id, name, email, telephone_number from contact";
        $output = "";
        try {
            $stmtQuery = $this->conn->query($query);
            foreach ($stmtQuery as $item) {
                $output .= "<p> id: '" . $item['id'] . "' name: '" . $item['name'] . "' email: '" . $item['email'] .
                    "' telf: '" . $item['telephone_number'] . "'.</p>";
            }
            return $output;
        } catch (PDOException $PDOExceptionIndex) {
            return "Error listado de contactos" . $PDOExceptionIndex->getMessage();
        }
    }

    /**
     * Show the form for creating a new resource.
     * @param string $name
     * @param string $email
     * @param string $telf
     * @return bool
     */
    public function create(string $name, string $email, string $telf): bool
    {
        $this->setName($name);
        $this->setEmail($email);
        $this->setTelf($telf);
        //Postgres
        $query = "insert into contact(name, email, telephone_number) values (:name, :email, :telephone_number)";
/*        $myPrepare = array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY);*/
        $param = array(':name' => $this->getName(), ':email' => $this->getEmail(), ':telephone_number' => $this->getTelf());
        try {/*$this->exist($this->getName(), $this->getEmail(), $this->getTelf())*/
            if ($this->existEmail($this->getEmail()) === false) {
                $stmtPrepare = $this->conn->prepare($query);
                $result = $this->conn->execute($param);
                if ($result) {
                    echo "<p>Usuario creado correctamente<p>";
                    return true;
                } else {
                    $this->showError($result);
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

        /*$stmtPrepare = $this->conn->prepare($query);
        $result = $this->conn->execute($param);
        if ($result) {
            echo "<p>Usuario creado correctamente<p>";
            return true;
        } else {
            $this->showError($result);
            return false;
        }*/
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
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
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
    public function setTelf(string $telf): void
    {
        $this->telf = $telf;
    }

    /**
     * Existe email
     * @param mixed $name
     * @return bool
     */
    public function existEmail(mixed $name): bool
    {
        /*$myQuery = "select name, email, telephone_number from contact;";*/
        $myQuery = "select name, email, telephone_number from contact where email = :email;";
        $myPrepare = array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY);
        $myExecute = array(':email' => $name);
        /*$myExecute = array(':name' => $this->getName(), ':email' => $this->getEmail(), ':telephone_number' => $this->getTelf());*/
        try {
            $stmtPrepare = self::getDb()->prepare($myQuery, $myPrepare);
            $stmtExecute = $stmtPrepare->execute($myExecute);
            if ($stmtExecute) {
                $stmtPrepare->rowCount();
                echo "<p>El usuario ya existe<p>";
                return true;
            } else {
                $this->showError($stmtExecute);
                echo "<p>El usuario no existe<p>";
                return false;
            }
        } catch (PDOException $PDOExceptionExistName) {
            echo "Error exist nombre del contacto" . $PDOExceptionExistName->getMessage();
            return false;
        }

        /*$nombre = htmlspecialchars(strip_tags($this->getName()));

        $stmt = self::getDb()->prepare($myQuery);
        $stmt->bindParam(':name', $nombre);
        if ($stmt->execute()) {
            $stmt->rowCount();
            echo "<p>El usuario ya existe<p>";
            return true;
        } else {
            $this->showError($stmt);
            echo "<p>El usuario no existe<p>";
            return false;
        }*/
    }

    /**
     * @param mixed $stmt
     * @return string
     */
    public function showError(mixed $stmt): string
    {
        return "<pre>" . $stmt->errorInfo() . "</pre>";
    }

    /**
     * Update the specified resource in storage.
     * @param string $name
     * @param string $email
     * @param string $telf
     * @return bool
     */
    public function update(string $name, string $email, string $telf): bool
    {
        //Postgres
        $myQuery = "update contact set name = :newName, telephone_number = :newTelephone_number where email = :email;";
        $myPrepare = array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY);
        $myExecute = array(':newName' => $name, ':newTelephone_number' => $telf, ':email' => $email);
        try {
            $stmtPrepare = self::getDb()->prepare($myQuery, $myPrepare);
            $stmtExecute = $stmtPrepare->execute($myExecute);
            if ($stmtExecute) {
                echo "<p>Usuario actualizado correctamente<p>";
                return true;
            } else {
                $this->showError($stmtExecute);
                return false;
            }
        } catch (PDOException $PDOExceptionUpdate) {
            echo "Error actualización del contacto" . $PDOExceptionUpdate->getMessage();
            return false;
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param string $name
     * @param string $email
     * @param string $telf
     * @return bool
     */
    public function destroy(string $name, string $email, string $telf): bool
    {
        $this->setName($name);
        $this->setEmail($email);
        $this->setTelf($telf);
        $myQuery = "delete from contact where name = :name and email = :email and telephone_number = :telephone_number";
        $myPrepare = array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY);
        $myExecute = array(':name' => $this->getName(), ':email' => $this->getEmail(), ':telephone_number' => $this->getTelf());
        try {
            if ($this->existEmail($this->getEmail()) === true) {
                $stmtPrepare = self::getDb()->prepare($myQuery, $myPrepare);
                $stmtExecute = $stmtPrepare->execute($myExecute);
                if ($stmtExecute) {
                    echo "<p>Usuario eliminado correctamente<p>";
                    return true;
                } else {
                    $this->showError($stmtExecute);
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
     * @param string $name
     * @param string $email
     * @param string $telf
     * @return bool
     */
    public function exist(string $name, string $email, string $telf): bool
    {
        $myQuery = "select name, email, telephone_number from contact where name = :name or email = :email or telephone_number = :telephone_number;";
        $myPrepare = array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY);
        $myExecute = array(':name' => $name, ':email' => $email, ':telephone_number' => $telf);
        /*$myExecute = array(':name' => $this->getName(), ':email' => $this->getEmail(), ':telephone_number' => $this->getTelf());*/
        try {
            $stmtPrepare = self::getDb()->prepare($myQuery, $myPrepare);
            $stmtExecute = $stmtPrepare->execute($myExecute);
            if ($stmtExecute) {
                $stmtPrepare->rowCount();
                echo "<p>El usuario ya existe<p>";
                return true;
            } else {
                $this->showError($stmtExecute);
                echo "<p>El usuario no existe<p>";
                return false;
            }
        } catch (PDOException $PDOExceptionExist) {
            echo "Error exist del contacto" . $PDOExceptionExist->getMessage();
            return false;
        }
    }

    /**
     * @param mixed $limiteInicio
     * @param mixed $limiteFin
     * @return string
     */
    public function list(mixed $limiteInicio, mixed $limiteFin): string
    {
        //Postgres
        $myQuery = "select id, name, email, telephone_number from contact order by name limit :fin offset :inicio";
        $myPrepare = array(PDO::ATTR_CURSOR => PDO::PARAM_INT);
        $myExecute = array(':fin' => $limiteFin, ':inicio' => $limiteInicio);
        try {
            $stmtPrepare = self::getDb()->prepare($myQuery, $myPrepare);
            return $stmtPrepare->execute($myExecute);
            /*$stmt = self::getDb()->prepare($myQuery);
            $stmt->bindParam(':inicio', $limiteInicio);
            $stmt->bindParam(':fin', $limiteFin);
            $stmt->execute();
            return $stmt;*/
        } catch (PDOException $PDOExceptionList) {
            return "Error listado de contactos" . $PDOExceptionList->getMessage();
        }
    }
}
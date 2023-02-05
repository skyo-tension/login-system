<?php
namespace app\model;

require_once 'model.php';

use PDO;

/**
 * model UsersModel
 *
 */
class UsersModel extends model
{
    private $name = 'users';

    public function __construct(){
        $dbms = 'MYSQL';
        parent::__construct($dbms);
    }

    public function __toString():string {
        return $this->name;
    }

    /**
     * get all record set
     * @return array
     */
    public function getAll():array {
        $sql  = <<< EOF
SELECT *
FROM {$this->name}
EOF;

        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            $rs = $stmt->fetchAll();
        }catch(Exception $e){
            $this->logging($e->getMessage());
        }

        return $rs;
    }

    /**
     * select record set
     * 
     * @param string $name
     * @return $rs
     */
    public function select($name) {

        $sql  = <<< EOF
SELECT *
FROM {$this->name}
WHERE name = :name
EOF;

        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->execute();
            $rs = $stmt->fetch(PDO::FETCH_ASSOC);
        }catch(Exception $e){
            $this->logging($e->getMessage());
        }

        return $rs;
    }

    /**
     * insert record
     */
    public function insert(array $param) {
        $sql  = <<< EOF
INSERT INTO {$this->name}(
    name,
    password
)VALUES(
    :name,
    :password
)
EOF;

        $this->pdo->beginTransaction();
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':name', $param['name'], PDO::PARAM_STR);
            $stmt->bindParam(':password', $param['password'], PDO::PARAM_STR);
            $stmt->execute();
            $this->pdo->commit();
        }catch(Exception $e){
            $this->logging($e->getMessage());
            $this->pdo->rollBack();
        }
    }

    /**
     * delete record
     */
    public function delete(array $param) {
        $sql  = <<< EOF
DELETE FROM {$this->name}
WHERE id = :id
EOF;

        $this->pdo->beginTransaction();        
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':id', $param['id'], PDO::PARAM_INT);
            $stmt->execute();
            $this->pdo->commit();
        }catch(Exception $e){
            $this->logging($e->getMessage());
            $this->pdo->rollBack();
        }
    }
}

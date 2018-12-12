<?php
namespace Database;

class PDODatabase implements DatabaseInterface
{
    /**
     * @var \PDO
     */
    private $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function query(string $query): StatementInterface
    {
        $stmt = $this->pdo->prepare($query);
        return new PDOPreparedStatement($stmt);

    }

    public function beginTransaction() {
        $this->pdo->beginTransaction();
    }

    public function commit(){
        $this->pdo->commit();
    }

    public function getErrorInfo(): array
    {
        return $this->pdo->errorInfo();
        // TODO: Implement getErrorInfo() method.
    }

    public function lastInserId() : int {
       return $this->pdo->lastInsertId();
    }
}
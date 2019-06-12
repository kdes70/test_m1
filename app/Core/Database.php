<?php


namespace App\Core;


use PDO;

class Database
{
    public $pdo;

    public function __construct()
    {
        $this->pdo = $this->getDB();
    }

    /**
     * Подключение к базе данных
     *
     * @return PDO
     */
    protected function getDB(): PDO
    {
        static $db = null;

        if ($db === null) {
            $dsn = 'mysql:host=' . getenv('DB_HOST') . ';dbname=' . getenv('DB_DATABASE') . ';charset=utf8';
            $db = new PDO($dsn, getenv('DB_USERNAME'), getenv('DB_PASSWORD'));
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        return $db;
    }


    /**
     *  Executes a prepared statement
     *
     * @param $query
     * @param array|null $params
     * @return array
     */
    public function execute($query, array $params = null): array
    {
        if (is_null($params)) {
            $stmt = $this->pdo->query($query);
            return $stmt->fetchAll();
        }
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll();

    }
}
<?php


namespace App\Models;

use PDO;

class Model
{
    /**
     * Подключение к базе данных
     *
     * @return PDO
     */
    protected static function getDB()
    {
        static $db = null;

        if ($db === null) {
            $dsn = 'mysql:host=' . getenv('DB_HOST'). ';dbname=' . getenv('DB_DATABASE') . ';charset=utf8';
            $db = new PDO($dsn, getenv('DB_USERNAME'), getenv('DB_PASSWORD'));
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        return $db;
    }
}
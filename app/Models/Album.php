<?php


namespace App\Models;


use Illuminate\Http\Request;

class Album extends Model
{

    protected $table = 'albums';


    /**
     * @var \PDO
     */
    protected $db;

    public function __construct()
    {
        $this->db = Model::getDB();
    }


    public function getList()
    {
        $query = $this->db->query("SELECT * FROM {$this->table} ORDER BY id DESC");
        $query->execute();

        return $query->fetchAll(\PDO::FETCH_OBJ);
    }

}
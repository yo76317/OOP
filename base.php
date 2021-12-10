<?php

class DB{
    protected $table='';
    protected $dsn="mysql:host=localhost;chartset=utf8;dbname=member";
    protected $pdo;

    // $db=new DB ('users');
    public function __construct($table){
        // 把pdo帶進來
        $this->pdo=new PDO($this->dsn,'root','');
        $this->table=$table;
    }

    public function getTable(){
        return $this->table;
    }
}

$db=new DB ('member');
echo $db->getTable();
?>
<?php

//條件
class DB{
    protected $table='';
    protected $dsn="mysql:host=localhost;charset=utf8;dbname=member";
    protected $pdo;

    //構成
    // $db=new DB ('users');
    public function __construct($table){
        // 把pdo帶進來
        $this->pdo=new PDO($this->dsn,'root','');
        $this->table=$table;
    }

    public function all(){
        $rows=$this->pdo->query("select * from $this->table")->fetchAll(PDO::FETCH_ASSOC);

        return $rows;
    }
}

$db=new DB ('member');
echo "<pre>";
print_r($db->all());
echo "</pre>";
?>
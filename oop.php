<?php
// 條件式
class Animal{
    public $name='';
    protected $age=0;
    private $heartbeat;

    // 建構式
    public function getName(){
       return $this->name;
    }
    public function getheartbeat(){
       return $this->heartbeat;
    }
    public function setName($name){
       $this->name=$name;
    }

}

$animal=new Animal;
$dog=new Animal;
// $this->age=rand(10,20);
// $this->name='yo';
// $this->heartbeat=rand(20,60);
// $animal=new Animal;

// echo $animal->name;

// 受保護内部使用
// echo $animal->age;

// 改變值，不好因為難找在那改變的
// $animal->name="qing"
// echo $animal->name;

echo $animal->getName();
$animal->setName('yo');
echo $animal->getName();
echo $animal->getHeartbeat();
echo "<hr>";
$dog->setName('qing');
echo $dog->getName();
?>
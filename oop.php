<?php

class Animal{
    public $name='';
    protected $age=0;
    private $heart_beat;

    // 建構式
    public function __construct(){
        $this->age=rand(10,20);
        $this->name='yo';
        $this->heartbeat=rand(20,60);
    }
}

$animal=new Animal;

echo $animal->name;

?>
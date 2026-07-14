<?php

namespace App\Models;

class ClassA   
{
    public static $count = 0;

    public function __construct(){
        self::$count++;
    }
}

class ClassB extends ClassA
{
    public $name;

    public function __construct($name)
    {
        parent::__construct();
        $this->name = $name;
    }
}

$class1 = new ClassB('1');
$class2 = new ClassB('2');
$class3 = new ClassB('3');

echo ClassA::$count;
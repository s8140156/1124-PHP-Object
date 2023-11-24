<?php

// 宣告class
class Animal{
	protected $name;
	// 宣告屬性 變數, 

	public function __construct($name){
		$this->name=$name;
	}

	public function setName($name){
		$this->name=$name;

	}
	public function getName(){
		return $this->name;
	}

}


// $animal=new Animal('阿明'); //實體(例)化 instant

// echo '顯示名稱:' .$animal->getName();
// echo "<br>";
// $animal->setName('小花');
// echo '顯示名稱:' .$animal->getName();
// echo "<br>";
// $animal->name="阿忠";

// 繼承
class Dog extends Animal{
	function sit(){
		echo $this->name;
		echo "坐下";
	}

}

$dog=new Dog('阿富');
echo $dog->getName();
echo $dog->sit();
echo "<br>";
// 這樣是一組
echo $dog->setName('豆腐');
echo $dog->getName();
echo $dog->sit();



?>
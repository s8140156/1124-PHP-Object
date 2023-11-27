<?php

// 宣告class
class Animal{
	protected $name;
	// 宣告protected屬性(封裝) 有一個變數$name

	public function __construct($name){
		$this->name=$name;
		// $this是指這一整個物件, 這個function就是把$name指定給name
	}

	public function setName($name){
		$this->name=$name;

	}
	public function getName(){
		return $this->name;
	}

}

$animal=new Animal; //實體(例)化 instant
// 建立一個名稱$animal, 為Animal類別的物件

echo '顯示名稱：' .$animal->name;
// 將物件的屬性name
echo '顯示名稱：' .$animal->setName('小花');
// 將物件的name屬性的值用setName方法 變更為"小花"

// $animal=new Animal('阿明'); //實體(例)化 instant
// 建立一個名稱$animal, 為Animal類別的物件

// echo '顯示名稱:' .$animal->getName();
// 將物件的getName
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
<?php

class Animal{
	// 宣告一個Animal class(類別)


}

interface bark{

	function b();
	// 這邊不需要大括號
}


class Dog extends Animal implements bark{
	function b(){
		return "汪";

	}

}


class Cat extends Animal{
	function b(){
		return "喵";

	}
}

$dog=new Dog;
$cat=new Cat;
// 會有紅線是因為有延伸模組intelephense偵測全部檔案是否有相同命名
// 雖有紅字但不影響程式 只是提醒還是可以執行

echo $dog->b();
echo "<br>";
echo $cat->b();



?>
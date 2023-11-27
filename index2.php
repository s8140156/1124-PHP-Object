<?php

class Animal{
    private $name;
     // 定義一個私有的屬性 $name

    public function setName($name){
        $this->name=$name;
        // 由於$name已被設定private, 所以即使public方法也無法直接使用
         // 公開的方法，用來"設定" $name 屬性的值
        // 透過 $this->name 存取物件的私有屬性
    }

    public function getName(){
        return $this->name;
           // 公開的方法，用來"取得" $name 屬性的值
        // 透過 $this->name 存取物件的私有屬性
    }
}

$animal=new Animal;
echo "顯示名稱:" .$animal->getName();
// 沒有給值不會顯示 但也只能透過getName方法來取得Name
$animal->setName('小花');
// 使用 setName 方法設定名字為 '小花'
echo "<br>";
echo "顯示名稱:" .$animal->getName();
// 顯示設定後的取得的名稱 '小花'

// setName 方法:
// 這個方法主要用於設定私有屬性 $name 的值，
// 它在內部直接修改物件的狀態。這種情況下，
// 並不需要明確地返回任何東西，因為該方法的目的是修改物件內部的狀態（修改名稱），
// 而不是返回結果。


// getName 方法:
// 這個方法主要用於取得私有屬性 $name 的值。
// 因為這個方法的目的是提供外部程式碼取得內部狀態，
// 所以需要使用 return 來將 $name 的值返回給呼叫方。

// setName 是一個用於修改內部狀態的方法，
// 而 getName 則是用於取得內部狀態的方法。
// 在物件導向程式設計中，這樣的設計通常被稱為封裝，
// 即將內部實現細節隱藏，只暴露必要的接口。


// 在提供的程式碼中，setName 和 getName 是自定義的方法（也可以稱為函式），而不是語言本身預先定義的函式。在物件導向程式設計中，類別（class）中的方法是開發者自行定義的，以實現特定的功能。

// 在這裡，setName 是一個方法，它接受一個參數（名稱），並將其設定為物件的私有屬性 $name。
// getName 也是一個方法，它不接受參數，而是返回物件的私有屬性 $name 的值。

// 這樣的設計允許將相關的操作和數據封裝在一個類別中，提高了程式碼的可讀性和可維護性。當你實例化一個物件後，你可以呼叫這些方法來操作該物件的狀態。
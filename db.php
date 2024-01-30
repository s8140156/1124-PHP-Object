<?php
date_default_timezone_set("Asia/Taipei");
session_start();

class DB
{

    protected $dsn = "mysql:host=localhost;charset=utf8;dbname=school";
    protected $pdo;
    protected $table;
    // 在宣告成員 不能有運算式or new甚麼...
    
    // construct()類別實例化時自動被呼叫
    public function __construct($table)
    {
        $this->table = $table;
        // $this:用db這個class產生的物件 ->:存取屬性或方法(統稱為成員)
        $this->pdo = new PDO($this->dsn, 'root', '');
    }



    function all($where = '', $other = '')
    {
        $sql = "select * from `$this->table` ";
        $sql=$this->sql_all($sql,$where,$other);
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        // FETCH_ASSOC: 只取key的資訊

    }

    function count($where = '', $other = '')
    {
        $sql = "select count(*) from `$this->table` ";
        $sql=$this->sql_all($sql,$where,$other);
        return $this->pdo->query($sql)->fetchColumn();
        //fetchColumn()取得指定欄位的資料
    }

    private function math($math,$col,$array='',$other = '')
    // 由於sum需要"欄位", 所以加入$col 參數(變數)
    {
        $sql = "select $math(`$col`) from `$this->table` ";
        $sql=$this->sql_all($sql,$array,$other);
        return $this->pdo->query($sql)->fetchColumn();
    }
    function sum($col='',$where='',$other = '')
    {
        // $sql = "select sum(`$col`) from `$this->table` ";
        // $sql=$this->sql_all($sql,$where,$other);
        // return $this->pdo->query($sql)->fetchColumn();
        return $this->math('sum',$col,$where,$other);
    }
    function max($col='',$where='',$other = '')
    {
        return $this->math('max',$col,$where,$other);
    }
    function min($col='',$where='',$other = '')
    {
        return $this->math('min',$col,$where,$other);
    }

    function total($id)
    {
        // global $pdo;
        $sql = "select count(`id`) from `$this->table` ";

        if (is_array($id)) {
            foreach ($id as $col => $value) {
                $tmp[] = "`$col`='$value'";
            }
            $sql .= " where " . join(" && ", $tmp);
        } else if (is_numeric($id)) {
            $sql .= " where `id`='$id'";
        } else {
            echo "錯誤:參數的資料型態比須是數字或陣列";
        }
        //echo 'find=>'.$sql;
        $row = $this->pdo->query($sql)->fetchColumn();
        return $row;
    }

    function find($id)
    {
        // global $pdo;
        $sql = "select * from `$this->table` ";

        if (is_array($id)) {
            $tmp = $this->a2s($id);
            $sql .= " where " . join(" && ", $tmp);
        } else if (is_numeric($id)) {
            $sql .= " where `id`='$id'";
        } else {
            echo "錯誤:參數的資料型態比須是數字或陣列";
        }
        //echo 'find=>'.$sql;
        $row = $this->pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
        return $row;
    }

    // 將insert與update function合併簡化
    // 並將原先函式設定protected是讓外部不能存取 只能用save funtion丟陣列進來判斷
    function save($array)
    {
        if (isset($array['id'])) {
            $sql = "update `$this->table` set ";

            if (!empty($array)) {
                $tmp = $this->a2s($array);
            } else {
                echo "錯誤:缺少要編輯的欄位陣列";
            }
            $sql .= join(",", $tmp);
            $sql .= " where `id`='{$array['id']}'";
        } else {
            $sql = "insert into `$this->table` ";
            $cols = "(`" . join("`,`", array_keys($array)) . "`)"; // array_keys()無視value 取key值(col)
            $vals = "('" . join("','", $array) . "')"; // .join() 這個函數會取$array中key、value的value出來組合成字串, join無視key 取value(val)
           
            $sql = $sql . $cols . " values " . $vals;
            //透過這樣組合來完成sql insert語法 insert into $table(`col1`,`col2`...) values(`val1`,`val2`...)
        }
        return $this->pdo->exec($sql);
    }

    function del($id)
    {
        // global $pdo;
        $sql = "delete from `$this->table` where ";
        // 只有del()把where寫在sql語法上

        if (is_array($id)) {
            $tmp = $this->a2s($id);
            $sql .= join(" && ", $tmp);
        } else if (is_numeric($id)) {
            $sql .= " `id`='$id'";
        } else {
            echo "錯誤:參數的資料型態比須是數字或陣列";
        }
        //echo $sql;

        return $this->pdo->exec($sql);
    }

    function q($sql)
    // 當使用完整sql語法時使用q()
    {
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        // 僅限查詢相關語法(update/del/insert不適用)
    }

    private function a2s($array)
    {
        // 雖然拉出的程式不是甚麼機密的問題 但是是外部非必須使用的 所以將權限設為private
        // array to sql(命名)
        foreach ($array as $col => $value) {
            $tmp[] = "`$col`='$value'";
            // 把它存成與sql指令一樣的格式( SQL 語句中的 SET 子句，以便在更新(update)資料庫中的記錄時使用)
        }
        return $tmp;
        // 注意 最後是存成一個$tmp來存取提出的陣列,所以return $tmp
    }
    private function sql_all($sql,$array,$other){
        if (isset($this->table) && !empty($this->table)) {

            if (is_array($array)) {

                if (!empty($array)) {
                    $tmp = $this->a2s($array);
                    $sql .= " where " . join(" && ", $tmp);
                    // $sql = $sql." where " . join(" && ", $tmp);
                    // x=x+5, 也等於x+=5
                }
            } else {
                $sql .= " $array";
            }

            $sql .= $other;
            //echo 'all=>'.$sql;
            // $rows = $this->pdo->query($sql)->fetchColumn();
            // 改用return回傳
            // 只是回傳筆數 所以不須所有資料紀錄
            return $sql;
        } else {
            echo "錯誤:沒有指定的資料表名稱";
        }
    }
}

function dd($array)
{
    echo "<pre>";
    print_r($array);
    echo "</pre>";
}

// $student=new DB('students');
// $rows=$student->all();
// dd($rows);

// $student=new DB('students');
// $rows=$student->total('3');
// dd($rows);

// $student = new DB('dept');
// $rows = $student->find('3');
// dd($rows);

echo"<hr>";


$student=new DB('students');
$rows=$student->count();
dd($rows);
echo "<hr>";
$Score=new DB('student_scores');
$sum=$Score->sum('score');
dd($sum);
echo "<hr>";
$sum=$Score->sum('score'," where `school_num` <= '911020'");
dd($sum);
echo "<hr>";
$sum=$Score->max('score');
dd($sum);

?>
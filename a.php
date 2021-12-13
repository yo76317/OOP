<?php
//條件
class DB{
    protected $table;
    protected $dsn="mysql:host=localhost;charset=utf8;dbname=member";
    protected $pdo;
    //構成
    public function __construct($table){
    // 把pdo帶進來
    $this->pdo=new PDO($this->dsn,'root','');
    $this->table=$table;
    }

    // 取全部,使用all
    public function all(...$arg){
        $sql="SELECT * FROM $this->table ";
        // 依參數數量來決定進行的動作因此使用switch...case
        switch(count($arg)){
            case 1:
                // 判斷參數是否為陣列
                if(is_array($arg[0])){
                    // 使用迴圈來建立條件語句的字串型式，並暫存在陣列中
                    foreach($arg[0] as $key => $value){
                        $tmp[]="`$key`='$value'";
                    }
                    // 使用implode()來轉換陣列為字串並和原本的$sql字串再結合
                    $sql.=" WHERE ". implode(" AND " ,$tmp);
                }else{
                    // 如果參數不是陣列，那應該是SQL語句字串，因此直接接在原本的$sql字串之後即可
                    $sql.=$arg[0];
                }
            break;
            case 2:
                // 第一個參數必須為陣列，使用迴圈來建立條件語句的陣列
                foreach($arg[0] as $key => $value){
                    $tmp[]="`$key`='$value'";
                }
                //將條件語句的陣列使用implode()來轉成字串，最後再接上第二個參數(必須為字串)
                $sql.=" WHERE ". implode(" AND " ,$tmp) . $arg[1];
            break;
            // 執行連線資料庫查詢並回傳sql語句執行的結果
            }
            // fetchAll()加上常數參數FETCH_ASSOC是為了讓取回的資料陣列中
            // 只有欄位名稱,而沒有數字的索引值
            // echo $sql;
            return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }


    // 只取一筆,使用find
    public function find($id){
        $sql="SELECT * FROM $this->table WHERE ";
        if(is_array($id)){
            foreach($id as $key => $value){
                $tmp[]="`$key`='$value'";
            }
            $sql .= implode(' AND ',$tmp);
        }else{
            $sql .= " id='$id'";
        }
        // echo $sql;
        return $this->pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
    }


    // 計算某個欄位或是計算符合條件的筆數
     // max,min,sum,count,avg
     public function math($math,$col,...$arg){
        $sql="SELECT $math($col) FROM $this->table ";

        //依參數數量來決定進行的動作因此使用switch...case
        switch(count($arg)){
            case 1:
                if(is_array($arg[0])){
                    foreach($arg[0] as $key => $value){
                        $tmp[]="`$key`='$value'";
                    }
                    $sql.=" WHERE ". implode(" AND " ,$tmp);
                }else{
                    $sql.=$arg[0];
                }
            break;
            case 2:
                foreach($arg[0] as $key => $value){
                    $tmp[]="`$key`='$value'";
                }
                $sql.=" WHERE ". implode(" AND " ,$tmp) . $arg[1];
            break;
            }
            echo $sql;
            return $this->pdo->query($sql)->fetchColumn();
    }

    public function sum($col,...$arg){
        $sql="SELECT sum({$col}) FROM $this->table ";
        //依參數數量來決定進行的動作因此使用switch...case
        switch(count($arg)){
            case 1:
                if(is_array($arg[0])){
                    foreach($arg[0] as $key => $value){
                        $tmp[]="`$key`='$value'";
                    }
                    $sql.=" WHERE ". implode(" AND " ,$tmp);
                }else{
                    $sql.=$arg[0];
                }
            break;
            case 2:
                foreach($arg[0] as $key => $value){
                    $tmp[]="`$key`='$value'";
                }
                $sql.=" WHERE ". implode(" AND " ,$tmp) . $arg[1];
            break;
            }
            echo $sql;
            return $this->pdo->query($sql)->fetchColumn(0);
    }
    public function min($col,...$arg){
        $sql="SELECT min({$col}) FROM $this->table ";
        //依參數數量來決定進行的動作因此使用switch...case
        switch(count($arg)){
            case 1:
                if(is_array($arg[0])){
                    foreach($arg[0] as $key => $value){
                        $tmp[]="`$key`='$value'";
                    }
                    $sql.=" WHERE ". implode(" AND " ,$tmp);
                }else{
                    $sql.=$arg[0];
                }
            break;
            case 2:
                foreach($arg[0] as $key => $value){
                    $tmp[]="`$key`='$value'";
                }
                $sql.=" WHERE ". implode(" AND " ,$tmp) . $arg[1];
            break;
            }
            echo $sql;
            return $this->pdo->query($sql)->fetchColumn(0);
    }
 

    // 更新資料,一次限一筆資料
     // 陣列裡面有沒有ID來處理
    public function save($array){
        if(isset($array['id'])){
            //update
            foreach($array as $key => $value){
                //sprint_f("`%s`='%s'",$key,$value)
                // if($key!='id'){   
                // ↑這一句是用來不讓前面搜id時被更新一次
                    $tmp[]="`$key`='$value'";
                // }
            }
            $sql="UPDATE $this->table SET ".implode(" , ",$tmp);
            $sql .= " WHERE `id`='{$array['id']}'";
            //UPDATE $this->table SET col1=value1,col2=value2.....where id=? && col1=value1
        }else{
            //insert
            //['col1'=>'value1','col3'=>'value3','col2'=>'value2',];

            /* $keys=array_keys($array);
            
            $cols=implode("`,`",array_keys($array));
            $values=implode("','",$array); */

            $sql="INSERT INTO $this->table (`".implode("`,`",array_keys($array))."`) 
                                     VALUES('".implode("','",$array)."')";

            //INSERT INTO $this->table(`col1`,`col2,`col3`.....) VALUES('value1','value2','value3'.....)
        }
        echo $sql;
        // return 新增才會一直新增不只會一筆而已
        return $this->pdo->exec($sql);
    }
 

    // 刪除資料
    public function del($id){
        $sql="DELETE FROM $this->table WHERE ";
        if(is_array($id)){
            foreach($id as $key => $value){
                // 加一個判斷式 if($key!="id") 讓id不被更新
                $tmp[]="`$key`='$value'";
            }
            $sql .= implode(' AND ',$tmp);
        }else{
            $sql .= " id='$id'";
        }
        // 刪除不用回傳資料回來，所以用EXEC，但會回傳筆數
        // return $this->pdo->exec($sql); 
        //echo $sql;
        return $this->pdo->exec($sql);
    }
 

    // 萬用的查詢
    public function q($sql){
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

} // db end


// 表單
$member=new DB('member');

echo "<h4>只取一筆find</h4>";
echo "<pre>";
print_r ($member->find(['address'=>'高雄']));
echo "</pre>"; 

echo "<h4>取全部all</h4>";
echo "<pre>";
print_r ($member->all(['address'=>'台北']));
echo "</pre>"; 

echo "<h4>台北的加起來</h4>";
echo "<pre>";
print_r ($member->math('sum','mobile',['address'=>'台北']));
echo "</pre>"; 

echo "<h4>台北的最小值</h4>";
echo "<pre>";
print_r ($member->math('min','mobile',['address'=>'台北']));
echo "</pre>"; 

echo "<h4>台北的筆數</h4>";
echo "<pre>";
print_r ($member->math('count','*',['address'=>'台北']));
echo "</pre>"; 

echo "<h4>刪除單筆資料</h4>";
echo "<p>刪除後回傳刪除筆數、出現0可能是已刪除指定欄位或是資料表打錯</p>";
echo "<pre>";
print_r($member->del(10));
echo "</pre>"; 

echo "<h4>查詢指定條件</h4>";
echo "<p>台北 和 mobile>30↑</p>";
echo "<pre>";
print_r ($member->q("select * from `member` where `address`='台北' && `mobile` > 30"));
echo "</pre>"; 

echo "<h4>更新或新增資料,一次限一筆資料</h4>";
echo "<p>更新後回傳更新筆數、出現0可能是數據一樣</p>";
echo "<pre>";
print_r($member->save(['id'=>12,'name'=>'陳佑青','address'=>'台北','mobile'=>'100']));
print_r($member->save(['name'=>'陳佑青07',
                        'address'=>'台北',
                        'mobile'=>'70',]));
echo "</pre>"; 


/* $db=new DB('journal');
echo "<pre>";
print_r($db->all(['item'=>'早餐']," ORDER by `money` desc"));
echo "</pre>";
echo "<pre>";
print_r($db->all());
echo "</pre>"; */
?>
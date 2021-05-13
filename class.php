<?php

class Db
{
    private $sql;

    public static function Select($sql, $data_content = array())
    {
        //データベースからidの羅列を取得
        $dsn = 'mysql:dbname=todo;host=localhost;charset=utf8';
        $user = 'root';
        $password = '';
        $dbh = new PDO($dsn, $user, $password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $dbh->prepare($sql);
        if(strpos($sql, "?") == true){
            for($i = 0; $i < substr_count($sql, "?"); $i++){
                $data[$i] = $data_content[$i];
            }
            $stmt->execute($data);
            $rec = $stmt->fetch(PDO::FETCH_ASSOC);
        }else{
            $stmt->execute();
            $rec = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        $dbh=null;
        return $rec;
    }
}

class Feature
{
    public static function Paging($id_list,$get_page)
    {
        $max=5;
        $id_sum=count($id_list);
        $max_page=ceil($id_sum/$max);
        if(isset($get_page)==false){
            $page=1;
        }else{
            $page=$get_page;
        }

        $start=$max*($page - 1);
        $view_page=array_splice($id_list,$start,$max,true);
        return [$view_page, $page, $max_page];
    }

    public static function PageBefore($page)
    {
        if($page > 1){
            echo '<a href="todo_list.php?page='.($page - 1).'" style="color: #114747;font-weight:bold;">＜＜前の５件</a>';
        }else{
            echo '<div style="width: 100px;">&nbsp;</div>';
        }
    }

    public static function PageAfter($page, $max_page)
    {
        if($page < $max_page){
            echo '<a href="todo_list.php?page='.($page + 1).'" style="color: #114747;font-weight:bold;">次の５件＞＞</a>';
        }else{
            echo '<div style="width: 100px;">&nbsp;</div>';
        }
    }
}
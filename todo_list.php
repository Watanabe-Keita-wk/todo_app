<!doctype html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
    <title>Index Page</title>
</head>
<body>
<h1 class="midashi">
    ToDo List Page
</h1>

<?php
try{
    //データベースからidの羅列を取得
    $dsn='mysql:dbname=todo;host=localhost;charset=utf8';
    $user='root';
    $password='';
    $dbh=new PDO($dsn,$user,$password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

    $sql='SELECT id FROM posts WHERE 1';
    $stmt=$dbh->prepare($sql);
    $stmt->execute();
    $rec=$stmt->fetchAll();

    //idを配列につっこむ
    $id_list=array();

    foreach($rec as $value){
        $id_list[]=$value['id'];
    }

    //ページング機能を追加
    $max=5;
    $id_sum=count($id_list);
    $max_page=ceil($id_sum/$max);
    if(isset($_GET['page'])==false){
        $page=1;
    }else{
        $page=$_GET['page'];
    }

    $start=$max*($page - 1);
    $view_page=array_splice($id_list,$start,$max,true);

    //ページに表示する情報を取得
    foreach($view_page as $val){
        $sql='SELECT id,title,content,created_at,updated_at FROM posts WHERE id=?';
        $stmt=$dbh->prepare($sql);
        $data[0]=$val;
        $stmt->execute($data);

        $posts=$stmt->fetch(PDO::FETCH_ASSOC);

        $post_title[]=$posts['title'];
        $post_content[]=$posts['content'];
        $post_created_at[]=$posts['created_at'];
        $post_updated_at[]=$posts['updated_at'];
    }

    $dbh=null;
}catch(Exception $e){
    print 'ただいま障害により大変ご迷惑をお掛けしております。';
    exit();
}


?>


<table>
<colgroup span="4"></colgroup>
<tr>
    <th class="id">ID</th>
    <th>タイトル</th>
    <th>内容</th>
    <th>作成日時</th>
    <th class="update">編集日時</th>
    <th>編集</th>
    <th>削除</th>
</tr>
<?php
//ループ処理でページに情報をテーブル表示
$disp_num=count($view_page);
for($i=0;$i<$disp_num;$i++){
?>
    <form method="post" action="branch.php">
    <input type="hidden" name="id" value="<?php print $view_page[$i]; ?>">
    <tr>
        <td><?php print $view_page[$i]; ?></td>
        <td><?php print $post_title[$i]; ?></td>
        <td><?php print $post_content[$i]; ?></td>
        <td><?php print $post_created_at[$i]; ?></td>
        <td><?php print $post_updated_at[$i]; ?></td>
        <!--編集・削除は両方一旦branch.phpに飛ばしてそこからリダイレクトする-->
        <td>
            <input class="choice" type="submit" name="edit" value="編集する">
        </td>
        <td>
            <input class="choice" type="submit" name="delete" value="削除する">
        </td>
    </tr>
    </form>
<?php
}
?>
</table>
<div class="box_button">
    <div>
        <?php
        //ページ移動する部分を追加
        if($page > 1){
        ?>
            <a href="todo_list.php?page=<?php print ($page-1); ?>" style="color: #114747;font-weight:bold;">＜＜前の５件</a>
        <?php
        }else{
        ?>
            <div style="width: 100px;">&nbsp;</div>
        <?php
        }
        ?>
    </div>

    <div>
        <form action="create.php">
        <button class="button" type="submit" style="padding: 10px;font-size: 16px;margin-bottom: 10px">New Todo</button>
        </form>
    </div>

    <div>
        <?php
        if($page < $max_page){
        ?>
            <a href="todo_list.php?page=<?php print ($page+1); ?>" style="color: #114747;font-weight:bold;">次の５件＞＞</a>
        <?php
        }else{
        ?>
            <div style="width: 100px;">&nbsp;</div>
        <?php
        }
        ?>
    </div>
</div>
</body>
</html>

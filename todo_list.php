<?php
    require_once("class.php")
?>
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

try
{
    //データベースからidの羅列を取得
    $sql = 'SELECT id FROM posts WHERE 1';
    $rec = Db::Select($sql);
    //idを配列につっこむ
    $id_list=array();

    foreach($rec as $value){
        $id_list[] = $value['id'];
    }

    //ページング機能を追加
    list($view_page, $page, $max_page) = Feature::Paging($id_list, $_GET['page']);

    //ページに表示する情報を取得
    foreach($view_page as $val){
        $sql='SELECT id,title,content,created_at,updated_at FROM posts WHERE id=?';
        $data[0]=$val;
        $posts=Db::Select($sql, $data);

        $post_title[]=$posts['title'];
        $post_content[]=$posts['content'];
        $post_created_at[]=$posts['created_at'];
        $post_updated_at[]=$posts['updated_at'];
    }

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
            Feature::PageBefore($page);
        ?>
    </div>

    <div>
        <form action="create.php">
        <button class="button" type="submit" style="padding: 10px;font-size: 16px;margin-bottom: 10px">New Todo</button>
        </form>
    </div>

    <div>
        <?php
            Feature::PageAfter($page, $max_page);
        ?>
    </div>
</div>
</body>
</html>

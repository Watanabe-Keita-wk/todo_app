<!doctype html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php
//フォームの二重送信をセッションを確認して防ぐ。
session_start();
if(!empty($_SESSION['page']) && $_SESSION['page']==true){
    unset($_SESSION['page']);
    try{
        require_once('common.php');

        $post=sanitize($_POST);
        $title=$post['title'];
        $content=$post['content'];
        $created_at=$post['created_at'];

        //データベース更新
        $dsn='mysql:dbname=todo;host=localhost;charset=utf8';
        $user='root';
        $password='';
        $dbh=new PDO($dsn,$user,$password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

        $sql='INSERT INTO posts (title,content,created_at) VALUES (?,?,?)';
        $stmt=$dbh->prepare($sql);
        $data[]=$title;
        $data[]=$content;
        $data[]=$created_at;
        $stmt->execute($data);

        $dbh=null;
    }catch(Exception $e){
        print 'ただいま障害により大変ご迷惑をお掛けしております。';
        exit();
    }
}else{
    print '<h2 class="texts" style="color: #e26a6a;">エラーが発生しました。</h2>';
    print '<form action="todo_list.php" style="text-align: center;margin-top: 30px;">';
    print '<button class="button" type="submit" style="padding: 10px;font-size: 16px;">一覧へ戻る</button>';
    print '</form>';
    exit();
}

?>

    <h2 class="texts">以下の内容で登録完了しました。</h2>

    <table>
        <colgroup span="4"></colgroup>
        <tr>
            <th>タイトル</th>
            <th>内容</th>
            <th>作成日時</th>
        </tr>
        <tr>
            <td><?php print $title ?></td>
            <td><?php print $content ?></td>
            <td><?php print $created_at ?></td>
        </tr>
    </table>

    <form action="todo_list.php" style="text-align: center;margin-top: 30px;">
        <button class="button" type="submit" style="padding: 10px;font-size: 16px;">一覧へ戻る</button>
    </form>

</body>
</html>
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
        $id=$post['id'];
        $title=$post['title'];
        $content=$post['content'];
        $updated_at=$post['updated_at'];

        $dsn='mysql:dbname=todo;host=localhost;charset=utf8';
        $user='root';
        $password='';
        $dbh=new PDO($dsn,$user,$password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

        $sql='UPDATE posts SET title=?,content=?,updated_at=? WHERE id=?';
        $stmt=$dbh->prepare($sql);
        $data[]=$title;
        $data[]=$content;
        $data[]=$updated_at;
        $data[]=$id;
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

<?php
display_table($title,$content,null,$updated_at);
?>

    <form action="todo_list.php" style="text-align: center;margin-top: 30px;">
        <button class="button" type="submit" style="padding: 10px;font-size: 16px;">一覧へ戻る</button>
    </form>

</body>
</html>
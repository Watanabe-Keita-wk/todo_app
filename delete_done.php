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
//存在しないデータの削除をセッションを確認して防ぐ。
session_start();
if(!empty($_SESSION['page']) && $_SESSION['page']==true){
    unset($_SESSION['page']);
    try{
        $id=$_POST['id'];

        $dsn='mysql:dbname=todo;host=localhost;charset=utf8';
        $user='root';
        $password='';
        $dbh=new PDO($dsn,$user,$password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

        $sql='DELETE FROM posts WHERE id=?';
        $stmt=$dbh->prepare($sql);
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

    <h2 class="texts" style="margin-top: 50px;">削除完了しました。</h2>
    <form action="todo_list.php" style="text-align: center;">
        <button class="button" type="submit" style="padding: 10px;font-size: 16px;">一覧へ戻る</button>
    </form>


</body>
</html>
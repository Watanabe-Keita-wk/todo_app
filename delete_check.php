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
    session_start();
    $_SESSION['page']=true;
    require_once('common.php');

try{
    $id=$_GET['id'];

    $dsn='mysql:dbname=todo;host=localhost;charset=utf8';
    $user='root';
    $password='';
    $dbh=new PDO($dsn,$user,$password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

    $sql='SELECT title,content,created_at FROM posts WHERE id=?';
    $stmt=$dbh->prepare($sql);
    $data[]=$id;
    $stmt->execute($data);

    $rec=$stmt->fetch(PDO::FETCH_ASSOC);
    $title=$rec['title'];
    $content=$rec['content'];
    $created_at=$rec['created_at'];

    $dbh=null;
}catch(Exception $e){
    print 'ただいま障害により大変ご迷惑をお掛けしております。';
    exit();
}
?>

<h2 class="texts">以下の内容を削除します。</h2>

<?php
display_table($title,$content,$created_at,null);
?>

<div class="box_button">
    <form method="post" action="delete_done.php">
    <input type="hidden" name="id" value="<?php print $id; ?>">
    <input class="button" type="submit" value="OK" style="font-size: 17px;padding: 9px 20px;margin-right: 20px;">
    <input class="button" type="button" onclick="history.back()" value="戻る" style="font-size: 15px;padding: 10px 20px;">
    </form>
</div>


</body>
</html>
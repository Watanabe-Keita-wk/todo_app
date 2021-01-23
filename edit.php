<!doctype html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
    <title>Edit Page</title>
</head>
<body>
<?php
try{
    $id=$_GET['id'];

    $dsn='mysql:dbname=todo;host=localhost;charset=utf8';
    $user='root';
    $password='';
    $dbh=new PDO($dsn,$user,$password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

    $sql='SELECT title,content FROM posts WHERE id=?';
    $stmt=$dbh->prepare($sql);
    $data[]=$id;
    $stmt->execute($data);

    $rec=$stmt->fetch(PDO::FETCH_ASSOC);
    $old_title=$rec['title'];
    $old_content=$rec['content'];

    $dbh=null;
}catch(Exception $e){
    print 'ただいま障害により大変ご迷惑をお掛けしております。';
    exit();
}
?>
<h1 class="midashi">
Edit Todo Page
</h1>
<div style="margin: 10px;text-align: center;">
    <form method="post" action="edit_check.php">
        <div style="text-align: left;display: inline-block;">
            <div style="margin: 10px">
                <label for="title">タイトル：</label>
                <input id="title" name="title" type="text" value="<?php print $old_title; ?>">
            </div>
            <div style="margin: 10px">
                <label for="content"><span class="content">内容：</span></label>
                <textarea name="content" rows="8" cols="40"><?php print $old_content; ?></textarea>
            </div>
        </div>
        <br />
        <input type="hidden" name="id" value="<?php print $id; ?>">
        <input class="button" type="submit" value="編集する" style="font-size: 15px;padding: 5px 10px;margin-right: 20px;">
        <input class="button" type="button" onclick="history.back()" value="戻る" style="font-size: 15px;padding: 5px 10px;">
    </form>
</div>
</body>
</html>
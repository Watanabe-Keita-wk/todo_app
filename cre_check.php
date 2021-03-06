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
date_default_timezone_set('Asia/Tokyo');
require_once('common.php');

//xss対策のサニタイジング
$post=sanitize($_POST);

$title=$post['title'];
$content=$post['content'];
$created_at=date("Y-m-d H:i:s");

post_check($title,$content);

if($title=='' || mb_strlen($title,'UTF-8') > 30 || $content==''){
    print '<form style="text-align: center;">';
	print '<input class="button" type="button" onclick="history.back()" value="戻る" style="font-size: 15px;padding: 8px 15px;">';
	print '</form>';
}else{
    //セッションを使って次ページでデータベース更新を許可
    session_start();
    $_SESSION['page']=true;
?>
    <h2 class="texts">以下の内容を登録します。</h2>
<?php
display_table($title,$content,$created_at,null);
?>

    <div class="box_button">
        <form method="post" action="cre_done.php">
        <input type="hidden" name="title" value="<?php print $title; ?>">
        <input type="hidden" name="content" value="<?php print $content; ?>">
        <input type="hidden" name="created_at" value="<?php print $created_at; ?>">
        <input class="button" type="submit" value="OK" style="font-size: 17px;padding: 9px 20px;margin-right: 20px;">
        <input class="button" type="button" onclick="history.back()" value="戻る" style="font-size: 15px;padding: 10px 20px;">
        </form>
    </div>
<?php
}
?>


</body>
</html>
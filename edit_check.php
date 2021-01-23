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

$post=sanitize($_POST);
$id=$post['id'];
$title=$post['title'];
$content=$post['content'];
$updated_at=date("Y-m-d H:i:s");

if($title==''){
    print '<h3 style="color: #e26a6a;text-align: center;">タイトルを入力してください。</h3>';
}elseif(mb_strlen($title,'UTF-8') > 30){
    print '<h3 style="color: #e26a6a;text-align: center;">タイトルは30文字以内におさめてください</h3>';
}

if($content==''){
    print '<h3 style="color: #e26a6a;text-align: center;">内容を入力してください。</h3>';
}

if($title=='' || mb_strlen($title,'UTF-8') > 30 || $content==''){
    print '<form style="text-align: center;">';
	print '<input class="button" type="button" onclick="history.back()" value="戻る" style="font-size: 15px;padding: 10px 20px;">';
	print '</form>';
}else{
    session_start();
    $_SESSION['page']=true;
?>
    <h2 class="texts">以下の内容で登録します。</h2>

    <table>
        <colgroup span="4"></colgroup>
        <tr>
            <th>タイトル</th>
            <th>内容</th>
            <th>最終編集日時</th>
        </tr>
        <tr>
            <td><?php print $title ?></td>
            <td><?php print $content ?></td>
            <td><?php print $updated_at ?></td>
        </tr>
    </table>

    <div class="box_button">
        <form method="post" action="edit_done.php">
        <input type="hidden" name="id" value="<?php print $id; ?>">
        <input type="hidden" name="title" value="<?php print $title; ?>">
        <input type="hidden" name="content" value="<?php print $content; ?>">
        <input type="hidden" name="updated_at" value="<?php print $updated_at; ?>">
        <input class="button" type="submit" value="OK" style="font-size: 17px;padding: 9px 20px;margin-right: 20px;">
        <input class="button" type="button" onclick="history.back()" value="戻る" style="font-size: 15px;padding: 10px 20px;">
        </form>
    </div>
<?php
}
?>


</body>
</html>
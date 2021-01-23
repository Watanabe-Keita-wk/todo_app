<!doctype html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
    <title>Create Page</title>
</head>
<body>
<h1 class="midashi">
    Post New ToDo Page
</h1>
<div style="margin: 10px;text-align: center;">
    <form method="post" action="cre_check.php">
        <div style="text-align: left;display: inline-block;">
            <div style="margin: 10px">
                <label for="title">タイトル：</label>
                <input id="title" name="title" type="text">
            </div>
            <div style="margin: 10px">
                <label for="content"><span class="content">内容：</span></label>
                <textarea name="content" rows="8" cols="40"></textarea>
            </div>
        </div>
        <br />
        <input class="button" type="submit" value="投稿する" style="font-size: 15px;padding: 5px 10px;margin-right: 20px;">
        <input class="button" type="button" onclick="history.back()" value="戻る" style="font-size: 15px;padding: 5px 10px;">
    </form>
</div>

</body>
</html>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>index</title>
</head>
<body>

<p><a href="first-password-input.php">アプリを初めて利用する場合はこちら</a></p>
<?php

if(isset($_SESSION['store'])){
    unset($_SESSION['store']);
}

?>
<form action="login-output.php" method="post">
店舗名<input type="text" name="store"><br>
パスワード<input type="password" name="password"><br>
<input type="submit" value="ログイン">
</form>

</body>
</html>
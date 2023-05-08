<?php require 'header.php'; ?>

<p>アプリを初めて利用する場合は、はじめに店舗と全店舗共通パスワードを設定してください</p>
<form action="first-password-output.php" method="post">
<div class="td"><input type="text" name="firstStoreName" placeholder="店舗"></div>
<div class="td"><input type="text" name="firstStorePassword" placeholder="パスワードを設定"></div>
<div class="td"><input type="submit" value="送信"></div>
</form>
<p><a href="login.php">ログイン画面へ戻る</a></p>
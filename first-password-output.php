<?php require 'header.php'; ?>

<?php
$pdo=new PDO('mysql:host=localhost;dbname=データベース名;charset=utf8','ユーザー名', 'パスワード');
$sql=$pdo->prepare('select * from store');
$sql->execute();
//既存の店舗があるか判断
$store = [];
foreach ($sql as $row){
    $store[]=$row['store_id'];  
}
if(empty($store)){
    $sql=$pdo->prepare('insert into store values(null,?,?)');
	$sql->execute(
		[htmlspecialchars($_REQUEST['firstStoreName']), password_hash($_REQUEST['firstStorePassword'], PASSWORD_DEFAULT)]
    );
    echo '初回の店舗登録が完了しました。';
    echo 'ログイン画面でログインをしてください';
}
else{
    echo '既存の店舗がある為、初回店舗追加は行われませんでした。';
}
?>
<p><a href="login.php">ログイン画面へ戻る</a></p>
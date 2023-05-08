<?php require 'header.php'; ?>
<?php require 'menu.php'; ?>

<?php
$pdo=new PDO('mysql:host=localhost;dbname=データベース名;charset=utf8','ユーザー名', 'パスワード');
$sql->execute();
//パスワードの取得
foreach ($sql as $row){
    $password=$row['store_password'];  
}
if(password_verify($_REQUEST['oldPass'],$password)){
    $sql=$pdo->prepare(
        'update store set store_password=:newPassword');
    $sql->bindValue(':newPassword',password_hash($_REQUEST['newPass'], PASSWORD_DEFAULT));
    $sql->execute();
    echo '全店舗共通パスワードを変更しました';
}
else{
    echo 'パスワードが違うため変更できませんでした';
}
?>

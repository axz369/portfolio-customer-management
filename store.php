<?php require 'header.php'; ?>
<?php require 'menu.php'; ?>
<p>店舗情報の編集削除</p>
<br>

<!--データの新規投稿フォーム-->
<form action="store.php" method="post">
<input type="hidden" name="command" value="insert">
<div class="td">新規</div>
<div class="td"><input type="text" name="name" placeholder="店舗名"></div>
<div class="td"><input type="submit" value="店舗追加"></div>
</form>

<?php
$pdo=new PDO('mysql:host=localhost;dbname=データベース名;charset=utf8','ユーザー名', 'パスワード');
$sql=$pdo->prepare('select * from store');
$sql->execute();

//パスワードの取得
foreach ($sql as $row){
    $password=$row['store_password'];  
}


//データの新規投稿、編集、削除処理
$pdo=new PDO('mysql:host=localhost;dbname=データベース名;charset=utf8','ユーザー名', 'パスワード');
if (isset($_REQUEST['command'])) {
	switch ($_REQUEST['command']) {
	case 'insert':
		$sql=$pdo->prepare('insert into store values(null,?,?)');
		$sql->execute(
			[htmlspecialchars($_REQUEST['name']), $password]);
		break;
	case 'update':
		$sql=$pdo->prepare(
			'update store set store_name=:store_name where store_id=:store_id');
		$sql->bindValue(':store_name',$_REQUEST['store_name']);
		$sql->bindValue(':store_id',$_REQUEST['update-id']);
		$sql->execute();
		break;
	case 'delete':
		$sql=$pdo->prepare('delete from store where store_id=?');
		$sql->execute([$_REQUEST['delete-id']]);
		break;
	}
    
    
	header("Location: store.php");
	exit();
}

$sql=$pdo->prepare('select * from store order by store_id desc');
$sql->execute();
//データの表示
foreach ($sql as $row) {
	echo '<div class="store-data">';
    echo '<form class="store-update-form" action="store.php" method="post">';
    echo '<div class="td">';
    echo '<input type="hidden" name="command" value="update">';
    echo '</div>';
    echo '<div class="td">';
	echo '<input type="hidden" name="update-id" value="', $row['store_id'], '">';
    echo '</div>';
    echo '<div class="td">';
    echo $row['store_id'];
    echo '</div>';
    echo '<div class="td">';
    echo '<input type="text" name="store_name" value="', $row['store_name'], '">';
    echo '</div>';
    echo '<div class="td">';
    echo '<input type="submit" value="更新">';
    echo '</div>';
	echo '</form>';
    echo '<form class="store-delete-form" action="store.php" method="post">';
    echo '<div class="td">';
	echo '<input type="hidden" name="command" value="delete">';
	echo '</div>';
    echo '<div class="td">';
    echo '<input type="hidden" name="delete-id" value="', $row['store_id'], '">';
	echo '</div>';
    echo '<div class="td">';
    echo '<input class="store-delete-button" type="submit" value="削除">';
    echo '</div>';
	echo '</form><br>';
	echo '</div>';
	echo "\n";
}

echo '<div class="new-store-from">';
echo '<form action="store-password-output.php" method="post">';
echo '全店舗共通パスワードを変更する';
echo '<br>';
echo '<div class="td">';
echo '<input type="text" name="oldPass" placeholder="現在のパスワード">';
echo '</div>';
echo '<div class="td">';
echo '<input type="text" name="newPass" placeholder="新しいパスワード">';
echo '</div>';
echo '<div class="td">';
echo '<input type="submit" value="変更">';
echo '</div>';
echo '</form><br>';
echo '</div>';
?>
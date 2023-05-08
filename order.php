<?php require 'header.php'; ?>
<?php require 'menu.php'; ?>
<?php
$pdo=new PDO('mysql:host=localhost;dbname=データベース名;charset=utf8','ユーザー名', 'パスワード');
$storeCount=0;
//データ投稿更新削除
if (isset($_REQUEST['command'])) {
	switch ($_REQUEST['command']) {
	case 'insert':
		$custoer_id=$_REQUEST['customer_id'];
		$sql=$pdo->prepare('INSERT INTO order_menu (id, customer_id, store_id, order_details,date) VALUES(:id, :customer_id, :store_id, :order_details,:date)');
		$sql->bindValue(':id', null);
		$sql->bindValue(':customer_id', $_REQUEST['customer_id']);
		$sql->bindValue(':store_id', $_REQUEST['store_id']);
		$sql->bindValue(':order_details', $_REQUEST['details']);
		$sql->bindValue(':date', $_REQUEST['date']);
		$sql->execute();		
		break;
	case 'update':
		$sql=$pdo->prepare(
			'UPDATE order_menu SET store_id=?, order_details=?, date=? where id=?');
		$sql->execute(
			[htmlspecialchars($_REQUEST['store_id']), $_REQUEST['details'], $_REQUEST['date'], 
			$_REQUEST['update_id']]);
		break;
	case 'delete':
		echo $_REQUEST['customer_id'];
		$sql=$pdo->prepare('delete from order_menu where id=?');
		$sql->execute([$_REQUEST['delete-id']]);
		break;
	}
	
	$url = "order.php?id=" . $_SESSION['customer']['id'];
	header("Location:" . $url );
	exit();
}

//表示顧客情報
$sql=$pdo->prepare('select * from customer where customer_id=?');
$sql->execute([$_GET['id']]);
foreach ($sql as $row) {
	$_SESSION['customer']=[
		'id'=>$row['customer_id'], 'name'=>$row['name']];	
}
if (isset($_SESSION['customer'])) {
	echo '<p>顧客番号', $_SESSION['customer']['id'], '</p>';
	echo $_SESSION['customer']['name'], 'さんの来店履歴';
} else {
	echo '顧客情報を取得できませんでした';
}
echo '<br>';

//新規投稿フォーム
$sql=$pdo->prepare('select * from store');
$sql->execute();
?>
<!--新規投稿のためphpいったん抜ける-->
<div class="order-new-data">
<form action="order.php" method="post">
<input type="hidden" name="command" value="insert">
<input type="hidden" name="customer_id" value="<?php echo $_SESSION['customer']['id']?>">
<div class="order-upper-data">
<select name="store_id">
<?php foreach ($sql as $row) : ?>
 <option value="<?php echo $row['store_id']; ?>" <?php if ( $_SESSION['store']['id'] == $row['store_id'] ) { echo ' selected'; } ?>><?php echo $row['store_name']; ?></option>
 <?php endforeach; ?>
</select>
<input name="date" type="date" value="<?php echo date('Y-m-j');?>"></input>
</div>

<br>
<div class="td">
<textarea name="details" placeholder="注文内容(300文字以内)" cols="80" rows="2"></textarea>
</div>
<div class="td"><input type="submit" value="追加"></div>
</form>
</div>

<!--新規投稿終了php再開-->
<?php
//データの表示
$sql=$pdo->prepare('SELECT * FROM order_menu join store ON order_menu.store_id = store.store_id where customer_id=? ORDER BY id desc');
$sql->execute([$_GET['id']]);

foreach ($sql as $row) {
	echo '<div class="order-data">';
    echo '<form class="order-update-form" action="order.php" method="post">';
	echo '<input type="hidden" name="command" value="update">';
	echo '<input type="hidden" name="customer_id" value="'.$row['customer_id'].'">';
	echo '<input type="hidden" name="store_id" value="', $row['store_id'], '">';
	echo '<input type="hidden" name="update_id" value="', $row['id'], '">';
	echo '<div class="td">';
	$storeSql=$pdo->prepare('select * from store');
	$storeSql->execute();
?>
<!--storeをoptionで選択式にするためphpタグをいったん抜ける-->
<select name="store_id">
 <?php foreach ($storeSql as $storeRow) : ?>
 <option value="<?php echo $storeRow['store_id']; ?>" <?php if ($storeRow['store_id']== $row['store_id'] ) { echo ' selected'; } ?>><?php echo $storeRow['store_name']; ?></option>
 <?php endforeach; ?>
</select>
<!--store項目終了、phpタグ再開-->
<?php
	echo '</div> ';
	echo '<div class="td">';
	echo '<input type="date" name="date" value="', $row['date'], '">';
	echo '</div> ';
	echo '<br>';
	echo '<div class="td">';
	echo '<textarea name="details" cols="80" rows="2">', $row['order_details'], '</textarea>';
	echo '</div> ';
	echo '<div class="td">';
	echo '<input type="submit" value="更新">';
	echo '</div> ';
	echo '</form> ';
	echo '<form class="order-delete-form" action="order.php" method="post">';
	echo '<input type="hidden" name="command" value="delete">';
	echo '<input type="hidden" name="customer_id" value="'.$row['customer_id'].'">';
	echo '<input type="hidden" name="delete-id" value="', $row['id'], '">';
	echo '<input type="submit" value="削除">';
	echo '</form><br>';
	echo '</div>';
	echo "\n";
}
?>
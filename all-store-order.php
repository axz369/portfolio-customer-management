<?php require 'header.php'; ?>
<?php require 'menu.php'; ?>

<?php
$pdo=new PDO('mysql:host=localhost;dbname=データベース名;charset=utf8','ユーザー名', 'パスワード');
$storeCount=0;
//データ投稿更新削除
if (isset($_REQUEST['command'])) {
	switch ($_REQUEST['command']) {
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
	header("Location: all-store-order.php");
	exit();
}

//データの表示
$sql=$pdo->prepare('SELECT * FROM order_menu join customer ON order_menu.customer_id = customer.customer_id ORDER BY id desc');
$sql->execute();
foreach ($sql as $row) {
	echo '<div class="all-order-data">';
    echo '<form class="all-order-update-form" action="all-store-order.php" method="post">';
	echo '<input type="hidden" name="command" value="update">';
    echo '<input type="hidden" name="store_id" value="', $row['store_id'], '">';
	echo '<input type="hidden" name="update_id" value="', $row['id'], '">';
	echo $row['customer_id'].' ';
    echo $row['name'].' ';
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
	echo '<form class="all-order-delete-form" action="all-store-order.php" method="post">';
	echo '<input type="hidden" name="command" value="delete">';
	echo '<input type="hidden" name="delete-id" value="', $row['id'], '">';
	echo '<input class="all-order-delete-button" type="submit" value="削除">';
	echo '</form><br>';
	echo '</div>';
	echo "\n";
}

?>
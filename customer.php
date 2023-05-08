<?php require 'header.php'; ?>
<?php require 'menu.php';?>

<!--検索フォーム-->
<p>顧客検索</p>
<form action="customer.php" method="post">
<input type="text" name="searchName" placeholder="名前">
<input type="submit" value="検索">
</form>
<form action="customer.php" method="post">
<input type="text" name="searchReading" placeholder="よみ">
<input type="submit" value="検索">
</form>
<form action="customer.php" method="post">
<input type="text" name="searchAge" placeholder="年齢">
<input type="submit" value="検索">
</form>
<form action="customer.php" method="post">
<input type="text" name="searchTel" placeholder="電話番号">
<input type="submit" value="検索">
</form>

<!--データの新規投稿フォーム-->
<div class="customer-new-data">
<form action="customer.php" method="post">
<input type="hidden" name="command" value="insert">
<div class="td">新規</div>
<div class="td"><input type="text" name="name" placeholder="名前"></div>
<div class="td"><input type="text" name="reading" placeholder="よみ"></div>
<div class="td">
<select name="age">
<?php for ($i=10;$i<=90;$i+=10) { ?>
 <option value="<?php echo $i; ?>"><?php echo $i.'代'; ?></option>
<?php }?>
</select>
</div>
<div class="td"><input type="text" name="telephone_number" placeholder="電話番号"></div>
<br>
<div class="td"><textarea name="details" placeholder="詳細(300文字以内)" cols="80" rows="3"></textarea></div>
<div class="td"><input type="submit" value="追加"></div>
</form>
</div>

<?php
//データの新規投稿、編集、削除処理
$pdo=new PDO('mysql:host=localhost;dbname=データベース名;charset=utf8','ユーザー名', 'パスワード');
if (isset($_REQUEST['command'])) {
	switch ($_REQUEST['command']) {
	case 'insert':
		$sql=$pdo->prepare('insert into customer values(null,?,?,?,?,?)');
		$sql->execute(
			[htmlspecialchars($_REQUEST['name']), $_REQUEST['reading'], $_REQUEST['age'], 
			$_REQUEST['telephone_number'], $_REQUEST['details']]);
		break;
	case 'update':
		$sql=$pdo->prepare(
			'update customer set name=:name, reading=:reading, age=:age, telephone_number=:telephone_number, details=:details where customer_id=:customer_id');
		$sql->bindValue(':name',$_REQUEST['name']);
		$sql->bindValue(':reading',$_REQUEST['reading']);
		$sql->bindValue(':age',$_REQUEST['age']);
		$sql->bindValue(':telephone_number',$_REQUEST['telephone_number']);
		$sql->bindValue(':details',$_REQUEST['details']);
		$sql->bindValue(':customer_id',$_REQUEST['update-id']);
		$sql->execute();
		break;
	case 'delete':
		$sql=$pdo->prepare('delete from customer where customer_id=?');
		$sql->execute([$_REQUEST['delete-id']]);
		break;
	}
	header("Location: customer.php");
	exit();
}

//データの表示処理
if (isset($_REQUEST['searchName'])) {
	$sql=$pdo->prepare('select * from customer where name like ? ORDER BY customer_id desc');
	$sql->execute(['%'.$_REQUEST['searchName'].'%']);
}else if(isset($_REQUEST['searchReading'])){
	$sql=$pdo->prepare('select * from customer where reading like ? ORDER BY customer_id desc');
	$sql->execute(['%'.$_REQUEST['searchReading'].'%']);
}else if(isset($_REQUEST['searchAge'])){
	$sql=$pdo->prepare('select * from customer where age like ? ORDER BY customer_id desc');
	$sql->execute(['%'.$_REQUEST['searchAge'].'%']);
}else if(isset($_REQUEST['searchTel'])){
	$sql=$pdo->prepare('select * from customer where telephone_number like ? ORDER BY customer_id desc');
	$sql->execute(['%'.$_REQUEST['searchTel'].'%']);
}else {
	$sql=$pdo->query('select * from customer ORDER BY customer_id desc');
}
foreach ($sql as $row) {
	echo '<div class="customer-data">';
	echo '<form class="customer-update-form" action="customer.php" method="post">';
	echo '<input type="hidden" name="command" value="update">';
	echo '<input type="hidden" name="update-id" value="', $row['customer_id'], '">';
	echo '<div class="td">';
	echo '<a href="order.php?id=', $row['customer_id'], '">', $row['customer_id'], '</a>';
	echo '</div> ';
	echo '<div class="td">';
	echo '<input type="text" name="name" value="', $row['name'], '">';
	echo '</div> ';
	echo '<div class="td">';
	echo '<input type="text" name="reading" value="', $row['reading'], '">';
	echo '</div> ';
	echo '<div class="td">';

?>
<!--ageをoptionで選択式にするためphpタグをいったん抜ける-->
<select name="age">
<?php for ($i=10;$i<=90;$i+=10) { ?>
 <option value="<?php echo $i; ?>" <?php if ( $i == $row['age'] ) { echo ' selected'; } ?>><?php echo $i.'代'; ?></option>
<?php }?>
</select>
<!--age項目終了、phpタグ再開-->
<?php
	echo '</div> ';
	echo '<div class="td">';
	echo '<input type="text" name="telephone_number" value="', $row['telephone_number'], '">';
	echo '</div> ';
	echo '<br>';
	echo '<div class="td">';
	echo '<textarea name="details" maxlength="300" cols="80" rows="3">' ,$row['details'], '</textarea>';
	echo '</div> ';
	echo '<div class="td">';
	echo '<input type="submit" value="更新">';
	echo '</div> ';
	echo '</form> ';
	echo '<form class="customer-delete-form" action="customer.php" method="post">';
	echo '<input type="hidden" name="command" value="delete">';
	echo '<input type="hidden" name="delete-id" value="', $row['customer_id'], '">';
	echo '<input type="submit" name="customer-delete-button" value="削除">';
	echo '</form><br>';
	echo '</div>';
	echo "\n";
}
?>
<?php session_start(); ?>
<?php
unset($_SESSION['store']);
$pdo=new PDO('mysql:host=localhost;dbname=データベース名;charset=utf8','ユーザー名', 'パスワード');
$sql=$pdo->prepare('select * from store where store_name=?');
$sql->execute([$_REQUEST['store']]);
foreach ($sql as $row) {
	if(password_verify(($_REQUEST['password']),trim($row['store_password']))){
		echo $row['store_pasword'];
		$_SESSION['store']=[
			'id'=>$row['store_id'], 'name'=>$row['store_name']
		];
	}
	
}
if (isset($_SESSION['store'])) {
	header("Location: customer.php");
	exit();
} else {
	echo 'ログイン名またはパスワードが違います。';
}
?>
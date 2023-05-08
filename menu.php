<?php session_start(); ?>
<ul>
  <li><a href="customer.php">顧客一覧</a></li>
  <li><a href="own-store-order.php">自店舗注文一覧</a></li>
  <li><a href="all-store-order.php">全店舗注文一覧</a></li>
  <li><a href="store.php">店舗設定</a></li>
  <li class="login-store"><?php echo $_SESSION['store']['name'], '店としてログイン中';?></li>
  <li><a href="login.php">ログアウト</a></li>
</ul>

<hr>

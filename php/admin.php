<!DOCTYPE html>
<html>
<head>
	<title>管理員頁面</title>
	<style>
		body {
			background-color: #F5F5F5;
			font-family: Arial, sans-serif;
		}
		h1 {
			text-align: center;
			color: #008080;
			margin-top: 50px;
		}
		p {
			font-size: 18px;
			text-align: center;
			color: #696969;
			margin-top: 30px;
		}
		ul {
			list-style-type: none;
			margin: 0;
			padding: 0;
			text-align: center;
		}
		li {
			display: inline-block;
			margin: 10px;
		}
		a {
			display: block;
			padding: 10px;
			background-color: #008080;
			color: white;
			text-decoration: none;
			border-radius: 5px;
			font-size: 16px;
		}
		a:hover {
			background-color: #006666;
		}
	</style>
</head>
<body>
	<h1>管理員頁面</h1>
	<?php
		// 檢查使用者是否以管理員身份登入
		session_start();
		if(isset($_SESSION['username']) && $_SESSION['role'] == 'admin') {
			echo "<p>您已以管理員身份登入。 <a href='logout.php'>登出</a></p>";
			// 顯示管理員選項
			echo "<ul>";
			echo "<li><a href='manage_artwork.php'>管理作品</a></li>";
			echo "<li><a href='add_exhibition.php'>新增展覽</a></li>";
			echo "<li><a href='manage_exhibition.php'>管理展覽</a></li>";
			echo "<li><a href='add_product.php'>新増產品</a></li>";
			echo "<li><a href='manage_inventory.php'>管理庫存與價格</a></li>";
			echo "<li><a href='view_orders.php'>查看訂單</a></li>";
			echo "<li><a href='manage_users.php'>管理使用者</a></li>";
			echo "<li><a href='analysis.php'>數據分析</a></li>";
			echo "</ul>";
		} else {
			echo "<p>您沒有權限訪問此頁面。</p>";
		}
	?>
</body>
</html>
<!DOCTYPE html>
<html>
<head>
	<title>編輯展覽</title>
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

	.container {
		width: 400px;
		margin: 0 auto;
		background-color: #fff;
		padding: 20px;
		border-radius: 5px;
		box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
	}

	.form-group {
		margin-bottom: 20px;
	}

	label {
		display: block;
		font-weight: bold;
		margin-bottom: 5px;
	}

	input[type="text"],
	input[type="date"],
	textarea {
		width: 100%;
		padding: 8px;
		border: 1px solid #ddd;
		border-radius: 4px;
	}

	.btn {
		display: inline-block;
		padding: 10px 20px;
		background-color: #008080;
		color: #fff;
		text-decoration: none;
		border-radius: 4px;
		transition: background-color 0.3s ease;
	}

	.btn:hover {
		background-color: #005F5F;
	}
</style>
</head>
<body>
	<h1>編輯展覽</h1>
	<?php
		// 開始會話
		session_start();
			// 檢查使用者是否以管理員身分登入
	if(isset($_SESSION['username']) && $_SESSION['role'] == 'admin') {
		// 檢查是否提供展覽編號
		if(isset($_GET['exhibition_ID'])) {
			$exhibition_ID = $_GET['exhibition_ID'];

			// 連接到資料庫
			$link = mysqli_connect('localhost', 'root', 'phpproject', 'wanwan');
			if(!$link) {
				die('無法連接到資料庫。');
			}

			// 檢索展覽資訊
			$query = "SELECT * FROM exhibition WHERE exhibition_ID = '$exhibition_ID'";
			$result = mysqli_query($link, $query);

			if(mysqli_num_rows($result) == 1) {
				$row = mysqli_fetch_assoc($result);
				$exhibition_name = $row['exhibition_name'];
				$exhibition_introduce = $row['exhibition_introduce'];
				$exhibition_start_time = $row['exhibition_start_time'];
				$exhibition_end_time = $row['exhibition_end_time'];
				$exhibition_place = $row['exhibition_place'];
				$exhibition_price = $row['exhibition_price'];
				$exhibition_status = $row['exhibition_status'];

				// 檢查是否提交了表單
				if(isset($_POST['submit'])) {
					$exhibition_name = $_POST['exhibition_name'];
					$exhibition_introduce = $_POST['exhibition_introduce'];
					$exhibition_start_time = $_POST['exhibition_start_time'];
					$exhibition_end_time = $_POST['exhibition_end_time'];
					$exhibition_place = $_POST['exhibition_place'];
					$exhibition_price = $_POST['exhibition_price'];
					$exhibition_status = $_POST['exhibition_status'];

					// 在資料庫中更新展覽資訊
					$update_query = "UPDATE exhibition SET exhibition_name = '$exhibition_name', exhibition_introduce = '$exhibition_introduce', exhibition_start_time = '$exhibition_start_time', exhibition_end_time = '$exhibition_end_time', exhibition_place = '$exhibition_place', exhibition_price = '$exhibition_price', exhibition_status = '$exhibition_status' WHERE exhibition_ID = '$exhibition_ID'";
					$update_result = mysqli_query($link, $update_query);

					if($update_result) {
						echo "<p>展覽資訊已成功更新。</p>";
						echo "<a href='manage_exhibition.php' class='btn'>返回展覽管理</a>";
					} else {
						echo "<p>更新展覽資訊時發生錯誤。</p>";
					}
				} else {
					// 顯示帶有展覽資訊的表單
					echo "<div class='container'>";
					echo "<form method='POST'>";
					echo "<div class='form-group'>";
					echo "<label for='exhibition_name'>展覽名稱：</label>";
					echo "<input type='text' id='exhibition_name' name='exhibition_name' value='$exhibition_name'>";
					echo "</div>";
					echo "<div class='form-group'>";
					echo "<label for='exhibition_introduce'>展覽介紹：</label>";
					echo "<textarea id='exhibition_introduce' name='exhibition_introduce'>$exhibition_introduce</textarea>";
					echo "</div>";
					echo "<div class='form-group'>";
					echo "<label for='exhibition_start_time'>展覽開始時間：</label>";
					echo "<input type='date' id='exhibition_start_time' name='exhibition_start_time' value='$exhibition_start_time'>";
					echo "</div>";
					echo "<div class='form-group'>";
					echo "<label for='exhibition_end_time'>展覽結束時間：</label>";
					echo "<input type='date' id='exhibition_end_time' name='exhibition_end_time' value='$exhibition_end_time'>";
					echo "</div>";
					echo "<div class='form-group'>";
					echo "<label for='exhibition_place'>展覽地點：</label>";
					echo "<input type='text' id='exhibition_place' name='exhibition_place' value='$exhibition_place'>";
					echo "</div>";
					echo "<div class='form-group'>";
					echo "<label for='exhibition_price'>展覽價格：</label>";
					echo "<input type='text' id='exhibition_price' name='exhibition_price' value='$exhibition_price'>";
					echo "</div>";
					echo "<div class='form-group'>";
					echo "<label for='exhibition_status'>展覽狀態：</label>";
					echo "<select name='exhibition_status' id='exhibition_status'>";
					echo "<option value='未開始' " . ($exhibition_status == '未開始' ? 'selected' : '') . ">未開始</option>";
					echo "<option value='進行中' " . ($exhibition_status == '進行中' ? 'selected' : '') . ">進行中</option>";
					echo "<option value='已結束' " . ($exhibition_status == '已結束' ? 'selected' : '') . ">已結束</option>";
					echo "</select>";
					echo "</div>";
					echo "<input type='submit' name='submit' value='更新' class='btn'>";
					echo "</form>";
					echo "</div>";
				}
			} else {
				echo "<p>未提供展覽編號。</p>";
			}

			mysqli_free_result($result);
			mysqli_close($link);
		} else {
			echo "<p>未提供展覽編號。</p>";
		}
	} else {
		echo "<p>您沒有權限訪問此頁面。</p>";
	}
?>
</body>
</html>

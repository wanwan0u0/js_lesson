<script type="text/javascript">
function goBack(){
    window.history.go(-1);
}
</script>

<!DOCTYPE html>
<html>
<head>
	<title>管理作品</title>
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

		.artist-section {
			margin-top: 30px;
		}

		.artist-heading {
			font-size: 18px;
			color: #008080;
			margin-bottom: 10px;
			cursor: pointer;
		}

		.artwork-section {
			display: none;
			flex-wrap: wrap;
			justify-content: center;
		}

		.artwork-item {
			width: 300px;
			margin: 20px;
			padding: 20px;
			background-color: #fff;
			border-radius: 5px;
			box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
		}

		.artwork-image {
			width: 100%;
			height: auto;
			border-radius: 5px;
			margin-bottom: 10px;
		}

		.artwork-title {
			font-size: 18px;
			color: #008080;
			margin-bottom: 5px;
		}

		.artist-name {
			font-size: 14px;
			color: #696969;
			margin-bottom: 5px;
		}

		.artwork-info {
			font-size: 14px;
			color: #696969;
		}

		.manage-link {
			display: block;
			margin-top: 10px;
			text-align: right;
			text-decoration: none;
			color: #008080;
		}

		.back-link {
			display: block;
			margin-top: 20px;
			margin-left: 20px;
			text-decoration: none;
			color: #008080;
			font-size: 16px;
		}
	</style>
	<script>
		// Function to toggle display of artwork section
		function toggleArtworkSection(artistSection) {
			const artworkSection = artistSection.nextElementSibling;
			artworkSection.style.display = artworkSection.style.display === 'none' ? 'flex' : 'none';
		}
	</script>
</head>
<body>
	<a href="admin.php" class="back-link">&#8592; 返回上一頁</a>
	<h1>管理作品</h1>
	<?php
		// start the session
		session_start();

		// check if the user is logged in as admin
		if(isset($_SESSION['username']) && $_SESSION['role'] == 'admin') {
			// connect to the database
			$link = mysqli_connect('localhost', 'root', 'phpproject', 'wanwan');
			if(!$link) {
				die('Failed to connect to the database.');
			}

			// query the database to retrieve artists
			$artistQuery = "SELECT DISTINCT user_name FROM uuser WHERE user_role = 'artist' ORDER BY user_name ASC";
			$artistResult = mysqli_query($link, $artistQuery);

			if(mysqli_num_rows($artistResult) > 0) {
				while ($artistRow = mysqli_fetch_assoc($artistResult)) {
					echo "<div class='artist-section'>";
					echo "<h2 class='artist-heading' onclick='toggleArtworkSection(this)'>" . $artistRow['user_name'] . "</h2>";
					
					// query the database to retrieve artworks by the artist
					$artistName = $artistRow['user_name'];
					$artworkQuery = "SELECT * FROM artwork WHERE user_id IN (SELECT user_id FROM uuser WHERE user_name = '$artistName') AND artwork_price IS NULL ORDER BY artwork_ID ASC";
					$artworkResult = mysqli_query($link, $artworkQuery);

					if(mysqli_num_rows($artworkResult) > 0) {
						echo "<div class='artwork-section'>";
						while ($artworkRow = mysqli_fetch_assoc($artworkResult)) {
							echo "<div class='artwork-item'>";
							echo "<img src='" . $artworkRow['artwork_file'] . "' alt='Artwork Image' class='artwork-image'>";
							echo "<h3 class='artwork-title'>" . $artworkRow['artwork_name'] . "</h3>";
							echo "<p class='artwork-info'>" . $artworkRow['artwork_information'] . "</p>";
							echo "<a href='edit_artwork.php?artwork_id=" . $artworkRow['artwork_ID'] . "' class='manage-link'>編輯</a>";
							echo "<a href='delete_artwork.php?artwork_id=" . $artworkRow['artwork_ID'] . "' class='manage-link'>刪除</a>";
							echo "</div>";
						}
						echo "</div>";
					} else {
						echo "<p>No artworks found for this artist.</p>";
					}

					mysqli_free_result($artworkResult);
					echo "</div>";
				}
			} else {
				echo "<p>No artists found.</p>";
			}

			mysqli_free_result($artistResult);
			mysqli_close($link);
		} else {
			echo "<p>You don't have permission to access this page.</p>";
		}
	?>
</body>
</html>

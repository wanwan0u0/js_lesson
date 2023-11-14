<html>
<head>
  <title>Login Page</title>
  <link rel="stylesheet" href="login_style.css">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/css?family=Noto+Sans+TC|Open+Sans&display=swap" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script src="https://kit.fontawesome.com/ad45004b60.js" crossorigin="anonymous"></script>
</head>
<body style="background-color: black;">
<header style="background: black;">
  <div class="header-container">
    <nav class="navbar navbar-expand-lg navbar-light">
      <a class="navbar-brand" href="index.php">
        <img src="logo1.png">
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <i class="fa-solid fa-bars" style="color: #ffffff;"></i>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item">
            <a class="nav-link" href="index.php" style="color:white;">首頁</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="exhibition.php" style="color:white;">展覽活動</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="artwork.php" style="color:white;">藝術作品</a>
          </li>
        </ul>

        
      </div>
    </nav>
  </div>
</header>
<section id="background-section">
<div class="container">
  <div class="login-container">
    <h2>Login</h2>
    <?php
    session_start();
    if(isset($_SESSION['username']) && isset($_SESSION['role'] ) && isset($_SESSION['viewer_user_ID'] )){
      header("Location: artist.php");
    }
    ?>
    <form method="post" action="authenticate2.php">
      <div class="form-group">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" placeholder="Enter your username" required>
      </div>
      <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" placeholder="Enter your password" required>
      </div>
      <div class="form-group">
        <button type="submit">Login</button>
      </div>

    </form>
    <div class="form-group">
      <a href = 'register.php' style='text-decoration: none; color:white;'><button>註冊</button></a>
      </div>
    <?php
		// 檢查 session 中是否有錯誤訊息
		if(isset($_SESSION['error'])) {
			echo "<p>{$_SESSION['error']}</p>";
			unset($_SESSION['error']); // 從 session 中移除錯誤訊息
		}
	?>
  	</div>
  </div>
  </section>
</body>
</html>


<html>
<head>
  <title>Register Page</title>
  <link rel="stylesheet" href="register_style.css?v=<?=time()?>"> 
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/css?family=Noto+Sans+TC|Open+Sans&display=swap" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script src="https://kit.fontawesome.com/ad45004b60.js" crossorigin="anonymous"></script>
</head>
<body style="background-color: white;">
<header style="background: white;">
  <div class="header-container">
    <nav class="navbar navbar-expand-lg navbar-light">
      <a class="navbar-brand" href="index.php">
        <img src="logo.png">
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <i class="fa-solid fa-bars" style="color: #ffffff;"></i>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item">
            <a class="nav-link" href="index.php" style="color:black;">首頁</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="exhibition.php" style="color:black;">展覽活動</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="artwork.php" style="color:black;">藝術作品</a>
          </li>
        </ul>

        
      </div>
    </nav>
  </div>
</header>
<?php
if(isset($_GET['value'])){
    $value=$_GET['value'];
}
echo"<section id='background-section'>";
echo"<div class='container'>";
echo"<div class='register-container'>";
echo "<h2>Register</h2>";
echo"<div class='input1'>";
echo "<form action='register_check.php' method='post' enctype='multipart/form-data'>";
echo "icon:</br>";
echo "<input type='file' name='icon' accept='image/png'></br>";
echo "Username:</br>";
echo "<input type='text' name='name' required='required'><p></p>";
echo "account:</br>";
echo "<input type='text' name='account' required='required'><p></p>";
echo "password:</br>";
echo "<input type='text' name='password' required='required'><p></p>";
echo "email:</br>";
echo "<input type='text' name='email' required='required'><p></p>";
if(@$value==1){
    echo"<font color='red'>該email已被註冊</font></br>";
}
if(@$value==2){
    echo"<font color='red'>該account已被註冊</font></br>";
}
echo"</div>";
echo"<div class='input2'>";
echo "role:";
echo "<input type='radio' name='role' value='collector' checked='checked'>collector";
echo "<input type='radio' name='role' value='artist'>artist";
echo"</div>";
echo "<h2>About</h2>";
echo "<textarea name='bio' cols='50' rows='10'>";
echo "</textarea></br>";
echo"<div class='form-group'>";
echo "<input type='submit'>";
echo "</div>";
echo"</div>";
echo"</section>";
?>
</body>
</html>



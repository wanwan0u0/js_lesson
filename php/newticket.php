<?php
    session_start();
    if(!$_SESSION) {
        header("Location:login.php");
      exit;
    }else{
    }
        
       
        $link = @mysqli_connect('localhost', 'root', 'phpproject', 'wanwan');
        mysqli_set_charset($link, "utf8");
        $SQL = 'SELECT * FROM exhibition';
        if (@$result = mysqli_query($link, $SQL)) {
        //echo "資料庫連結成功";
    } else {
    echo "資料庫查詢失敗";
    }
?>
<!DOCTYPE html>
<html>
<head>
    <title>展覽售票系統</title>
    <link rel="stylesheet" href="newticket_style.css">
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
          <li class="nav-item">
            <a class="nav-link" href="newticket.php" style="color:white;">購票服務</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="login.php" style="color:white;">會員中心</a>
          </li>
        </ul>

      </div>
    </nav>
  </div>
</header>
<section id="background-section">
  <div class="container">
    <div class="ticket-container">
    <h2>訂票服務</h2>
    <hr width="95%" color="#dddddd">
    <br/>
      展覽活動選擇：<select id="event-select" onchange="showTicketPrice()">
            <option value="">請選擇展覽活動</option>
            <?php
                while ($row = mysqli_fetch_assoc($result)) {
                    $eventName = $row['exhibition_name'];
                    $exhibitionID = $row['exhibition_ID'];
                    $ticketPrice = $row['exhibition_price'];
                    echo "<option value='$ticketPrice'>$eventName</option>";
                }
            ?>
        </select>
        <p id="ticket-price-display"></p>
    <form method="post" action="ticketsucess.php" >
    <div class="form-group">
        <label for="name">姓名 ：<input type="text" name="name" id="name" placeholder="請輸入您的姓名" required></label>

      </div>
      <div class="form-group">
        <label for="quantity">數量 ：<input type="number" name="quantity" id="quantity" min="1" placeholder="請輸入您的購票數量"required></label>
        
    </div>
        
    <div class="form-group">   
        <label for="email">email ：<input type="text" name="e-mail" id="e-mail" placeholder="請輸入您的電子郵件" required></label>
        
    </div>
    <div class="form-group">    
        <label for="tel">電話 ：<input type="text" name="tel" id="tel" placeholder="請輸入您的電話號碼" required></label>
 
    </div>
        <input type="hidden" name="ticket-price" id="ticket-price-input" value="<?php echo $ticketPrice; ?>">
        <input type="hidden" name="exhibitionID" id="exhibitionID" value="<?php echo $exhibitionID;?>">
    <div class="form-group">
        <button type="submit" >購買</button>
    </div>
    <div class="form-group">
        <button type="reset" style="background-color: black;">重設</button>
    </div>
    </form>

    </div>

  </div>
</section>

    <script>
        function showTicketPrice() {
            var select = document.getElementById("event-select");
            var ticketPrice = select.value;
            var priceParagraph = document.getElementById("ticket-price-display");
            priceParagraph.textContent = "票價：$" + ticketPrice;
            
            
        }
    </script>
</body>
</html>>



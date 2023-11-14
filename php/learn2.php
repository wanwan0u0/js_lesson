<html>
    <head>

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Noto+Sans+TC|Open+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="learn2_style.css?<?=time()?>"> 
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/ad45004b60.js" crossorigin="anonymous"></script>

    <title>Wan wan Art</title>
    </head>

    <body>

    <header style="background: black;">
        <div class="container" >
            <nav class="navbar navbar-expand-lg navbar-light ">
                <a class="navbar-brand" href="index.php">
                    <img src="logo1.png" >
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation" >
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
    <section id='intro' >
    <div class='jumbotron' >
        <picture class="img-demo"> 
            <img class="content_img" src="header圖.jpg" alt width="100%" max-height="100%">
        </picture>
        <div class='container'>
            <div class='row'>
                <div class="col-md-12">
                <h1 style="color: #000;">
                    Wan wan藝廊，綻放你的創造力</h1>
                <p class='lead' style="color: #000;">讓藝術點綴你的生活，追求最極致的藝術體驗！</p>
                <a class='btn' href='artistinfo.php'>探索更多藝術家</a>
                </div>
            </div>
        </div>
    </div>
    </section>

    <section id='second'>
        <div class='container'>
            <div class='row'>
                <div class='col-md-8 offset-md-2 text-center'> 
                    <h3>熱門創作者</h3>
                    <div class='row'>
                    <div class='col-md-4'>
                    <?php
                        $link = mysqli_connect('localhost', 'root', 'phpproject', 'wanwan');
                        $artistSQL = "SELECT * , COUNT(artwork.user_id) as total 
                                      FROM collection_detail 
                                      JOIN artwork on collection_detail.artwork_ID = artwork.artwork_ID 
                                      JOIN uuser on uuser.user_ID =artwork.user_id  GROUP BY artwork.user_id 
                                      ORDER BY total DESC LIMIT 3";    
                                    $artistResult = mysqli_query($link, $artistSQL);

                            if($artistResult) {
                                    while($row = mysqli_fetch_assoc($artistResult)) {
                                    $artistname = $row["user_name"];
                                    $artistpng = $row["user_icon"];
                                    $artistintroduce = $row["user_introduce_html"];
                                    $artistID=$row['user_ID'];
                                    echo "<a href='artist.php?owner_user_ID=$artistID'>";
                                    echo "<img src='$artistpng'/>";
                                    echo '<br>';
                                    echo "<div class='name'>";
                                    echo $artistname;
                                    echo "</div>";
                                    echo "</a>";
                                    echo "</div>";
                                    echo "<div class='col-md-8 text-left'>";
                                    echo $artistintroduce;
                                    echo "</div>";


                                    }
                            } else {
                                    echo "資料庫查詢失敗：" . mysqli_error($link);
                            }
                    ?>

                    </div>
                        
                    </div>

                </div>
            </div>
        </div>
    </section>
   
    <section id='third'>
        <div class='container'>
            <div class='row'>
                <div class='col-md-12 text-center'>
                    <h3>最新作品</h3>
                </div>

            </div>
    
        <div class='row'>
        <?php 
            $artworkjpgSQL = "SELECT * FROM artwork where artwork_price!='null' ORDER BY artwork_ID DESC LIMIT 3 ";
            $artworkjpgResult = mysqli_query($link, $artworkjpgSQL);
            while($row = mysqli_fetch_assoc($artworkjpgResult)){
            $artworkjpg = $row['artwork_file'];
            $artworkstock = $row['artwork_stock'];
            $artworkprice = $row['artwork_price'];
            $artworkjpg = $row['artwork_file'];
            $artworkinformation = $row['artwork_information_html'];   
            ?>
            <div class='col-md-4'>
                <div class='outer'>
                    <a href='artwork.php'>
                        <div class='upper'>
                            <?php    echo "<img src ='$artworkjpg'>"
                            ?>
                            <div class='innertext'>
                            <span <?php if ($artworkstock == 0) { echo "style='color: red;'"; } ?>>
                                <?php
                                if ($artworkstock == 0) {
                                    echo "無庫存";
                                } else {
                                    echo "庫存", $artworkstock;
                                }
                                ?>
                            </span>
                                <span style='margin-left:135px';><?php echo "售價", $artworkprice ?></span>
                            </div>
                        </div>
                        <div class='lower'>
                            <h3><?php echo $row['artwork_name'];?></h3>
                            
                        </div>
                    </a>
                </div>
            </div>
            <?php
            }
            ?>
         </section>
        
        
            
    <section id='final'>
        <div class='container'>
            <div class='row'>
                <div class='col-md-12 text-center'>
                    <h3>近期展覽</h3>
                </div>

            </div>
            <div class='row'>
                <div class='col-md-12'>
            <div class="bd">
<div id="carouselExampleFade" class="carousel slide" data-ride="carousel">
  <div class="carousel-inner">
    <div class="carousel-item active">
     	 <img class="d-block"  style="max-width: 1208px;
    max-height: 805px; filter: brightness(80%);">
    <?php 
                  mysqli_set_charset($link, "utf8");
                  $exhibitionSQL = "SELECT artwork_file FROM artwork ORDER BY exhibition_ID DESC LIMIT 3";
                  $exhibitionResult = mysqli_query($link, $exhibitionSQL);
                  if(@$exhibitionResult = mysqli_query($link, $exhibitionSQL)){
                    $row = mysqli_fetch_assoc($exhibitionResult);
                    $exhibition = $row['artwork_file'];
                    echo "<a href='exhibition.php'>";
                    echo "<img src ='$exhibition'/>";
                    echo "</a>";    
                    echo '<br>'; 
                   
                  }
    ?>
                  
	    <div class="carousel-caption d-none d-md-block">
           <?php 
                  mysqli_set_charset($link, "utf8");
                  $exhibitionnameSQL = "SELECT exhibition_name FROM exhibition ORDER BY exhibition_ID DESC LIMIT 3 ";
                  $exhibitionnameResult= mysqli_query($link, $exhibitionnameSQL);
                  $exhibitiontimeSQL = "SELECT exhibition_start_time, exhibition_end_time FROM exhibition ORDER BY  exhibition_ID DESC LIMIT 3";
                  $exhibitiontimeResult=mysqli_query($link, $exhibitiontimeSQL);
                  if ($exhibitionnameResult && $exhibitiontimeResult) {
                    while($row = mysqli_fetch_assoc($exhibitionnameResult)) {
                        while($row1 = mysqli_fetch_assoc($exhibitiontimeResult)){
                            $exhibitionname = $row['exhibition_name'];
                            $exhibitionstarttime = $row1['exhibition_start_time'];
                            $exhibitionendtime = $row1['exhibition_end_time'];
                            echo $exhibitionname;
                            echo "<br/>";
                            echo $exhibitionstarttime;
                            echo " ";
                            echo "to";
                            echo " ";
                            echo $exhibitionendtime;
                        }
                    } 
                  
                }
            ?>
                
       </div>
    </div>
    
  <a class="carousel-control-prev" href="#carouselExampleFade" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleFade" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>
</section>
    <section id='email'>
    <div class="container">
        <div class="row">
        <div class='col-md offset-md text-left'>
                    <h3>加入電子信箱</h3> 
        </div>
        </div>
        <div class="row">
            <div class='col-md offset-md text-left'>
                <p>讓我們隨時通知您最新的藝術作品！</p>
                <div class="input-group input-group-lg">
                </div>
                        <form method="post" action="emailcheck.php">
                        <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg" placeholder="您的信箱" name="email">
                            <br/>
                        <input class = 'btn' type="submit" a href= "emailcheck.php"> 
                </div>
            </div>
        </div>
    
    </div>               
    </section>
    
    <footer style="background: black;">
        <div class="container">
            <div class="row">
                <div class='col-md-4 text-left'>
                    <img src='logo1.png'>
                    <p style="color: #f8f9fa;">Wan wan藝廊，綻放你的創造力。讓藝術點綴你的生活，追求最極致的藝術體驗！</p>

                </div>
                <div class='col-md-4 text-left'>
                    <h4 style="color: #ad8304;">連結</h4>
                    <ul >
                        <li><a href='index.php' style="color: #f8f9fa;">首頁</a></li>
                        <li><a href='exhibition.php' style="color: #f8f9fa;">展覽活動</a></li>
                        <li><a href='artwork.php' style="color: #f8f9fa;">藝術作品</a></li>
                    </ul>
                    <ul>
                        <li><a href='newticket.php' style="color: #f8f9fa;">購票服務</a></li>
                        <li><a href='login.php' style="color: #f8f9fa;">會員中心</a></li>

                    </ul>

                </div>
                <div class='col-md-4 text-left'>
                    <h4 style="color: #ad8304;">聯絡我們</h4>
                    <p style="color: #f8f9fa;">Address: 高雄市楠梓區高雄大學路700號<br>
                        Phone: (07) 591 9000<br>
                        Email: <a href='wanwanart123@gmail.com'>wanwanart123@gmail.com</a>
                    </p>
                </div>
                
            </div>

        </div>
    </footer>
    <a href="index.php" class="back-to-top">
    <i class="fa-regular fa-circle-up" style="color: #7e4730;"></i>
    </a>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        var backToTopButton = document.querySelector(".back-to-top");
    
        window.addEventListener("scroll", function() {
        if (window.pageYOffset > 200) {
            backToTopButton.classList.add("show");
        } else {
            backToTopButton.classList.remove("show");
        }
        });
    
        backToTopButton.addEventListener("click", function(e) {
        e.preventDefault();
        window.scrollTo({ top: 0, behavior: "smooth" });
        });
    });
    </script>
    </body>

</html>


<link rel="stylesheet" href="artwork_detail.css?v=<?=time()?>">

<?php
$artwork_ID = $_GET['artwork_ID'];
$link = mysqli_connect('localhost', 'root', 'phpproject', 'wanwan');
mysqli_set_charset($link, "utf8");

$SQL = "SELECT * FROM artwork WHERE artwork_ID='$artwork_ID'";
if ($result = mysqli_query($link, $SQL)) {
  $row = mysqli_fetch_assoc($result);
  $artwork_name = $row['artwork_name'];
  $artwork_file = $row['artwork_file'];
  $artwork_information = $row['artwork_information_html'];
}
?>

<style>
#background-section {
  background-image: url('<?php echo $artwork_file; ?>');
  display: flex;
  background-size: cover;
  justify-content: center;
  align-items: center;
  height: 100vh;
  /* 添加其他相關樣式設定 */
}
</style>

<script type="text/javascript">
function goBack() {
  window.history.go(-1);
}
</script>
<?php
echo"<section id='background-section'>";
echo"<div class='container'>";
echo "<b><font size='6' class=product>作品介紹</font></b>";
    echo"<div class='info-container'>";
        echo"<div class='artwork-intro'>";
            echo"<div class='artwork-image' style='display: inline-block; vertical-align: top;'>";
                echo "<IMG SRC='".$artwork_file."'></IMG>";
            echo "</div>";
            echo"<div class='artwork-details' style='display: inline-block; vertical-align: top;'>";
                echo "<text>";
                    echo "<div class=text_content>";
                        echo "作品名稱:".$artwork_name;
                        for($n=1;$n<=10;$n++){
                        echo "</br>";
                        }
                        echo "作品描述:";
                            echo "<div class=text_block>";
                            echo $artwork_information;
                            echo "</div>";
                    echo "</div>";
                echo "</text>";
            echo "</div>";
        echo "</div>";
    echo "</div>";
echo "</div>";
echo "<input type='button' value='返回' onclick='goBack()' id='div'>";
echo"</section>";
echo "</div>";
echo "</br>";
?>

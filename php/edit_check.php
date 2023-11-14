<?php $user_ID=$_POST['user_ID']; ?>
<script type="text/javascript">
function goBack(){
    var value=1;
    var user_ID="<?php echo $user_ID; ?>";
    location.href="edit.php?value="+value+"&user_ID="+user_ID;
}

function click(){
    let div=document.getElementById("div");
    div.click();
}
</script>
<?php
$link=mysqli_connect('localhost','root','phpproject','wanwan');
mysqli_set_charset($link,"utf8");
$user_name=$_POST['user_name'];
$Bio=$_POST['Bio'];
$email=$_POST['email'];
$role=$_POST['role'];

if(@!empty($_FILES["myfile"]["tmp_name"])){
    copy($_FILES["myfile"]["tmp_name"],$_FILES['myfile']['name']);
    unlink($_FILES["myfile"]["tmp_name"]);
    $icon=$_FILES['myfile']['name'];
    $SQL="UPDATE uuser SET user_icon='$icon' WHERE user_ID='$user_ID'";
    if($result=mysqli_query($link,$SQL)){
    }
}
$SQL="SELECT * FROM uuser WHERE user_email='$email'";
$result=mysqli_query($link,$SQL);
$row=mysqli_fetch_assoc($result);
if($row['user_email']==$email && $user_ID!=$row['user_ID']){
    echo "<input type='hidden' value='返回' onclick='goBack()' id='div'>";
    echo "<script type='text/javascript'>click();</script>";
}
else{
    $SQL="UPDATE uuser SET user_name='$user_name' , user_introduce='$Bio', user_email='$email', user_role='$role', user_introduce_html='".nl2br(strip_tags($Bio))."' WHERE user_ID='$user_ID'";

    if($result=mysqli_query($link,$SQL)){
        header("location:artist.php");
    }
}
?>

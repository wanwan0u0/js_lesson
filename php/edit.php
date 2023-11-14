<?php
if(isset($_GET['value'])){
    $value=$_GET['value'];
}
$user_ID=$_GET['user_ID'];
$link=mysqli_connect('localhost','root','phpproject','wanwan');
mysqli_set_charset($link,"utf8");

$SQL="SELECT * FROM uuser WHERE user_ID=$user_ID";
if($result=mysqli_query($link,$SQL)){
    $row=mysqli_fetch_assoc($result);
    $name=$row['user_name'];
    $bio=$row['user_introduce'];
    $email=$row['user_email'];
    $role=$row['user_role'];
}

echo "<h1>Edit profile</h1>";
echo "<form action='edit_check.php' method='post' enctype='multipart/form-data'>";
echo "icon:</br>";
echo "<input type='file' name='myfile' accept='image/png'></br>";
echo "Username:</br>";
echo "<input type='text' name='user_name' value='".$name."'><p></p>";
echo "email:</br>";
if(@$value==1){
    echo "<input type='text' name='email' 'required='required'><p></p>";
    echo"<font color='red'>該email已被註冊</font></br>";
}
else{
    echo "<input type='text' name='email' value= '".$email."'required='required'><p></p>";
}
echo "role:</br>";
if($role=='artist'){
    echo "<input type='radio' name='role' value='collector' >collector";
    echo "<input type='radio' name='role' value='artist' checked='checked'>artist<p></p>";
}
else{
    echo "<input type='radio' name='role' value='collector' checked='checked'>collector";
    echo "<input type='radio' name='role' value='artist' >artist<p></p>";
}
echo "<h1>About</h1>";
echo "<HR width=89% color='#dddddd'>";
echo "Bio:</br>";
echo "<textarea name='Bio' cols='50' rows='10' >";
echo $bio;
echo "</textarea></br>";
echo "<input type='hidden' name='user_ID' value='".$user_ID."'><p></p>";
echo "<input type='submit'>";
?>

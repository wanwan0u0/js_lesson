<html>
<head>
<meta charset="utf-8">
<title>表單</title>
</head>
<body>

<form method="post" action="result.php">

請輸入你的id:<input type="text" name="id"></br>
請輸入你的密碼:<input type="text" name="pwd"></br>
請選擇你的性別:
男<input type="radio" name="gender" value="male">
女<input type="radio" name="gender" value="female"></br>
請選擇你的興趣:
<input type="checkbox" name="interest[]" value="swim" >游泳
<input type="checkbox" name="interest[]" value="ball">打球
<input type="checkbox" name="interest[]" value="sleep">睡覺
</p>
請選擇你居住的城市:
<select name="city[]" multiple>
<option value="taipei">Taipei
<option value="taichung">Tachung
<option value="kaohusing">Kaohusing
</select></br>
<textarea name="comment" cols="10" rows="10">
</textarea>
<input type="submit"> <input type="reset">
</form>

</body>
</html>
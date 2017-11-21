<html>
<head>
<meta charset=utf-8" />
<title>mission_1-6.php</title>
</head>
<body>
<form action="mission_1-6.php" method="post">
  <input type="text" name="comment"/>
  <input type="submit"/><br/>
<?php
$fp = fopen('write.txt', 'a');
// fputs($fp,$comment);//直接データを受け取ることはできない？
$data = $_POST["comment"];
fputs($fp,$data.PHP_EOL);
fclose($fp);
?>
</form>
</body>
</html>
<html>
<head>
<meta charset=utf-8" />
<title>mission_1-5.php</title>
</head>
<body>
<form action="mission_1-5.php" method="post">
  <input type="text" name="comment"/>
  <input type="submit"/><br/>
<?php
$fp = fopen('write.txt', 'w');
// fputs($fp,$comment);//���ڃf�[�^���󂯎�邱�Ƃ͂ł��Ȃ��H
$data = $_POST["comment"];
fputs($fp,$data);
fclose($fp);
?>
</form>
</body>
</html>
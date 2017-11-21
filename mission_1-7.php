<html>
<head>
<meta charset=utf-8" />
<title>mission_1-7.php</title>
</head>
<body>
<?php
$file_name = "write.txt";
$ret_array = file($file_name);
for($i=0; $i<count($ret_array); ++$i){
echo($ret_array[$i]."<br/>\n");
}
?>
</body>
</html>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>mission_2-1</title>
</head>
<body>
名前とコメントを入力して送信できます。<br/>
<div style="border-style: solid ; border-width: 1px; width: 450px; border-color: #c9c9c9;">
<form action="mission_2-2.php" method="post">
　<input type ="text" name ="name" placeholder="名前"/><br/>
　<textarea name="comment" cols="50" rows="5" placeholder="コメント"></textarea>
<input type ="submit">
</from>
<?php echo $_POST["name"] ?><br/>
<?php echo $_POST["comment"] ?><br/>
</div>

</body>
</html>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>mission_2-3</title>
</head>
<body>
名前とコメントを入力して送信できます。<br/>
<div style="border-style: solid ; border-width: 1px; width: 450px; border-color: #c9c9c9;">
<form action="mission_2-2.php" method="post">
　名前:<input type ="text" name ="name"><br/>
　コメント:<textarea name="comment" cols="50" rows="5"></textarea>
<input type ="submit">
</from>
</div>
<?php
$lines = file('write2.txt');//テキストファイルを配列に格納
$c = count($lines);//配列の要素数をカウント

//explodeで配列に格納
for($i=0; $i<$c; $i++){

$boards = explode("<>",$lines[$i]);
$amount = substr_count($lines[$i],"<>"); //<>の個数を取得
//echo "$amount";
//echo nl2br("\n");

$change = $change + $amount;//これまで読み込んだ配列に登場した<>の個数を数える
for($j=0;$j<count($boards);$j++){//$boardsの中身を表示
echo "$boards[$j] ";
}

if($change % 3 == 0){//もし<>が3の倍数回登場していれば改行する
echo nl2br("\n");
}

echo nl2br("\n");//配列一段目の表示が終われば改行


}


/*for($j=0; $j<4;$j++){
echo "$boards[$j]";
}
}*/
?>


</body>
</html>

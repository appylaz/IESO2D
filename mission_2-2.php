<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>mission_2-2</title>
</head>
<body>

</div>
<?php

header('Location: http://co-715.it.99sv-coco.com/mission_2-3.php');


//入力項目をテキストファイルへ書き込む（M2-2）
if($_POST['name'] != "" and $_POST['comment'] != "" and $_POST['md'] == ""){

 $today = getdate();
 $Comment = $_POST['comment'];
 $Name = $_POST['name'];
 $filename = 'write2.txt';

//投稿番号の計算
$lines = file('write2.txt');//テキストファイルを配列に格納
$c = count($lines);//配列の要素数をカウント

if($c == 0){
$ln = 0;

}else{

//explodeで配列に格納
  for($i=0; $i<$c; $i++){

  $amount = substr_count($lines[$i],"<>"); //<>の個数を取得
if($amount ==2 or $amount == 3){
  $boards = explode("<>",$lines[$i]);
  $ln = $boards[0];
  }


  }
}

/*
 echo "分岐成功";
 $sdfile = file_get_contents('write2.txt'); //ファイの中身を格納
 echo substr_count($sdfile,"<>"); //<>の個数を探してその値を返す

 $amount = substr_count($sdfile,"<>"); //<>の個数を取得
 //echo "$amount"; 
 //echo nl2br("\n");

 $last = $amount / 3; //最終投稿番の取得号
 //echo "$last";
 //echo nl2br("\n");

 $count = $last + 1; //最終投稿番号に1を加える
 //echo "$count";
 //echo nl2br("\n");
*/

//ファイルにデータを書き込む
 $count = $ln +1;
 $fp = fopen($filename, 'a');
 fputs($fp,$count."<>".$Name."<>".$Comment."<>".$today[year].$today[mon].$today[mday].$today[hours].$today[minutes].$today[seconds].PHP_EOL);
 fclose($fp);


 /*echo "送信完了しました";
 echo nl2br("\n"); 
 print '<pre>';
 print_r( $today ); //gettimeofdayの配列情報を全て出力
 print "</pre>\n";*/

}//M2-2終了


?>

</body>
</html>

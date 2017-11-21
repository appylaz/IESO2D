<?php
if($_POST['edit'] != ""){

//----------------------パスワードを取得--------------------------------------------------
$lines = file('MS26.txt');//テキストファイルを配列に格納
$c = count($lines);//配列の要素数をカウント
$edinum = $_POST["edit"];
$amount =0;
$change =0;
$edif = 0;//delfの初期値は0

for($i=0; $i<$c; $i++){

$boards = explode("<>",$lines[$i]);
$amount = substr_count($lines[$i],"<>"); //<>の個数を取得
$change = $change + $amount;//これまで読み込んだ配列に登場した<>の個数を数える

//削除番号と照らし合わせる。
if($boards[0] == $edinum or $edif == 1){  //$delf==1もしくは$boards[0]==削除番号なら$i番目に<>を$amount個書き込む。
$flag = $change % 5; //現在の<>合計数が5の倍数かどうか

//現在の行末までの<>の累計が5で割れなかった場合、次の行もフラグを立てる
if($flag == 0){//$flag != 0ならば$delf=1,==ならば$del=0

$edif=0;

}else{

$edif=1;

}

switch ($amount){
case 2:
//現在の行構成number<>name<>comment
  break;
case 3:
//現在の行構成comment<>time<>password<>
  $passcheck = $boards[2];
  break;
case 5:
//現在の行構成number<>name<>comment<>time<>password<>
  $passcheck = $boards[4];  
  break;
case NULL:
//現在の行構成comment
  break;
default:
  break;
}

}

}
//---------------password取得完了-----------------------------------------------------------
$epass = $_POST['edipass'];
if($passcheck == $epass){

$lines = file('MS26.txt');
$c = count($lines);//配列の要素数をカウント
$amount =0;
$edif = 0;
$reedit = array();
$vcomment = array();

//explodeで配列に格納
for($i=0; $i<$c; $i++){
$boards = explode("<>",$lines[$i]);
$amount = substr_count($lines[$i],"<>"); //<>の個数を取得
$change = $change + $amount;//これまで読み込んだ配列に登場した<>の個数を数える

if($boards[0] == $edinum or $edif == 1){
$flag = $change % 5;

if($flag == 0){
$edif = 0;
}else{
$edif = 1;
}

switch ($amount){
case 2:
  //現在の行構成number<>name<>comment
  array_push ($reedit,$boards[0]);  
  array_push ($reedit,$boards[1]);
  array_push ($reedit,$boards[2]); 
  break;
case 3:
  //現在の行構成comment<>time<>password<>
  array_push ($reedit,$boards[0]);
  array_push ($reedit,$boards[1]);
  array_push ($reedit,$boards[2]);
  break;
case 5:
  //現在の行構成number<>name<>comment<>time<>password<>
  array_push ($reedit,$boards[0]);  
  array_push ($reedit,$boards[1]); 
  array_push ($reedit,$boards[2]); 
  array_push ($reedit,$boards[3]); 
  array_push ($reedit,$boards[4]); 
  break;
case NULL:
  //現在の行構成comment
  array_push ($reedit,$boards[0]); 
  break;
default:
  break;
}//switch閉

}//if閉 $reeditへの編集部分の値格納終了

}//for閉

$d = count($reedit);//配列の要素数を計算
$e = $d - 4;//コメントが格納されている部分の要素数

for($j=0; $j<$e; $j++){
$vcomment[$j] = $reedit[$j +2]; //コメント部分だけを配列に抽出
}
$avc = count($vcomment);
$hedinum = $edinum;
}

}//if閉



?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>mission_2-6</title>

</head>
<body>
<h1>簡易掲示板</h1>
<div style="border-style: solid ; border-width: 1px; width: 450px; border-color: #c9c9c9;">


<h2>投稿フォーム</h2>
<form action="mission_2-6_ex.php" method="post">
<input type ="text" name ="name" placeholder="名前" value="<?php echo $reedit[1];?>"/><br/>
<textarea name="comment" cols="50" rows="5" placeholder="コメント">
<?php 
for($k=0; $k<$avc; $k++){
echo $vcomment[$k];
}
 ?>
</textarea>
<input type ="text" name ="password" placeholder="パスワード"/><br/>
<input type="hidden" name="md" value="<?php echo $hedinum;?>"/>
<input type ="submit"/>
</form>

<h2>削除フォーム</h2>
<form action="mission_2-6_ex.php" method="post">
<input type ="text" name ="delete" placeholder="削除番号"/><br/>
<input type ="text" name ="delpass" placeholder="パスワード"/><br/>
<input type ="submit"/>
</form>

<h2>編集フォーム</h2>
<form action="mission_2-6.php" method="post">
<input type ="text" name ="edit" placeholder="編集番号"/><br/>
<input type ="text" name ="edipass" placeholder="パスワード"/><br/>
<input type ="submit"/>
</form>

</div>

<?php

//表示処理
$lines = file('MS26.txt');//テキストファイルを配列に格納
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

if($change % 5 == 0){//もし<>が3の倍数回登場していれば改行する
echo nl2br("\n");
}

echo nl2br("\n");//配列一段目の表示が終われば改行


}
/*echo $edinum;
echo nl2br("\n");
print "送信された内容は{$_POST['md']}です。<br/>";
*/
?>
</body>
</html>
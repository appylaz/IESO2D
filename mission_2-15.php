<?php
/*-----------------------データベースへの接続----------------------------------------------------------------------------------------*/
//DSN
$dsn = 'データベース名';

//ユーザー名
$username = 'ユーザー名';

//パスワード
$password = 'パスワード';


//フラグ(全て初期値０)
$Sflg0 = 0;//投稿フラグ
$Sflg1 = 0;
$Sflg2 = 0;
$Sflg3 = 0;
$Slfg4 = 0;

$Dflg0 = 0;//削除フラグ

$PEflg0 = 0;//編集準備フラグ

$Eflg0 = 0;//編集フラグ
$Eflg0 = 1;
$Eflg0 = 2;
$Eflg0 = 3;

//フォーム入力内容の格納
$name = $_POST['fname'];
$comment =$_POST['fcomment'];
$pass = $_POST['fpass'];
$date = new DateTime(); 
//その他の要素
$id = 1;//初期値
$time = $date->format('Y-m-d H:i:s');


//var_dump($_POST['fname']);
//var_dump($_POST['fcomment']);
        
	
//入力状態の確認（パスワード以外のすべての値が入力されているときのみ1）
if($_POST['fname'] != "" and $_POST['fcomment'] != "" and $_POST['md'] == ""){$Sflg0 = 1;}//モードチェンジなし、両方入力
if($_POST['fname'] != "" and $_POST['fcomment'] == "" and $_POST['md'] == ""){$Sflg1 = 1;}//モードチェンジなし、nameのみ入力
if($_POST['fname'] == "" and $_POST['fcomment'] != "" and $_POST['md'] == ""){$Sflg2 = 1;}//モードチェンジなし、commentのみ入力
if($_POST['fname'] == "" and $_POST['fcomment'] == "" and $_POST['md'] == ""){$Sflg3 = 1;}//モードチェンジなし、両方未入力
if($_POST['fpass'] != "" ){$Sflg4 = 1;}//パスワード入力

if($_POST['fdelete'] != ""){$Dflg0 = 1;}

if($_POST['fedit'] != ""){$EPflg0 = 1;}
//if($_POST['fname'] != "" and $_POST['fcomment'] != "" and $_POST['md'] != ""){$flg3 = 1;}

if($_POST['fname'] != "" and $_POST['fcomment'] != "" and $_POST['md'] != ""){$Eflg0 = 1;}//モードチェンジあり、両方入力
if($_POST['fname'] != "" and $_POST['fcomment'] == "" and $_POST['md'] != ""){$Eflg1 = 1;}//モードチェンジあり、nameのみ入力
if($_POST['fname'] == "" and $_POST['fcomment'] != "" and $_POST['md'] != ""){$Eflg2 = 1;}//モードチェンジあり、commentのみ入力
if($_POST['fname'] == "" and $_POST['fcomment'] == "" and $_POST['md'] != ""){$Eflg3 = 1;}//モードチェンジあり、両方未入力

//フラグ状況確認
/*var_dump($flg0);
echo nl2br("\n");
var_dump($flg1);
echo nl2br("\n");
var_dump($flg2);
echo nl2br("\n");
var_dump($flg3);
echo nl2br("\n");*/
	
try{
		
	$pdo = new PDO($dsn, $username, $password);
	$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);//setAttributeで属性設定を行う。引数は(設定の属性,設定内容)
	//print('接続に成功しました。<br>');
	$tbl_name = 'Bb';

}catch (PDOException $e){
	echo $sql."<br>".$e->getMessage();
}

/*-----------------------------------------編集準備------------------------------------------------------------------------------------------- */
if($PEflg0 == 1){
	
	//パスワードの取得
	$num = $_POST['fedit'];
	$sql5 = "SELECT * FROM $tbl_name WHERE id =:id";
	if($res5 =$pdo->prepare($sql5)){
		$res5->bindValue(':id',$num,PDO::PARAM_INT);
		$res5->execute();
		while($re5 = $res5->fetch(PDO::FETCH_ASSOC)){
			//echo $re3[pass];
			$passcheck = $re5[pass];
			if($passcheck == $_POST['fedipass']){
				$rename = $re5[name];
				$recomment = $re5[comment];
			}else{
				echo "パスワードが違います";
			}
		}
	}
}/*else if($PEflg0 != 1 and $_POST["esub"]){
	echo "編集フォームが未入力です";
	echo nl2br("\n");
}*/

/*----------------------接続完了------------------------------------------------------------------------------------------------------*/			
?>


<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>mission_2-15</title>
	</head>
	<body>
	<script>
	function SDC(){
	flag = confirm("削除してもよろしいですか？");
		if (flag==true){
			return flag;
		}else{
			alert("削除を取消しました");
			return flag;
		}
	}
	
	function E1(){
	
	alert("コメント未入力です");
	}

	</script>
	<h1>簡易掲示板</h1>
	・各フォーム、全ての項目が必須入力です。
	<h2>投稿フォーム</h2>
	<form action="mission_2-15.php" method="post">
	<input type ="text" name ="fname" placeholder="名前" value="<?php echo $rename;?>"/><br/>
	<textarea name="fcomment" cols="50" rows="5" placeholder="コメント" ><?php echo $recomment; ?></textarea><br/>
	<input type ="text" name ="fpass" placeholder="パスワード"/><br/>
	<input type="hidden" name="md" value="<?php echo $num;?>"/>
	<input type ="submit" name = "ssub"/>
	</form>
	
	<h2>削除フォーム</h2>
	<form action="mission_2-15.php" method="post" onsubmit="return SDC()">
	<input type ="text" name ="fdelete" placeholder="削除番号"/><br/>
	<input type ="text" name ="fdelpass" placeholder="パスワード"/><br/>
	<input type ="submit" name = "dsub"/>
	</form>
	
	<h2>編集フォーム</h2>
	<form action="mission_2-15.php" method="post">
	<input type ="text" name ="fedit" placeholder="編集番号"/><br/>
	<input type ="text" name ="fedipass" placeholder="パスワード"/><br/>
	<input type ="submit" name = "esub"/>
	</form>
        <?php




/*-----------------投稿処理----------------------------------------------------------------------------------------------*/
	if(Sflg4 == 1){		
		if($Sflg0 == 1){
			//echo "番号取得開始";			
			//番号取得
			$sql0 =sprintf("SELECT * FROM $tbl_name order by id");
			if($res0 = $pdo->query($sql0)){
      				while($re0 = $res0->fetch(PDO::FETCH_ASSOC)){
					
					$cid = $re0[id];
      					//echo $cid;
					$id = $cid +1;
				}
			}
			
		//挿入する値のチェック
		/*var_dump($id);
		echo nl2br("\n");
		var_dump($name);
		echo nl2br("\n");
		var_dump($comment);
		echo nl2br("\n");
		var_dump($time);
		echo nl2br("\n");
		var_dump($pass);*/
		
			//データベースに値を挿入
			$sql1 ="INSERT INTO $tbl_name (id,name,comment,time,pass) VALUES (:id,:name,:comment,:time,:pass) ";
			
			if($res1 = $pdo->prepare($sql1)){
				$res1->bindValue(':id',$id,PDO::PARAM_INT);
				$res1->bindParam(':name',$name,PDO::PARAM_STR);
				$res1->bindParam(':comment',$comment,PDO::PARAM_STR);
				$res1->bindParam(':time',$time,PDO::PARAM_STR);
				$res1->bindParam(':pass',$pass,PDO::PARAM_STR);
				$res1->execute();
				
			}else{
				echo 'エラーが発生してますよ！！';
				
			}
			
		}else if($_POST["ssub"] and $Sflg1 == 1){
			echo "コメントが未入力です";
			echo nl2br("\n");
		}else if($_POST["ssub"] and $Sflg2 == 1){
			echo "名前が未入力です";
			echo nl2br("\n");
		}else if($_POST["ssub"] and $Sflg3 == 1){
			echo "名前とコメントが未入力です";
			echo nl2br("\n");
		}
	}else if($_POST["ssub"] and $Sflg4 !=1){
		echo "パスワードを入力してください";
		echo nl2br("\n");
	}
/*-----------------------削除処理-------------------------------------------------------------------------------------*/	
	if($Dflg0 == 1){
	
		$num = $_POST['fdelete'];//指定番号
		$delpass = $_POST['fdelpass'];//パスワード
	
		//パスワードの取得
		$sql3 = "SELECT * FROM $tbl_name WHERE id =:id";
		if($res3 =$pdo->prepare($sql3)){
			$res3->bindValue(':id',$num,PDO::PARAM_INT);
			$res3->execute();
			while($re3 = $res3->fetch(PDO::FETCH_ASSOC)){
				//echo $re3[pass];
				$passcheck = $re3[pass];		
			}
		}
				
		//入力パスワードどデータベースのパスワードを表示
		//var_dump($passcheck);
		//echo nl2br("\n");
		//var_dump($delpass);
		//echo nl2br("\n");
		
		if($passcheck == $delpass or $passcheck == "" ){
			//データを削除
			$sql4 ="DELETE FROM $tbl_name WHERE id =:id ";//idが:idなら削除
			if($res4 =$pdo->prepare($sql4)){
				$res4->bindValue(':id',$num,PDO::PARAM_INT);
				$res4->execute();
			}
		
		}else{
			echo "パスワードが違います";
		}
	
	}else if($Dflg0 != 1 and $_POST["dsub"]){
		echo "削除フォームが未入力です";
		echo nl2br("\n");
	}
	
/*--------------------------編集処理----------------------------------------------------------------------------------*/
	if(Eflg0 == 1){
		
		$num = $_POST['md'];
	    	$sql6 ="UPDATE $tbl_name SET name=:name,comment=:comment,time=:time,pass=:pass WHERE id =:id ";//idが:idならcommentを:commentに書き換え
	    	if($res6 =$pdo->prepare($sql6)){
			
			$res6->bindValue(':id',$num,PDO::PARAM_INT);
			$res6->bindParam(':name',$name,PDO::PARAM_STR);
			$res6->bindParam(':comment',$comment,PDO::PARAM_STR);
			$res6->bindParam(':time',$time,PDO::PARAM_STR);
			$res6->bindParam(':pass',$pass,PDO::PARAM_STR);
		}
	    	$res6->execute();        
	}else if($_POST["ssub"] and $Eflg1 == 1){
		echo "コメントが未入力です";
		echo nl2br("\n");
	}else if($_POST["ssub"] and $Eflg2 == 1){
		echo "名前が未入力です";
		echo nl2br("\n");
	}else if($_POST["ssub"] and $Eflg3 == 1){
		echo "名前とコメントが未入力です";
		echo nl2br("\n");
	}
	
	if($PEflg0 != 1 and $_POST["esub"]){
	echo "編集フォームが未入力です";
	echo nl2br("\n");
	}
/*--------------------------表示処理----------------------------------------------------------------------------------*/
	$sql2 = "SELECT * FROM $tbl_name order by id";
	if($res2 = $pdo->query($sql2)){
        	while($re2 = $res2->fetch(PDO::FETCH_ASSOC)){
			
			echo $re2[id]." ".$re2[name]." ".$re2[time];
       			echo nl2br("\n");
			echo nl2br($re2[comment]);
			//echo ('<pre>');
			//echo $re2[comment];
			//echo ('</pre>');
			echo nl2br("\n");
			echo nl2br("\n");
		}
	}
	

	?>
	
	</body>
</html>

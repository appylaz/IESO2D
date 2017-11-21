<?php
session_start();
if($_SESSION['login']!= true){
header('Location: http://co-715.it.99sv-coco.com/mission_3-7.php');//loginがtrueでないならログイン画面に飛ばす
exit;
}
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


//フォーム入力内容の格納
$name = $_SESSION['name'];
$comment =$_POST['fcomment'];
$pass = $_SESSION['pass'];
$date = new DateTime(); 
//その他の要素
$no = 1;//初期値
$time = $date->format('Y-m-d H:i:s');
/*--------------------------------------使用者の表示---------------------------------------*/

echo "現在[".$name."]としてログインしています";
	
//入力状態の確認（パスワード以外のすべての値が入力されているときのみ1）
if($_POST['fcomment'] != "" and $_POST['md'] == ""){$Sflg0 = 1;}//モードチェンジなし、入力
if($_POST['fcomment'] == "" and $_POST['md'] == ""){$Sflg1 = 1;}//モードチェンジなし、未入力


if($_POST['fdelete'] != ""){$Dflg0 = 1;}

if($_POST['fedit'] != ""){$PEflg0 = 1;}
//if($_POST['fname'] != "" and $_POST['fcomment'] != "" and $_POST['md'] != ""){$flg3 = 1;}

if($_POST['fcomment'] != "" and $_POST['md'] != ""){$Eflg0 = 1;}//モードチェンジあり、入力
if($_POST['fcomment'] == "" and $_POST['md'] != ""){$Eflg1 = 1;}//モードチェンジあり、未入力


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
	

}catch (PDOException $e){
	echo $sql."<br>".$e->getMessage();
}

/*-----------------------------------------編集準備------------------------------------------------------------------------------------------- */

if($_POST['fedit'] != ""){
	//パスワードの取得
	$num = $_POST['fedit'];
	$sql5 = "SELECT * FROM mboard WHERE no =:no";
	if($res5 =$pdo->prepare($sql5)){
		$res5->bindValue(':no',$num,PDO::PARAM_INT);
		$res5->execute();
		while($re5 = $res5->fetch(PDO::FETCH_ASSOC)){
			//echo $re3[pass];
			$passcheck = $re5[pass];
			if($passcheck == $pass){
				$recomment = $re5[comment];
			}else{
				//echo "あなたの投稿ではありません。";
				echo '<script type="text/javascript">alert("あなたの投稿ではありません");</script>';
			}
		}
	}
}else if($_POST['fedit'] == "" and $_POST["esub"]){
			//echo "編集したい番号を指定してください。";
			echo '<script type="text/javascript">alert("編集したい番号を指定してください");</script>';
			//echo nl2br("\n");
}

/*else if($PEflg0 != 1 and $_POST["esub"]){
	echo "編集フォームが未入力です";
	echo nl2br("\n");
}*/

/*----------------------接続完了------------------------------------------------------------------------------------------------------*/			
?>


<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>mission_3-8</title>
	</head>
	<body>
	
	<a href="http://co-715.it.99sv-coco.com/mission_3-7_2.php">ログアウト</a>
	
	
	
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
	<form action="" method="post" enctype ="multipart/form-data">
	<input type="hidden" name="MAX_FILE_SIZE" value="20000000" />
	<textarea name="fcomment" cols="50" rows="5" placeholder="コメント" ><?php echo $recomment; ?></textarea><br/>
	<input type="hidden" name="md" value="<?php echo $num;?>"/>
	<input type ="file" name="upfile" accept="video/*,image/*"/>
	<input type ="submit" name = "ssub"/>
	</form>
	
	<h2>削除フォーム</h2>
	<form action="" method="post" onsubmit="return SDC()">
	<input type ="text" name ="fdelete" placeholder="削除番号"/><br/>
	<input type ="submit" name = "dsub"/>
	</form>
	
	<h2>編集フォーム</h2>
	<form action="" method="post">
	<input type ="text" name ="fedit" placeholder="編集番号"/><br/>
	<input type ="submit" name = "esub"/>
	</form>
	
	
	
	
        <?php
	
	


/*-----------------投稿処理----------------------------------------------------------------------------------------------*/
		
		
		//番号取得
		$sql0 =sprintf("SELECT * FROM mboard order by no");
		if($res0 = $pdo->query($sql0)){
      			while($re0 = $res0->fetch(PDO::FETCH_ASSOC)){
				
				$cno = $re0[no];
      				//echo $cno;
				$no = $cno +1;
			}
		}
		
		//mboard
		if($_POST['fcomment'] != "" and $_POST['md'] == ""){
			//echo "番号取得開始";			
			
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
			$sql1 ="INSERT INTO mboard (no,name,comment,time,pass) VALUES (:no,:name,:comment,:time,:pass) ";
			
			if($res1 = $pdo->prepare($sql1)){
				$res1->bindValue(':no',$no,PDO::PARAM_INT);
				$res1->bindParam(':name',$name,PDO::PARAM_STR);
				$res1->bindParam(':comment',$comment,PDO::PARAM_STR);
				$res1->bindParam(':time',$time,PDO::PARAM_STR);
				$res1->bindParam(':pass',$pass,PDO::PARAM_STR);
				$res1->execute();
				
			}else{
				echo 'エラーが発生してますよ！！';
				
			}
			
		}else if($_POST['fcomment'] == "" and $_POST['md'] == "" and $_POST["ssub"]){
			//echo "コメントが未入力です";
			//echo nl2br("\n");
			echo '<script type="text/javascript">alert("コメントが未入力です");</script>';
		}

		
		
		//sfile
		$error = $_FILES['upfile']['error'];
		$img = $_FILES['upfile']['tmp_name'];//一時的保存ファイル名、終了と同時に削除
		$img_path = $_FILES['upfile']['name'];//ファイル名
		$ext = pathinfo($img_path,PATHINFO_EXTENSION);//ファイル名から拡張子を取得
		$contents = file_get_contents($img);
		
		 /*//一字ファイルができているか（アップロードされているか）チェック
    		if(is_uploaded_file($_FILES['upfile']['tmp_name'])){

	        	//一字ファイルを保存ファイルにコピーできたか
	        	if(move_uploaded_file($_FILES['upfile']['tmp_name'],"./".$_FILES['upfile']['name'])){
	
	            	//正常
				echo "uploaded";
	
			}else{

	            	//コピーに失敗（だいたい、ディレクトリがないか、パーミッションエラー）
				echo "error while saving.";
			}

		}else{

		        //そもそもファイルが来ていない。
			echo "file not uploaded.";

		}*/
	
		if($_FILES['upfile']['tmp_name'] != "" and $_POST['md'] == "" and $_POST["ssub"]){
		//ファイル情報をデータベースに格納

			//データベースに格納
			$sql7 ="INSERT INTO sfile (no,ext,contents) VALUES (:no,:ext,:contents) ";
					
			if($res7 = $pdo->prepare($sql7)){
				$res7->bindValue(':no',$no,PDO::PARAM_INT);
				$res7->bindParam(':ext',$ext,PDO::PARAM_STR);
				$res7->bindParam(':contents',$contents,PDO::PARAM_STR);
				$res7->execute();
						
			}else{
				echo 'エラー';
					
			}
		}
		
/*-----------------------削除処理-------------------------------------------------------------------------------------*/	
		if($_POST['fdelete'] != ""){
	
			$num = $_POST['fdelete'];//指定番号
			$delpass = $pass;//パスワード
			
			//パスワードの取得
			$sql3 = "SELECT * FROM mboard WHERE no =:no";
			if($res3 =$pdo->prepare($sql3)){
				$res3->bindValue(':no',$num,PDO::PARAM_INT);
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
		
			if($passcheck == $delpass){
				//データを削除
				$sql4 ="DELETE FROM mboard WHERE no =:no ";//idが:idなら削除
				if($res4 =$pdo->prepare($sql4)){
					$res4->bindValue(':no',$num,PDO::PARAM_INT);
					$res4->execute();
				}
				
				
				$sql9 ="DELETE FROM sfile WHERE no =:no ";//idが:idなら削除
				if($res9 =$pdo->prepare($sql9)){
					$res9->bindValue(':no',$num,PDO::PARAM_INT);
					$res9->execute();
				}
				
			}else{
				//echo "あなたの投稿ではありません。";
				echo '<script type="text/javascript">alert("あなたの投稿ではありません");</script>';
			}
		
		}else if($_POST['fdelete'] == "" and $_POST["dsub"]){
			echo "削除したい番号を指定してください。";
			echo nl2br("\n");
		}
	
/*--------------------------編集処理----------------------------------------------------------------------------------*/
		if($_POST['fcomment'] != "" and $_POST['md'] != ""){
			$num = $_POST['md'];
		    	$sql6 ="UPDATE mboard SET name=:name,comment=:comment,time=:time,pass=:pass WHERE no =:no ";//noが:noならcommentを:commentに書き換え
		    	if($res6 =$pdo->prepare($sql6)){
				
				$res6->bindValue(':no',$num,PDO::PARAM_INT);
				$res6->bindParam(':name',$name,PDO::PARAM_STR);
				$res6->bindParam(':comment',$comment,PDO::PARAM_STR);
				$res6->bindParam(':time',$time,PDO::PARAM_STR);
				$res6->bindParam(':pass',$pass,PDO::PARAM_STR);
			}
		    	$res6->execute();   
			
			if($_FILES['upfile']['tmp_name'] != ""){
				
				$sql10 ="UPDATE sfile SET ext=:ext,contents=:contents WHERE no =:no ";//noが:noなら書き換え
		    		if($res10 =$pdo->prepare($sql10)){
					
					$res10->bindValue(':no',$num,PDO::PARAM_INT);
					$res10->bindParam(':ext',$ext,PDO::PARAM_STR);
					$res10->bindParam(':contents',$contents,PDO::PARAM_STR);
				}
			    	$res10->execute();   
			}
				
				
				
				
		}else if($_POST["ssub"] and $_POST['fcomment'] == "" and $_POST['md'] != ""){
			//echo "コメントが未入力です";
			//echo nl2br("\n");
			echo '<script type="text/javascript">alert("コメントが未入力です");</script>';
		}
		
/*--------------------------表示処理----------------------------------------------------------------------------------*/
		//mboardの中身を表示
		$sql2 = "SELECT * FROM mboard order by no";
		if($res2 = $pdo->query($sql2)){
	        	while($re2 = $res2->fetch(PDO::FETCH_ASSOC)){
				
				echo $re2[no]." ".$re2[name]." ".$re2[time];
	       			echo nl2br("\n");
				echo nl2br($re2[comment]);
				//echo ('<pre>');
				//echo $re2[comment];
				//echo ('</pre>');
				echo nl2br("\n");
				echo nl2br("\n");
				
				//投稿番号に連動してsfileの拡張子を取得
				$no = $re2[no];
				$sql8 = "SELECT * FROM sfile WHERE no = :no";
				if($res8=$pdo->prepare($sql8)){
					$res8->bindValue(':no',$no,PDO::PARAM_INT);
					$res8->execute();
					$re8 = $res8->fetch(PDO::FETCH_ASSOC);
					$ext = $re8[ext];
					echo nl2br("\n");
					
				}	
				
				//ファイルを表示
				if($ext == "jpeg" or $ext == "jpg" or $ext == "png" or $ext == "bmp" or $ext == "gif"){
					//print("<img src=\"img.php?no=" . $no . "\" width=\"193\" height=\"130\">");
					print("<img src=\"img.php?no=" . $no . "\" width=\"193\" height=\"130\"></img>");
				}else if($ext == "mp4"){
					print("<video src=\"img.php?no=" . $no . "\" width=\"193\" height=\"130\" controls></video>");
					$ext =="";
				}else if($ext == ""){
				}
				echo nl2br("\n");
			}
		}
		
				
	?>
	
	</body>
</html>

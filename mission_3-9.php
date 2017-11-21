<?php
/*-----------------------データベースへの接続----------------------------------------------------------------------------------------*/
//DSN
$dsn = 'データベース名';

//ユーザー名
$username = 'ユーザー名';

//パスワード
$password = 'パスワード';

try{
		
	$pdo = new PDO($dsn, $username, $password);
	$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);//setAttributeで属性設定を行う。引数は(設定の属性,設定内容)
	//print('接続に成功しました。<br>');

}catch (PDOException $e){
	echo $sql."<br>".$e->getMessage();
}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>mission_3-9</title>
	</head>
	<body>
		
	
	<h1>ユーザー登録</h1>
	・全ての項目が必須入力です。<br/>
	・パスワードは確認のためもう一度入力してください。<br/>
	
	<form action="mission_3-9.php" method="post">
	<input type ="text" name ="user_name" placeholder="名前" value=""/><br/>
	<input type="password" name="user_pass" size="16" placeholder="パスワード" maxlength="8"/><br/>
	<input type="password" name="user_repass" size="16" placeholder="パスワード再入力" maxlength="8"/><br/>
	<input type="text" name="mail" placeholder="メールアドレス"/><br/>
	<input type ="submit" name = "rsub" value = "入力内容を送信" />
	</form>
	
	<?php
		
		//ユーザー定義関数
		
		
			//ランダムなＩＤを生成する関数
		function makeRandid(){
			// 生成に使用する英数字を代入
		$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJLKMNOPQRSTUVWXYZ0123456789';
		
			// 変数の初期化
		$id ='';
		
			// 繰り返し処理でランダムに文字列を生成(8文字)
		for ($i = 0; $i < 8; $i++){
		$id .= $chars[mt_rand(0, 61)];//.=は結合代入演算子
		}
		
			// 生成された文字列を返す
		return $id;
		}
		
		
		
		
		//フィールド
		$name = $_POST['user_name'];
		$pass = $_POST['user_pass'];
		$repass = $_POST['user_repass'];
		$regi = 0;
		
		/*echo "$name";
		echo nl2br("\n");
		echo "$pass";
		echo nl2br("\n");
		echo "$repass";
		echo nl2br("\n");*/
		
		
		
		
		
/*------------------------------------------ID比較部分-----------------------------------------------------------*/
		//メールのURLパラメータから、登録されたIDの情報を探して登録状況をアップデート
		if($_GET['mid'] != ""){
			$mid = $_GET['mid'];
			$regi = 1;
			echo $mid;
			$sql1 ="UPDATE yboard SET regi=:regi WHERE id =:id ";//noが:noならcommentを:commentに書き換え
		    	if($res1 =$pdo->prepare($sql1)){
				
				$res1->bindParam(':id',$mid,PDO::PARAM_STR);
				$res1->bindValue(':regi',$regi,PDO::PARAM_INT);
			}
		    	$res1->execute();   
			
			//本登録フラグの読み出し
			$sql2 = "SELECT * FROM yboard ";
			if($res2 =$pdo->prepare($sql2)){
				$res2->execute();
				while($re2 = $res2->fetch(PDO::FETCH_ASSOC)){
					$Cregi = $re2[regi];
					$id = $re2[id];
				}
			}
		}
		
		
		//本登録フラグを用いて、本登録できているか確認、できたら確認画面へ飛ばす
		if($Cregi == 1){
		
			//echo '<script type="text/javascript">alert("本登録完了しました");</script>';
			session_start();
			$_SESSION['regi'] = $Cregi;
			$_SESSION['id'] = $id;
			header('Location: http://co-715.it.99sv-coco.com/mission_3-6_1.php');
			exit();
		}
		
/*-------------------------------------------ID生成部分-----------------------------------------------------------*/
		if($_POST["rsub"]){
				
			if($_POST['user_name'] == ""){
				
				//echo "名前を入力してください";
				echo '<script type="text/javascript">alert("名前を入力してください");</script>';
				
			}else if($_POST['user_pass'] == ""){
				
				//echo "パスワードを入力してください";
				echo '<script type="text/javascript">alert("パスワードを入力してください");</script>';
				
			}else if($_POST['user_repass'] == ""){
				
				//echo "パスワードを再度入力してください";
				echo '<script type="text/javascript">alert("パスワードを再度入力してください");</script>';
				
			}else if($_POST['user_pass'] != $_POST['user_repass']){
			
				//echo "パスワードが一致しません";
				echo '<script type="text/javascript">alert("パスワードが一致しません");</script>';
					
			}else if($_POST['user_pass'] == $_POST['user_repass'] and $_POST['user_name'] != ""){
				
				/*echo '<script type="text/javascript">checkRegist();</script>';
				$C = '<script type="text/javascript">document.write(check);</script>';
				$F = '<script type="text/javascript">document.write(Fcheck);</script>';
				$T = '<script type="text/javascript">document.write(Tcheck);</script>';
				var_dump($C);
				var_dump($F);
				var_dump($T);*/
				$id = makeRandid();
				//echo "idが生成されました";
				//echo nl2br("\n");
				//echo $id;
				//echo nl2br("\n");
			
				$tbl_name = 'yboard';
					//データベースに値を挿入
				$sql0 ="INSERT INTO $tbl_name (id,name,pass,regi) VALUES (:id,:name,:pass,:regi) ";
			
				if($res0 = $pdo->prepare($sql0)){
					$res0->bindParam(':id',$id,PDO::PARAM_STR);
					$res0->bindParam(':name',$name,PDO::PARAM_STR);
					$res0->bindParam(':pass',$pass,PDO::PARAM_STR);
					$res0->bindValue(':regi',$regi,PDO::PARAM_INT);
					$res0->execute();
					
					
				}
				
				
				//仮登録完了メールの送信
				mb_language("Japanese");
				mb_internal_encoding("UTF-8");

				$to      = $_POST['mail'];
				$subject = "簡易掲示板の仮登録が完了のお知らせ";
				$message = "$name"."様簡易掲示板の仮登録が完了しました。\n".
				           "以下のURLから本登録を済ませてください。\n".
				           "http://co-715.it.99sv-coco.com/mission_3-9.php?mid=$id\n";
				
				//$headers = 'From: from@hoge.co.jp' . "\r\n";

				mb_send_mail($to, $subject, $message);
				
			}
		}
		
		
		
		
		//echo '<script type="text/javascript">alert("指定の文字数を超えています。");</script>';
	?>
	<a href="http://co-715.it.99sv-coco.com/mission_3-7.php">既に登録済みの方はこちら</a>
	</body>
</html>

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
		<title>mission_3-7</title>
	</head>
	<body>
	

	<h1>ユーザーログイン</h1>

	
	<form action="mission_3-7.php" method="post">
	<input type ="text" name ="user_id" placeholder="ID" value=""/><br/>
	<input type="password" name="user_pass" size="16" placeholder="パスワード" maxlength="8"/><br/>
	<input type ="submit" name = "rsub" value = "送信" />
	</form>
	
	<?php
	
	session_start();
	if($_SESSION['login'] != true ){
		
		if($_POST["rsub"]){
			
			$c=0;//idが一致したかどうかのための変数　idが一致している場合、インクリメントされる
			$id=$_POST['user_id'];
			$pass=$_POST['user_pass'];
			//echo "ID:".$id."/pass:".$pass;
			
			
			
			
			//DBからIDに対応するパスワードを取り出す
			$tbl_name = 'yboard';
			$sql0 = "SELECT * FROM $tbl_name WHERE id =:id";
			
			if($res0 = $pdo->prepare($sql0)){
				$res0->bindParam(':id',$id,PDO::PARAM_STR);
				$res0->execute();
	        		while($re0 = $res0->fetch(PDO::FETCH_ASSOC)){
					$dbid = $re0[id];
					$dbpass = $re0[pass];
					$dbname = $re0[name];
					$dbregi = $re0[regi];
					$c++;
				}
			}
			
			
			//パスワードが取り出せたかどうか（IDが存在したかどうか）判定
			if($c == 0){
				echo '<script type="text/javascript">alert("入力されたIDは存在しません。");</script>';
							
			}else{
			
				//パスワードが一致したかどうか判定
				if($dbpass == $pass){
					if($dbregi == 1){
						$_SESSION['login'] = true;//セッション変数においてloginにtrueを代入
						$_SESSION['pass'] = $dbpass; //セッション変数にパスワードを代入
						$_SESSION['name'] = $dbname;//セッション変数に名前を代入
						$_SESSION['id'] = $dbid;//セッション変数にIDを代入
					
					
						header('Location: http://co-715.it.99sv-coco.com/mission_3-7.php');//loginがtrueの時、3-7をもう一度実行すると全ての処理がスキップ
					}else{
						
						echo '<script type="text/javascript">alert("本登録が完了していません。");</script>';
					}
						
				}else{
					echo '<script type="text/javascript">alert("パスワードが一致しません。");</script>';
				}
				
				
				
				
				
				
			}
		
		}
		
	}else{
		header('Location: http://co-715.it.99sv-coco.com/mission_3-8.php');//loginがtrueの時、3-7をもう一度実行すると全ての処理がスキップ
		//echo "ログイン完了";
	
	}
	?>
	
	
	<a href="http://co-715.it.99sv-coco.com/mission_3-9.php">まだ登録がお済でない方はこちら</a>
	</body>
</html>

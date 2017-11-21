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
		<title>mission_3-6</title>
	</head>
	<body>
	
	<?php
	session_start();
	//echo $_SESSION['id'] ;
	$id = $_SESSION['id'];
	$regi = $_SESSION['regi'];
	unset($_SESSION['id']);
	unset($_SESSION['regi']);
	echo $regi;
	if($regi == 1){
		echo '<script type="text/javascript">alert("本登録完了しました");</script>';
		$tbl_name = 'yboard';
		$sql0 = "SELECT * FROM $tbl_name WHERE id =:id";
		if($res0 = $pdo->prepare($sql0)){
			$res0->bindValue(':id',$id,PDO::PARAM_STR);
			$res0->execute();
        		while($re0 = $res0->fetch(PDO::FETCH_ASSOC)){
				
				echo "ID:".$re0[id];
	       			echo nl2br("\n");
				echo "名前:".$re0[name];
				echo nl2br("\n");
				echo "パスワード:".$re0[pass];
				echo nl2br("\n");
				echo "上記の内容で登録しました";
				echo nl2br("\n");
			}
		}
	
		// セッション変数を全て解除する
		$_SESSION = array();
		// セッションクッキーを削除する。:クライアント側のセッションID
		if (isset($_COOKIE["PHPSESSID"])) {
			setcookie("PHPSESSID", '', time()-42000, '/');
		}
		// 最終的にセッションを破壊する:サーバー側のセッションID
		session_destroy();
	}	
	
	?>
	<a href="http://co-715.it.99sv-coco.com/mission_3-7.php">ログイン画面へ</a>
	</body>
</html>

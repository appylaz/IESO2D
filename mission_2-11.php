<?php
//データベースへの接続
//DSN
$dsn = 'データベース名';

//ユーザー名
$username = 'ユーザー名';

//パスワード
$password = 'パスワード';

try{

    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);//setAttributeで属性設定を行う。引数は(設定の属性,設定内容)
    print('接続に成功しました。<br>');
    
    $num = '3';
    $tbl_name = 'test_tbl';
    $sql ="INSERT INTO $tbl_name (id,comment) VALUES (:id,:comment) ";
    if($res = $pdo->prepare($sql)){
    $res->bindValue(':id',$num,PDO::PARAM_INT);
    $res->bindParam(':comment',$comment,PDO::PARAM_STR);
    /*$num ='1'; なぜ数字は後から代入されていないのか？*/
    $comment ='テスト入力3';
    $res->execute();

    }else{
    
    echo 'エラーが発生してますよ！！';

    }        

}catch (PDOException $e){
    echo $sql."<br>".$e->getMessage();
}

?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>mission_2-11</title>
	</head>
	<body>
	</body>
</html>

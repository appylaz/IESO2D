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
    $sql ="CREATE table IF NOT EXISTS mboard(
        id VARCHAR(16) NOT NULL,
        name VARCHAR(32) NOT NULL,
	comment text NOT NULL,
	time VARCHAR(32) NOT NULL,
        pass VARCHAR(32));" ;
        $pdo->exec($sql);
        print("Created Table.\n");

}catch (PDOException $e){
    echo $sql."<br>".$e->getMessage();
}

?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>mission_2-8</title>
	</head>
	<body>
	</body>
</html>

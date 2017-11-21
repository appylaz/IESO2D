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
    
    //テーブル表示
    $sql = 'SHOW TABLES';//シングルクォーテーションのくせに文字列が何故か関数的に扱われる
    $result = $pdo->query($sql);
    
    if (!$result) {
    echo "DB Error, could not list tables\n";
    echo 'MySQL Error: ' . mysql_error();
    exit;
    }
    
    while($re = $result->fetch(PDO::FETCH_ASSOC)){
        echo('<pre>');
        var_dump($re); 
        echo('</pre>');   // $re は配列。echo では表示できない
    }

}catch (PDOException $e){
    echo $sql."<br>".$e->getMessage();
}

?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>mission_2-9</title>
	</head>
	<body>
	</body>
</html>

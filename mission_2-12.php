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

//データを表示
    //セレクトでテーブルのデータを選択
    $tbl_name ='mboard';
    $sql = "SELECT * FROM $tbl_name";
    if($res = $pdo->query($sql)){
        while($re = $res->fetch(PDO::FETCH_ASSOC)){
    
        echo('<pre>');
        var_dump($re);
        echo('</pre>');
    
        }

    }else{
    
    echo "エラーが発生してますよ！！";
    
    }

}catch (PDOException $e){
    echo $sql."<br>".$e->getMessage();
}

?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>mission_2-12</title>
	</head>
	<body>
	</body>
</html>

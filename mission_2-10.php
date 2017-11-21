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
  /*$sql1 = 'SHOW TABLES';//シングルクォーテーションのくせに文字列が何故か関数的に扱われる
    $res1 = $pdo->query($sql);


    if (!$res1) {
    echo "DB Error, could not list tables\n";
    echo 'MySQL Error: ' . mysql_error();
    exit;
    }

    while($re = $result->fetch(PDO::FETCH_ASSOC)){
        var_dump($re);    // $re は配列。echo では表示できない
    }*/
    
    $tbl_name = 'Bb';
    $sql2 = "SHOW CREATE TABLE {$tbl_name}";//シングルクォーテーションのくせに文字列が何故か関数的に扱われる
    $res2= $pdo->query($sql2);
    
    if (!$res2) {
    echo "DB Error, could not list tables\n";
    echo 'MySQL Error: ' . mysql_error();
    exit;
    }
    
    while($re2 = $res2->fetch(PDO::FETCH_ASSOC)){

        echo('<pre>');
        var_dump($re2); 
        echo('</pre>');   
                           // $re は配列。echo では表示できない
    }
    

}catch (PDOException $e){
    echo $sql."<br>".$e->getMessage();
}

?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>mission_2-10</title>
	</head>
	<body>
	</body>
</html>

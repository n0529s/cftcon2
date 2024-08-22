<?php

session_start();
$userid = $_SESSION['userid'];
$username = $_SESSION['username'];
$gen_name = $_SESSION['gen_name'];

$floor_id = $_GET["id"];

var_dump($floor_id);


//1. 接続します
require_once('funcs.php');
$pdo = db_conn();





// ３．SQL文を用意(データ登録：INSERT)
$stmt = $pdo->prepare(
  "SELECT * FROM floor where id = :floor_id"
);

// 4. バインド変数を用意
$stmt->bindValue(':floor_id', $floor_id, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)




// 5. 実行
$status = $stmt->execute();
if($status==false) {
  //execute（SQL実行時にエラーがある場合）
  $error = $stmt->errorInfo();
  exit("ErrorQuery:".$error[2]);
}else{
//Selectデータの数だけ自動でループしてくれる
//FETCH_ASSOC=http://php.net/manual/ja/pdostatement.fetch.php
  while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){ 
      //GETデータ送信リンク作成
      // <a>で囲う。
      
        $floor_num = $result['floor_num'];
        $floor_height = $result['floor_height'];
    
      
      }
  
};

?>




<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width">
<script src="js/jquery-2.1.3.min.js"></script>
<link rel="stylesheet" href="css/main.css" />
<link href="css/bootstrap.min.css" rel="stylesheet">
<style>div{padding: 10px;font-size:16px;}</style>
<title>フロア入力</title>
</head>
<body>

<header style="position: fixed;width:100%;z-index: 9999;">
  <nav class="navbar navbar-default" style="background:linear-gradient(to bottom, #8EA9DB 70%, #D9EAFF 100%); border-color:#305496;font-size:15px;display:flex;justify-content:space-between;">
    <div class="container-fluid"><p style="font-size: 20px;color:#E2EFDA;font-weight: bold;">CFTコンクリート施工管理システム</p></div>
    <div>
      <a class="navbar-brand" href="genba.php">現場選択</a>
      <a class="navbar-brand" href="sekkei.php">設計入力</a>
      <p>LoginID:<?= $userid ?></p>
  </div>
    </div>
  </nav>

</header>



<p style="height:100px;"></p>
<p style="font-size:20px;">現場名：<?= $gen_name ?></p>
<h3>フロア設定修正</h3>


<form name="form1" action="floor_update.php" method="post" style="font-size:14px;width:800px;">
 <div style="display: flex; justify-content:flex-start;margin:5px;">
 <p style="font-size:20px;margin:10px;">フロア番号：</p>
 <input type="text" name="floor_num" style="margin:10px;Width:100px;" value=<?= $floor_num ?> />
 <p style="font-size:20px;margin:10px;">　フロア高さ：</p>
 <input type="text" name="floor_height" style="margin:10px;Width:100px;" value=<?= $floor_height ?> />
 <p style="font-size:20px;margin:10px;">mm</p>
 <input style="font-size:20px;margin:10px;" type="submit" value="登録" />
 </div>

 <input type="hidden" name="id" value="<?= $floor_id ?>" />
 <input type="hidden" name="gen_name" value="<?= $gen_name ?>" />

</form>





 </body>
</html>


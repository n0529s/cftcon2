<?php

session_start();
$userid = $_SESSION['userid'];
$username = $_SESSION['username'];
$gen_name = $_SESSION['gen_name'];

$id = $_GET["id"];




//1. 接続します
require_once('funcs.php');
$pdo = db_conn();





// ３．SQL文を用意(データ登録：INSERT)
$stmt = $pdo->prepare(
  "SELECT * FROM pillcrossspec where id = :id"
);

// 4. バインド変数を用意
$stmt->bindValue(':id', $id, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)




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
        $gr_name = $result['gr_name'];
        $pill_crossnum = $result['pill_crossnum'];
        $pillsize_x = $result['pillsize_x'];
        $pillsize_y = $result['pillsize_y'];
        $thickness = $result['thickness'];
        $mouth = $result['mouth'];
        $sumiR = $result['sumiR'];
        $cs_area = $result['cs_area'];

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
<title>設計入力</title>
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
<h3>断面修正</h3>

<form name="form1" action="crossspec_update.php" method="post" style="font-size:14px;">
    <div style="display: flex;justify-content:flex-start;margin:5px;width:600px;">
        <p style="font-size:20px;margin:10px;">断面名:</p>
        <input type="text" name="pill_crossnum" style="margin:10px;width:200px;" value=<?= $pill_crossnum ?> />
    </div>
    <div style="display: flex; justify-content:flex-start;margin:10px;width:600px;">
        <p style="font-size:20px;margin:10px;">X寸法:</p>
        <input type="text" name="pillsize_x" style="margin:10px;width:100px;" value=<?= $pillsize_x ?> />
        <p style="font-size:14px;margin:10px;">mm</p>
        <p style="font-size:20px;margin:10px;"> Y寸法:</p>
        <input type="text" name="pillsize_y" style="margin:10px;width:100px;" value=<?= $pillsize_y ?> />
        <p style="font-size:14px;margin:10px;">mm</p>
    </div>
    <div style="display: flex; justify-content:flex-start;margin:10px;width:600px;">
        <p style="font-size:20px;margin:10px;">肉 厚:</p>
        <input type="text" name="thickness" style="margin:10px;width:100px"  value=<?= $thickness ?> />
          <p style="font-size:14px;margin:10px;">mm</p>
        <p style="font-size:20px;margin:10px;">開口径:</p>
        <input type="text" name="mouth" style="margin:10px;width:100px" value=<?= $mouth ?> /><br>
        <p style="font-size:14px;margin:10px;">mm</p>
      </div>
      <div style="display: flex; justify-content:flex-start;margin:10px;width:600px;">
        <p style="font-size:20px;margin:10px;">隅部曲率半径R:</p>
        <input type="text" name="sumiR" style="margin:10px;width:100px" value=<?= $sumiR ?> /><br>
        <p style="font-size:14px;margin:10px;">mm</p>
        <p style="font-size:20px;margin:10px;">断面積S:</p>
        <input type="text" name="cs_area" style="margin:10px;width:100px" value=<?= $cs_area ?> /><br>
        <p style="font-size:14px;margin:10px;">m2</p>

        <input type="hidden" name="id" value="<?= $id ?>" />
        <input type="hidden" name="gr_name" value="<?= $gr_name ?>" />
      
      <input style="margin-left:30px;" type="submit" value="修正"/>
      </div>
 </form>





 </body>
</html>


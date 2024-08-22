<?php

//SESSIONスタート
session_start();
$userid = $_SESSION['userid'];
$username = $_SESSION['username'];
$gen_name = $_SESSION['gen_name'];


require_once('funcs.php');
//ログインチェック
// loginCheck();
$pdo = db_conn();





// フロア情報抽出
$stmt = $pdo->prepare("select * from floor where gen_name = :gen_name");
$stmt->bindValue(':gen_name', $gen_name, PDO::PARAM_STR);
$status = $stmt->execute();

// var_dump($status);

$view_floor = "<tr style='background: #BDD7EE;color:#833C0C;'><th width:5%;>フロア番号</th><th width:5%;>フロア高</th><th width:20%;>修正</th><th width:20%;>削除</th></tr>";

$total_height=0;


if($status==false) {
  //execute（SQL実行時にエラーがある場合）
  $error = $stmt->errorInfo();
  exit("ErrorQuery:".$error[2]);
}
else{
//Selectデータの数だけ自動でループしてくれる
//FETCH_ASSOC=http://php.net/manual/ja/pdostatement.fetch.php
  while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){ 
      //GETデータ送信リンク作成
      // <a>で囲う。
      $view_floor .= '<tr><td>'.$result['floor_num'].'</td>';
      $view_floor .= '<td>'.$result['floor_height'].'</td>';
      $total_height = $total_height+$result['floor_height']/1000;


      $view_floor .= '<td id="ss"><a href=floor_ss.php?id='.$result['id'].'>修正</td>';
      $view_floor .= '<td id="aa"><a href=floor_aa.php?id='.$result['id'].'>削除</td>';
      $view_floor .= '</tr>';




      
  }

};

// var_dump($result['gen_name']);

?>




<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width">
<link rel="stylesheet" href="css/main.css" />
<link href="css/bootstrap.min.css" rel="stylesheet">
<style>div{padding: 10px;font-size:16px;}</style>
<title>フロア入力</title>
</head>
<body>

<header style="position: fixed;width:100%;z-index: 9999;">
  <nav class="navbar navbar-default" style="background:linear-gradient(to bottom, #8EA9DB 70%, #D9EAFF 100%); border-color:#305496;font-size:15px;display:flex;justify-content:space-between;">
    <div class="container-fluid"><p style="font-size: 24px;color:#E2EFDA;font-weight: bold;">CFTコンクリート施工管理システム</p></div>
    <div>
      <a class="navbar-brand" href="login.php">TOPページ</a>
      <p>LoginID:<?= $userid ?></p>
  </div>
    </div>
  </nav>
</header>



<p style="height:100px;"></p>
<p style="font-size:20px;">現場名：<?= $gen_name ?></p>
<h3>フロア設定</h3>

<form name="form1" action="floor_act.php" method="post" style="font-size:14px;width:800px;">
 <div style="display: flex; justify-content:flex-start;margin:5px;">
 <p style="font-size:20px;margin:10px;">フロア番号：</p>
 <input type="text" name="floor_num" style="margin:10px;Width:100px;"/>
 <p style="font-size:20px;margin:10px;">　フロア高さ：</p>
 <input type="text" name="floor_height" style="margin:10px;Width:100px;"/>
 <p style="font-size:20px;margin:10px;">mm</p>
 <input style="font-size:20px;margin:10px;" type="submit" value="登録" />
 </div>
</form>


 <div style="display: flex; justify-content:flex-start;margin:5px;">
 <p style="margin-left:20px; margin-bottom:0px;">柱高さ：</p>
 <?= $total_height ?>
 </div>

 <p style="margin-left:20px; margin-bottom:0px;">フロア設定登録値</p>
<table style="font-size: 12px;width: 600px;margin-left:20px; margin-bottom:0px;">
 <?= $view_floor ?>
</table>

<input type="button" onclick="location.href='./sekkei.php'" value="設計入力に戻る" style='coler:white; border-color:#3b82f6;color:white; font-size:18px;margin:10px; background:#8EA9DB; border-radius:10px;'>
 <input type="button" onclick="location.href='./pillvirtispec.php'" value="柱符号設定画面へ" style='coler:white; border-color:#3b82f6;color:white; font-size:18px;margin:10px; background:#8EA9DB; border-radius:10px;'>


</body>
</html>
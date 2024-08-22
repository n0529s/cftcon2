<?php

//SESSIONスタート
session_start();
$userid = $_SESSION['userid'];
$username = $_SESSION['username'];
$gen_name = $_SESSION['gen_name'];
// var_dump($gen_name);
require_once('funcs.php');
//ログインチェック
// loginCheck();
$pdo = db_conn();

// 現場経歴一覧取得_emp_idで抽出
$stmt = $pdo->prepare("select * from gen where 1");
// $stmt->bindValue();
$status = $stmt->execute();

// var_dump($status);

$select = '<select name="gen" id="genselect" style="height: 28px;"><option value="">-</option>';



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
      $select .= '<option value="'.$result['id'].'">'.$result['gen_name'].'</option>';
      
  }
$select .= '</select> <br>';
}

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
<title>設計入力</title>
</head>
<body>

<header style="position: fixed;width:100%;z-index: 9999;">
  <nav class="navbar navbar-default" style="background:linear-gradient(to bottom, #8EA9DB 70%, #D9EAFF 100%); border-color:#305496;font-size:15px;display:flex;justify-content:space-between;">
    <div class="container-fluid"><p style="font-size: 20px;color:#E2EFDA;font-weight: bold;">CFTコンクリート施工管理システム</p></div>
    <div>
      <a class="navbar-brand" href="genba.php">現場選択</a>
      <p>LoginID:<?= $userid ?></p>
  </div>
    </div>
  </nav>
</header>



<p style="height:100px;"></p>

<p style="font-size:20px;">現場名：<?= $gen_name ?></p>
<h3>施工管理設定</h3>

<form name="form1" action="constandard.php" method="post" style="font-size:14px;">
<div style="display: flex; justify-content:space-around;margin:10px;width:400px;">
 <p style="font-size:20px;width:250px;">①受入検査基準値設定</p>
 <input stile="margin:10px;" type="submit" value="入力へ" />
 </div>
 </form>

 <form name="form1" action="conmanege.php" method="post" style="font-size:14px;">
 <div style="display: flex; justify-content:space-around;margin:10px;width:400px;">
 <p style="font-size:20px;width:250px">②Con仕様・プラント設定</p>
 <input stile="margin:10px;" type="submit" value="入力へ" />
 </div>
 </form>


 
 <input type="button" onclick="location.href='./menu2.php'" value="メニュー画面へ" style='coler:white; border-color:#3b82f6;color:white; font-size:18px;margin:10px; background:#8EA9DB; border-radius:10px;'>




</body>
</html>
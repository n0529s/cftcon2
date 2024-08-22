<?php

//SESSIONスタート
session_start();
$userid = $_SESSION['userid'];
$username = $_SESSION['username'];
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
<title>現場選択</title>
</head>
<body>

<header style="position: fixed;width:100%;z-index: 9999;">
  <nav class="navbar navbar-default" style="background:linear-gradient(to bottom, #8EA9DB 70%, #D9EAFF 100%); border-color:#305496;font-size:15px;display:flex;justify-content:space-between;">
    <div class="container-fluid"><p style="font-size: 20px;color:#E2EFDA;font-weight: bold;">CFTコンクリート施工管理システム</p></div>
    <div>
      <a class="navbar-brand" href="login.php">ログアウト</a>
      <p>LoginID:<?= $userid ?></p>
  </div>
    </div>
  </nav>
</header>



<p style="height:100px;"></p>

<!-- lLOGINogin_act.php は認証処理用のPHPです。 -->
<form name="form1" action="menu.php" method="post" style="font-size:14px;">
<h3 style="margin-left:10px;">現場選択</h3>
<div style="display: flex; justify-content:space-between;margin:10px;width:600px;">
 <p>◆現場選択：</p> <?= $select ?><br>
 <input style="coler:white; border-color:#3b82f6;color:white; font-size:18px;margin-right:30px;padding:10px 20px; background:#8EA9DB; border-radius:10px;" type="submit" value="メニュー画面へ" />
 </div>


 
 </form>


 <form name="form1" action="genba_act.php" method="post" style="font-size:14px; margin-left:10px;">
<h3>◆新規現場登録</h3><br>
<div>
 　現 場 名  ：　　<input type="text" name="gen_name"><br>
 </div>
<div>
 　工事コード：　<input type="text" name="gen_code"><br>
 </div>
<div>
 　住　 所   ：　　<input type="text" name="gen_address"><br>
 </div>

<input type="submit" value="登録" />


</form>




</body>
</html>
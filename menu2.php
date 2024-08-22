<?php

//SESSIONスタート
session_start();
$userid = $_SESSION['userid'];
$username = $_SESSION['username'];
$gen_name = $_SESSION['gen_name'];





// require_once('funcs.php');
// //ログインチェック
// // loginCheck();
// $pdo = db_conn();

// // 現場経歴一覧取得_emp_idで抽出
// $stmt = $pdo->prepare("select * from gen where id=$genid");
// // $stmt->bindValue();
// $status = $stmt->execute();

// //4．データ表示
// if ($status == false) {
//     sql_error($status);
// } else {
//     $result = $stmt->fetch();//ここを追記！！
// }

// $gen_name = $result["gen_name"];
// $_SESSION["gen_name"] = $gen_name;

?>










<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width">
<link rel="stylesheet" href="css/main.css" />
<link href="css/bootstrap.min.css" rel="stylesheet">
<style>div{padding: 10px;font-size:16px;}</style>
<title>メニュー画面</title>
</head>
<body>

<header style="position: fixed;width:100%;z-index: 9999;">
  <nav class="navbar navbar-default" style="background:linear-gradient(to bottom, #8EA9DB 70%, #D9EAFF 100%); border-color:#305496;font-size:15px;display:flex;justify-content:space-between;">
    <div class="container-fluid"><p style="font-size:30px;px;color:#E2EFDA;font-weight: bold;">CFTコンクリート施工管理システム</p></div>
    <div>
      <a class="navbar-brand" href="genba.php">現場選択</a>
      <p>LoginID:<?= $userid ?></p>
  </div>
    </div>
  </nav>
</header>



<p style="height:100px;"></p>

<!-- lLOGINogin_act.php は認証処理用のPHPです。 -->

<h3>メニュー画面</h3>
 <p style="font-size:20px;">現場名：<?= $gen_name ?></p>

<div style="display: flex; justify-content:space-between; width:400px">
  <form name="form1" action="sekkei.php" method="post" style="font-size:14px;">
  <input style="coler:white; border-color:#3b82f6;color:white; font-size:18px;margin-right:30px;padding:10px 20px; background:#8EA9DB; border-radius:10px;" type="submit" value="設計値入力" />
  </form>

  <form name="form1" action="sekoukanri.php" method="post" style="font-size:14px;">
  <input style="coler:white; border-color:#3b82f6;color:white; font-size:18px;margin-right:30px;padding:10px 20px; background:#8EA9DB; border-radius:10px;" type="submit" value="施工管理値入力" />
  </form>


  <form name="form1" action="pillselect.php" method="post" style="font-size:14px;">
  <input style="coler:white; border-color:#3b82f6;color:white; font-size:18px;margin-right:30px;padding:10px 20px; background:#8EA9DB; border-radius:10px;" type="submit" value="施工管理画面へ" />
  </form>
</div>


</body>
</html>
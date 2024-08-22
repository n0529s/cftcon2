<?php

session_start();
$userid = $_SESSION['userid'];
$username = $_SESSION['username'];
$gen_name = $_SESSION['gen_name'];

$stcore_id = $_GET["id"];

var_dump($stcore_id);


//1. 接続します
require_once('funcs.php');
$pdo = db_conn();





// ３．SQL文を用意(データ登録：INSERT)
$stmt = $pdo->prepare(
  "SELECT * FROM stcore where stcore_id = :stcore_id"
);

// 4. バインド変数を用意
$stmt->bindValue(':stcore_id', $stcore_id, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)




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
      
        $stcore_num = $result['stcore_num'];
        $stcore_coordineate = $result['stcore_coordineate'];
      

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
<h3>通り芯設定</h3>

<form name="form2" action="core_update.php" method="post" style="font-size:14px;">
<div style="margin:10px;width:400px;">
 <p style="font-size:20px;">通り芯修正</p>
 <select name="axle" style='coler:white; border-color:#3b82f6;color:white; font-size:18px;margin:10px; background:#8EA9DB; border-radius:10px;'>
     <option value="X">X軸</option>
     <option value="Y">Y軸</option>
     </select><br>
<div style="display:flex; align-items:center;">
 通り芯名：　<input type="text" name="stcore_num" style="margin:10px;" value=<?= $stcore_num ?> />
 </div>
 <div style="display:flex; align-items:center;">
 芯間距離：　<input type="text" name="stcore_coordineate" style="margin:10px;" value=<?= $stcore_coordineate ?> />mm<br>
</div>
 <input stile="margin:10px;" type="submit" value="修正" />
 
 <input type="hidden" name="stcore_id" value="<?= $stcore_id ?>" />
 <input type="hidden" name="gen_name" value="<?= $gen_name ?>" />
</form>





 </body>
</html>


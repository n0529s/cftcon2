<?php

//SESSIONスタート
session_start();
$userid = $_SESSION['userid'];
$username = $_SESSION['username'];
$gen_name = $_SESSION['gen_name'];

$gr_name = $_POST['gr_name'];
$gr_name2 = $_SESSION["gr_name2"];
$pill_crossnum = $_POST["pill_crossnum"];
$pillsize_x = $_POST["pillsize_x"];
$pillsize_y = $_POST["pillsize_y"];
$thickness = $_POST["thickness"];
$mouth = $_POST['mouth'];
$sumiR = $_POST['sumiR'];

if($sumiR =="on" ){
  $sumiR2 = 2.5 * $thickness; 
}else{
  $sumiR2 =" ";
}


if($gr_name == ""){
  $gr_name = $gr_name2;
}





var_dump($sumiR);
var_dump($sumiR2);

require_once('funcs.php');
//ログインチェック 
// loginCheck();
$pdo = db_conn();

if($sumiR == "on"){
  $cs_area1 = (($pillsize_x - ($thickness*2))/1000 * ($pillsize_y - ($thickness*2))/1000);
  $cs_area_sumi = (($sumiR2-$thickness)/1000)*(($sumiR2-$thickness)/1000)*4;
  $cs_area_sumi2 =((($sumiR2-$thickness)/1000*2))*((($sumiR2-$thickness)/1000*2))*3.14/4*180/360;

  $cs_area_total = $cs_area1 - $cs_area_sumi + $cs_area_sumi2;
  $cs_area = round($cs_area_total, 4); 
  
}else{
  $cs_area1 = (($pillsize_x - ($thickness*2))/1000 * ($pillsize_y - ($thickness*2))/1000);
  $cs_area = round($cs_area1, 4);

}



// var_dump($cs_area1);
// var_dump($cs_area_sumi);
// var_dump($cs_area_sumi2);

?>




<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width">
<link rel="stylesheet" href="css/main.css" />
<link href="css/bootstrap.min.css" rel="stylesheet">
<style>div{padding: 10px;font-size:16px;}</style>
<title>断面入力</title>
</head>
<body>

<header style="position: fixed;width:100%;z-index: 9999;">
  <nav class="navbar navbar-default" style="background:linear-gradient(to bottom, #8EA9DB 70%, #D9EAFF 100%); border-color:#305496;font-size:15px;display:flex;justify-content:space-between;">
    <div class="container-fluid"><p style="font-size: 20px;color:#E2EFDA;font-weight: bold;">CFTコンクリート施工管理システム</p></div>
    <div>
      <a class="navbar-brand" href="login.php">TOPページ</a>
      <p>LoginID:<?= $userid ?></p>
  </div>
    </div>
  </nav>
</header>



<p style="height:100px;"></p>

<p style="font-size:20px;">現場名：<?= $gen_name ?></p>
<h3>断面設定</h3>

<form name="form1" action="crossspec_act.php" method="post" style="font-size:14px;">
    <div style="display: flex;justify-content:flex-start;margin:5px;width:600px;">
        <p style="font-size:20px;margin:10px;">グループ名:</p>

        <input type="text" name="gr_name" style="margin:10px;width:200px;" value=<?= $gr_name ?> />
      
    </div>

   

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
        <input type="text" name="thickness" style="margin:10px;width:100px" value=<?= $thickness ?> />
          <p style="font-size:14px;margin:10px;">mm</p>
        <p style="font-size:20px;margin:10px;">開口径:</p>
        <input type="text" name="mouth" style="margin:10px;width:100px" value=<?= $mouth ?> /><br>
        <p style="font-size:14px;margin:10px;">mm</p>
      </div>
      <div style="display: flex; justify-content:flex-start;margin:10px;width:600px;">
        <p style="font-size:20px;margin:10px;">隅部曲率半径R:</p>
        <input type="text" name="sumiR" style="margin:10px;width:100px" value=<?= $sumiR2 ?> /><br>
        <p style="font-size:14px;margin:10px;">mm</p>
        <p style="font-size:20px;margin:10px;">断面積S:</p>
        <input type="text" name="cs_area" style="margin:10px;width:100px" value=<?= $cs_area ?> /><br>
        <p style="font-size:14px;margin:10px;">m2</p>


      <input style="margin-left:30px;" type="submit" value="登録" />




      </div>
 </form>





 <input type="button" onclick="location.href='./sekkei.php'" value="設計入力に戻る" style='coler:white; border-color:#3b82f6;color:white; font-size:18px;margin:10px; background:#8EA9DB; border-radius:10px;'>
 <input type="button" onclick="location.href='./pillvirtispec.php'" value="柱断面・フロア設定画面へ" style='coler:white; border-color:#3b82f6;color:white; font-size:18px;margin:10px; background:#8EA9DB; border-radius:10px;'>




</body>
</html>
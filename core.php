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

// 通り芯表示
$stmt = $pdo->prepare("SELECT * FROM stcore WHERE gen_name = :gen_name");
$stmt->bindValue(':gen_name', $gen_name, PDO::PARAM_STR);
$status2 = $stmt->execute();



// ４．データ表示
$view_x = "<tr style='background: #BDD7EE;color:#833C0C'><th width:20%;>通り芯符号</th><th width:20%;>間隔</th><th width:20%;>修正</th><th width:20%;>削除</th></tr>";
$view_y = "<tr style='background: #BDD7EE;color:#833C0C'><th width:20%;>通り芯符号</th><th width:20%;>間隔</th><th width:20%;>修正</th><th width:20%;>削除</th></tr>";

$max_x = 60;
$max_y = 430;


$view_core_x = "ctx.font = '16px Roboto medium';";
$view_coordineate = "ctx.font = '10px Roboto medium';";

$view_y10=450;
$view_x10=40;

$view_linex ='';
$view_liney ='';



if($status2==false) {
  //execute（SQL実行時にエラーがある場合）
  $error = $stmt->errorInfo();
  exit("ErrorQuery:".$error[2]);
}else{
//Selectデータの数だけ自動でループしてくれる
//FETCH_ASSOC=http://php.net/manual/ja/pdostatement.fetch.php
  while( $result2 = $stmt->fetch(PDO::FETCH_ASSOC)){ 
    if($result2['axle']=='X'){
      $max_x = $max_x +$result2['stcore_coordineate']/100;
    }
    elseif($result2['axle']=='Y'){
      $max_y = $max_y -$result2['stcore_coordineate']/100;
    }
   }
  };

// var_dump($max_x);
// var_dump($max_y);


$stmt = $pdo->prepare("SELECT * FROM stcore WHERE gen_name = :gen_name");
$stmt->bindValue(':gen_name', $gen_name, PDO::PARAM_STR);
$status = $stmt->execute();



if($status==false) {
  //execute（SQL実行時にエラーがある場合）
  $error = $stmt->errorInfo();
  exit("ErrorQuery:".$error[2]);
}else{

    while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){ 
        //GETデータ送信リンク作成
        // <a>で囲う。
        if($result['axle']=='X'){
          // 入力情報表示_X
          $view_x .= '<tr><td>'.$result['stcore_num'].'</td>';
          $view_x .= '<td>'.$result['stcore_coordineate'].'</td>';
          $view_x .= '<td id="ss"><a href=core_ss.php?id='.$result['stcore_id'].'>修正</td>';
          $view_x .= '<td id="aa"><a href=core_aa.php?id='.$result['stcore_id'].'>削除</td>';
          $view_x .= '</tr>';

          // 通り芯符号表示_X
          $view_x10 = $view_x10+$result['stcore_coordineate']/100;
          $view_x11 = $view_x10+10;
          $view_x12 = $view_x10-$result['stcore_coordineate']/200;
          $view_core_x .= "ctx.fillText('".$result['stcore_num']."',".$view_x10.',490);';
          
          // 芯間距離表示
          $view_coordineate .= "ctx.fillText('".$result['stcore_coordineate']."',".$view_x12.',500);';

          // 通り芯表示
          $view_linex .='ctx.moveTo('.$view_x11.',450);';
          $view_linex .='ctx.lineTo('.$view_x11.','.$max_y.');';
          


        }
        elseif($result['axle']=='Y'){
          // 入力情報表示_Y
          $view_y .= '<tr><td>'.$result['stcore_num'].'</td>';
          $view_y .= '<td>'.$result['stcore_coordineate'].'</td>';
          $view_y .= '<td id="ss"><a href=core_ss.php?id='.$result['stcore_id'].'>修正</td>';
          $view_y .= '<td id="aa"><a href=core_aa.php?id='.$result['stcore_id'].'>削除</td>';
          $view_y .= '</tr>';
          // 通り芯符号表示_Y
          $view_y10 = $view_y10-$result['stcore_coordineate']/100;
          $view_y11 = $view_y10-10;
          $view_y12 = $view_y10+$result['stcore_coordineate']/200;
          $view_core_x .= "ctx.fillText('".$result['stcore_num']."',5,".$view_y10.');';

          // 芯間距離表示_Y
          $view_coordineate .= "ctx.fillText('".$result['stcore_coordineate']."',0,".$view_y12.');';

          $view_liney .='ctx.moveTo('.$max_x.','.$view_y11.');';
          $view_liney .='ctx.lineTo(40,'.$view_y11.');';
          

        }
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
<p style="font-size:20px;">現場名：<?= $gen_name ?></p>
<h3>通り芯設定</h3>

<form name="form1" action="core_act.php" method="post" style="font-size:14px;">
<div style="margin:10px;width:400px;">
 <p style="font-size:20px;">通り芯設定</p>
 <select name="axle" style='coler:white; border-color:#3b82f6;color:white; font-size:18px;margin:10px; background:#8EA9DB; border-radius:3px;width:60px;'>
     <option value="X">X軸</option>
     <option value="Y">Y軸</option>
     </select><br>

 通り芯名：　<input type="text" name="stcore_num" style="margin:10px;"/><br>
 <div>
 芯間距離：　<input type="text" name="stcore_coordineate" style="margin:10px;"/>　mm<br>


</div>
 <input stile="margin:10px;" type="submit" value="登録" />
 </div>
 </form>
<p>X軸登録値</p>
<table style="font-size: 12px;width: 600px;">
 <?= $view_x ?>
</table>
 <p>Y軸登録値</p>
 <table style="font-size: 12px;width: 600px;">
 <?= $view_y ?>
 </table>

 

 <input type="button" onclick="location.href='./sekkei.php'" value="設計入力に戻る" style='coler:white; border-color:#3b82f6;color:white; font-size:18px;margin:10px; background:#8EA9DB; border-radius:10px;'>
 <input type="button" onclick="location.href='./floor.php'" value="フロア設定画面へ" style='coler:white; border-color:#3b82f6;color:white; font-size:18px;margin:10px; background:#8EA9DB; border-radius:10px;'>



 <!-- 通り芯表示 -->
 <canvas id="core" width="500" height="500"></canvas>
 

<!--/ コンテンツ表示画面 -->
<script>

// Canbas記載事項
    // plane記載
    function init() {
        var canvas = document.getElementById("core");
        // 表示位置指定
          canvas.style.position = "absolute";
          canvas.style.left = "700px";
          canvas.style.top = "150px";
        var ctx = canvas.getContext("2d");
        // 通り芯番号表示
        ctx.font = '20px Roboto medium';
        ctx.fillText('通り芯', 20, 20);
        <?= $view_core_x ?>
        // 芯間距離表示
        <?= $view_coordineate ?>
       
        // 通り芯線表示
        ctx.lineWidth = 3;
        ctx.strokeStyle = "#595959";
        <?= $view_linex ?>;
        <?= $view_liney ?>;
        ctx.stroke();

        draw();

        }
      

// コンテンツ描画処理
window.onload = function() {
    init();
};
 


</script>

</body>
</html>
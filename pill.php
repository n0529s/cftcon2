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

// １．通り芯表示
$stmt = $pdo->prepare("SELECT * FROM stcore WHERE gen_name = :gen_name");
$stmt->bindValue(':gen_name', $gen_name, PDO::PARAM_STR);
$status2 = $stmt->execute();



// ２．通り芯図面表示
// 基準座標（0,0）設定
$Ref_x = 60;
$Ref_y = 430;


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
      $Ref_x2 = $Ref_x +$result2['coord']*10;
    }
    elseif($result2['axle']=='Y'){
      $Ref_y2 = $Ref_y -$result2['coord']*10;
    }
   }
  }





// ３．通り芯選択一覧表示（通り芯情報図示含む）
  $stmt = $pdo->prepare("SELECT * FROM stcore WHERE gen_name = :gen_name");
  $stmt->bindValue(':gen_name', $gen_name, PDO::PARAM_STR);
  $status = $stmt->execute();
  
  $view_x ="";
  $view_y ="";

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
            $view_linex .='ctx.lineTo('.$view_x11.','.$Ref_y2.');';
            
  
  
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
  
            $view_liney .='ctx.moveTo('.$Ref_x2.','.$view_y11.');';
            $view_liney .='ctx.lineTo(40,'.$view_y11.');';
            
  
          }
      }
    }

    // var_dump($view_x11);
    
  





$select_x = "<select name='stcore_numX' style='coler:white; border-color:#3b82f6;color:white; font-size:18px;margin:10px; background:#8EA9DB; border-radius:5px; width:100px;'>";
$select_x .= "<br><option value='-'>-</option>";
$select_y = "<select name='stcore_numY' style='coler:white; border-color:#3b82f6;color:white; font-size:18px;margin:10px; background:#8EA9DB; border-radius:5px; width:100px;'>";
$select_y .= "<br><option value='-'>-</option>";

// ４．通り芯選択情報一覧抽出
$stmt = $pdo->prepare("SELECT * FROM stcore WHERE gen_name = :gen_name");
$stmt->bindValue(':gen_name', $gen_name, PDO::PARAM_STR);
$status2 = $stmt->execute();

if($status2==false) {
  //execute（SQL実行時にエラーがある場合）
  $error = $stmt->errorInfo();
  exit("ErrorQuery:".$error[2]);
}else{
    while( $result2 = $stmt->fetch(PDO::FETCH_ASSOC)){ 
        //GETデータ送信リンク作成
        // <a>で囲う。
        if($result2['axle']=='X'){
          // 入力情報表示_X
          $select_x .= '<option value="'.$result2['stcore_num'].'">'.$result2['stcore_num'].'</option>';
        }
        elseif($result2['axle']=='Y'){
          // 入力情報表示_Y
          $select_y .= '<option value="'.$result2['stcore_num'].'">'.$result2['stcore_num'].'</option>';
        }
    }
  };

  $select_x .= "</select>";
  $select_y .= "</select>";
  


// ５．杭符号選択情報抽出
$stmt = $pdo->prepare("select * from pillvirtispec where gen_name = :gen_name");
$stmt->bindValue(':gen_name', $gen_name, PDO::PARAM_STR);
$status = $stmt->execute();

$select = "<select name='pill_sign' style='color:white; border-color:#3b82f6;color:white; font-size:18px;margin:10px; background-color:#8EA9DB; border-radius:5px; width:80px;'>";
$select .= "<br><option value=''>-</option>";

// 配列グループ作成
$pill_sign_a= array();
$pill_sign_b= "";

if($status==false) {
  //execute（SQL実行時にエラーがある場合）
  $error = $stmt->errorInfo();
  exit("ErrorQuery:".$error[2]);
}
else{
  while( $result4 = $stmt->fetch(PDO::FETCH_ASSOC)){ 
      
    // 前回の配列呼び出し
    $pill_sign_c = $pill_sign_b;
    // 配列に値を追加
    $pill_sign_a[] = $result4['pill_sign'];
    // 配列内の重複を削除
    $pill_sign_b = array_unique($pill_sign_a);

    if($pill_sign_c != $pill_sign_b ){
      $select .= '<option value="'.$result4['pill_sign'].'">'.$result4['pill_sign'].'</option>';
    }
  }
  $select .= '</select>';
}


// ６．柱情報一覧表抽出/図示
$stmt = $pdo->prepare("select * from design where gen_name = :gen_name");
$stmt->bindValue(':gen_name', $gen_name, PDO::PARAM_STR);
$status = $stmt->execute();

// var_dump($status);

$view_pill = "<tr style='background: #BDD7EE;color:#833C0C;'><th width:5%;>柱番号</th><th width:5%;>柱符号</th><th width:10%;>通り芯X</th><th width:10%;>通り芯Y</th></th><th width:20%;>offset_X</th><th width:20%;>offset_Y</th><th width:20%;>柱長</th><th width:20%;>修正</th><th width:20%;>削除</th></tr>";

$shape_pilly= $Ref_y;
$shape_pillx= $Ref_x-20;

$shape_pill ="";
$view_pillnum ="";
$view_pillsign ="";

 
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
      $view_pill .= '<tr><td>'.$result['pill_num'].'</td>';
      $view_pill .= '<td>'.$result['pill_sign'].'</td>';
      $view_pill .= '<td>'.$result['stcore_numX'].'</td>';
      $view_pill .= '<td>'.$result['stcore_numY'].'</td>';
      $view_pill .= '<td>'.$result['offsetX'].'</td>';
      $view_pill .= '<td>'.$result['offsetY'].'</td>';
      $view_pill .= '<td>'.$result['virtilength'].'</td>';

      $view_pill .= '<td id="ss"><a href=pill_ss.php?id='.$result['pill_id'].'>修正</td>';
      $view_pill .= '<td id="aa"><a href=pill_aa.php?id='.$result['pill_id'].'>削除</td>';
      $view_pill .= '</tr>';   
     // 柱位置抽出
      $shape_pillx2 = $result['coordX']*10;
      $shape_pilly2 = $result['coordY']*10;
      $shape_pillx3 = $shape_pillx + $shape_pillx2;
      $shape_pilly3 = $shape_pilly - $shape_pilly2;
    // 柱番号用位置抽出
      $shape_pilly4 = $shape_pilly3 -3;
    // 柱符号用位置抽出
      $shape_pilly5 = $shape_pilly3 +33;
    
     // 柱表示
      $shape_pill .= 'ctx.rect(';
      $shape_pill .= $shape_pillx3.',';
      $shape_pill .= $shape_pilly3.',';
      $shape_pill .= '20,20);';

     //柱番号抽出 
      $shape_pillnum = $result['pill_num'];
      $view_pillnum .= "ctx.fillText('".$shape_pillnum."',".$shape_pillx3.",".$shape_pilly4.');';

     //柱符号抽出 
      $shape_pillsign = $result['pill_sign'];
      $view_pillsign .= "ctx.fillText('".$shape_pillsign."',".$shape_pillx3.",".$shape_pilly5.');';


   }
  }
  
// var_dump($shape_pillx3);


?>




<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width">
<link rel="stylesheet" href="css/main.css" />
<link href="css/bootstrap.min.css" rel="stylesheet">
<style>div{padding: 10px;font-size:16px;}</style>
<title>柱設定入力</title>
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
<h3>柱設定</h3>

<form name="form1" action="pill_act.php" method="post" style="font-size:14px;width:800px;">
 <div style="display: flex; justify-content:flex-start;margin:5px;">
 <p style="font-size:20px;margin:10px;">柱番号登録：</p>
 <input type="text" name="pill_num" style="margin:10px;Width:100px;"/>
 </div>

 <div style="display: flex; justify-content:flex-start;margin:5px;">
 <p style="font-size:20px;margin:10px;">柱符号選択：</p>
 <?= $select ?>
 </div>
 <div style="display: flex; justify-content:flex-start;margin:5px;">
 <p style="font-size:20px;margin:10px;">通り芯 X軸：</p>
 <?= $select_x ?>
 <p style="font-size:20px;margin:10px;">　X軸offset：</p>
 <input type="number" name="offsetX" style="margin:10px;Width:100px;"/>
 <p style="font-size:20px;margin:10px;">ｍｍ</p>
 </div>

 <div style="display: flex; justify-content:flex-start;margin:5px;">
 <p style="font-size:20px;margin:10px;">通り芯 Y軸：</p>
 <?= $select_y ?>
 <p style="font-size:20px;margin:10px;">　Y軸offset：</p>
 <input type="number" name="offsetY" style="margin:10px;Width:100px;"/>
 <p style="font-size:20px;margin:10px;">ｍｍ</p>
 </div>

 <div style="display: flex; justify-content:flex-start;margin:5px;">
 <p style="font-size:18px;margin:10px;">打設開始高offset：</p>
 <input type="text" name="offset_st" style="margin:10px;Width:90px;"/>
 <p style="font-size:18px;margin:10px;">終了高offset：</p>
 <input type="text" name="offset_end" style="margin:10px;Width:90px;"/>
 
 </div>
 <p style="font-size:12px;margin-left:30px;">単位は「ｍ」、フロアレベルより上側が＋、下側がマイナス</p>
 <div style="display: flex; justify-content:flex-start;margin:5px;">

 <input style="font-size:20px;margin:10px;" type="submit" value="登録" />
 </div>
 </form>



 <p style="margin-left:20px; margin-bottom:0px;">柱設定登録値</p>
<table style="font-size: 12px;width: 600px;margin-left:20px; margin-bottom:0px;">
 <?= $view_pill ?>
</table>

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
        // X軸
        <?= $view_linex ?>
        // Y軸
        <?= $view_liney ?>
        ctx.stroke();
        // 柱表示枠線のみ
        ctx.beginPath();
          <?= $shape_pill ?>;
          ctx.strokeStyle = 'red';
          ctx.lineWidth = 3;
         ctx.stroke();

         ctx.beginPath();
          ctx.fillStyle = 'blue';
          ctx.lineWidth = 1;
          <?= $view_pillnum ?>;
          <?= $view_pillsign ?>;
         ctx.stroke();

        draw();

        }
      

// コンテンツ描画処理
window.onload = function() {
    init();
};
 


</script>



<input type="button" onclick="location.href='./sekkei.php'" value="設計入力に戻る" style='coler:white; border-color:#3b82f6;color:white; font-size:18px;margin:10px; background:#8EA9DB; border-radius:10px;'>
 
</body>
</html>
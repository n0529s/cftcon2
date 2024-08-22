<?php

// SESSIONスタート
session_start();
$userid = $_SESSION['userid'];
$username = $_SESSION['username'];
$gen_name = $_SESSION['gen_name'];

require_once('funcs.php');
// ログインチェック
// loginCheck();
$pdo = db_conn();

// PDOのエラーモードを設定
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// 登録情報検索
$stmt = $pdo->prepare("SELECT COUNT(*) AS count FROM constmanege2 WHERE gen_name=:gen_name");
$stmt->bindValue(':gen_name', $gen_name, PDO::PARAM_STR);
$status = $stmt->execute();

if ($status === false) {
    // エラーハンドリング
    sql_error($stmt->errorInfo());
} else {
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $status22 = $result["count"];
    $_SESSION["status22"] = $status22;
    var_dump($status22);
}

// 登録情報検索2
$stmt3 = $pdo->prepare("SELECT COUNT(*) AS count FROM plant WHERE gen_name=:gen_name");
$stmt3->bindValue(':gen_name', $gen_name, PDO::PARAM_STR);
$status3 = $stmt3->execute();

if ($status3 === false) {
    // エラーハンドリング
    sql_error($stmt3->errorInfo());
} else {
    $result3 = $stmt3->fetch(PDO::FETCH_ASSOC);
    $status33 = $result3["count"];
    $_SESSION["status33"] = $status33;
    var_dump($status33);
}

// ４．データ表示
$view_x = "<tr text-align='center' style='background: #BDD7EE;color:#833C0C;'><th width='25%'>種類</th><th width='10%'>Fc強度</th><th width='10%'>フロー</th><th width='10%'>目標空気量</th><th width='10%'>単位水量</th><th width='10%'>水結合材比</th><th width='10%'>塩化物</th><th width='10%'>ﾌﾞﾘｰﾃﾞｨﾝｸﾞ量</th><th width='10%'>沈下量</th></tr>";
$view_y = "<tr text-align='center' style='background: #BDD7EE;color:#833C0C;'><th width='10%'>プラント名</th><th width='10%'>住所</th><th width='5%'>運搬時間</th><th width='5%'>距離</th><th width='5%'>Fc強度</th><th width='5%'>フロー</th><th width='5%'>配合</th><th width='5%'>単位ｾﾒﾝﾄ量</th><th width='5%'>単位水量</th><th width='5%'>水セメント比</th></tr>";
$view_z = "<tr text-align='center' style='background: #BDD7EE;color:#833C0C;'><th width:14%;>種別</th><th  width:14%;>呼び強度</th><th width:14%;>フロー</th><th width:5%;>範囲</th><th width:14%;>空気量</th><th width:5%;>範囲</th><th width:14%;>塩化物</th><th width:10%;>Con温度Min</th><th width:10%;>Con温度MAX</th></tr>";
$type = "";
$strength = "";
$slump = "";
$air = "";
$water = "";
$ww = "";
$chlo = "";
$bb = "";
$sink = "";




if ($status22 != 0) {
    $stmt2 = $pdo->prepare("SELECT * from constmanege2 where gen_name=:gen_name");
    $stmt2->bindValue(':gen_name', $gen_name, PDO::PARAM_STR);
    $status2 = $stmt2->execute();
    
    if ($status2 == false) {
      sql_error($status2);
    } else {
      while ($result2 = $stmt2->fetch(PDO::FETCH_ASSOC)) {
        $design_contype = $result2["design_contype"];
        $design_strength = $result2["design_strength"];
        $design_slump = $result2["design_slump"];
        $design_air = $result2["design_air"];
        $design_water = $result2["design_water"];
        $design_ww = $result2["design_ww"];
        $design_chlo = $result2["design_chlo"];
        $design_bb = $result2["design_bb"];
        $design_sink = $result2["design_sink"];
        
        // ４.２データ表示
        $view_x .= '<tr align="center"><td>' . $design_contype . '</td>';
        $view_x .= '<td>' . $design_strength . '</td>';
        $view_x .= '<td>' . $design_slump . '</td>';
        $view_x .= '<td>' . $design_air . '</td>';
        $view_x .= '<td>' . $design_water . '</td>';
        $view_x .= '<td>' . $design_ww . '</td>';
        $view_x .= '<td>' . $design_chlo . '</td>';
        $view_x .= '<td>' . $design_bb . '</td>';
        $view_x .= '<td>' . $design_sink . '</td>';
        $view_x .= '</tr>';
      }
    }
}

if ($status33 != 0) {
  $stmt4 = $pdo->prepare("SELECT * from plant where gen_name=:gen_name");
  $stmt4->bindValue(':gen_name', $gen_name, PDO::PARAM_STR);
  $status4 = $stmt4->execute();
  
  if ($status4 == false) {
    sql_error($status4);
  } else {
    while ($result4 = $stmt4->fetch(PDO::FETCH_ASSOC)) {
      $plant = $result4["plant"];
      $plant_address = $result4["plant_address"];
      $plant_time = $result4["plant_time"];
      $plant_distance = $result4["plant_distance"];
      $plant_strength	 = $result4["plant_strength"];
      $plant_slump = $result4["plant_slump"];
      $plant_mix = $result4["plant_mix"];
      $plant_ceme = $result4["plant_ceme"];
      $plant_water = $result4["plant_water"];
      $plant_wcrate = $result4["plant_wcrate"];

      
      // ４.２データ表示
      $view_y .= '<tr align="center"><td>' . $plant . '</td>';
      $view_y .= '<td>' . $plant_address . '</td>';
      $view_y .= '<td>' . $plant_time . '分</td>';
      $view_y .= '<td>' . $plant_distance . '</td>';
      $view_y .= '<td>' . $plant_strength . '</td>';
      $view_y .= '<td>' . $plant_slump . '</td>';
      $view_y .= '<td>' . $plant_mix . '</td>';
      $view_y .= '<td>' . $plant_ceme . '</td>';
      $view_y .= '<td>' . $plant_water . '</td>';
      $view_y .= '<td>' . $plant_wcrate . '</td>';
      $view_y .= '</tr>';
    }
  }
};

// 管理基準値設定値表示
$stmt22 = $pdo->prepare("SELECT * from constmanege where gen_name=:gen_name");
$stmt22->bindValue(':gen_name', $gen_name, PDO::PARAM_STR);
$status22 = $stmt22->execute();

//4．データ表示
if ($status22 == false) {
  sql_error($status22);
} else {
  $result22 = $stmt22->fetch();//ここを追記！
}
$type = $result22 ["contype"];
$strength = $result22 ["constrength"];
$flow = $result22 ["conflow"];
$range = ($result22 ["slumpmax"]-$result2 ["slumpmin"])/2;
$range2 = ($result22 ["airmax"]-$result2 ["airmin"])/2;
$air = $result22 ["airmax"]-$range2/2;
$chlomax = $result22 ["chlomax"];
$tempmax = $result22 ["contempmax"];
$tempmin = $result22 ["contempmin"];


$view_z .= '<tr align="center"><td>'.$type.'</td>';
$view_z .= '<td>'.$strength.'</td>';
$view_z .= '<td>'.$flow.'</td>';
$view_z .= '<td>±'.$range.'</td>';
$view_z .= '<td>'.$air.'</td>';
$view_z .= '<td>±'.$range2.'</td>';
$view_z .= '<td>'.$chlomax.'以下</td>';
$view_z .= '<td>'.$tempmin.'℃以上</td>';
$view_z .= '<td>'.$tempmax.'℃以下</td>';
$view_z .= '</tr>';



















?>





<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width">
<script src="js/jquery-2.1.3.min.js"></script>
<!-- <link rel="stylesheet" href="css/main.css" /> -->
<!-- <link href="css/bootstrap.min.css" rel="stylesheet"> -->
<style>div{padding: 10px;font-size:16px;}</style>
<title>コンクリート仕様・プラント</title>
</head>
<body>

<header style="position: fixed;width:100%;z-index: 9999;top: 0;left: 0;margin: 0;padding: 0;">
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


<p style="height:60px;"></p>

<p style="font-size:20px;">現場名：<?= $gen_name ?></p>
<h3>設計図書基準値・プラント設定基準値</h3>
<div style="display: flex; justify-content:flex-start;margin:5px;">
    <div style="width:450px;">
        <p style="margin:0px;font-size:18px;">■設計図書基準値</p>
        <form name="form1" action="conmanege_act.php" method="post" style="background-color: #DDEBF7;">
            ◆セメントの種類：　<input id="Type"  name="Type" type="text" style="margin:10px; width:220px;" value="<?= $design_contype ?>"/><br>
            ◆設計基準強度Fc：　<input id="Strength" name="Strength" type="text" style="margin:10px;width:50px;" value="<?= $design_strength ?>"/>N/mm2<br>
            ◆スランプフロー：　<input id="Slump" name="Slump" type="text" style="margin:10px; width:50px;" value="<?= $design_slump ?>"/>cm<br>
            ◆目標空気量：　　　<input id="Air" name="Air" type="text" style="margin:10px; width:50px;" value="<?= $design_air ?>"/>%<br>
            ◆単位水量：　　　　<input id="Water" name="Water" type="text" style="margin:10px; width:50px;" value="<?= $design_water ?>"/>kg/cm3以下<br>
            ◆水結合材比：　　　<input id="Ww" name="Ww" type="text" style="margin:10px; width:50px;" value="<?= $design_ww ?>"/>%以下<br>
            ◆塩化物含有量：　　<input id="Chlo" name="Chlo" type="text" style="margin:10px; width:50px;" value="<?= $design_chlo ?>"/>kg/m3以下<br>
            ◆ブリーディング量：<input id="Bb" name="Bb" type="text" style="margin:10px; width:50px;" value="<?= $design_bb ?>"/>cm3/cm2以下<br>
            ◆沈　降　量：　　　<input id="Sink" name="Sink" type="text" style="margin:10px; width:50px;" value="<?= $design_sink ?>"/>mm以下　　　
            <input style="margin:10px;font-size:16px;" type="submit" value="登録" />
        </form>
    </div>
 
    <div style="width:450px;">
        <p style="margin:0px;font-size:18px;">■プラント設定基準値</p>
        <form name="form1" action="conmanege_act2.php" method="post" style="background-color: #DDEBF7;">
            ◆プラント工場名：　<input id="Plant"  name="Plant" type="text" style="margin:10px; width:200px;" value="<?= $plant ?>"/><br>
            ◆プラント所在地：　<input id="Address" name="Address" type="text" style="margin:10px;width:250px;" value="<?= $plant_address ?>"/><br>
            ◆想定運搬時間：　　<input id="Time" name="Time" type="text" style="margin:10px; width:50px;" value="<?= $plant_time ?>"/>分<input type="text" name="Distance" style="margin:10px; width:50px;" value="<?= $plant_distance ?>"/>km<br>
            ◆設計基準強度Fc：　<input id="Strength" name="Strength" type="text" style="margin:10px; width:50px;" value="<?= $plant_strength ?>"/>N/mm2<br>
            ◆スランプフロー：　<input id="Slump" name="Slump" type="text" style="margin:10px; width:50px;" value="<?= $plant_slump ?>"/>cm<br>
            ◆配合（呼び名）：　<input id="Mix" name="Mix" type="text" style="margin:10px; width:100px;" value="<?= $plant_mix ?>"/><br>
            ◆単位セメント量：　<input id="Ceme" name="Ceme" type="text" style="margin:10px; width:50px;" value="<?= $plant_ceme ?>"/>kg/m3<br>
            ◆単位水量：　　　　<input id="Water" name="Water" type="text" style="margin:10px; width:50px;" value="<?= $plant_water ?>"/>kg/cm3<br>
            ◆水セメント比：　　<input id="WCrate" name="WCrate" type="text" style="margin:10px; width:50px;" value="<?= $plant_wcrate ?>"/>　　　
            <input style="margin:10px;font-size:16px;" type="submit" value="登録" />
        </form>
    </div>
</div>




 <p style="margin:0px;">■管理基準値登録値</p>
 <table style="font-size: 12px;width: 800px;">
 <?= $view_z ?>
 </table>

 <p style="margin:20px 0px 0px 0px;">■コンクリート設計仕様・プラント設定値</p> 
<table style="font-size: 12px;width: 950px;">
 <?= $view_x ?>
</table>
<table style="font-size: 12px;width: 950px;">
 <?= $view_y ?>
</table>

 

 <input type="button" onclick="location.href='./sekkei.php'" value="設計入力に戻る" style='color:white; border-color:#3b82f6;color:white; font-size:18px;margin:10px; background:#8EA9DB; border-radius:10px;'>
 <input type="button" onclick="location.href='./menu2.php'" value="メニュー画面へ" style='color:white; border-color:#3b82f6;color:white; font-size:18px;margin:10px; background:#8EA9DB; border-radius:10px;'>




 <script>
      // セレクトボックスの値取得
      const type = document.getElementById("Type");
      const str = document.getElementById("Strength");
      const flow = document.getElementById("Flow");
      const slump = document.getElementById("Slump");
      const span = document.getElementById("Span");

    //  呼び強度選択値取得
    type.addEventListener("change", function (e) {
        var category = type.value;
        console.log("Type value changed to:", category);
        let options2 = '';

        if(category == "F"){
          options2 = '<option value="27">27</option><option value="30">30</option><option value="33">33</option><option value="36">36</option><option value="40">40</option><option value="42">42</option><option value="45">45</option>';
        }else{
          options2 = '<option value="50">50</option><option value="55">55</option><option value="60">60</option>';
        }
        str.innerHTML = options2;
        console.log("Type options2 updated to:", options2);
      });

    //  呼び強度選択値取得
      str.addEventListener("change", function (e) {
        var strvalue = str.value;
        console.log("Strength value changed to:", strvalue);
        let options = '';

        if (strvalue == 27 || strvalue == 30) {
          options = '<option value="N">-</option><option value="45">45</option>';
        } else if (strvalue == 33) {
          options = '<option value="45">45</option><option value="50">50</option>';
        } else if (strvalue == 36) {
          options = '<option value="45">45</option><option value="50">50</option><option value="55">55</option>';
        } else {
          options = '<option value="45">45</option><option value="50">50</option><option value="55">55</option><option value="60">60</option>';
        }
        flow.innerHTML = options;
        console.log("Flow options updated to:", options);
      });

    // フロー値選択値取得
      flow.addEventListener("change", function (e) {
        var slumpvalue = flow.value;
        // console.log("Flow value changed to:", slumpvalue);
        slump.value = slumpvalue;
        console.log("Slump  value updated to:", slumpvalue);

        if(slumpvalue == 60){
          var spanwidth = 10;
        }else{
          var spanwidth = 7.5;
        }
        span.value = spanwidth;
        console.log("Span  value updated to:", spanwidth);
      });

  </script>


 </body>
</html>
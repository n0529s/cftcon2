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

// 0.図面最大値取得
$stmt = $pdo->prepare("SELECT MAX(coordX) AS `max_X` FROM design where gen_name = :gen_name");
$stmt->bindValue(':gen_name', $gen_name, PDO::PARAM_STR);
$status = $stmt->execute();
foreach ($stmt as $row) {
  $max_X =$row['max_X'];
}

$stmt = $pdo->prepare("SELECT MAX(coordY) AS `max_Y` FROM design where gen_name = :gen_name");
$stmt->bindValue(':gen_name', $gen_name, PDO::PARAM_STR);
$status = $stmt->execute();
foreach ($stmt as $row2) {
  $max_Y =$row2['max_Y'];
}



// 表示比率設定
$Xrate = 1100/$max_X/2;
$Yrate = 500/$max_Y;
// var_dump($Xrate);
// var_dump($Yrate);




// １．通り芯表示
$stmt = $pdo->prepare("SELECT * FROM stcore WHERE gen_name = :gen_name");
$stmt->bindValue(':gen_name', $gen_name, PDO::PARAM_STR);
$status2 = $stmt->execute();



// ２．通り芯図面表示
// 基準座標（0,0）設定
$Ref_x = 60;
$Ref_y = 530;


$view_core_x = "ctx.font = '16px Roboto medium';";
$view_coordineate = "ctx.font = '10px Roboto medium';";

$view_y10= $Ref_y+20;
$view_x10= $Ref_x-20;

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
      $Ref_x2 = $Ref_x +$result2['coord']*$Xrate;
    }
    elseif($result2['axle']=='Y'){
      $Ref_y2 = $Ref_y -$result2['coord']*$Yrate;
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
            $view_x10 = $view_x10+$result['stcore_coordineate']/1000*$Xrate;
            $view_x11 = $view_x10+10;
            $view_x12 = $view_x10-$result['stcore_coordineate']/2000*$Xrate;
            
         

            $view_core_x .= "ctx.fillText('".$result['stcore_num']."',".$view_x10.',590);';
            
            // 芯間距離表示
            $view_coordineate .= "ctx.fillText('".$result['stcore_coordineate']."',".$view_x12.',600);';
  
            // 通り芯表示
            $view_linex .='ctx.moveTo('.$view_x11.','.$view_y10.');';
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
            $view_y10 = $view_y10-$result['stcore_coordineate']/1000*$Yrate;
            $view_y11 = $view_y10-10;
            $view_y12 = $view_y10+$result['stcore_coordineate']/2000*$Yrate;
            $view_core_x .= "ctx.fillText('".$result['stcore_num']."',5,".$view_y10.');';
  
            // 芯間距離表示_Y
            $view_coordineate .= "ctx.fillText('".$result['stcore_coordineate']."',0,".$view_y12.');';
  
            $view_liney .='ctx.moveTo('.$Ref_x2.','.$view_y11.');';
            $view_liney .='ctx.lineTo(40,'.$view_y11.');';
            
  
          }
      }
    }


  


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
// 柱寸法指定（3倍）
$view_pillsizeX = 3*$Yrate;
// 表示位置
$shape_pilly= $Ref_y-$view_pillsizeX/2+10;
$shape_pillx= $Ref_x-$view_pillsizeX/2-10;



$shape_pill ="";
$view_pillnum = "";
$view_pillsign =""; 

// クリック判定変数
$pillnum222 = array();
$pillx222 = array();
$pilly222 = array();



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
       
     // 柱位置抽出
      $shape_pillx2 = $result['coordX']*$Xrate;
      $shape_pilly2 = $result['coordY']*$Yrate;
      $shape_pillx3 = $shape_pillx + $shape_pillx2;
      // $shape_pillx3total .=$shape_pillx3;
      $shape_pilly3 = $shape_pilly - $shape_pilly2;
    // 柱番号用位置抽出
      $shape_pilly4 = $shape_pilly3 -3;
    // 柱符号用位置抽出
      $shape_pilly5 = $shape_pilly3 +33;

    // クリックしたときの抽出座標
      $pillnum222[] =$result['pill_num'];
      $pillx222[] =$shape_pillx3;
      $pilly222[] =$shape_pilly3;


    
     // 柱表示
      $shape_pill .= 'ctx.rect(';
      $shape_pill .= $shape_pillx3.',';
      $shape_pill .= $shape_pilly3.',';
      $shape_pill .= $view_pillsizeX.','.$view_pillsizeX.');';

     //柱番号抽出 
      $shape_pillnum = $result['pill_num'];
      $view_pillnum .= "ctx.fillText('".$shape_pillnum."',".$shape_pillx3.",".$shape_pilly4.');';

     //柱符号抽出 
      $shape_pillsign = $result['pill_sign'];
      $view_pillsign .= "ctx.fillText('".$shape_pillsign."',".$shape_pillx3.",".$shape_pilly5.');';
   }
  }
  
// var_dump($pillx222);
// var_dump($result['coordX']);

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
      <a  href="login.php">TOPページ</a>
      <p>LoginID:<?= $userid ?></p>
  </div>
    </div>
  </nav>
</header>



<p style="height:100px;"></p>
<div>
<p style="font-size:20px;">現場名：<?= $gen_name ?></p>
<div style="display: flex; justify-content:flex-start;margin:5px;">
<h3>柱選択画面</h3>
<input type="button" onclick="location.href='./sekkei.php'" value="設計入力に戻る" style='coler:white; border-color:#3b82f6;color:white; font-size:18px;margin:10px; background:#8EA9DB; border-radius:10px;'>
<input type="button" onclick="location.href='./time.php'" value="施工管理へ" style='coler:white; border-color:#3b82f6;color:white; font-size:18px;margin:10px; background:#8EA9DB; border-radius:10px;'>
</div>
</div>


 <canvas id="core" width="1100" height="600"></canvas>


<!--/ コンテンツ表示画面 -->
<script>

// Canbas記載事項
    // plane記載
    function init() {
        var canvas = document.getElementById("core");
        // 表示位置指定
          canvas.style.position = "absolute";
          canvas.style.left = "30px";
          canvas.style.top = "250px";
        var ctx = canvas.getContext("2d");
        // 通り芯番号表示
        ctx.font = '16px Roboto medium';
        // ctx.fillText('柱選択', 10, 20);
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

        // draw();

        }
      

// コンテンツ描画処理
          window.onload = function() {
              init();
          }


// マウスクリックで座標取得

const canvas = document.getElementById('core');
const ctx = canvas.getContext('2d'); // Canvasの2Dコンテキストを取得する

canvas.addEventListener('click', (e) => {
  var rect = e.target.getBoundingClientRect();
  var x = e.clientX - rect.left;
  var y = e.clientY - rect.top;
  console.log(`${x}:${y}`);
  draw(x, y); // xとyを引数としてdraw()関数を呼び出す


    // 設計柱情報受け取り(php→JS)
    var pillnum222 = JSON.parse('<?php echo json_encode($pillnum222)?>');
    var pillx222 = JSON.parse('<?php echo json_encode($pillx222)?>');
    var pilly222 = JSON.parse('<?php echo json_encode($pilly222)?>');
    // var xx =array();
    // console.log(pillx222);



// 要素の推定
for (let i = 0; i < pillx222.length; i++) {
   let xx = x - pillx222[i];
   let yy = y - pilly222[i];
   let total = Math.sqrt(xx * xx + yy * yy);
   console.log(total);
}

// 最小値取得
let min = Number.MAX_VALUE; // 初期値として最大の数値を設定する
let index = -1;

for (let i = 0; i < pillx222.length; i++) {
   let xx = x - pillx222[i];
   let yy = y - pilly222[i];
   let currentDistance = Math.sqrt(xx * xx + yy * yy);
   
   if (currentDistance < min) {
      min = currentDistance;
      if(min < 50){
        index = i; // 最小値を持つ要素のインデックスを更新
      }
      
   }
}

console.log("最小値:", min);
console.log("最小値のインデックス:", index);

var target = pillnum222[index];
console.log("選択された柱番号:", target);
// alert("選択された柱番号:" +target);

var btn = document.getElementById('btn');

var result = window.confirm("選択された柱番号:"+target +"これでよろしいですか？");

console.log( result );

    if(result) {
            console.log('OKがクリックされました');
            window.location.href = 'index2.php?id='+target;
        }else{

        }

});

function draw(x, y) {
    // 描画処理
    ctx.fillRect(x, y, 10, 10);
}

</script>


</body>
</html>


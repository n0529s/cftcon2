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

        draw();

        }
      

// コンテンツ描画処理
          window.onload = function() {
              init();
          };
          





// // マウスオーバーイベント！！！！
// var targetFlag = false; // trueでマウスが要素に乗っているとみなす
// var rect = null;

// /* Canvas上にマウスが乗った時 */
// function onMouseOver(e) {
//     rect = e.target.getBoundingClientRect();
//     canvas.addEventListener('mousemove', onMouseMove, false);
// }
// /* Canvasからマウスが離れた時 */
// function onMouseOut() {
//     canvas.removeEventListener('mousemove', onMouseMove, false);
// }
// /* Canvas上でマウスが動いている時 */
// function onMouseMove(e) {
//     /* マウスが動く度に要素上に乗っているかかどうかをチェック */
//     moveActions.updateTargetFlag(e);

//     /* 実行する関数には、間引きを噛ませる */
//     if (targetFlag) {
//         moveActions.throttle(moveActions.over, 50);
//     } else {
//         moveActions.throttle(moveActions.out, 50);
//     }
// }

// /* mouseMoveで実行する関数 */
// var moveActions = {
//     timer: null,
//     /* targetFlagの更新 */
//     updateTargetFlag: function(e) {
//         var x = e.clientX - rect.left;
//         var y = e.clientY - rect.top;

//         /* 最後の50は、該当する要素の半サイズを想定 */
//         var a = (x > w / 2 - 50);
//         var b = (x < w / 2 + 50);
//         var c = (y > h / 2 - 50);
//         var d = (y < h / 2 + 50);

//         targetFlag = (a && b && c && d); // booleanを代入
//     },
//     /* 連続イベントの間引き */
//     throttle: function(targetFunc, time) {
//         var _time = time || 100;
//         clearTimeout(this.timer);
//         this.timer = setTimeout(function () {
//             targetFunc();
//         }, _time);
//     },
//     out: function() {
//         drawRect();
//     },
//     over: function() {
//         drawRectIsHover();
//     }
// };

// function drawRect(color) {
//     // デフォルトもしくはマウスが要素から離れた時の描画処理
// }
// function drawRectIsHover() {
//     // マウスが要素に乗った時の描画処理
// }

// canvas.addEventListener('mouseover', onMouseOver, false);
// canvas.addEventListener('mouseout', onMouseOut, false);

// drawRect();





</script>




</body>
</html>
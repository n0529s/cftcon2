<?php

//SESSIONスタート
session_start();
$userid = $_SESSION['userid'];
$username = $_SESSION['username'];
$gen_name = $_SESSION['gen_name'];

$pill_num = $_GET["id"];

$_SESSION["pill_num"] = $pill_num;


require_once('funcs.php');
//ログインチェック
// loginCheck();
$pdo = db_conn();

// １．杭番号情報抽出
$stmt = $pdo->prepare("select * from design where pill_num = :pill_num");
$stmt->bindValue(':pill_num', $pill_num, PDO::PARAM_STR);
$status = $stmt->execute();
foreach ($stmt as $row) {
  $pill_sign =$row['pill_sign'];
  $virtilength =$row['virtilength'];
  $stcore_numX =$row['stcore_numX'];
  $stcore_numY =$row['stcore_numY'];
}


?>




<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width">
<link rel="stylesheet" href="css/main.css" />
<link href="css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.4/Chart.min.js"></script>
<style>div{padding: 10px;font-size:16px;}</style>
<title>CFT-con施工管理</title>
</head>

<header style="position: fixed;width:100%;z-index: 9999;">
  <nav class="navbar navbar-default" style="background:linear-gradient(to bottom, #8EA9DB 70%, #D9EAFF 100%); border-color:#305496;font-size:15px;display:flex;justify-content:space-between;">
    <div class="container-fluid"><p style="font-size: 24px;color:#E2EFDA;font-weight: bold;">CFTコンクリート施工管理システム</p></div>
    <div>
      <a  style="color:#FFFFFF;" href="pillselect.php">柱選択画面へ</a>
      <p>LoginID:<?= $userid ?></p>
  </div>
    </div>
  </nav>
</header>


<body>


<p style="height:100px;"></p>
<h3>施工管理画面</h3>
<div style="display: flex; justify-content:flex-start;margin:5px;">
    <div>
        <p style="font-size:20px;">現場名：<?= $gen_name ?></p>
        <p style="font-size:20px;">杭番号：<?= $pill_num ?></p>
    </div>
    <div>
        <input type="button" onclick="location.href='./accept.php'" value="受入検査へ" style='coler:white; border-color:#3b82f6;color:white; font-size:18px;margin:10px; background:#8EA9DB; border-radius:10px;width:120px;'>
        <input type="button" onclick="location.href='./time.php'" value="打設高管理へ" style='coler:white; border-color:#3b82f6;color:white; font-size:18px;margin:10px; background:#8EA9DB; border-radius:10px;'>
        <input type="button" onclick="window.open('https://d28000001pumpeaw.my.salesforce-sites.com/', '_blank')" value="配車管理へ" style="color:white; border-color:#3b82f6; font-size:18px; margin:10px; background:#8EA9DB; border-radius:10px;">


    </div>
</div>
    <div style="display: flex; justify-content:space-around;margin:5px;width:300px;padding:0px;">
        <p style="font-size:16px; margin:3px;">杭番号：<?= $pill_num ?></p>
        <p style="font-size:16px; margin:3px;">杭符号：<?= $pill_sign ?></p>
    </div>
    <div style="display: flex; justify-content:space-around;margin:5px;width:300px;padding:0px;">
        <p style="font-size:16px; margin:3px;">位置：<?=  $stcore_numX ?> － <?=  $stcore_numY ?></p>
        <p style="font-size:16px; margin:3px;">柱長：<?= $virtilength ?></p>

    </div>
















<!-- <div id="video">
 <iframe
   id="eizo" 
   src="http://10.58.224.6/live.asp?r=201610270.17104665163885002" 
   title="PC画面">
  </iframe>
</div> -->

<div style="display: flex; justify-content:space-around;margin:5px;width:300px;padding:0px;">
      <div  id="video1">
        <p>◆搬入口状況</p> 
          <iframe 
          width="400" height="300" src="https://www.youtube-nocookie.com/embed/9b8hzFfW5V0?si=T1kv2b6fwH9yvcPI" 
          title="YouTube video player" 
          frameborder="0" 
          allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
          referrerpolicy="strict-origin-when-cross-origin" allowfullscreen>
          </iframe>
      </div>


  
      <div id="video2">
        <div style="display: flex; justify-content:flex-start; margin:5px;padding:0px;">
            <p>◆充填状況確認</p>
            <form method="post"> 
                <input type="submit" name="button1" class="button" value="記録" style="margin-left:30px;"/> 
            </form> 
        </div>
        <div style="margin:0px auto; overflow:hidden;padding:0;width:400px;height:300px;" >
        <iframe
          src="http://10.58.224.6/live.asp?r=201610270.8554343267928939"

          id="MJPEG_streaming"
          style="transform: scale(0.6); transform-origin: top left; margin-top:-75px; margin-left:-160px;"
          width="1000" height="900" 
          title="PC画面2">
          </iframe>
          </div>
        <p style="font-size:16px; color:white; position:absolute; top:400px; left:450px;">杭番号：<?= $pill_num ?></p>
      <!-- http://218.219.233.189/viewer/live/ja/live.html"  "position:absolute; top:300px; left:350px;" "transform: scale(0.5);"-->

      </div>
</div>





<!-- 折れ線グラフ_コンクリート打設圧力管理 -->

  <p>◆コンクリート打設圧力管理</p>
  <div style="display: flex; justify-content:space-around;margin:5px;width:900px;padding:0px;">
      <div style="width:500px; margin:0;" >
        <canvas id="chart2"></canvas>
      </div>

      <div style="border: 10px outset #31A9EE; width:300px; padding:auto; background:#FFFF00;">
        <p style="font-size: 18px;">現在の計測値：1.556 MPa</p>
        <p>計測時間：10:11:23</p>
        <p>打設高さ：12.6m</p>
        <p style="font-size: 24px;">警報</p>
        <p>二次管理値超えです</p>
 
      </div>
    </div>



<!-- 折れ線グラフ_コンクリート打設高さ管理 -->
<div style="width:500px;" >
  <p>◆コンクリート打設高さ管理</p>
    <canvas id="chart"></canvas>
   </div>





  <!-- ここから上にコードを書く -->
  <!-- この中に記述していく -->
  <script type="text/javascript">
      const labels = ['0', '300', '600', '900', '1200', '1500', '1800'];
      const data = {
        labels: labels,
        datasets: [{
          label: '計測値(MPa)',
          data: [1.2, 0.559, 0.481, 0.658, 0.768, 0.952, 0.956],
          fill: false,
          borderColor: 'rgb(75, 192, 192)',
        },{
          label: '管理値',
          data: [1.5, 1.5, 1.5, 1.5, 1.5, 1.5, 1.5],
          fill: false,
          borderColor: 'rgb(192, 75, 192)',
          tension: 0.3
        }]
      };
      const config = {
        type: 'line',
        data: data,
      };
var ctx = document.getElementById('chart2').getContext('2d');
var myChart = new Chart(ctx, config);
</script>

<script type="text/javascript">
      var canvas;
      var ctx;

      function init() {
          canvas = document.getElementById("chart");
          canvas.style.position = "absolute";
          // canvas.style.right = "80px";
          // canvas.style.top = "260px";
          ctx = canvas.getContext("2d");
          
          draw();
      }

      function draw() {
          ctx.style = "#000000";
          ctx.rect( 0, 0, 100, 100 );
          ctx.stroke();
      }

      window.onload = function() {
          init();
      };


<!-- グラフ表示設定 -->

        var ctx = document.getElementById("chart");
        var myLineChart = new Chart(ctx, {
          // グラフの種類：折れ線グラフを指定
          type: 'line',
          data: {
            // x軸の各メモリ
            labels: [],
            datasets: [
              {
                label: '打上り完了時間',
                data: [],
                borderColor: "#ea2260",
                lineTension: 0, //<===追加
                fill: true, 
                backgroundColor: "#00000000"
                          
              },
            ],
          },
          options: {
            title: {
              display: true,
              text: '打上り高さ管理'
            },
            scales: {
              yAxes: [{
                        // type: 'time',
                        // distribution: 'series'
                        ticks: {
                          suggestedMax: 100,
                          suggestedMin: 50,
                          stepSize: 10,  // 縦メモリのステップ数
                          callback: function(value, index, values){

                    return  value +  'sec'  // 各メモリのステップごとの表記（valueは各ステップの値）
                  }
                }
              }]
            },
          }
        });




  </script>

</body>

</html>
<?php
//【重要】
/**
 * DB接続のための関数をfuncs.phpに用意
 * require_onceでfuncs.phpを取得
 * 関数を使えるようにする。
 */



//SESSIONスタート
session_start();
$userid = $_SESSION['userid'];
$username = $_SESSION['username'];
require_once('funcs.php');
//ログインチェック
// loginCheck();
$pdo = db_conn();



// 現場経歴一覧取得_emp_idで抽出
$stmt = $pdo->prepare("select * from clinic inner join cl_detail on clinic.id2 = cl_detail.id");
// $stmt->bindValue();
$status = $stmt->execute();



// 4．データ表示
$view = "<tr style='background: #A9D08E;color:#833C0C'><th width:5%;>番号</th><th width:20%;>医院名</th><th width:15%;>最寄り駅</th><th width:5%;>駅徒歩</th><th width:20%;>住所</th><th width:15%;>連絡先</th><th width:5%;>詳細表示</th></tr>";


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
        $view .= '<tr><td>'.$result['id'].'</td>';
        $view .= '<td>'.$result['cl_name'].'</td>';
        if($result['station'] == 1){
          $view .= '<td>長津田</td>';
        }elseif ($result['station'] == 2) {
          $view .= '<td>つくし野</td>';
        }elseif ($result['station'] == 3) {
          $view .= '<td>すずかけ台</td>';
        }else {
          $view .= '<td>南町田ｸﾞﾗﾝﾍﾞﾘｰﾊﾟｰｸ</td>';
        };
        $view .= '<td>'.$result['dis'].'分</td>';
        $view .= '<td>'.$result['address'].'</td>';
        $view .= '<td>'.$result['tel'].'</td>';
        
        $view .= '<td>';//追記
        $view .= '<a href="map.php?id='. $result['id'] . '">';
        $view .= '[詳細表示]';//追記
        $view .= '</a></td>';//追記
        $view .= '</tr>';//追記

       
        

// pinを打つための配列にデータを保存
// $latlon[] =  [$result['lat'],$result['lon'],$result['k_name']];
   $latlon[] =  [$result['lat'],$result['lon'],$result['cl_name'],$result['color']];
  }


 
   $latlon_json = json_encode($latlon); //JSONエンコード

}

// $stmt2 = $pdo2->prepare("select * from station");
// // $stmt->bindValue();
// $status2 = $stmt2->execute();

// if($status2==false) {
//   //execute（SQL実行時にエラーがある場合）
//   $error2 = $stmt2->errorInfo();
//   exit("ErrorQuery:".$error2[2]);
// }else{
// //Selectデータの数だけ自動でループしてくれる
// //FETCH_ASSOC=http://php.net/manual/ja/pdostatement.fetch.php
//   while( $result2 = $stmt2->fetch(PDO::FETCH_ASSOC)){ 
//     // pinを打つための配列にデータを保存
//    $latlon2[] =  [$result2['lat'],$result2['lon'],$result2['st_name'],$result2['color']];
//   }


 
//    $latlon_json2 = json_encode($latlon2); //JSONエンコード
// }
// var_dump($userid);
// var_dump($username);
// 


?>



<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>歯科医院一覧</title>
    <!-- <link rel="stylesheet" href="css/range.css"> -->
    <!-- <link rel="stylesheet" href="css/sample.css"> -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/range.css" rel="stylesheet">
    <script src="js/jquery-2.1.3.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.4/Chart.min.js"></script>

    <style>
        div {
            padding: 10px;
            font-size: 18px;
            color: #1e3a8a;
        }
    </style>
</head>

<body id="main">
    <!-- Head[Start] -->
    <header style="position: fixed;width:100%;z-index: 9999;">
        <nav class="navbar navbar-default" style="background:linear-gradient(to bottom, #8EA9DB 70%, #D9EAFF 100%); border-color:#305496;font-size:15px;">
            <div class="container-fluid">
                <div class="navbar-header" style="float: left;">
                    <a class="navbar-brand" href="index_u.php">新規登録</a>
                    <a class="navbar-brand" href="login.php">ログイン</a>

                  </div>

                    <div style="float: right;">
                    <p>LoginID:<?php echo $userid; ?></p>
                    
                </div>
            </div>
        </nav>
    </header>
    <!-- Head[End] -->



<div style="height:100px;">
    <p></p>
    
</div>

<div id="top" style="padding:20px; display: flex;">
<div>
  <p style="font-size:28px;padding:15px;">路線検索</p>
  </div>
 <div style="margin-top:10px;">
     <select name="路線選択" style='coler:white; border-color:#3b82f6;color:white; font-size:18px;margin-right:30px;padding:10px 20px; background:#8EA9DB; border-radius:10px;'>
     <option value="1">東急田園都市線</option>
     <option value="2">東急東横線</option>
     <option value="3">JR横浜線</option>
     </select>

     <input type="button" onclick="location.href='select4.php'" value="南町田ｸﾞﾗﾝﾍﾞﾘｰﾊﾟｰｸ"style='coler:white; border-color:#3b82f6;color:white; font-size:18px;margin-right:30px;padding:10px 20px; background:#3b82f6; border-radius:10px;'>
     <input type="button" onclick="location.href='select3.php'" value="すずかけ台"style='coler:white; border-color:#3b82f6;color:white; font-size:18px;margin-right:30px;padding:10px 20px; background:#3b82f6; border-radius:10px;'>
     <input type="button" onclick="location.href='select2.php'" value="つくし野"style='coler:white; border-color:#3b82f6;color:white; font-size:18px;margin-right:30px;padding:10px 20px; background:#3b82f6; border-radius:10px;'>
     <input type="button" onclick="location.href='select1.php'" value="長津田"style='coler:white; border-color:#3b82f6;color:white; font-size:18px;margin-right:30px;padding:10px 20px; background:#3b82f6; border-radius:10px;'>
    </div>
</div>

<div style="height:450px;">
   <P></P>
  </div>







    <!-- Main[Start] -->
    <div style="padding:10px;">
        <div class="container-fluid" style="background:#E6F1DF;padding:30px;border-radius:15px">
            <fieldset style="width: 100%;"> 
            <legend style="font-size:24px;color:#833C0C;">歯科医院一覧</legend>
              <table style="font-size: 12px;width: 100%;">
                <?= $view ?>
              </table> 
              
              </form>
              </fieldset>
        </div>
    </div>


    <!-- Main[End] -->
    








  <!-- <input type="submit" value="表示"> -->

    <!-- MapArea -->

  <div id="view_1"></div>

  <div id="myMap" style="width: 90%;height:450px;"></div>
  
  <!-- /MapArea -->




<!-- JQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<!-- JQuery -->

 

  <!-- jQuery&GoogleMapsAPI -->
  <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
  <script src='https://www.bing.com/api/maps/mapcontrol?callback=GetMap&key=Amd84VwxSptT2cHsO8hlJ93s6Yy8ffivd1BiyizIgmbeH3COcxKJWOj_W0Fw6F0I'
    async defer></script>
  <script src="js/BmapQuery.js"></script>
  
  <script>
    //****************************************
    //最初に実行する関数
    //****************************************
    function GetMap(){
      navigator.geolocation.getCurrentPosition(mapsInit, mapsError, set);
    }
    //****************************************
    //成功関数
    //****************************************
    let map;
    // let hairetsu;???
    function mapsInit(position){
      // 緯度経度取得 lat=緯度 lon=経度
      const now_lat = "35.52012919";
      const now_lon = "139.4798804";

      //Map表示
      map = new Bmap("#myMap");
      map.startMap(now_lat,now_lon,"load",14);//Mapの開始位置
      
      var latlon = JSON.parse('<?php echo $latlon_json; ?>'); //JSONでコード
      
      
      latlon.forEach(function (value, index) {
      console.log(value[0] + "," + value[1] + "," + value[2] + "," + value[3]);
    
      setTimeout(() => {

        const lat = value[0] ;
        const lon = value[1] ;
        const k_name = value[2] ;
        const color = value[3] ;

        let pin = map.pin(lat,lon,color);


        map.onPin(pin,"click",function(){
        map.infobox(lat,lon,k_name);});

        // sleep(1);
            }, (index+1)*10);
      });    
    }

    //****************************************
    //失敗関数
    //****************************************
    function mapsError(error) {
      let e = "";
      if (error.code == 1) { //1＝位置情報取得が許可されてない（ブラウザの設定）
        e = "位置情報が許可されてません";
      }
      if (error.code == 2) { //2＝現在地を特定できない
        e = "現在位置を特定できません";
      }
      if (error.code == 3) { //3＝位置情報を取得する前にタイムアウトになった場合
        e = "位置情報を取得する前にタイムアウトになりました";
      }
      alert("エラー：" + e);
    };
    //****************************************
    //オプション設定
    //****************************************
    const set = {
      enableHighAccuracy: true, //より高精度な位置を求める
      maximumAge: 20000, //最後の現在地情報取得が20秒以内であればその情報を再利用する設定
      timeout: 10000 //10秒以内に現在地情報を取得できなければ、処理を終了
    };

// マップ表示位置指定
const pos = $('#myMap').offset({
    top: 220,
    left: 50
});




    
  </script>




</body>
</html>
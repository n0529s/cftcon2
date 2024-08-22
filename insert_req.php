<?php
// 1. POSTデータ取得
//$name = filter_input( INPUT_GET, ","name" ); //こういうのもあるよ
//$email = filter_input( INPUT_POST, "email" ); //こういうのもあるよ

$youbi = $_POST["youbi"];
$jikantai = $_POST["jikantai"];
$jikan = $_POST["jikan"];
$koment = $_POST["koment"];
$cl_id = $_POST["cl_id"];

//SESSIONスタート
session_start();
$userid = $_SESSION['userid'];
$username = $_SESSION['username'];
require_once('funcs.php');
//ログインチェック
// loginCheck();
$pdo = db_conn();

$stmt = $pdo->prepare("select * from clinic where id2 = :cl_id");
$stmt->bindValue(':cl_id', $cl_id, PDO::PARAM_INT);
// $stmt->bindValue();
$status = $stmt->execute();

//4．データ表示
if ($status == false) {
    sql_error($status);
} else {
    $result = $stmt->fetch(

     );//ここを追記！！
}


$cl_name = $result['cl_name'];


$stmt = $pdo->prepare("select * from userid where userid = :userid");
$stmt->bindValue(':userid', $userid, PDO::PARAM_STR);
// $stmt->bindValue();
$status = $stmt->execute();

$val = $stmt->fetch(); //1レコードだけ取得する方法

$username = $val['username'];
$exdate = $val['exdate'];
$address = $val['address'];
$mail = $val['mail'];
$tel = $val['tel'];






// ３．SQL文を用意(データ登録：INSERT)
// $stmt = $pdo->prepare(
//   "insert into yama_kei_table( id, num, lat, lon, alt, k_name, s_year, y_name, etc, indate  )
//   VALUES( NULL, :num, :lat, :lon, :alt, :k_name, :s_year, :y_name, :etc, sysdate() )"
// );

// // 4. バインド変数を用意
// $stmt->bindValue(':num', $num, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
// $stmt->bindValue(':lat', $lat, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
// $stmt->bindValue(':lon', $lon, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
// $stmt->bindValue(':alt', $alt, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
// $stmt->bindValue(':k_name', $k_name, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
// $stmt->bindValue(':s_year', $s_year, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
// $stmt->bindValue(':y_name', $y_name, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
// $stmt->bindValue(':etc', $etc, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)

// // 5. 実行
// $status = $stmt->execute();

// // 6．データ登録処理後
// if($status==false){
//   //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
//   $error = $stmt->errorInfo();
//   exit("ErrorMassage:".$error[2]);
// }else{
//   //５．index.phpへリダイレクト
//   header('Location: index2.php');//ヘッダーロケーション（リダイレクト）
// }
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/range.css" rel="stylesheet">
    <script src="js/jquery-2.1.3.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.4/Chart.min.js"></script>
  <title>申請確認</title>
</head>
<body>
<header style="position: fixed;width:100%;z-index: 9999;">
        <nav class="navbar navbar-default" style="background:linear-gradient(to bottom, #8EA9DB 70%, #D9EAFF 100%); border-color:#305496;font-size:15px;">
            <div class="container-fluid" >
                <div class="navbar-header" style="float: left;">
                    <a class="navbar-brand">リクエスト</a>
                    <a class="navbar-brand" href="login.php">ログイン</a>
                    <a class="navbar-brand" href="select.php?">戻る</a>
                    
                </div>
                <div style="float: right;">
                    <p>LoginID:<?php echo $userid; ?></p>
                    
                </div>
            </div>
        </nav>
    </header>
  <p style="height:80px;"></p>  
  <h1 style="font-size:22px;">申請内容確認</h1>
<div style="display:flex;">
<div style="margin:20px;">
<p>申請内容</p>
<p>申請医院名：<?php echo $cl_name; ?></p>
<p>希望曜日：<?php echo $youbi; ?>曜日</p>
<p>希望時間帯：<?php echo $jikantai; ?></p>
<p>希望勤務時間：<?php echo $jikan; ?>時間</p>
<p>コメント欄：<?php echo $koment; ?></p>
</div>
<div style="margin:20px;">
<p>申請者名：<?php echo $username; ?></p>
<p>業務経験：<?php echo $exdate; ?>年</p>
<p>申請者住所：<?php echo $address; ?></p>
<p>連絡先(mail)：<?php echo $mail; ?></p>
<p>連絡先(tel)：<?php echo $tel; ?></p>
</div>
</div>

<div style="margin:10px;display:flex">
                        <form name="form2" action="insert_req2.php" method="post">
                                  <input type="hidden" name="cl_id" value=<?php echo $cl_id; ?>>
                                  <input type="hidden" name="userid" value=<?php echo $userid; ?>>
                                  <input type="hidden" name="youbi" value=<?php echo $youbi; ?>>
                                  <input type="hidden" name="jikantai" value=<?php echo $jikantai; ?>>
                                  <input type="hidden" name="jikan" value=<?php echo $jikan; ?>>
                                  <input type="hidden" name="koment" value=<?php echo $koment; ?>>
                                  <input type="hidden" name="userid" value=<?php echo $userid; ?>>


                            
                              <input type="submit" style="coler:white; border-color:#3b82f6;color:white; font-size:18px;margin-right:30px;padding:5px 20px; background:#8EA9DB; border-radius:10px;margin:10px;" value="申請" />
                          </form>










</body>
</html>
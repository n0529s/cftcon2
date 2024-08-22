<?php

// SESSIONスタート
session_start();
$userid = $_SESSION['userid'];
$username = $_SESSION['username'];
$gen_name = $_SESSION['gen_name'];
$pill_num = $_SESSION["pill_num"];

require_once('funcs.php');
// ログインチェック
// loginCheck();
$pdo = db_conn();


$num_times = $_POST["Num_times"];
$ac_slump = $_POST["Slump"];
$ac_air = $_POST["Air"];
$ac_temp = $_POST["Temp"];
$ac_chlo = $_POST['Chlo'];
$arr50 = $_POST['Arr50'];
$stop_time = $_POST['Stop_time'];
$bunri = $_POST['Bunri'];
$gouhi = $_POST['Gouhi'];
$memo = $_POST['Memo'];



//１. 接続します
require_once('funcs.php');
$pdo = db_conn();


// ２.登録情報検索
$stmt2 = $pdo->prepare("SELECT COUNT(*) AS count FROM conaccept WHERE gen_name=:gen_name &&  pill_num = :pill_num && num_times = :num_times");
$stmt2->bindValue(':gen_name', $gen_name, PDO::PARAM_STR);
$stmt2->bindValue(':pill_num', $pill_num, PDO::PARAM_STR);
$stmt2->bindValue(':num_times', $num_times, PDO::PARAM_STR);

$status2 = $stmt2->execute();

if ($status2 === false) {
    // エラーハンドリング
    sql_error($stmt2->errorInfo());
} else {
    $result2 = $stmt2->fetch(PDO::FETCH_ASSOC);
    $status2 = $result2["count"];
    
    // var_dump($status2);
}

// 登録済みの場合は+１
$num_times = $num_times + $status2;






// ３．SQL文を用意(データ登録：INSERT)
  $stmt = $pdo->prepare("INSERT INTO conaccept(id, gen_name, pill_num, num_times, slump_ac, air_ac, temp_ac, ion_ac, bunri, gouhi, reach_50, stop_time, memo, datetime) VALUES 
( NULL, :gen_name, :pill_num, :num_times, :slump_ac, :air_ac, :temp_ac, :ion_ac, :bunri, :gouhi, :reach_50, :stop_time, :memo, sysdate())");

// 4. バインド変数を用意
$stmt->bindValue(':gen_name', $gen_name, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':pill_num', $pill_num, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':num_times', $num_times, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':slump_ac', $ac_slump, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':air_ac', $ac_air, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':temp_ac', $ac_temp, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':ion_ac', $ac_chlo, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':reach_50', $arr50, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':stop_time', $stop_time, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':bunri', $bunri, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':gouhi', $gouhi, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':memo', $memo, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)





// 5. 実行
$status = $stmt->execute();

// 6．データ登録処理後
if($status==false){
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  $error = $stmt->errorInfo();
  exit("ErrorMassage:".$error[2]);
}else{
  //５．index.phpへリダイレクト
  header('Location: accept.php');//ヘッダーロケーション（リダイレクト）
}
//処理終了
exit();

?>



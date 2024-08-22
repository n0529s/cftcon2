<?php
// 1. POSTデータ取得
//$name = filter_input( INPUT_GET, ","name" ); //こういうのもあるよ
//$email = filter_input( INPUT_POST, "email" ); //こういうのもあるよ

$youbi = $_POST["youbi"];
$jikantai = $_POST["jikantai"];
$jikan = $_POST["jikan"];
$koment = $_POST["koment"];
$cl_id = $_POST["cl_id"];
$userid = $_POST["userid"];



var_dump($koment);






//SESSIONスタート
session_start();
$userid = $_SESSION['userid'];
$username = $_SESSION['username'];
require_once('funcs.php');
//ログインチェック
// loginCheck();
$pdo = db_conn();



var_dump($userid);





// ３．SQL文を用意(データ登録：INSERT)
$stmt = $pdo->prepare(
  "INSERT INTO request( id, cl_id, userid, youbi, jikantai, jikan, koment, rgdate)
  VALUES( NULL, :cl_id, :userid, :youbi, :jikantai, :jikan, :koment, sysdate())"
);

// 4. バインド変数を用意
$stmt->bindValue(':cl_id', $cl_id, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':userid', $userid, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':youbi', $youbi, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':jikantai', $jikantai, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':jikan', $jikan, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':koment', $koment, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)


// 5. 実行
$status = $stmt->execute();

// 6．データ登録処理後
if($status==false){
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  $error = $stmt->errorInfo();
  exit("ErrorMassage:".$error[2]);
}else{
  //５．index.phpへリダイレクト
  header('Location: map.php?id='.$cl_id);//ヘッダーロケーション（リダイレクト）
}

?>



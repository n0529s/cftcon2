<?php

session_start();
$userid = $_SESSION['userid'];
$username = $_SESSION['username'];
$gen_name = $_SESSION['gen_name'];
$pill_num = $_SESSION['pill_num'];

$floor_num = $_GET["id"];

var_dump($floor_num);


//1. 接続します
require_once('funcs.php');
$pdo = db_conn();





// ３．SQL文を用意(データ削除：INSERT)
$stmt = $pdo->prepare(
  "DELETE FROM `speed` WHERE gen_name = :gen_name AND pill_num = :pill_num AND floor_num = :floor_num"
);

// 3. パラメータをバインド
$stmt->bindValue(':gen_name', $gen_name, PDO::PARAM_STR);  // 文字列の場合はPDO::PARAM_STR
$stmt->bindValue(':pill_num', $pill_num, PDO::PARAM_STR);  // 数値の場合はPDO::PARAM_INT
$stmt->bindValue(':floor_num', $floor_num, PDO::PARAM_STR); // 数値の場合はPDO::PARAM_INT


// 5. 実行
$status = $stmt->execute();

// 6．データ登録処理後
if($status==false){
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  $error = $stmt->errorInfo();
  exit("ErrorMassage:".$error[2]);
}else{
  //５．index.phpへリダイレクト
  header('Location: time.php');//ヘッダーロケーション（リダイレクト）
}
//処理終了
exit();

?>



<?php

session_start();
$userid = $_SESSION['userid'];
$username = $_SESSION['username'];
$gen_name = $_SESSION['gen_name'];

$id = $_GET["id"];




//1. 接続します
require_once('funcs.php');
$pdo = db_conn();





// ３．SQL文を用意(データ削除：INSERT)
$stmt = $pdo->prepare(
  "DELETE FROM `conaccept` WHERE id = $id"
);

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



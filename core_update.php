<?php

session_start();

$axle = $_POST["axle"];
$stcore_num = $_POST["stcore_num"];
$stcore_coordineate = $_POST["stcore_coordineate"];
$gen_name = $_POST['gen_name'];
$stcore_id = $_POST['stcore_id'];

var_dump($gen_name);
var_dump($stcore_id);

//1. 接続します
require_once('funcs.php');
$pdo = db_conn();





// ３．SQL文を用意(データ登録：INSERT)
$stmt = $pdo->prepare(
  "UPDATE stcore SET gen_name = :gen_name, axle= :axle, stcore_num= :stcore_num, stcore_coordineate= :stcore_coordineate WHERE stcore_id = :stcore_id;"
);

// 4. バインド変数を用意
$stmt->bindValue(':stcore_id', $stcore_id, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':gen_name', $gen_name, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':axle', $axle, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':stcore_num', $stcore_num, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':stcore_coordineate', $stcore_coordineate, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)



// 5. 実行
$status = $stmt->execute();

// 6．データ登録処理後
if($status==false){
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  $error = $stmt->errorInfo();
  exit("ErrorMassage:".$error[2]);
}else{
  //５．index.phpへリダイレクト
  header('Location: core.php');//ヘッダーロケーション（リダイレクト）
}
//処理終了
exit();

?>



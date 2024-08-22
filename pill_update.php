<?php

session_start();

$pill_id = $_POST["pill_id"];
$pill_num = $_POST["pill_num"];
$pill_sign = $_POST["pill_sign"];
$virtilength = $_POST["virtilength"];
$stcore_numX = $_POST["stcore_numX"];
$stcore_numY = $_POST["stcore_numY"];
$offsetX = $_POST["offsetX"];
$offsetY = $_POST["offsetY"];
$gen_name = $_SESSION['gen_name'];

var_dump($gen_name);
var_dump($pill_id);

//1. 接続します
require_once('funcs.php');
$pdo = db_conn();





// ３．SQL文を用意(データ登録：INSERT)
$stmt = $pdo->prepare(
  "UPDATE design SET pill_num = :pill_num, virtilength= :virtilength, pill_sign= :pill_sign, stcore_numX= :stcore_numX, stcore_numY= :stcore_numY, offsetX= :offsetX, offsetY= :offsetY WHERE pill_id = :pill_id;"
);

// 4. バインド変数を用意
$stmt->bindValue(':pill_id', $pill_id, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':pill_num', $pill_num, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':pill_sign', $pill_sign, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':virtilength', $virtilength, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':stcore_numX', $stcore_numX, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':stcore_numY', $stcore_numY, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':offsetX', $offsetX, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':offsetY', $offsetY, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)


// 5. 実行
$status = $stmt->execute();

// 6．データ登録処理後
if($status==false){
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  $error = $stmt->errorInfo();
  exit("ErrorMassage:".$error[2]);
}else{
  //５．index.phpへリダイレクト
  header('Location: pill.php');//ヘッダーロケーション（リダイレクト）
}
//処理終了
exit();

?>



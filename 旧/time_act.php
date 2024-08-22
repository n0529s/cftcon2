<?php

session_start();
$gen_name = $_POST['gen_name'];
$pill_num = $_POST["pill_num"];
$floor_num = $_POST["floor_num"];





//1. 接続します
require_once('funcs.php');
$pdo = db_conn();





// ３．SQL文を用意(データ登録：INSERT)
$stmt = $pdo->prepare(
  "INSERT INTO speed( id, gen_name, pill_num, floor_num, rgtime)
  VALUES( NULL, :gen_name, :pill_num, :floor_num, sysdate())"
);

// 4. バインド変数を用意
$stmt->bindValue(':gen_name', $gen_name, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':pill_num', $pill_num, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':floor_num', $floor_num, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)


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



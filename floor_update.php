<?php

session_start();

$id = $_POST["id"];
$floor_num = $_POST["floor_num"];
$floor_height = $_POST["floor_height"];
$gen_name = $_SESSION['gen_name'];

var_dump($gen_name);


//1. 接続します
require_once('funcs.php');
$pdo = db_conn();





// ３．SQL文を用意(データ登録：INSERT)
$stmt = $pdo->prepare(
  "UPDATE floor SET floor_num = :floor_num, floor_height= :floor_height WHERE id = :id;"
);

// 4. バインド変数を用意
$stmt->bindValue(':id', $id, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':floor_num', $floor_num, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':floor_height', $floor_height, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)



// 5. 実行
$status = $stmt->execute();

// 6．データ登録処理後
if($status==false){
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  $error = $stmt->errorInfo();
  exit("ErrorMassage:".$error[2]);
}else{
  //５．index.phpへリダイレクト
  header('Location: floor.php');//ヘッダーロケーション（リダイレクト）
}
//処理終了
exit();

?>



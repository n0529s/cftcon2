<?php

session_start();
$gen_name = $_SESSION['gen_name'];
$pill_num = $_SESSION["pill_num"];
$floor_num = $_POST["floor_num"];
$measure_height = $_POST["measure_height"];



//1. 接続します
require_once('funcs.php');
$pdo = db_conn();

// ２．過去の履歴を検索
$stmt2 = $pdo->prepare(
  "SELECT COUNT(*) AS count FROM speed WHERE gen_name = :gen_name AND pill_num = :pill_num AND  floor_num = :floor_num");
  $stmt2->bindValue(':gen_name', $gen_name, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
  $stmt2->bindValue(':pill_num', $pill_num, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
  $stmt2->bindValue(':floor_num', $floor_num, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)

  $status2 = $stmt2->execute();
  if ($status2 === false) {
    // エラーハンドリング
    sql_error($stmt2->errorInfo());
} else {
    $result2 = $stmt2->fetch(PDO::FETCH_ASSOC);
    $status2 = $result2["count"];
    
    var_dump($status2);
}




// ３．SQL文を用意(データ登録：INSERT)
if($status2 != 0){
  header('Location: time.php');
}else{

$stmt = $pdo->prepare(
  "INSERT INTO speed( id, gen_name, pill_num, floor_num, measure_height, rgtime)
  VALUES( NULL, :gen_name, :pill_num, :floor_num, :measure_height, sysdate())"
);

// 4. バインド変数を用意
$stmt->bindValue(':gen_name', $gen_name, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':pill_num', $pill_num, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':floor_num', $floor_num, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':measure_height', $measure_height, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)

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

}

?>



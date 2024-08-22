<?php

session_start();

$gen_name = $_SESSION['gen_name'];
$pill_sign = $_POST["pill_sign"];
$floor_num = $_POST["floor_num"];
$floor_height = $_POST["floor_height"];
$pill_crossnum = $_POST["pill_crossnum"];
$gr_name = $_POST["gr_name"];



var_dump($gen_name);
var_dump($pill_sign);
var_dump($floor_num);
var_dump($floor_height);
var_dump($pill_crossnum);


//1. 接続します
require_once('funcs.php');
$pdo = db_conn();


// ３．SQL文を用意(データ登録：INSERT)
$floorNum = count($floor_num);
var_dump($floor_num[3]);

$i = 0;
 while($i !== $floorNum){ 
  // if($pill_crossnum[$i] != ""){
    $stmt = $pdo->prepare("insert into pillvirtispec(id, gen_name, pill_sign, floor_num, floor_height, gr_name, pill_crossnum ) VALUES 
  ( NULL, :gen_name, :pill_sign, :floor_num, :floor_height, :gr_name, :pill_crossnum)");
  
  $stmt->bindValue(':gen_name', $gen_name, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
  $stmt->bindValue(':pill_sign', $pill_sign, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
  $stmt->bindValue(':floor_num', $floor_num[$i], PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
  $stmt->bindValue(':floor_height', $floor_height[$i], PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
  $stmt->bindValue(':gr_name', $gr_name, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
  $stmt->bindValue(':pill_crossnum', $pill_crossnum[$i], PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
  
// 5. 実行
$status = $stmt->execute();
  // }
   
  

  $i++;//ブロック最後の行に到達したら、iに1を加算する
}









// 6．データ登録処理後
if($status==false){
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  $error = $stmt->errorInfo();
  exit("ErrorMassage:".$error[2]);
}else{
  //５．index.phpへリダイレクト
  header('Location: pillvirtispec.php');//ヘッダーロケーション（リダイレクト）
}











//処理終了
exit();

?>



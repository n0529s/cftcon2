<?php

session_start();
$userid = $_SESSION['userid'];
$username = $_SESSION['username'];
$gen_name = $_SESSION['gen_name'];
$status = $_SESSION['status'];

$contype = $_POST["Type"];
$constrength = $_POST["Strength"];
$conflow = $_POST["Flow"];
$span = $_POST["Span"];
$contempmin = $_POST['Tempmin'];
$contempmax = $_POST['Tempmax'];
$air = $_POST['Air'];
$airspan = $_POST['AirSpan'];
$chlomax = $_POST['ChloMax'];





var_dump($gen_name);
var_dump($status);
var_dump($chlomax);

$slumpmax = $conflow + $span;
$slumpmin = $conflow - $span;
$airmax = $air + $airspan;
$airmin = $air - $airspan;

var_dump($airmin);



//1. 接続します
require_once('funcs.php');
$pdo = db_conn();



// ３．SQL文を用意(データ登録：INSERT)

if($status = 0){
      $stmt = $pdo->prepare(
        "INSERT INTO constmanege( id, gen_name, contype, constrength, conflow, slumpmax,slumpmin,airmax,airmin,chlomax,contempmin,contempmax)
        VALUES( NULL, :gen_name, :contype, :constrength, :conflow, :slumpmax, :slumpmin, :airmax, :airmin, :chlomax, :contempmin, :contempmax)"
      );
      // 4. バインド変数を用意
      $stmt->bindValue(':gen_name', $gen_name, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
      $stmt->bindValue(':contype', $contype, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
      $stmt->bindValue(':constrength', $constrength, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
      $stmt->bindValue(':conflow', $conflow, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
      $stmt->bindValue(':slumpmax', $slumpmax, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
      $stmt->bindValue(':slumpmin', $slumpmin, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
      $stmt->bindValue(':airmax', $airmax, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
      $stmt->bindValue(':airmin', $airmin, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
      $stmt->bindValue(':chlomax', $chlomax, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
      $stmt->bindValue(':contempmin', $contempmin, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
      $stmt->bindValue(':contempmax', $contempmax, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)  
      // 5. 実行
      $status = $stmt->execute();
      // 6．データ登録処理後
      if($status==false){
        //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
        $error = $stmt->errorInfo();
        exit("ErrorMassage:".$error[2]);
      }else{
        //５．index.phpへリダイレクト
        header('Location: constandard.php');//ヘッダーロケーション（リダイレクト）
      }
      //処理終了
      exit();

}else{
    // ３．SQL文を用意(データ登録：INSERT)
      $stmt = $pdo->prepare(
        "UPDATE constmanege SET gen_name=:gen_name,contype=:contype,constrength=:constrength,conflow=:conflow,slumpmax=:slumpmax,slumpmin=:slumpmin,airmax=:airmax,airmin=:airmin,chlomax=:chlomax,contempmin=:contempmin,contempmax=contempmax WHERE gen_name=:gen_name;"
      );
      // 4. バインド変数を用意
      $stmt->bindValue(':gen_name', $gen_name, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
      $stmt->bindValue(':contype', $contype, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
      $stmt->bindValue(':constrength', $constrength, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
      $stmt->bindValue(':conflow', $conflow, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
      $stmt->bindValue(':slumpmax', $slumpmax, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
      $stmt->bindValue(':slumpmin', $slumpmin, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
      $stmt->bindValue(':airmax', $airmax, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
      $stmt->bindValue(':airmin', $airmin, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
      $stmt->bindValue(':chlomax', $chlomax, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
      $stmt->bindValue(':contempmin', $contempmin, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
      $stmt->bindValue(':contempmax', $contempmax, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
      // 5. 実行
      $status = $stmt->execute();
      // 6．データ登録処理後
      if($status==false){
        //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
        $error = $stmt->errorInfo();
        exit("ErrorMassage:".$error[2]);
      }else{
        //５．index.phpへリダイレクト
        header('Location: constandard.php');//ヘッダーロケーション（リダイレクト）
      }
      //処理終了
      exit();
}

?>



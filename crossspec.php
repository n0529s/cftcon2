<?php
$gr_name ="";
//SESSIONスタート
session_start();
$userid = $_SESSION['userid'];
$username = $_SESSION['username'];
$gen_name = $_SESSION['gen_name'];
// $gr_name = $_POST['gr_name'];

$gr_name2 = $_SESSION["gr_name2"];






// var_dump($gr_name2);
// var_dump($gr_name);

// $gr_name = $_POST['gr_name'];
if($gr_name != ""){
  $_SESSION["gr_name2"] = $gr_name;
}else{
$gr_name = $gr_name2;
}


require_once('funcs.php');
//ログインチェック 
// loginCheck();
$pdo = db_conn();

// 現場経歴一覧取得_emp_idで抽出
$stmt = $pdo->prepare("SELECT * from pillcrossspec WHERE 1");
$status2 = $stmt->execute();


$view_x = "<tr style='background-color: #BDD7EE;color:#833C0C'><th width:20%;>断面名</th><th width:10%;>X寸法</th><th width:10%;>Y寸法</th><th width:10%;>肉厚mm</th><th width:10%;>開口径</th><th width:10%;>隅部R</th><th width:10%;>断面積</th><th width:20%;>修正</th><th width:20%;>削除</th></tr>";

// var_dump($status);

$select = "<select name='gr_name' style='color:white; border-color:#3b82f6;color:white; font-size:18px;margin:10px; background-color:#8EA9DB; border-radius:5px; width:200px;'>";
$select .= "<br><option value=''>-</option>";
// 配列グループ作成
$gr_name_a= array();
$gr_name_b= "";

if($status2==false) {
  //execute（SQL実行時にエラーがある場合）
  $error = $stmt->errorInfo();
  exit("ErrorQuery:".$error[2]);
}
else{
//Selectデータの数だけ自動でループしてくれる
//FETCH_ASSOC=http://php.net/manual/ja/pdostatement.fetch.php
  while( $result2 = $stmt->fetch(PDO::FETCH_ASSOC)){ 
      
      // 前回の配列呼び出し
      $gr_name_c = $gr_name_b;
      // 配列に値を追加
      $gr_name_a[] = $result2['gr_name'];
      // 配列内の重複を削除
      $gr_name_b = array_unique($gr_name_a);

      if($gr_name_c != $gr_name_b ){
        if($gr_name == $result2['gr_name']){
          
          $select .= '<option value="'.$result2['gr_name'].'"selected>'.$result2['gr_name'].'</option>';
        }
        elseif($gr_name == $result2['gr_name']){

          $select .= '<option value="'.$result2['gr_name'].'"selected>'.$result2['gr_name'].'</option>';
        }
      
        else{
        
          $select .= '<option value="'.$result2['gr_name'].'">'.$result2['gr_name'].'</option>';
        }
        
      }
    }
    $select .= '</select>';
    }





  
    




$stmt = $pdo->prepare("SELECT * FROM pillcrossspec WHERE gr_name = :gr_name");
$stmt->bindValue(':gr_name', $gr_name, PDO::PARAM_STR);
$status = $stmt->execute();

if($status==false) {
  //execute（SQL実行時にエラーがある場合）
  $error = $stmt->errorInfo();
  exit("ErrorQuery:".$error[2]);
}
else{
//Selectデータの数だけ自動でループしてくれる
//FETCH_ASSOC=http://php.net/manual/ja/pdostatement.fetch.php
  while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){ 
      //GETデータ送信リンク作成
      // <a>で囲う。
      
      $view_x .= '<tr><td>'.$result['pill_crossnum'].'</td>';
      $view_x .= '<td>'.$result['pillsize_x'].'</td>';
      $view_x .= '<td>'.$result['pillsize_y'].'</td>';
      $view_x .= '<td>'.$result['thickness'].'</td>';
      $view_x .= '<td>'.$result['mouth'].'</td>';
      $view_x .= '<td>'.$result['sumiR'].'</td>';
      $view_x .= '<td>'.$result['cs_area'].'</td>';
      $view_x .= '<td id="ss"><a href=crossspec_ss.php?id='.$result['id'].'>修正</td>';
      $view_x .= '<td id="aa"><a href=crossspec_aa.php?id='.$result['id'].'>削除</td>';
      $view_x .= '</tr>';

  }
}
    
      
// var_dump($gr_name);

// var_dump($result['gen_name']);

?>




<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width">
<link rel="stylesheet" href="css/main.css" />
<link href="css/bootstrap.min.css" rel="stylesheet">
<style>div{padding: 10px;font-size:16px;}</style>
<title>断面入力</title>
</head>
<body>

<header style="position: fixed;width:100%;z-index: 9999;">
  <nav class="navbar navbar-default" style="background:linear-gradient(to bottom, #8EA9DB 70%, #D9EAFF 100%); border-color:#305496;font-size:15px;display:flex;justify-content:space-between;">
    <div class="container-fluid"><p style="font-size: 20px;color:#E2EFDA;font-weight: bold;">CFTコンクリート施工管理システム</p></div>
    <div>
      <a class="navbar-brand" href="login.php">TOPページ</a>
      <p>LoginID:<?= $userid ?></p>
  </div>
    </div>
  </nav>
</header>



<p style="height:100px;"></p>

<p style="font-size:20px;">現場名：<?= $gen_name ?></p>
<h3>断面設定</h3>

<form name="form2" action="crossspec.php" method="post" style="font-size:14px;">
<div style="display: flex;justify-content:flex-start;margin:5px;width:600px;">
<?= $select ?>
<input style="margin-left:30px;" type="submit" value="選択" />
</div>
</form>


<form name="form1" action="crossspec2.php" method="post" style="font-size:14px;">
    <div style="display: flex;justify-content:flex-start;margin:5px;width:600px;">
        <p style="font-size:20px;margin:10px;">新規グループ名:</p>
        <input type="text" name="gr_name" style="margin:10px;width:200px;"/>
        <p style="margin:0px;">※追加の場合は、未入力</p>
    </div>

   

    <div style="display: flex;justify-content:flex-start;margin:5px;width:600px;">
        <p style="font-size:20px;margin:10px;">断面名:</p>
        <input type="text" name="pill_crossnum" style="margin:10px;width:200px;" required="required"/>
    </div>
    <div style="display: flex; justify-content:flex-start;margin:10px;width:600px;">
        <p style="font-size:20px;margin:10px;">X寸法:</p>
        <input type="text" name="pillsize_x" style="margin:10px;width:100px;" required="required"/>
        <p style="font-size:14px;margin:10px;">mm</p>
        <p style="font-size:20px;margin:10px;"> Y寸法:</p>
        <input type="text" name="pillsize_y" style="margin:10px;width:100px;" required="required"/>
        <p style="font-size:14px;margin:10px;">mm</p>
    </div>
    <div style="display: flex; justify-content:flex-start;margin:10px;width:600px;">
        <p style="font-size:20px;margin:10px;">肉 厚:</p>
        <input type="text" name="thickness" style="margin:10px;width:100px" required="required"/>
          <p style="font-size:14px;margin:10px;">mm</p>
        <p style="font-size:20px;margin:10px;">開口径:</p>
        <input type="text" name="mouth" style="margin:10px;width:100px"/><br>
        <p style="font-size:14px;margin:10px;">mm</p>
      </div>
      <div style="display: flex; justify-content:flex-start;margin:10px;width:600px;">
        <p style="font-size:20px;margin:10px;">隅部曲率半径R:</p>
        <input type="checkbox" name="sumiR" style="margin:10px;width:100px"/><br>
        <p style="font-size:14px;margin:10px;">mm</p>
      <input style="margin-left:30px;" type="submit" value="登録" />
      </div>
 </form>



 <p>断面登録値</p>
<table style="font-size: 12px;width: 600px;margin-bottom:20px;">
 <?= $view_x ?>
</table>


 <input type="button" onclick="location.href='./sekkei.php'" value="設計入力に戻る" style='coler:white; border-color:#3b82f6;color:white; font-size:18px;margin:10px; background:#8EA9DB; border-radius:10px;'>
 <input type="button" onclick="location.href='./pillvirtispec.php'" value="柱符号設定画面へ" style='coler:white; border-color:#3b82f6;color:white; font-size:18px;margin:10px; background:#8EA9DB; border-radius:10px;'>




</body>
</html>
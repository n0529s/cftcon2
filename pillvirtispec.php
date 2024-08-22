<?php

//SESSIONスタート
session_start();
$userid = $_SESSION['userid'];
$username = $_SESSION['username'];
$gen_name = $_SESSION['gen_name'];




require_once('funcs.php');


//ログインチェック
// loginCheck();
$pdo = db_conn();


// ２．断面グループ選択＿断面グループ抽出
$stmt = $pdo->prepare("SELECT * from pillcrossspec WHERE 1");
$status2 = $stmt->execute();



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
        // if($gr_name == $result2['gr_name']){
          
        //   $select .= '<option value="'.$result2['gr_name'].'"selected>'.$result2['gr_name'].'</option>';
        // }
        // elseif($gr_name == $result2['gr_name']){

        //   $select .= '<option value="'.$result2['gr_name'].'"selected>'.$result2['gr_name'].'</option>';
        // }
      
        // else{
        
          $select .= '<option value="'.$result2['gr_name'].'">'.$result2['gr_name'].'</option>';
        // }
        
      }
    }
    $select .= '</select>';
    }
  

 // ３．断面選択＿断面名抽出


// $stmt = $pdo->prepare("SELECT * from pillcrossspec WHERE gr_name = :gr_name");
// $stmt->bindValue(':gr_name', $gr_name, PDO::PARAM_STR);
// $status3 = $stmt->execute();



// // var_dump($status);

// $select3 = "<select name='pill_crossnum[]' style='color:white; border-color:#3b82f6;color:white; font-size:16px;margin:5px; background-color:#8EA9DB; border-radius:5px; width:200px;height:30px;'>";
// $select3 .= "<br><option value=''>-</option>";
// // 配列グループ作成


// if($status3==false) {
//   //execute（SQL実行時にエラーがある場合）
//   $error = $stmt->errorInfo();
//   exit("ErrorQuery:".$error[2]);
// }
// else{
// //Selectデータの数だけ自動でループしてくれる
// //FETCH_ASSOC=http://php.net/manual/ja/pdostatement.fetch.php
//   while( $result3 = $stmt->fetch(PDO::FETCH_ASSOC)){ 
//           $select3 .= '<option value="'.$result3['pill_crossnum'].'">'.$result3['pill_crossnum'].'</option>';
//         }
        
//       }
    
//     $select3 .= '</select>';







// ４．フロア名表示＿フロア情報抽出
$stmt = $pdo->prepare("SELECT * FROM floor WHERE gen_name = :gen_name ORDER BY id DESC "); 
$stmt->bindValue(':gen_name', $gen_name, PDO::PARAM_STR);
$status = $stmt->execute();


$view_v = '<div style="display:flex; flex-direction:column;margin:5px;width:300px; align-items: center">';

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
      
      $view_v .= '<div style="display: flex;justify-content:flex-start;margin:0px;padding:0px;width:300px;">'; // Added semicolon
      $view_v .= '<p style="margin:10px;">' . $result['floor_num'] . '</p>';
      $view_v .= ' <input type="hidden" name="floor_num[]" value="'.$result['floor_num'] .'">';
      $view_v .= ' <input type="hidden" name="floor_height[]" value="'.$result['floor_height'] .'">';
      // $view_v .= $select3; 
      $view_v .= '</div>';
      
  }
}


// ５５．表一覧＿杭符号情報抽出
$stmt = $pdo->prepare("select * from pillvirtispec where gen_name = :gen_name ORDER BY id DESC ");
$stmt->bindValue(':gen_name', $gen_name, PDO::PARAM_STR);
$status = $stmt->execute();


// 配列グループ作成
$pill_sign_a= array();
$pill_sign_b= "";

$floor_num_a= array();
$floor_num_b="";


if($status==false) {
  //execute（SQL実行時にエラーがある場合）
  $error = $stmt->errorInfo();
  exit("ErrorQuery:".$error[2]);
}
else{
//Selectデータの数だけ自動でループしてくれる
//FETCH_ASSOC=http://php.net/manual/ja/pdostatement.fetch.php

$view_vspec = '<tr style="background: #BDD7EE;color:#833C0C;align:center;"><th style="width:50px;">階高</th>';

$view_vspec3 = "<tr><td></td>";
$view_vspec4 = "<tr><td></td>";
// $floor_num_total ="";


  while( $result4 = $stmt->fetch(PDO::FETCH_ASSOC)){ 
      
      // 前回の配列呼び出し
      $pill_sign_c = $pill_sign_b;
      // 配列に値を追加
      $pill_sign_a[] = $result4['pill_sign'];
      // 配列内の重複を削除
      $pill_sign_b = array_unique($pill_sign_a);

      if($pill_sign_c != $pill_sign_b ){
        $view_vspec .= '<th style="width:150px;">'.$result4['pill_sign'].'</th>';

        $view_vspec3.= '<td id="ss"><a href=pillvirtispec_ss.php?id='.$result4['pill_sign'].'>修正</td>';
        $view_vspec4 .= '<td id="aa"><a href=pillvirtispec_aa.php?id='.$result4['pill_sign'].'>削除</td>';
      }

      // 前回の配列呼び出し
        $floor_num_c = $floor_num_b;
      // 配列に値を追加
        $floor_num_a[] = $result4['floor_num'];
      // 配列内の重複を削除
        $floor_num_b = array_unique($floor_num_a);
    }
  }

$view_vspec .= '</tr>';

$view_vspec2 ="";

$floorNum = count($floor_num_c);

// var_dump($floorNum);
// var_dump($pill_sign_a);



$i = 0;
while($i !== $floorNum){ 

  $view_vspec2 .= '<tr><td align="center">'.$floor_num_c[$i].'</td>';

// 55.表一覧＿杭符号情報抽出2
$stmt = $pdo->prepare("select * from pillvirtispec where gen_name = :gen_name AND floor_num = :floor_num ORDER BY id DESC");
$stmt->bindValue(':gen_name', $gen_name, PDO::PARAM_STR);
$stmt->bindValue(':floor_num', $floor_num_c[$i], PDO::PARAM_STR);

$status = $stmt->execute();


$pill_sign1= array();
$pill_sign2= "";

if($status==false) {
      //execute（SQL実行時にエラーがある場合）
  $error = $stmt->errorInfo();
  exit("ErrorQuery:".$error[2]);
    }
else{
//Selectデータの数だけ自動でループしてくれる
  while( $result5 = $stmt->fetch(PDO::FETCH_ASSOC)){
    // 前回の配列呼び出し
    $pill_sign3 = $pill_sign2;
    // 配列に値を追加
    $pill_sign1[] = $result5['pill_sign'];
    // 配列内の重複を削除
    $pill_sign2 = array_unique($pill_sign1);

    if($pill_sign3 != $pill_sign2 ){
      $view_vspec2 .= '<td>'.$result5['pill_crossnum'].'</td>';
    }else{
      $view_vspec2 .= '</tr>';
    }
     
  
  }
}
$i++;//ブロック最後の行に到達したら、iに1を加算する

}


$view_vspec3 .= '</tr>';
$view_vspec4 .= '</tr>';


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
<h3>柱符号設定</h3>



<div style="display: flex;justify-content:flex-start;">
<form name="form2" action="pillvirtispec2.php" method="post" style="font-size:14px;">
<div style="display: flex;justify-content:flex-start;margin:5px;width:600px;">
<p style="font-size:20px;margin:10px;">断面選択：</p>
<?= $select ?>
<input style="margin-left:30px;" type="submit" value="選択" />
</div>
</div>
</form>

<div style="display: flex;justify-content:flex-start;">
<form name="form1" action="pillvirtispec_act.php" method="post" style="font-size:14px;">
<div style="display: flex; justify-content:flex-start;margin:5px;">
<p style="font-size:20px;margin:10px;">柱符号入力：</p>
 <input type="text" name="pill_sign" style="margin:10px;Width:100px;"/>
</div>
<p style="font-size:20px;margin:10px;">階毎断面設定：</p>
<?= $view_v ?>

<input style="font-size:20px;margin:10px;" type="submit" value="登録" />

</form>

</div>





<div>
 <p>断面フロア登録値</p>
<table style="font-size: 12px;margin-bottom:20px;">
<?= $view_vspec ?>
<?= $view_vspec2 ?>
<?= $view_vspec3 ?>
<?= $view_vspec4 ?>
</table>

</div>

</div>


 <input type="button" onclick="location.href='./sekkei.php'" value="設計入力に戻る" style='coler:white; border-color:#3b82f6;color:white; font-size:18px;margin:10px; background:#8EA9DB; border-radius:10px;'>
 <input type="button" onclick="location.href='./pill.php'" value="柱設定画面へ" style='coler:white; border-color:#3b82f6;color:white; font-size:18px;margin:10px; background:#8EA9DB; border-radius:10px;'>
 <input type="button" onclick="location.href='./crossspec.php'" value="柱断面設定画面へ" style='coler:white; border-color:#3b82f6;color:white; font-size:18px;margin:10px; background:#8EA9DB; border-radius:10px;'>




</body>
</html>
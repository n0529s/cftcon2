<?php
//SESSIONスタート
session_start();
$userid = $_SESSION['userid'];
$username = $_SESSION['username'];
$gen_name = $_SESSION['gen_name'];
$pill_num = $_SESSION["pill_num"];
$num_times = $_SESSION["num_times"];


// $images = $_POST["file1"];

// var_dump($_FILES);


require_once('funcs.php');
//ログインチェック
// loginCheck();
$pdo = db_conn();
    if (isset($_POST['upload'])) {//送信ボタンが押された場合
        $image1 = uniqid(mt_rand(), true);//ファイル名をユニーク化
        $image1 .= '.' . substr(strrchr($_FILES['image1']['name'], '.'), 1);//アップロードされたファイルの拡張子を取得
        $file = "images/$image1";
        $sql = " INSERT INTO image_accept(id, gen_name, pill_num, num_times, image1, rgtime) VALUES(NULL,:gen_name,:pill_num,:num_times,:image1,sysdate())";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':image1', $image1, PDO::PARAM_STR);
        $stmt->bindValue(':gen_name', $gen_name, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
        $stmt->bindValue(':pill_num', $pill_num, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
        $stmt->bindValue(':num_times', $num_times, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)

        if (!empty($_FILES['image1']['name'])) {//ファイルが選択されていれば$imageにファイル名を代入
            move_uploaded_file($_FILES['image1']['tmp_name'], './images/' . $image1);//imagesディレクトリにファイル保存
            if (exif_imagetype($file)) {//画像ファイルかのチェック
                $message = '画像をアップロードしました';
                $stmt->execute();
            } else {
                $message = '画像ファイルではありません';
            }
        }
    }

// ５．２ 画像ファイルアップロード２
$pdo = db_conn();
if (isset($_POST['upload2'])) {//送信ボタンが押された場合
    $image2 = uniqid(mt_rand(), true);//ファイル名をユニーク化
    $image2 .= '.' . substr(strrchr($_FILES['image2']['name'], '.'), 1);//アップロードされたファイルの拡張子を取得
    $file2 = "images/$image2";
    $sql = " INSERT INTO image_accept2(id, gen_name, pill_num, num_times, image2, rgtime) VALUES(NULL,:gen_name,:pill_num,:num_times,:image2,sysdate())";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':image2', $image2, PDO::PARAM_STR);
    $stmt->bindValue(':gen_name', $gen_name, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
    $stmt->bindValue(':pill_num', $pill_num, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
    $stmt->bindValue(':num_times', $num_times, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)

    if (!empty($_FILES['image2']['name'])) {//ファイルが選択されていれば$imageにファイル名を代入
        move_uploaded_file($_FILES['image2']['tmp_name'], './images/' . $image2);//imagesディレクトリにファイル保存
        if (exif_imagetype($file2)) {//画像ファイルかのチェック
            $message = '画像をアップロードしました';
            $stmt->execute();
        } else {
            $message = '画像ファイルではありません';
        }
    }
}


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



<h1>画像アップロード</h1>
<!--送信ボタンが押された場合-->
<?php if (isset($_POST['upload'])): ?>
    <p><?php echo $message; ?></p>
    <p><a href="image.php">画像表示へ</a></p>
<?php else: ?>
    <form method="post" enctype="multipart/form-data">
        <p>アップロード画像</p>
        <input type="file" name="image">
        <button><input type="submit" name="upload" value="送信"></button>
    </form>
<?php endif;?>

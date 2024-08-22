<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width">
<link rel="stylesheet" href="css/main.css" />
<link href="css/bootstrap.min.css" rel="stylesheet">
<style>div{padding: 10px;font-size:16px;}</style>
<title>ログイン</title>
</head>
<body>

<header style="position: fixed;width:100%;z-index: 9999;">
  <nav class="navbar navbar-default" style="background:linear-gradient(to bottom, #8EA9DB 70%, #D9EAFF 100%); border-color:#305496;font-size:15px;display:flex;justify-content:space-between;">
    <div class="container-fluid"><p style="font-size: 20px;font-color:#E2EFDA">CFTコンクリート施工管理システム</p></div>
    <div><a class="navbar-brand" href="login.php">TOPページ</a></div>
  </nav>
</header>



<p style="height:100px;"></p>
<h2 style="margin-left:10px;">ログインフォーム</h2>
<!-- lLOGINogin_act.php は認証処理用のPHPです。 -->
 <div style="margin-left:10px;">
<form name="form1" action="login_act.php" method="post">
ＩＤ：　<input type="text" name="userid" /><br>
<p></p>
ＰＷ：　<input type="password" name="userpw" /><br>
<p></p>
<p>　　　　　　</p><input type="submit" value="LOGIN" />


</form>
</div>

</body>
</html>
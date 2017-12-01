<?php
//エラー表示
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors','On');
require '../booststrap.php';
$session = new Session();//セッションクラス
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>HAL学生管理システム|メニュー画面</title>
<!--Import Google Icon Font-->
<!--<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"> -->
<!--Import materialize.css-->
<link type="text/css" rel="stylesheet" href="css/reset/html5reset-1.6.1.css" />
<!--<link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/> -->
<link type="text/css" rel="stylesheet" href="css/bootstrap.min.css" />
<link type="text/css" rel="stylesheet" href="css/desin_enrollment.css" />
<!--Let browser know website is optimized for mobile-->
</head>
<body>
<div id="wrapper">
   <div id="header">
     <div class="page-header">
        <h1>HAL学生管理システム　　        <small>サブ・テキスト</small></h1>
        <div id="userinfo_box">
          <p><?php echo $name = $session -> get("loginUser");?>さんがログイン中</p>
          <a href="logout.php" >ログアウト</a>
        </div><!-- end userinfo_box -->
       </div><!-- end header -->
    </div><!-- end page-header -->
    <div id="nav_box">

    </div><!-- end nav_box -->
    <div id="content">
     <div id="enrollment_box">
      <a href="enrollment.php"><button type="button" class="btn btn-default btn-block">在籍確認</button></a>
     </div><!-- end enrollment_box -->
     <div id="event_box">
      <a href="events.php"><button type="button" class="btn btn-default btn-block">イベント掲示板</button></a>
     </div><!-- end event_box -->
     <div id="lost_box">
       <a href="lost_article.php"><button type="button" class="btn btn-default btn-block">忘れ物掲示板</button></a>
     </div><!-- end lost_box -->
     <div id="aaa">
       <a href="#"><button type="button" class="btn btn-default btn-block">？？？？</button></a>
     </div><!-- end aaa -->
  </div><!-- end content -->
  <div id="footer">
    <div id="footer_box">

    </div><!-- end footer_box -->
  </div><!-- end footer -->
</div><!-- end wrapper -->
<!--Import jQuery before materialize.js-->
<script type="text/javascript" src="jq/jquery-3.2.1.min.js"></script>
<!--<script type="text/javascript" src="js/materialize.min.js"></script> -->
</body>
</html>

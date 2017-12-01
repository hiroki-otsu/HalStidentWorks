<?php
//エラー表示
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors','On');
//外部ファイル読み込み
require '../booststrap.php';
//インスタンス化
$session = new Session();//セッションクラス
$dataAccess = new DataAccess();//データアクセスクラス
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>HAL学生管理システム|イベント投稿</title>
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
      <ol class="breadcrumb">
       <li><a href="menu.php"><span class="glyphicon glyphicon-home" aria-hidden="true"></span>メニュー画面</a></li>
       <li class="active"><a href="events.php">イベント掲示板</a></li>
       <li class="active">イベント投稿</li>
     </ol>
  </div>
  <div id="content">
    <div class="panel panel-default">
      <div class="panel-heading">
        LINK
      </div>
      <div class="list-group">
        <a class="list-group-item size" href="menu.php">メニュー画面</a>
        <a class="list-group-item list-group-item-info"  href="events.php">イベント掲示板</a>
        <a class="list-group-item size" href="lost_article.php">忘れ物掲示板</a>
        <a class="list-group-item size" href="#!">????????????</a>
      </div>
    </div>
    <form action="event_upload.php" method="post" class="form-horizontal">
      <div class="form-group">
        <label class="col-sm-2 control-label" for="Title">イベント名</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="title" placeholder="イベント名">
        </div>
      </div><!-- end form-group -->
      <div class="form-group">
        <label class="col-sm-2 control-label" for="eventdate">開催日</label>
        <div class="col-sm-10">
          <input type="date" name="eventdate" class="form-control" >
        </div>
      </div><!-- end form-group -->
      <div class="form-group">
        <label class="col-sm-2 control-label" for="Comment">イベント内容</label>
        <div class="col-sm-10">
          <textarea type="text" class="form-control" name="comment" rows="10"></textarea>
        </div>
      </div><!-- end form-group -->
      <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
          <input type="reset" class="btn btn-default" value="リセット">
          <input type="submit" class="btn btn-default" value="投稿">
        </div>
      </div><!-- end form-group -->
    </form>
  </div><!-- end content -->
  <div id="footer">
    <div id="footer_box"></div><!-- end footer_box -->
  </div><!-- end footer -->
</div><!-- end wrapper -->
<!--Import jQuery before materialize.js-->
<script type="text/javascript" src="jq/jquery-3.2.1.min.js"></script>
<!--<script type="text/javascript" src="js/materialize.min.js"></script> -->
</body>
</html>

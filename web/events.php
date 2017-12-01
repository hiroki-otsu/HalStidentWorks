<?php
//エラー表示
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors','On');
//外部ファイル読み込み
require '../booststrap.php';
//インスタンス化
$session = new Session();//セッションクラス
$dataAccess = new DataAccess();//データアクセスクラス&データベースクラス
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>HAL学生管理システム|イベント掲示板</title>
<!--Import Google Icon Font-->
<!--<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"> -->
<!--Import materialize.css-->
<link type="text/css" rel="stylesheet" href="css/reset/html5reset-1.6.1.css" />
<!--<link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/> -->
<link type="text/css" rel="stylesheet" href="css/bootstrap.min.css" />
<link type="text/css" rel="stylesheet" href="css/desin/desin_events.css" />
<!--Let browser know website is optimized for mobile-->
</head>
<body>
<div id="wrapper">
  <div id="header">
    <div class="page-header">
      <div id="titile_box">
        <h1>HAL学生管理システム</h1>
      </div>
      <div id="userinfo_box">
        <h4>ログイン<b>:</b><?php echo $name = $session -> get("loginUser");?><a href="logout.php" >ログアウト</a></h4>
      </div><!-- end userinfo_box -->
    </div><!-- end page-header -->
  </div><!-- end header -->
  <div id="upside">
    <div id="breadcrumb_list_box">
      <ol class="breadcrumb">
        <li><a href="menu.php"><span class="glyphicon glyphicon-home" aria-hidden="true"></span>メニュー画面</a></li>
        <li class="active">イベント掲示板</li>
      </ol>
    </div>
   <div id="eventpost_box">
      <a href="event_post.php" class="btn btn-default btn-block">イベント投稿へ</a>
    </div>
  </div><!-- end  -->
  <div id="contents">
    <div id="side">
      <div id="link_navbox">
        <div class="panel panel-default">
          <div class="panel-heading"></div><!-- end panel-heading -->
            <div class="list-group">
              <a class="list-group-item size" href="menu.php">メニュー画面</a>
              <a class="list-group-item list-group-item-info"  href="events.php">イベント掲示板</a>
              <a class="list-group-item size" href="lost_article.php">忘れ物掲示板</a>
              <a class="list-group-item size" href="#!">????????????</a>
            </div>
        </div>
      </div><!-- end link_navbox -->
    </div><!-- end side -->
    <div id="event">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h5>開催イベント</h5>
    </div>
    <div id="list_box">
      <table class="table table-hover">
        <thead>
          <tr>
            <th>イベント名</th>
            <th>対象学年</th>
            <th>開催日程</th>
            <th>イベント詳細</th>
          </tr>
        </thead>
          <?php
          $events = $dataAccess -> getEventsInformation();
          foreach ($events as $value) {
            print("<tr>");
            print("<td>".$value['Events_Title'].PHP_EOL."</td>");
            print("<td>全学年</td>");
            print("<td>".$value['Events_Date'].PHP_EOL."</td>");
            print("<td><a href='events_details.php?event=".$value['Events_No'].PHP_EOL."'><button class='btn btn-default'>詳細情報へ</button></a></td>");
            print("<tr>");
          }
           ?>
        <tbody>
        </tbody>
      </table>
    </div><!-- end list_box -->
  </div>
</div><!-- end event -->
</div><!-- end contents -->
<div id="footer">
 <p>Footer Area</p>
</div>
</div><!-- end wrapper -->
<!--Import jQuery before materialize.js-->
<script type="text/javascript" src="jq/jquery-3.2.1.min.js"></script>
<!--<script type="text/javascript" src="js/materialize.min.js"></script> -->
</body>
</html>

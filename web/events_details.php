<?php
//エラー表示
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors','On');
require '../booststrap.php';
$session = new Session();//セッションクラス
$request = new Request();//リクエストクラス

$event_code=$_GET['event'];
$data = new DataAccess();
$details= $data -> getEventdetails($event_code);

?>
<!DOCTYPE html>
 <html lang="ja">
 <head>
 <meta charset="utf-8">
 <title>HAL学生管理システム|イベント詳細</title>
 <!--Import Google Icon Font-->
 <!--<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"> -->
 <!--Import materialize.css-->
 <link type="text/css" rel="stylesheet" href="css/html5reset-1.6.1.css" />
 <!--<link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/> -->
 <link type="text/css" rel="stylesheet" href="css/bootstrap.min.css" />
 <!-- <link type="text/css" rel="stylesheet" href="css/desin_index.css" /> -->
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
     	  <li class="active">イベント詳細画面</li>
      </ol>
   </div>
   <div id="content">
    <div class="panel panel-default">
			<div class="panel-heading">
			</div>
			<div class="list-group">
				<a class="list-group-item size" href="menu.php">メニュー画面</a>
				<a class="list-group-item list-group-item-info"  href="events.php">イベント掲示板</a>
				<a class="list-group-item size" href="lost_article.php">忘れ物掲示板</a>
        <a class="list-group-item size" href="#!">????????????</a>
			</div>
		</div>
    <div class="panel panel-primary">
      <?php
      foreach ($details as $value) {
        print("<div class='panel-heading'>[イベント名]".$value['Events_Title'].PHP_EOL."</div>");
        print("<div class='pnel-body'>".nl2br($value['Events_Contents'].PHP_EOL));
        print("開催日".$value['Events_Date'].PHP_EOL."<br>");
        print("投稿時間".$value['Events_Time'].PHP_EOL."<br></div>");
      }
      ?>
    </div>
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

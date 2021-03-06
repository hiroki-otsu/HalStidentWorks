<?php
//エラー表示
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors','On');
//外部ファイル読み込み
require '../bootstrap.php';
//インスタンス化
$session = new Session();
$access = new DataAccess();
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
    <title>イベント詳細</title>
    <link type="text/css" rel="stylesheet" href="css/reset/html5reset-1.6.1.css" />
    <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>
    <link type="text/css" rel="stylesheet" href="css/materialize.min.css" />
    <link type="text/css" rel="stylesheet" href="css/sweetalert.css" />
    <link type="text/css" rel="stylesheet" href="css/design/design_format.css" />
    <link type="text/css" rel="stylesheet" href="css/design/design_events_details.css" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
</head>
<body>
<div id="wrapper">
  <div id="nav" class="z-depth-3">
    <div id="logo">
        <img src="image/logo.jpg" width="258" height="255" alt="ロゴ">
    </div>
    <div id="menu">
      <ul>
        <li class="menubar"><a href="home.php"><img src="image/icon/ic_home_black_24dp_1x.png" width="24" height="24" alt="home"/>Home</a></li>
        <li class="menubar"><a href="enrollment.php"><img src="image/icon/ic_airline_seat_recline_extra_black_24dp_1x.png" width="24" height="24" alt="座席確認"/>在籍確認</a></li>
        <li class="menubar"><a href="events.php"><img src="image/icon/ic_event_note_black_24dp_1x.png" width="24" height="24" alt="イベント掲示板"/>イベント</a></li>
        <li class="menubar"><a href="lost_article_list.php"><img src="image/icon/ic_live_help_black_24dp_1x.png" width="24" height="24" alt="忘れ物掲示板"/>拾得物</a></li>
        <li class="menubar"><a href="classroom.php"><img src="image/icon/ic_search_black_24dp_1x.png" width="24" height="24" alt="教室予約"/>教室検索・予約</a></li>
      </ul>
    </div>
  </div>
  <div id="contents">
    <div id="header">
      <div id="title">
        <h2>HAL Students System</h2>
      </div>
      <div id="user">
          <p><a href="home.php"><img src="image/icon/ic_person_black_24dp_1x.png" width="24" height="24" alt="アカウント"/><?php echo $session->get('ohs50054')?></a></p>
      </div>
    </div><!-- end header -->
    <div id="event">
      <div id="eventcomment">
        <ul class="collection with-header" id="comment">
            <?php
            $dataList =$access -> getEventDetails($_GET['event']);
                foreach ($dataList as $value){
                    echo '<li class="collection-header" ><h4>'.$value['events_title'].'</h4></li>';
                    echo '<li class="collection-item" id="item">';
                    echo nl2br($value['events_contents']);
                    echo '</li>';
                }
            ?>
        </ul>
      </div>
        <?php if(isset($_GET['details'])):?>
            <div id="eventpropriety">
                <a class="waves-effect waves-light btn sweet" id="btnjoin" data-join="2&<?php echo $_GET['event']?>"><p>参加</p></a>
                <a class="waves-effect waves-light btn sweet" id="btnnotgoing" data-join="1&<?php echo $_GET['event']?>"><p>不参加</p></a>
            </div>
        <?php endif;?>
    </div>
    <div id="footer">
      <footer>2017 HAL Students System</footer>
    </div><!-- footer -->
  </div><!-- end contents -->
</div><!-- end wrapper -->
<script type="text/javascript" src="jq/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="js/check.js"></script>
<script type="text/javascript" src="js/sweetalert.min.js"></script>
<script type="text/javascript" src="js/detailes.js"></script>
<script type="text/javascript" src="js/materialize.min.js"></script>
<script type="text/javascript" src="js/legacy.js"></script>
<script type="text/javascript" src="js/lang-ja.js"></script>
<script type="text/javascript" src="js/app.js"></script>
<script type="text/javascript" src="js/picker.js"></script>
<script type="text/javascript" src="js/picker.date.js"></script>
</body>
</html>

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
<title>HAL学生管理システム|イベント投稿</title>
<link type="text/css" rel="stylesheet" href="css/reset/html5reset-1.6.1.css" />
<link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>
<link type="text/css" rel="stylesheet" href="css/themes/default.css">
<link type="text/css" rel="stylesheet" href="css/themes/default.date.css">
<link type="text/css" rel="stylesheet" href="css/materialize.min.css" />
<link type="text/css" rel="stylesheet" href="css/design/design_format.css" />
<link type="text/css" rel="stylesheet" href="css/design/design_events_post.css" />
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
</head>
<body>
<div id="wrapper">
    <div id="nav" class="z-depth-3">
        <div id="logo">
            <img src="" width="" height="" alt=""/>
        </div>
        <div id="menu">
            <ul>
                <li class="menubar"><a href="home.php"><img src="image/icon/ic_home_black_24dp_1x.png" width="24" height="24" alt="home"/>Home</a></li>
                <li class="menubar"><a href="enrollment.php"><img src="image/icon/ic_airline_seat_recline_extra_black_24dp_1x.png" width="24" height="24" alt="座席確認"/>在籍確認</a></li>
                <li class="menubar"><a href="events.php"><img src="image/icon/ic_event_note_black_24dp_1x.png" width="24" height="24" alt="イベント掲示板"/>イベント掲示板</a></li>
                <li class="menubar"><a href="lost_article_list.php"><img src="image/icon/ic_live_help_black_24dp_1x.png" width="24" height="24" alt="忘れ物掲示板"/>忘れ物掲示板</a></li>
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
          <form action="event.php" method="get">

              <div class="input-field" id="even-title">
                  <input id="event-name" type="text" class="validate" name="title">
                  <label for="event-name">イベント名</label>
              </div>
              <div class="input-field" id="category">
                  <select name="category">
                      <option value="" disabled selected>Choose your option</option>
                      <option value="1">ゲーム</option>
                      <option value="3">デザイン</option>
                      <option value="4">ミュージック</option>
                      <option value="5">IT</option>
                      <option value="6">その他</option>
                  </select>
                  <label>Category Select</label>
              </div>

              <div class="input-field" id="event-date">
                  <input id="events-date" type="text" class="datepicker" name="eventDate">
                  <label for="events-date">開催日</label>
              </div>

              <div class="input-field" id="school-year">
                  <select multiple name="target[]">
                      <option value="" disabled selected>Choose your option</option>
                      <option value="1">1年生</option>
                      <option value="2">2年生</option>
                      <option value="3">3年生</option>
                  </select>
                  <label>対象学年</label>
              </div>

              <div id="event-content">
                  <div class="input-field" id="event-contents">
                      <textarea class="materialize-textarea" name="content"></textarea>
                      <label for="contents">イベント内容</label>
                  </div>
              </div>

              <div id="send">
                  <button class="btn waves-effect waves-light"  id="btn-send" type="submit" >イベントを投稿
                      <i class="material-icons right">send</i>
                  </button>
              </div>
          </form>
        </div>
        <div id="footer">
            <footer>2017 HAL Students System</footer>
        </div><!-- footer -->
    </div><!-- end contents -->
</div><!-- end wrapper -->
<script type="text/javascript" src="jq/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="js/check.js"></script>
<script type="text/javascript" src="js/materialize.min.js"></script>
<script type="text/javascript" src="js/legacy.js"></script>
<script type="text/javascript" src="js/lang-ja.js"></script>
<script type="text/javascript" src="js/app.js"></script>
<script type="text/javascript" src="js/picker.js"></script>
<script type="text/javascript" src="js/picker.date.js"></script>
</body>
</html>

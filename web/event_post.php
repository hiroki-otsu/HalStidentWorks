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
<link type="text/css" rel="stylesheet" href="css/desin/desin_format.css" />
<link type="text/css" rel="stylesheet" href="css/desin/desin_events_post.css" />
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
        <li class="menubar"><a href="home.php"><img src="img/icon/ic_home_black_24dp_1x.png" width="24" height="24" alt="home"/>Home</a></li>
        <li class="menubar"><a href="enrollment.php"><img src="img/icon/ic_airline_seat_recline_extra_black_24dp_1x.png" width="24" height="24" alt="座席確認"/>在籍確認</a></li>
        <li class="menubar"><a href="events.php"><img src="img/icon/ic_event_note_black_24dp_1x.png" width="24" height="24" alt="イベント掲示板"/>イベント掲示板</a></li>
        <li class="menubar"><a href="lost_article.php"><img src="img/icon/ic_live_help_black_24dp_1x.png" width="24" height="24" alt="忘れ物掲示板"/>忘れ物掲示板</a></li>
        <li class="menubar"><a href="classroom.php"><img src="img/icon/ic_search_black_24dp_1x.png" width="24" height="24" alt="教室予約"/>教室検索・予約</a></li>
      </ul>
    </div>
  </div>
  <div id="contents">
    <div id="header">
      <div id="title">
        <h2>HAL Students System</h2>
      </div>
      <div id="user">
        <p><a href="mypagehome.php"><img src="img/icon/ic_person_black_24dp_1x.png" width="24" height="24" alt="アカウント"/>ohs50054:大津裕幹</a></p>
      </div>
    </div><!-- end header -->
    <div id="event">
      <form class="" action="index.html" method="post">
        <div class="input-field col s6" id="eventname">
          <input placeholder="Placeholder" id="first_name" type="text" class="validate">
          <label for="Event_name">イベント名</label>
        </div>

        <div class="input-field col s6" id="eventdate">
          <input placeholder="Placeholder" id="date" type="text" class="validate datepicker" >
          <label for="events_date">開催日</label>
        </div>

        <div class="input-field col s6">
        <select multiple>
          <option value="" disabled selected>Choose your option</option>
          <option value="1">1年生</option>
          <option value="2">2年生</option>
          <option value="3">3年生</option>
        </select>
        <label>対象学年</label>
        </div>
        <div class="input-field col s6">
          <textarea id="icon_prefix2" class="materialize-textarea"></textarea>
          <label for="icon_prefix2">Comment</label>
        </div>

        <button class="btn waves-effect waves-light" type="submit" name="action">Submit
           <i class="material-icons right">send</i>
        </button>
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

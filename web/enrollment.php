<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>HAL学生管理システム|在籍確認画面</title>
<link type="text/css" rel="stylesheet" href="css/reset/html5reset-1.6.1.css" />
<link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>
<link type="text/css" rel="stylesheet" href="css/materialize.min.css" />
<link type="text/css" rel="stylesheet" href="css/desin/desin_format.css" />
<link type="text/css" rel="stylesheet" href="css/desin/desin_enrollment.css" />
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
        <li class="menubar"><a href="lost_article.php"><img src="image/icon/ic_live_help_black_24dp_1x.png" width="24" height="24" alt="忘れ物掲示板"/>忘れ物掲示板</a></li>
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
        <p><a href="home.php"><img src="image/icon/ic_person_black_24dp_1x.png" width="24" height="24" alt="アカウント"/>ohs50054:大津裕幹</a></p>
      </div>
    </div><!-- end header -->
    <div id="seach" class="input-field">
      <form action="#!" method="post">
        <div id="seachname">
          <i class="material-icons prefix">account_circle</i>
            <input id="icon_prefix" type="text" class="validate" >
            <label for="icon_prefix">Teacher Name</label>
        </div>
        <button class="btn waves-effect waves-light" type="submit" name="action">Seach</button>
      </form>
    </div>
    <div id="teacherlist">
      <table class="highlight">
        <thead>
          <tr>
            <th class="teachername">名前</th>
            <th class="teacherenrollment">在籍状況</th>
            <th class="teacherlamp">在籍ランプ</th>
            <th class="teacherdate">更新日時</th>
          </tr>
        </thead>
        <tbody>
        <tr>
          <td class="teachername">川島智弘</td>
          <td class="teacherenrollment">在籍中</td>
          <td class="teacherlamp"><div id="lamp_color_green"></td>
          <td class="teacherdate">2017/01/01 00:00:00</td>
        </tr>
        <tr>
          <td class="teachername">川島智弘</td>
          <td class="teacherenrollment">離席中</td>
          <td class="teacherlamp"><div id="lamp_color_orange"></div></td>
          <td class="teacherdate">2017/01/01 00:00:00</td>
        </tr>
        <tr>
          <td class="teachername">川島智弘</td>
          <td class="teacherenrollment">不在</td>
          <td class="teacherlamp"><div id="lamp_color_gray"></div></td>
          <td class="teacherdate">2017/01/01 00:00:00</td>
        </tr>
        </tbody>
      </table>
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

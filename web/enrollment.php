<?php
//エラー表示
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors','On');

require '../bootstrap.php';
$session = new Session();
$dataAccess = new DataAccess();

?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>HAL学生管理システム|在籍確認画面</title>
<link type="text/css" rel="stylesheet" href="css/reset/html5reset-1.6.1.css" />
<link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>
<link type="text/css" rel="stylesheet" href="css/materialize.min.css" />
<link type="text/css" rel="stylesheet" href="css/design/design_format.css" />
<link type="text/css" rel="stylesheet" href="css/design/design_enrollment.css" />
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
          <p><a href="home.php"><img src="image/icon/ic_person_black_24dp_1x.png" width="24" height="24" alt="アカウント"/><?php echo $session->get('ohs50054')?></a></p>
      </div>
    </div><!-- end header -->
    <div id="search" class="input-field">
      <form action="#!" method="post">
        <div id="search-name">
          <i class="material-icons prefix">account_circle</i>
            <input id="icon_prefix" type="text" class="validate" >
            <label for="icon_prefix">Teacher Name</label>
        </div>
        <button class="btn waves-effect waves-light" type="submit" name="action">Search</button>
      </form>
    </div>
    <div id="teacher-list">
      <table class="highlight">
        <thead>
          <tr>
            <th class="teacher-name">名前</th>
            <th class="teacher-enrollment">在籍状況</th>
            <th class="teacher-lamp">在籍ランプ</th>
            <th class="teacher-date">更新日時</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $teacher = $dataAccess -> getTeacherList();
          foreach ($teacher as $value) {
            switch ($value['teacher_status']) {
              case 1:
                $TeacherStatus ="在籍中";
                $lamp="<div id='lamp_color_green'>";
                break;
              case 2:
                $TeacherStatus="離席中";
                $lamp="<div id='lamp_color_orange'>";
                break;
              default:
                $TeacherStatus ="不在中";
                $lamp="<div id='lamp_color_gray'>";
                break;
            }
            print("<tr>");
            print("<td class='teacher-name'>".$value['teacher_name'].PHP_EOL."</td>");
            print("<td class='teacher-enrollment'>".$TeacherStatus."</td>");
            print("<td class='teacher-lamp'>".$lamp.PHP_EOL."</td>");
            print("<td class='teacher-date'>".$value['teacher_update'].PHP_EOL."</td>");
            print("</tr>");
          }
          ?>
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

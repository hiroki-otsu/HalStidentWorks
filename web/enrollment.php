<?php
//エラー表示
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors','On');

require '../bootstrap.php';
$session = new Session();
$access = new DataAccess();
define('TEACHER_PAGE',10);
define('TEACHER','teacher_account');
if(isset($_GET['page'])){
    preg_match('/^[1-9][0-9]*$/',$_GET['page']);
    $page = (int)$_GET['page'];
}
else{
    $page =1;
}
$total = $access->getCountDate(TEACHER);
$totalPage = ceil($total / TEACHER_PAGE);

?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>在籍確認</title>
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
    <div id="search" class="input-field">
      <form action="teacherSearch" method="get">
        <div id="search-name">
          <i class="material-icons prefix">account_circle</i>
            <input id="icon_prefix" type="text" class="validate" name="teacher">
            <label for="icon_prefix">Teacher Name</label>
        </div>
        <button class="btn waves-effect waves-light" type="submit">検索
            <i class="material-icons left">search</i>
        </button>
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
        <td class='teacher-enrollment'></td>
        <?php $teacher = $access -> getTeacherList($page,TEACHER_PAGE);?>
        <?php for ($i =0; $i<count($teacher);$i++) :?>
            <tr>
                <td class='teacher-name'><?php echo $teacher[$i]['teacher']?></td>
                <td class='teacher-enrollment'><?php echo $teacher[$i]['lampCharacter']?></td>
                <td class='teacher-lamp'><div id='<?php echo $teacher[$i]['lampColor'] ?>'></td>
                <td class='teacher-date'><?php echo $teacher[$i]['timestamp']?></td>
            </tr>
        <?php endfor; ?>
        </tbody>
      </table>
    </div>
      <!--  ページング機能  -->
      <div id="page">
          <ul class="pagination">
              <!--  前を表示させる  -->
              <?php if ($page > 1) : ?>
                  <li class="disabled"><a href="?page=<?php echo $page - 1; ?>"><i class="material-icons">chevron_left</i></a></li>
              <?php endif; ?>
              <!-- トータル件数が6件より少ない場合はページングを表示させない -->
              <?php if($totalPage>TEACHER_PAGE): ?>
                  <?php for ($i=1 ; $i <= $totalPage; $i++): ?><!-- ページングを表示させる処理 -->
                      <?php if($page == $i) :?>
                          <li class="active"><a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                      <?php else: ?>
                          <li class="waves-effect"><a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                      <?php endif; ?>
                  <?php endfor; ?>
              <?php endif; ?>
              <!--  次を表示させる  -->
              <?php if ($page < $totalPage) : ?>
                  <li class="waves-effect"><a href="?page=<?php echo $page + 1; ?>"><i class="material-icons">chevron_right</i></a></li>
              <?php endif; ?>
          </ul>
      </div><!-- page -->
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

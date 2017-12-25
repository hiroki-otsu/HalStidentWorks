<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>HAL学生管理システム|</title>
<link type="text/css" rel="stylesheet" href="css/reset/html5reset-1.6.1.css" />
<link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>
<link type="text/css" rel="stylesheet" href="css/materialize.min.css" />
<link type="text/css" rel="stylesheet" href="css/desin/desin_format.css" />
<link type="text/css" rel="stylesheet" href="css/desin/desin_home.css" />
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
    <div id="tab">
      <div class="col s12">
        <ul class="tabs">
          <li class="tab col s2"><a class="active" href="#test1">成績</a></li>
          <li class="tab col s2"><a href="#test2">出席</a></li>
          <li class="tab col s2"><a href="#test3">メッセージ</a></li>
          <li class="tab col s2"><a href="#test5">イベント</a></li>
          <li class="tab col s2"><a href="#test4">パスワード</a></li>
          <li class="tab col s2"><a href="#test6">お問い合わせ</a></li>
        </ul>
      </div>
      <div id="test1" class="col s2">
        <div id="achievement">
          <table class="centered">
            <thead>
              <tr>
                  <th id="subjectCode">科目コード</th>
                  <th id="subjectName">科目名</th>
                  <th id="subjectScore">点数</th>
                  <th id="subjectRating">評定</th>
              </tr>
              <tbody>
                <tr>
                  <td class="code">JV34</td>
                  <td class="name">JavaプログラミングⅣ</td>
                  <td class="score"><a class="waves-effect waves-light modal-trigger" href="#modal1"><img src="image/icon/ic_expand_more_black_24dp_1x.png" width="24" height="24" alt="" /></a></td>
                  <td class="rating"><a class="waves-effect waves-light modal-trigger" href="#modal1"><img src="image/icon/ic_expand_more_black_24dp_1x.png" width="24" height="24" alt="" /></a></td>
                </tr>
              </tbody>
            </thead>
          </table>
        </div>

        <div id="modal1" class="modal modal-fixed-footer">
          <div class="modal-content">
            <h4>JavaプログラミングⅣ</h4>
            <p>A bunch of text</p>
          </div>
          <div class="modal-footer">
            <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat ">Agree</a>
          </div>
        </div>

        <div id="modal1" class="modal modal-fixed-footer">
          <div class="modal-content">
            <h4>JavaプログラミングⅣ</h4>
            <p>A bunch of text</p>
          </div>
          <div class="modal-footer">
            <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat ">Agree</a>
          </div>
        </div>


      </div>
      <div id="test2" class="col s12">

      </div>
      <div id="test3" class="col s12">

      </div>
      <div id="test4" class="col s12">

      </div>
      <div id="test5" class="col s12">

      </div>
      <div id="test6" class="col s12">
        <div id="contact">
        </div>
        <div id="contactComment">
          <form action="" method="get">
            <div class="input-field col s3">
              <input id="contacTitle" type="text" class="validate">
              <label for="contacTitle">タイトル</label>
            </div>
            <div class="row">
              <div class="row">
                <div class="input-field col s12">
                  <textarea id="content" class="materialize-textarea"></textarea>
                  <label for="content">内容</label>
                </div>
              </div>
            </div>
        </div>
        <div id="contactSend">
          <button class="btn waves-effect waves-light" type="submit" name="action">送信
            <i class="material-icons right">send</i>
          </button>
        </div>
          </form>
      </div>
    </div>
    <div id="footer">
      <footer>2017 HAL Students System</footer>
    </div><!-- footer -->
  </div><!-- end contents -->
</div><!-- end wrapper -->
<script type="text/javascript" src="jq/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="js/check.js"></script>
<script type="text/javascript" src="js/model.js"></script>
<script type="text/javascript" src="js/materialize.min.js"></script>
<script type="text/javascript" src="js/legacy.js"></script>
<script type="text/javascript" src="js/lang-ja.js"></script>
<script type="text/javascript" src="js/app.js"></script>
<script type="text/javascript" src="js/picker.js"></script>
<script type="text/javascript" src="js/picker.date.js"></script>
</body>
</html>

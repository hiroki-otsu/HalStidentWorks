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
<title>HAL学生管理システム|</title>
<link type="text/css" rel="stylesheet" href="css/reset/html5reset-1.6.1.css" />
<link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>
<link type="text/css" rel="stylesheet" href="css/materialize.min.css" />
<link type="text/css" rel="stylesheet" href="css/design/design_format.css" />
<link type="text/css" rel="stylesheet" href="css/design/design_home.css" />
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
    <div id="tab">
      <div class="col s12">
        <ul class="tabs">
          <li class="tab col s2"><a class="active" href="#achievement">成績</a></li>
          <li class="tab col s2"><a href="#attend">出席</a></li>
          <li class="tab col s2"><a href="#message">メッセージ</a></li>
          <li class="tab col s2"><a href="#events">イベント</a></li>
          <li class="tab col s2"><a href="#pass">パスワード</a></li>
          <li class="tab col s2"><a href="#test6">お問い合わせ</a></li>
        </ul>
      </div>
      <div id="achievement" class="col s2">
        <div id="achievement">
          <table class="centered">
            <thead>
              <tr>
                  <th id="subjectCode">科目コード</th>
                  <th id="subjectName">科目名称</th>
                  <th id="subjectScore">課題</th>
                  <th id="subjectRating">評価</th>
              </tr>
              <tbody>
              <?php
                $dataList =$access -> getAchievementDataList();
                foreach($dataList as $value){
                    echo '<tr>';
                    print '<td class="code">'.$value['subject_code'].'</td>';
                    print '<td class="name">'.$value['subject_name'].'</td>';
                    print '<td class="score"><a class="waves-effect waves-light modal-trigger" href="#0'.$value['subject_code'].'"><img src="image/icon/ic_expand_more_black_24dp_1x.png" width="24" height="24" alt="" /></a></td>';
                    print '<td class="rating"><a class="waves-effect waves-light modal-trigger" href="#1'.$value['subject_code'].'"><img src="image/icon/ic_expand_more_black_24dp_1x.png" width="24" height="24" alt="" /></a></td>';
                    print '</tr>';
                }
              ?>
              </tbody>
            </thead>
          </table>
        </div>
          <?php
            $dataList =$access -> getAchievementDataList();
            foreach ($dataList as $value) {
                switch ($value['task_status']){
                    case 0:
                        echo '<div id="0'.$value['subject_code'].'" class="modal modal-fixed-footer">';
                        echo '<div class="modal-content">';
                        echo '<h4>'.$value['subject_name'].'[課題]</h4>';
                        break;
                    case 1:
                        echo '<div id="1'.$value['subject_code'].'" class="modal modal-fixed-footer">';
                        echo '<div class="modal-content">';
                        echo '<h4>'.$value['subject_name'].'[評価]</h4>';
                        break;
                }
                echo '<table class="centered">';
                echo '<thead>';
                echo '<tr>';
                echo '<th>課題名</th>';
                echo '<th>点数</th>';
                echo '</tr>';
                echo '<tbody>';
                echo '<tr>';
                echo '<td>'.$value['task_name'].'</td>';
                echo '<td>'.$value['task_score'].'</td>';
                echo '</tr>';
                echo '</tbody>';
                echo '</thead>';
                echo '</table>';
                echo '</div>';
                echo '<div class="modal-footer">';
                echo '<a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat ">Agree</a>';
                echo '</div>';
                echo '</div>';
            }
          ?>
      </div>
      <div id="attend" class="col s12">

      </div>
      <div id="message" class="col s12">

      </div>
      <div id="events" class="col s12">

      </div>
      <div id="pass" class="col s12">

      </div>
      <div id="test6" class="col s12">
        <div id="contact">
        </div>
        <div id="contactComment">
          <form action="" method="get">
            <div class="input-field col s3">
              <input id="contactTitle" type="text" class="validate">
              <label for="contactTitle">タイトル</label>
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

<?php
//エラー表示
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors','On');
//外部ファイル読み込み
require '../bootstrap.php';
//インスタンス化
$session = new Session();
$access = new DataAccess();
define('EVENT_PAGE',10);
define('events','events');

if(isset($_GET['page'])){
    preg_match('/^[1-9][0-9]*$/',$_GET['page']);
    $page = (int)$_GET['page'];
}
else{
    $page =1;
}
$total = $access->getCountDate(events);
$totalPage = ceil($total / EVENT_PAGE);
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
    <title>イベント掲示板</title>
    <link type="text/css" rel="stylesheet" href="css/reset/html5reset-1.6.1.css" />
    <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>
    <link type="text/css" rel="stylesheet" href="css/materialize.min.css" />
    <link type="text/css" rel="stylesheet" href="css/design/design_format.css" />
    <link type="text/css" rel="stylesheet" href="css/design/design_events.css" />
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
        </div><!-- menu -->
    </div><!-- nav -->
    <div id="contents">
        <div id="header">
            <div id="title">
                <h2>HAL Students System</h2>
            </div>
            <div id="user">
                <p><a href="home.php"><img src="image/icon/ic_person_black_24dp_1x.png" width="24" height="24" alt="アカウント"/><?php echo $student=$session->get('ohs50054')?></a></p>
            </div>
        </div><!-- end header -->
        <div id="eventpost">
            <a href="event_post.php"class="waves-effect waves-light btn-large">イベント投稿へ</a>
        </div>
        <div class="input-field" id="option">
            <select multiple>
                <option value="" disabled selected>Choose your optio</option>
                <option value="1">1年生</option>
                <option value="2">2年生</option>
                <option value="3">3年生</option>
            </select>
            <label>対象学年絞り込み</label>
        </div>
        <div id="events">
            <table class="highlight" id="list">
                <thead>
                <tr>
                    <th class="events_name">イベント名</th>
                    <th class="school_year">対象学年</th>
                    <th class="events_date">開催日</th>
                    <th class="events_date">カテゴリー</th>
                    <th class="details_link">詳細</th>
                </tr>
                </thead>
                <tbody>
                    <?php  $event=$access -> getEventsInformation($student,$page,EVENT_PAGE); ?>
                    <?php for ($i =0; $i<count($event);$i++) :?>
                    <tr>
                        <td class="events_name"><?php echo $event[$i]['title'].PHP_EOL?></td>
                        <td class="school_year"><?php echo $event[$i]['target'].PHP_EOL?></td>
                        <td class="events_date"><?php echo $event[$i]['date'].PHP_EOL?></td>
                        <td class="events_date"><?php echo $event[$i]['category'].PHP_EOL?></td>
                        <td class="details_link"><a href="events_details.php?event=<?php echo $event[$i]['link'].PHP_EOL?>&details=date">
                                <img src="image/icon/ic_expand_more_black_24dp_1x.png" width="24" height="24" alt="詳細リンク" /></a>
                        </td>
                    <tr>
                    <?php endfor;?>
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
                <!-- トータル件数が10件より少ない場合はページングを表示させない -->
                <?php if($totalPage<>EVENT_PAGE): ?>
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
    </div>
</div><!-- wrapper -->
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

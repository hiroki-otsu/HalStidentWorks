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
    <div id="contents">
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
        <div id="header">
            <div id="title">
                <h2>HAL Students System</h2>
            </div>
            <div id="user">
                <p><a href="home.php"><img src="image/icon/ic_person_black_24dp_1x.png" width="24" height="24" alt="アカウント"/><?php echo $session->get('ohs50054')?></a></p>
            </div>
        </div><!-- end header -->
        <div>
            <ul class="tabs">
                <li class="tab col"><a class="active" href="#test1">成績</a></li>
                <li class="tab col"><a href="#test2">出席</a></li>
                <li class="tab col"><a href="#test3">メッセージ</a></li>
                <li class="tab col"><a href="#test4">イベント</a></li>
                <li class="tab col"><a href="#test5">パスワード</a></li>
                <li class="tab col"><a href="#test6">お問い合わせ</a></li>
            </ul>
        </div>
        <div id="test1">
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
                    <?php
                    $dataList =$access -> getLessonDataList();
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
            for ($i=0;$i<count($dataList);$i++){
                switch ($dataList[$i]['task_status']) {
                    case 0:
                        echo '<div id="0' . $dataList[$i]['subject_code'] . '" class="modal modal-fixed-footer">';
                        echo '<div class="modal-content">';
                        echo '<h4>' . $dataList[$i]['subject_name'] . '[課題]</h4>';
                        break;
                    case 1:
                        echo '<div id="1' . $dataList[$i]['subject_code'] . '" class="modal modal-fixed-footer">';
                        echo '<div class="modal-content">';
                        echo '<h4>' . $dataList[$i]['subject_name'] . '[評価]</h4>';
                        break;
                }
                echo '<table class="centered">';
                echo '<thead>';
                echo '<tr>';
                echo '<th>課題名</th>';
                echo '<th>点数</th>';
                echo '</tr>';
                echo '<tbody>';
                $flg = true;
                $count=0;
                $serial=0;
                echo '<tr>';
                echo '<td>'.$dataList[$i+$count]['task_name'].'</td>';
                echo '<td>'.$dataList[$i+$count]['task_score'].'</td>';
                echo '</tr>';
                while ($flg){
                    $count++;
                    if ($dataList[$i]['subject_code'] == $dataList[$serial+$count]['subject_code']){
                        echo '<tr>';
                        echo '<td>'.$dataList[$i+$count]['task_name'].'</td>';
                        echo '<td>'.$dataList[$i+$count]['task_score'].'</td>';
                        echo '</tr>';
                        $serial++;
                    }else{
                        $flg = false;
                        echo '</tbody>';
                        echo '</thead>';
                        echo '</table>';
                        echo '</div>';
                        echo '<div class="modal-footer">';
                        echo '<a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat ">Agree</a>';
                        echo '</div>';
                        echo '</div>';
                    }
                }
            }
            ?>
        </div><!-- tab01-->
        <div id="test2">
            <div id="attend">
                <table class="centered">
                    <thead>
                    <tr>
                        <th id="subjectCode">科目コード</th>
                        <th id="subjectName">科目名</th>
                        <th id="subject">出席率</th>
                    </tr>
                    <tbody>
                    <tr>
                        <td class="code">JV34</td>
                        <td class="name">JavaプログラミングⅣ</td>
                        <td class="score"></td>
                    </tr>
                    </tbody>
                    </thead>
                </table>
            </div>
        </div><!-- tab02 -->
        <div id="test3">
            <div id="message">
                <table class="centered">
                    <thead>
                    <tr>
                        <th id="">件名</th>
                        <th id="">送信者</th>
                        <th id="">時間</th>
                        <th id="">詳細</th>
                    </tr>
                    <tbody>
                    <tr>
                        <td class="title">就職連絡</td>
                        <td class="sender">山口陽一</td>
                        <td class="time">2017/12/23(火)</td>
                        <td class="details"><a class="waves-effect waves-light modal-trigger" href="#modal1"><img src="img/icon/ic_expand_more_black_24dp_1x.png" width="24" height="24" alt="" /></a></td>
                    </tr>
                    </tbody>
                    </thead>
                </table>
            </div>
        </div><!-- tab03-->
        <div id="test4"></div>
        <div id="test5">
            <div id="expiration-date">
                <h5>パスワード有効期限:01月02日(火)</h5>
            </div>
            <div id="pass">
                <form action="#" method="post">
                    <div class="input-field " id="current">
                        <input id="password" type="password" class="validate">
                        <label for="password">現在のパスワード</label>
                    </div>
                    <div class="input-field " id="new">
                        <input id="password" type="password" class="validate">
                        <label for="password">新しいパスワード</label>
                    </div>
                    <div class="input-field " id="confirmation">
                        <input id="password" type="password" class="validate">
                        <label for="password">新しいパスワード(確認)</label>
                    </div>
                    <button class="btn waves-effect waves-light" type="submit" name="action" id="btn-update">
                        パスワード変更
                        <i class="material-icons right">send</i>
                    </button>
                </form>
            </div>
        </div><!-- tab05-->
        <div id="test6">
            <div id="contact">

            </div>
            <form action="" method="get">
                <div class="input-field" id="contact-title">
                    <input type="text" class="validate">
                    <label for="contactTitle">タイトル</label>
                </div>
                <div id="contact-content">
                    <div class="input-field" id="contact-comment">
                        <textarea class="materialize-textarea"></textarea>
                        <label for="content">内容</label>
                    </div>
                </div>
                <div id="btn-send">
                    <button class="btn waves-effect waves-light" id="contact-send" type="submit" name="action">送信
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
<script type="text/javascript" src="js/model.js"></script>
<script type="text/javascript" src="js/materialize.min.js"></script>
<script type="text/javascript" src="js/legacy.js"></script>
<script type="text/javascript" src="js/lang-ja.js"></script>
<script type="text/javascript" src="js/app.js"></script>
<script type="text/javascript" src="js/picker.js"></script>
<script type="text/javascript" src="js/picker.date.js"></script>
</body>
</html>

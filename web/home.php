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
                    <li class="menubar"><a href="events.php"><img src="image/icon/ic_event_note_black_24dp_1x.png" width="24" height="24" alt="イベント掲示板"/>イベント</a></li>
                    <li class="menubar"><a href="lost_article_list.php"><img src="image/icon/ic_live_help_black_24dp_1x.png" width="24" height="24" alt="忘れ物掲示板"/>拾得物</a></li>
                    <li class="menubar"><a href="classroom.php"><img src="image/icon/ic_search_black_24dp_1x.png" width="24" height="24" alt="教室予約"/>教室検索・予約</a></li>
                </ul>
            </div>
        </div>
        <div id="header">
            <div id="title">
                <h2>HAL Students System</h2>
            </div>
            <div id="user">
                <p><a href="home.php"><img src="image/icon/ic_person_black_24dp_1x.png" width="24" height="24" alt="アカウント"/><?php echo $student=$session->get('ohs50054')?></a></p>
            </div>
        </div><!-- end header -->
        <div>
            <ul class="tabs">
                <li class="tab col"><a class="active" href="#test1">成績</a></li>
                <li class="tab col"><a href="#test2">出席</a></li>
                <li class="tab col"><a href="#test3">メッセージ</a></li>
                <li class="tab col"><a href="#test4">イベント</a></li>
                <li class="tab col"><a href="#test5">申請状況</a></li>
                <li class="tab col"><a href="#test6">パスワード</a></li>
                <li class="tab col"><a href="#test7">お問い合わせ</a></li>
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
                        echo '<a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat ">Close</a>';
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
                        <th id="">差出人</th>
                        <th id="">時間</th>
                        <th id="">詳細</th>
                    </tr>
                    <tbody>
                    <?php
                    $mailList=$access->getMessage($student);
                    foreach ($mailList as $mail){
                        echo '<tr>';
                        echo '<td class="title">'.$mail['message_title'].'</td>';
                        echo '<td class="sender">'.$mail['teacher_name'].'</td>';
                        echo '<td class="time">'.$mail['date'].'</td>';
                        echo '<td class="details">';
                        echo '<a class="waves-effect waves-light modal-trigger" href="#mail'.$mail['message_no'].'">';
                        echo '<img src="image/icon/ic_expand_more_black_24dp_1x.png" width="24" height="24" alt="" /></a>';
                        echo '</td>';
                        echo '</tr>';
                    }
                    ?>
                    </tbody>
                    </thead>
                </table>
            </div>
            <?php
            $mailList=$access->getMessage($student);
            foreach ($mailList as $mail){
                echo '<div id="mail'.$mail['message_no'].'" class="modal modal-fixed-footer">';
                echo '<div class="modal-content">';
                echo '<ul class="collection with-header">';
                echo '<li class="collection-header">Title:'.$mail['message_title'].'</li>';
                echo '<li class="collection-item">From:'.$mail['teacher_name'].'</li>';
                echo '<li class="collection-item">To:'.$mail['teacher_name'].'</li>';
                echo '<li class="collection-item">日時:'.$mail['date'].'</li>';
                echo '<li class="collection-item">'.nl2br($mail['message_content']).'</li>';
                echo '</ul>';
                echo '</div>';
                echo '<div class="modal-footer">';
                echo '<a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat ">Close</a>';
                echo '</div>';
                echo '</div>';
            }

            ?>
        </div><!-- tab03-->
        <div id="test4">
            <div id="schedule">
                <dl>
                    <dt><i class="material-icons left">insert_invitation</i><h5>イベント参加スケジュール</h5></dt>
                    <dd class="schedule-title"><p>Kotlinを学ぼう!!</p></dd>
                    <dd class="schedule-date"><p>20118/01/29</p></dd>
                    <dd class="schedule-details"><a href="#" class="waves-effect waves-light btn text-cut"><i class="material-icons right">chevron_right</i>詳細</a></dd>
                </dl>
            </div>
            <div id="event-relation">
                <dl>
                    <dt><i class="material-icons left">access_time</i><h5>イベント参加履歴</h5></dt>
                    <dd><a class="waves-effect waves-light btn text-cut"><i class="material-icons left">chevron_right</i><p>Kotlinを学ぼう!!zzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzz</p></a></dd>
                </dl>
                <dl>
                    <dt><i class="material-icons left">create</i><h5>イベント投稿履歴</h5></dt>
                    <dd><a class="waves-effect waves-light btn text-cut"><i class="material-icons left">chevron_right</i><p>Kotlinを学ぼう!!zzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzz</p></a></dd>
                </dl>
            </div>
        </div>
        <div id="test5">
            <div id="request">
                <div id="sub-title">
                    <i class="material-icons left">send</i><h5>教室予約申請</h5>
                </div>
                <div id="request-list">
                    <table class="centered">
                        <thead>
                        <tr>
                            <th>教室</th>
                            <th>日時</th>
                            <th>限目</th>
                            <th>申請日</th>
                            <th>ステータス</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>182</td>
                            <td>2018/02/05</td>
                            <td>4限目</td>
                            <td>2018/02/04</td>
                            <td><img src="image/icon/check-circle.png" width="24px" href="24px" alt="承認">承認</td>
                        </tr>
                        <tr>
                            <td>182</td>
                            <td>2018/02/05</td>
                            <td>4限目</td>
                            <td>2018/02/04</td>
                            <td><img src="image/icon/send.png" width="24px" href="24px" alt="承認">申請中</td>
                        </tr>
                        <tr>
                            <td>182</td>
                            <td>2018/02/05</td>
                            <td>4限目</td>
                            <td>2018/02/04</td>
                            <td><img src="image/icon/close-circle.png" width="24px" href="24px" alt="承認">非承認</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div id="test6">
            <div id="expiration-date">
                <h5>パスワード有効期限:
                    <?php
                        $limitDate=$access->getLimitPassWord('ohs50054');
                        $limit=explode("-",$limitDate[0]);
                        echo $limit[0].'年'.$limit[1].'月'.$limit[2].'日';
                    ?>
                </h5>
            </div>
            <div id="pass">
                <form action="password_change.php" method="post">
                    <div class="input-field " id="current">
                        <input id="password" type="password" class="validate" name="current">
                        <label for="password">現在のパスワード</label>
                    </div>
                    <div class="input-field " id="new">
                        <input id="password" type="password" class="validate" name="new">
                        <label for="password">新しいパスワード</label>
                    </div>
                    <div class="input-field " id="confirmation">
                        <input id="password" type="password" class="validate" name="confirmation">
                        <label for="password">新しいパスワード(確認)</label>
                    </div>
                    <button class="btn waves-effect waves-light" type="submit" name="action" id="btn-update">
                        パスワード変更
                        <i class="material-icons right">send</i>
                    </button>
                </form>
            </div>
        </div><!-- tab06-->
        <div id="test7">
            <div id="contact">

            </div>
            <form action="contact.php" method="get">
                <div class="input-field" id="contact-title">
                    <input type="text" class="validate" name="title">
                    <label for="contactTitle">タイトル</label>
                </div>
                <div id="contact-content">
                    <div class="input-field" id="contact-comment">
                        <textarea class="materialize-textarea" name="content"></textarea>
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

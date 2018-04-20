<?php
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors','On');
require '../bootstrap.php';
$session = new Session();
$access = new DataAccess();
define('EVENT_HISTORY',3);
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
    <title>HOME</title>
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
            </div><!-- end menu -->
        </div><!-- end nav -->
        <div id="header">
            <div id="title">
                <h2>HAL Students System</h2>
            </div><!-- end title -->
            <div id="user">
                <p><a href="home.php"><img src="image/icon/ic_person_black_24dp_1x.png" width="24" height="24" alt="アカウント"/><?php echo $student=$session->get('ohs50054')?></a></p>
            </div><!-- end user -->
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
            <div class="sub-title">
                <i class="material-icons left">assessment</i><h5>成績情報</h5>
            </div>
            <div id="achievement">
                <table class="centered">
                    <thead>
                    <tr>
                        <th id="subjectCode">科目コード</th>
                        <th id="subjectName">科目名</th>
                        <th id="subjectScore">点数</th>
                        <th id="subjectRating">評定</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $dataList =$access -> getLessonDataList($student) ?>
                    <?php foreach($dataList as $value):?>
                        <tr>
                            <td class="code"><?php echo $value['subject_code']?></td>
                            <td class="name"><?php echo $value['subject_name']?></td>
                            <td class="score">
                                <a class="waves-effect waves-light modal-trigger" href="#modal1" data-subject="0#<?php echo $value['subject_code']?>">
                                    <img src="image/icon/ic_expand_more_black_24dp_1x.png" width="24" height="24" alt="" />
                                </a>
                            </td>
                            <td class="rating">
                                <a class="waves-effect waves-light modal-trigger" href="#modal1" data-subject="1#<?php echo $value['subject_code']?>">
                                    <img src="image/icon/ic_expand_more_black_24dp_1x.png" width="24" height="24" alt="" />
                                </a>
                            </td>
                        </tr>
                    <?php endforeach;?>
                    </tbody>
                </table>
                <div class="modal modal-fixed-footer" id="modal1">
                    <div class="modal-content" id="achievementData">

                    </div>
                    <div class="modal-footer">
                        <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat ">Close</a>
                    </div>
                </div>
            </div>
        </div><!-- tab01-->
        <div id="test2">
            <div class="sub-title">
                <i class="material-icons left">airline_seat_recline_normal</i><h5>出席情報</h5>
            </div>
            <div id="attend">
                <table class="centered">
                    <thead>
                    <tr>
                        <th id="subjectCode">科目コード</th>
                        <th id="subjectName">科目名</th>
                        <th id="subject">出席率</th>
                    </tr>
                    <tbody>
                    <?php $attend = $access->getAttend($student)?>
                    <?php foreach ($attend as $value) :?>
                        <tr>
                            <td class="code"><?php echo $value['subject_code']?></td>
                            <td class="name"><?php echo $value['subject_name']?></td>
                            <td class="score"><?php echo $value['attendance_rate']?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                    </thead>
                </table>
            </div>
        </div><!-- tab02 -->

        <div id="test3">
            <div class="sub-title">
                <i class="material-icons left">mail</i><h5>メッセージ一覧</h5>
            </div>
            <div id="message-list">
                <table class="centered">
                    <thead>
                    <tr>
                        <th id="">件名</th>
                        <th id="">差出人</th>
                        <th id="">時間</th>
                        <th id="">詳細</th>
                    </tr>
                    <tbody>
                    <?php $mailList=$access->getMessage($student)?>
                    <?php foreach ($mailList as $mail) :?>
                        <tr>
                            <td class="title"><?php echo $mail['message_title'] ?></td>
                            <td class="sender"><?php echo $mail['teacher_name'] ?></td>
                            <td class="time"><?php echo $mail['date'] ?></td>
                            <td class="details">
                                <a class="waves-effect waves-light modal-trigger" href="#mail<?php echo $mail['message_no']?>">
                                    <img src="image/icon/ic_expand_more_black_24dp_1x.png" width="24" height="24" alt="" />
                                </a>
                            </td>
                        </tr>
                    <?php endforeach;?>
                    </tbody>
                    </thead>
                </table>
            </div>
            <?php $mailList=$access->getMessage($student)?>
            <?php foreach ($mailList as $mail): ?>
                <div id="mail<?php echo $mail['message_no']?>" class="modal modal-fixed-footer">
                    <div class="modal-content">
                        <ul class="collection with-header">
                            <li class="collection-item"><h6>Title:</h6><p><?php echo $mail['message_title']?></p></li>
                            <li class="collection-item"><h6>From:</h6><p><?php echo $mail['teacher_name']?>＜<?php echo $mail['message_From']?>＞</p></li>
                            <li class="collection-item"><h6>To:</h6><p><?php echo $mail['Student_Name']?>＜<?php echo $mail['message_To']?>＞</p></li>
                            <li class="collection-item"><h6>日時:</h6><p><?php echo $mail['date']?></p></li>
                            <li class="collection-item"><div class="message"><?php echo nl2br($mail['message_content'])?></div></li>
                        </ul>
                    </div>
                    <div class="modal-footer">
                        <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat ">Close</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div><!-- tab03-->
        <div id="test4">
            <div id="schedule">
                <?php $schedule=$access->getEventsSchedule($student)?>
                <dl>
                    <dt><i class="material-icons left">insert_invitation</i><h5>イベント参加スケジュール</h5></dt>
                    <?php foreach ($schedule as $value):?>
                        <dd class="schedule-title"><p><?php echo $value['events_title']?></p></dd>
                        <dd class="schedule-date"><p>開催日：<?php echo $value['date']?></p></dd>
                        <dd class="schedule-details">
                            <a href="events_details.php?event=<?php echo $value['events_no']?>" class="waves-effect waves-light btn text-cut">
                                <i class="material-icons right">chevron_right</i>詳細
                            </a>
                        </dd>
                    <?php endforeach;?>
                </dl>
            </div>
            <div id="event-relation">
                <?php $join = $access->getEventsHistory($student,EVENT_HISTORY)?>
                <dl>
                    <dt><i class="material-icons left">access_time</i><h5>イベント参加履歴</h5></dt>
                    <?php foreach ($join as $value):?>
                        <dd><a class="waves-effect waves-light btn text-cut" href="events_details.php?event=<?php echo $value['events_no']?>">
                                <i class="material-icons left">chevron_right</i>
                                <p><?php echo $value['events_title']?></p>
                            </a>
                        </dd>
                    <?php endforeach;?>
                </dl>
                <?php $history=$access->getEventsPostHistory($student)?>
                <dl>
                    <dt><i class="material-icons left">create</i><h5>イベント投稿履歴</h5></dt>
                    <?php foreach ($history as $value) :?>
                        <dd><a class="waves-effect waves-light btn text-cut" href="events_details.php?event=<?php echo $value['events_no']?>">
                                <i class="material-icons left">chevron_right</i>
                                <p><?php echo $value['events_title']?></p>
                            </a>
                        </dd>
                    <?php endforeach;?>
                </dl>
            </div>
        </div><!-- tab04-->
        <div id="test5">
            <div id="request">
                <div class="sub-title">
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
                            <th>責任者</th>
                            <th>ステータス</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $requestRoom= $access->getRequestRoom($student) ?>
                        <?php foreach ($requestRoom as $value): ?>
                            <tr>
                                <td><?php echo $value['reservation_classRoom'] ?></td>
                                <td><?php echo  $value['request_date']?></td>
                                <td><?php echo $value['roomlimit']?>限目</td>
                                <td><?php echo  $value['date']?></td>
                                <td><?php echo  $value['teacher_name']?></td>
                                <?php switch ($value['reservation_status']) {
                                    case 0:
                                        echo '<td><img src="image/icon/send.png" width="24px" href="24px" alt="承認">申請中</td>';
                                        break;
                                    case 1:
                                        echo '<td><img src="image/icon/check-circle.png" width="24px" href="24px" alt="承認">承認　</td>';
                                        break;
                                    case 2:
                                        echo '<td><img src="image/icon/close-circle.png" width="24px" href="24px" alt="承認">非承認</td>';
                                        break;
                                }
                                ?>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div><!-- tab05-->
        <div id="test6">
            <div class="sub-title">
                <i class="material-icons left">lock</i><h5>パスワード</h5>
            </div>
            <div id="expiration-date">
                <h5>パスワード有効期限:
                    <?php $limitDate=$access->getLimitPassWord('ohs50054');?>
                    <?php $limit=explode("-",$limitDate[0]);?>
                    <?php echo $limit[0]?>年<?php echo $limit[1]?>月<?php echo $limit[2]?>日
                </h5>
            </div>
            <div id="pass">
                <form action="password_change.php" method="post">
                    <div class="input-field " id="current">
                        <input class="password" type="password" class="validate" name="current">
                        <label for="password">現在のパスワード</label>
                    </div>
                    <div class="input-field " id="new">
                        <input class="password" type="password" class="validate" name="new">
                        <label for="password">新しいパスワード</label>
                    </div>
                    <div class="input-field " id="confirmation">
                        <input class="password" type="password" class="validate" name="confirmation">
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
            <div class="sub-title">
                <i class="material-icons left">help</i><h5>お問い合わせ</h5>
            </div>
            <div id="contact">
                <h5>何か破損している場合やなどはここに入力して下さい。</h5>
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
        </div><!-- tab07-->
        <div id="footer">
            <footer>2017 HAL Students System</footer>
        </div><!-- footer -->

    </div><!-- end contents -->
</div><!-- end wrapper -->
<script type="text/javascript" src="jq/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="js/materialize.min.js"></script>
<script type="text/javascript" src="js/home.js"></script>
</body>
</html>
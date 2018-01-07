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
<title>HAL学生管理システム|教室検索・予約</title>
<link type="text/css" rel="stylesheet" href="css/reset/html5reset-1.6.1.css" />
<link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>
<link type="text/css" rel="stylesheet" href="css/themes/default.css">
<link type="text/css" rel="stylesheet" href="css/themes/default.date.css">
<link type="text/css" rel="stylesheet" href="css/materialize.min.css" />
<link type="text/css" rel="stylesheet" href="css/design/design_format.css" />
<link type="text/css" rel="stylesheet" href="css/design/design_classroom.css" />
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
        </div>
        <div id="reservation">
            <form action="#" method="get">
                <div id="btn-search"><!-- 絞り込み検索 -->
                    <button class="btn waves-effect waves-light" id="btn-room-search" type="submit" name="action">絞り込み検索
                        <i class="material-icons left">search</i>
                        </button>
                </div>
                <div id="room-size"><!-- 教室のサイズ -->
                    <p>教室サイズ</p>
                    <input class="with-gap" name="size" type="radio" id="size-s"  checked/>
                    <label for="size-s">S</label>
                    <input class="with-gap" name="size" type="radio" id="size-m"  />
                    <label for="size-m">M</label>
                    <input class="with-gap" name="size" type="radio" id="size-l"  />
                    <label for="size-l">L</label>
                </div>
                <div id="room-power-port"><!--電源ﾎﾟｰﾄ -->
                    <p> 電源ポート</p>
                    <input class="with-gap" name="power" type="radio" id="power-true"  checked/>
                    <label for="power-true">有り</label>
                    <input class="with-gap" name="power" type="radio" id="power-false"  />
                    <label for="power-false">無し</label>
                </div>
                <div id="room-lan-port"><!-- LANﾎﾟｰﾄ-->
                    <p>LANポート</p>
                    <input class="with-gap" name="lan" type="radio" id="lan-true"  checked/>
                    <label for="lan-true">有り</label>
                    <input class="with-gap" name="lan" type="radio" id="lan-false"  />
                    <label for="lan-false">無し</label>
                </div>
                <div id="room-floor" class="input-field">
                    <select>
                        <option value="" disabled selected>floor</option>
                        <option value="1">3</option>
                        <option value="2">4</option>
                        <option value="3">5</option>
                    </select>
                </div>
            </form>
        </div>
        <div id="plans">
            <table class="centered highlight">
                <thead>
                <tr>
                    <th>教室</th>
                    <th>LANポート</th>
                    <th>電源ポート</th>
                    <th>サイズ</th>
                    <th>空き状況確認</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $class = $access->getClassRoomDataList();
                foreach ($class as $value){
                    echo '<tr>';
                    echo '<td>'.$value['classroom_no'].'</td>';
                    switch ($value['lan_port']){
                        case 0:
                            echo '<td>無</td>';
                            break;
                        case 1:
                            echo '<td>有</td>';
                            break;
                    }
                    switch ('power_port'){
                        case 0:
                            echo '<td>無</td>';
                            break;
                        case 1:
                            echo '<td>有</td>';
                            break;
                    }
                    echo '<td>'.$value['classroom_size'].'</td>';
                    echo '<td><a class="waves-effect waves-light btn modal-trigger" href="#'.$value['classroom_no'].'">確認</a></td>';
                    echo '</tr>';
                }
                ?>
                </tbody>
            </table>
            <?php
            $schedule = $access->getClassSchedule();
            foreach ($schedule as $value){
                echo '<div id="'.$value['classroom_no'].'" class="modal modal-fixed-footer">';
                echo '<div class="modal-content">';
                echo '<h4>'.$value['classroom_no'].'教室</h4>';
                echo '<table class="centered highlight">';
                echo '<tbody>';
                echo '<tr>';
                switch ($value['first_limit']){
                    case 0:
                        echo '<td>1限目</td>';
                        echo '<td>×</td>';
                        echo '<td>使用中</td>';
                        echo '<td><a class="waves-effect waves-light btn modal-trigger" href="#modal1" disabled="disabled">予約申請</a></td>';
                        break;
                    case 1:
                        echo '<td>1限目</td>';
                        echo '<td>〇</td>';
                        echo '<td>使用可能</td>';
                        echo '<td><a class="waves-effect waves-light btn modal-trigger" href="#modal1">予約申請</a></td>';
                        break;
                }
                echo '</tr>';
                switch ($value['second_limit']){
                    case 0:
                        echo '<td>2限目</td>';
                        echo '<td>×</td>';
                        echo '<td>使用中</td>';
                        echo '<td><a class="waves-effect waves-light btn modal-trigger" href="#modal1" disabled="disabled">予約申請</a></td>';
                        break;
                    case 1:
                        echo '<td>2限目</td>';
                        echo '<td>〇</td>';
                        echo '<td>使用可能</td>';
                        echo '<td><a class="waves-effect waves-light btn modal-trigger" href="#modal1">予約申請</a></td>';
                        break;
                }
                echo '</tr>';
                switch ($value['third_limit']){
                    case 0:
                        echo '<td>3限目</td>';
                        echo '<td>×</td>';
                        echo '<td>使用中</td>';
                        echo '<td><a class="waves-effect waves-light btn modal-trigger" href="#modal1" disabled="disabled">予約申請</a></td>';
                        break;
                    case 1:
                        echo '<td>3限目</td>';
                        echo '<td>〇</td>';
                        echo '<td>使用可能</td>';
                        echo '<td><a class="waves-effect waves-light btn modal-trigger" href="#modal1">予約申請</a></td>';
                        break;
                }
                echo '</tr>';
                switch ($value['fourth_limit']){
                    case 0:
                        echo '<td>4限目</td>';
                        echo '<td>×</td>';
                        echo '<td>使用中</td>';
                        echo '<td><a class="waves-effect waves-light btn modal-trigger" href="#modal1" disabled="disabled">予約申請</a></td>';
                        break;
                    case 1:
                        echo '<td>4限目</td>';
                        echo '<td>〇</td>';
                        echo '<td>使用可能</td>';
                        echo '<td><a class="waves-effect waves-light btn modal-trigger" href="#modal1">予約申請</a></td>';
                        break;
                }
                echo '</tr>';
                switch ($value['five_limit']){
                    case 0:
                        echo '<td>5限目</td>';
                        echo '<td>×</td>';
                        echo '<td>使用中</td>';
                        echo '<td><a class="waves-effect waves-light btn modal-trigger" href="#modal1" disabled="disabled">予約申請</a></td>';
                        break;
                    case 1:
                        echo '<td>5限目</td>';
                        echo '<td>〇</td>';
                        echo '<td>使用可能</td>';
                        echo '<td><a class="waves-effect waves-light btn modal-trigger" href="#modal1">予約申請</a></td>';
                        break;
                }
                echo '</tr>';
                switch ($value['sixth_limit']){
                    case 0:
                        echo '<td>6限目</td>';
                        echo '<td>×</td>';
                        echo '<td>使用中</td>';
                        echo '<td><a class="waves-effect waves-light btn modal-trigger" href="#modal1" disabled="disabled">予約申請</a></td>';
                        break;
                    case 1:
                        echo '<td>6限目</td>';
                        echo '<td>〇</td>';
                        echo '<td>使用可能</td>';
                        echo '<td><a class="waves-effect waves-light btn modal-trigger" href="#modal1">予約申請</a></td>';
                        break;
                }
                echo '</tbody>';
                echo '</table>';
                echo '</div>';
                echo '<div class="modal-footer">';
                echo '<a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat ">Agree</a>';
                echo '</div>';
                echo '</div>';
            }
            ?>
        </div>
        <div id="page">
            <ul class="pagination">
                <li class="disabled"><a href="#!"><i class="material-icons">chevron_left</i></a></li>
                <li class="active"><a href="#!">1</a></li>
                <li class="waves-effect"><a href="#!">2</a></li>
                <li class="waves-effect"><a href="#!">3</a></li>
                <li class="waves-effect"><a href="#!">4</a></li>
                <li class="waves-effect"><a href="#!">5</a></li>
                <li class="waves-effect"><a href="#!"><i class="material-icons">chevron_right</i></a></li>
            </ul>
        </div>
        <div id="footer">
            <footer>2017 HAL Students System</footer>
        </div><!-- footer -->
    </div>
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

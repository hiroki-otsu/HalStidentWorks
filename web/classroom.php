<?php
//エラー表示
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors','On');
//外部ファイル読み込み
require '../bootstrap.php';
$session = new Session();
$access = new DataAccess();
define('CLASSROOM_PAGE',10);
define('CLASSROOM','classroom');
if(isset($_GET['page'])){
    preg_match('/^[1-9][0-9]*$/',$_GET['page']);
    $page = (int)$_GET['page'];
}
else{
    $page =1;
}
$total = $access->getCountDate(CLASSROOM);
$totalPage = ceil($total/CLASSROOM_PAGE);
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>教室検索・予約</title>
    <link type="text/css" rel="stylesheet" href="css/reset/html5reset-1.6.1.css" />
    <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>
    <link type="text/css" rel="stylesheet" href="css/design/design_format.css" />
    <link type="text/css" rel="stylesheet" href="css/design/design_classroom.css" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
</head>
<body>
<div id="wrapper">
    <div id="nav" class="z-depth-3">
        <div id="logo">
            <img src="image/logo.jpg" width="258" height="255" alt="ロゴ">
        </div><!-- logo -->
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
            </div><!-- title -->
            <div id="user">
                <p><a href="home.php"><img src="image/icon/ic_person_black_24dp_1x.png" width="24" height="24" alt="アカウント"/><?php echo $session->get('ohs50054')?></a></p>
            </div><!-- user -->
        </div><!-- header  -->
        <div id="reservation">
            <div id="room-search">
                <form action="#" method="get">
                    <div id="btn-search">
                        <button class="btn waves-effect waves-light" id="btn-room-search" type="submit" name="action">絞り込み検索
                            <i class="material-icons left">search</i>
                        </button>
                    </div><!-- 絞り込み検索 -->
                    <div id="room-size">
                        <p>教室サイズ</p>
                        <input class="with-gap" name="size" type="radio" id="size-s"  checked/>
                        <label for="size-s">S</label>
                        <input class="with-gap" name="size" type="radio" id="size-m"  />
                        <label for="size-m">M</label>
                        <input class="with-gap" name="size" type="radio" id="size-l"  />
                        <label for="size-l">L</label>
                    </div><!-- 教室のサイズ -->
                    <div id="room-power-port">
                        <p> 電源ポート</p>
                        <input class="with-gap" name="power" type="radio" id="power-true"  checked/>
                        <label for="power-true">有り</label>
                        <input class="with-gap" name="power" type="radio" id="power-false"  />
                        <label for="power-false">無し</label>
                    </div><!--電源ﾎﾟｰﾄ -->
                    <div id="room-lan-port">
                        <p>LANポート</p>
                        <input class="with-gap" name="lan" type="radio" id="lan-true"  checked/>
                        <label for="lan-true">有り</label>
                        <input class="with-gap" name="lan" type="radio" id="lan-false"  />
                        <label for="lan-false">無し</label>
                    </div><!-- LANﾎﾟｰﾄ-->
                    <div id="room-floor">
                        <div class="input-field">
                            <select>
                                <option value="" disabled selected>floor</option>
                                <option value="1">3</option>
                                <option value="2">4</option>
                                <option value="3">5</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div><!-- room-search -->
        </div><!-- reservation -->
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
                <?php  $classRoom = $access->getClassRoomDataList($page,CLASSROOM_PAGE)?>
                <?php  for ($i =0; $i<count($classRoom);$i++) :?>
                <tr>
                    <td><?php echo $classRoom[$i]['class'] ?></td>
                    <td><?php echo $classRoom[$i]['lan'] ?></td>
                    <td><?php echo $classRoom[$i]['power'] ?></td>
                    <td><?php echo $classRoom[$i]['size'] ?></td>
                    <td><a class="waves-effect waves-light btn modal-trigger" href="#modal" data-class="#<?php echo $classRoom[$i]['class']?>">確認</a></td>
                </tr>
                <?php endfor; ?>
            </table>

            <!-- Modal Structure -->
            <div id="modal" class="modal modal-fixed-footer">
                <div class="modal-content">
                    <table id="limit" class="centered highlight">

                    </table>
                </div>
                <div class="modal-footer">
                    <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat ">Close</a>
                </div>
            </div>
        </div>
        <!--  ページング機能  -->
        <div id="page">
            <ul class="pagination">
                <!--  前を表示させる  -->
                <?php if ($page > 1) : ?>
                    <li class="disabled"><a href="?page=<?php echo $page - 1; ?>"><i class="material-icons">chevron_left</i></a></li>
                <?php endif; ?>
                <!--  1 2...とか表示  -->
                <?php for ($i=1 ; $i <= $totalPage; $i++): ?>
                    <?php if($page == $i) :?>
                        <li class="active"><a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                    <?php else: ?>
                        <li class="waves-effect"><a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                    <?php endif; ?>
                <?php endfor; ?>
                <!--  次を表示させる  -->
                <?php if ($page < $totalPage) : ?>
                    <li class="waves-effect"><a href="?page=<?php echo $page + 1; ?>"><i class="material-icons">chevron_right</i></a></li>
                <?php endif; ?>
            </ul>
        </div><!-- page -->
        <div id="footer">
            <footer>2017 HAL Students System</footer>
        </div><!-- footer -->
    </div><!-- content -->
</div><!-- wrapper -->
<script type="text/javascript" src="jq/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="js/materialize.min.js"></script>
<script type="text/javascript" src="js/schedule-list.js"></script>
<script type="text/javascript" src="js/model.js"></script>
</body>
</html>

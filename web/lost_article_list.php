<?php
//エラー表示
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors','On');
//外部ファイル読み込み
require '../bootstrap.php';
//インスタンス化
$session = new Session();
$access = new DataAccess();
define('LOST_ARTICLE_PAGE',6);
define('LOST_ARTICLE','lostarticle');

if(isset($_GET['page'])){
    preg_match('/^[1-9][0-9]*$/',$_GET['page']);
    $page = (int)$_GET['page'];
}
else{
    $page =1;
}
$total = $access->getCountDate(LOST_ARTICLE);
$totalPage = ceil($total / LOST_ARTICLE_PAGE);
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>拾得物</title>
    <link type="text/css" rel="stylesheet" href="css/reset/html5reset-1.6.1.css" />
    <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>
    <link type="text/css" rel="stylesheet" href="css/design/design_format.css" />
    <link type="text/css" rel="stylesheet" href="css/design/design_lost_article_list.css" />
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
        </div>
        <div id="lost-article-post">
            <a href="lost_article_post.php"class="waves-effect waves-light btn-large">拾得物を投稿</a>
        </div>
        <div id="lost-article">
            <div id="sub-title">
                <i class="material-icons left">live_help</i><h5>拾得物一覧</h5>
            </div>
            <?php $lostArticle=$access->getLostArticlesList($page,LOST_ARTICLE_PAGE);?>
            <div id="card">
            <?php   for ($i =0; $i<count($lostArticle);$i++) :?>
                <div class="lost-article-card">
                    <div class="card-title">
                        <dl>
                            <dt><h5>拾得物名:<?php  echo $lostArticle[$i]['title']?></h5></dt>
                            <dt><p>カテゴリー:<?php  echo $lostArticle[$i]['category']?></p></dt>
                            <dd class="card-time"><p><?php  echo $lostArticle[$i]['datetime']?></p></dd>
                        </dl>
                    </div>
                    <div class="card-content">
                        <?php  echo $lostArticle[$i]['comment']?>
                    </div>
                    <div class="card-link">
                        <!-- Modal Trigger -->
                        <a class="modal-trigger" href="#modal<?php echo $lostArticle[$i]['no']?>">image show</a>
                    </div>
                </div>

                <!-- Modal Structure -->
                <div id="modal<?php echo $lostArticle[$i]['no']?>" class="modal modal-fixed-footer">
                    <div class="modal-content">
                        <h4><?php  echo $lostArticle[$i]['title']?></h4>
                        <img src="<?php  echo $lostArticle[$i]['image']?>" alt="<?php  echo $lostArticle[$i]['title']?>">
                    </div>
                    <div class="modal-footer">
                        <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat ">close</a>
                    </div>
                </div>
            <?php endfor;?>
            </div>
            <!--  ページング機能  -->
            <div id="page">
                <ul class="pagination">
                    <!--  前を表示させる  -->
                    <?php if ($page > 1) : ?>
                        <li class="disabled"><a href="?page=<?php echo $page - 1; ?>"><i class="material-icons">chevron_left</i></a></li>
                    <?php endif; ?>
                    <!-- トータル件数が6件より少ない場合はページングを表示させない -->
                    <?php if($totalPage>LOST_ARTICLE_PAGE): ?>
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
    </div>
</div><!-- end wrapper -->
<script type="text/javascript" src="jq/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="js/materialize.min.js"></script>
<script type="text/javascript" src="js/model.js"></script>

</body>
</html>

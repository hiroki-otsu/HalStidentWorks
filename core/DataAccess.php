<?php
//require("DbManager.php");
class DataAccess
{
  const DSN ="mysql:host=localhost;dbname=StudentWorks;charset=utf8";//データベース名
  const USER_NAME ="root";//ユーザー名
  const PASSWORD ="root";//パスワード
  public static $dbCon;

    /**
     * DataAccess constructor.
     */
  public function __construct()
  {
    self::$dbCon = new PDO(self::DSN,self::USER_NAME,self::PASSWORD);
    self::$dbCon->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    self::$dbCon->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
  }

    /**
     * DataAccess destruct.
     */
  public function __destruct()
  {
    self::$dbCon = null;
  }

    /**
     * ログインするユーザの情報を取得するメソッド
     *
     * @param $id   学籍番号
     * @return mixed
     */
  public function getLoginUserInformation($id){

      $sql="SELECT Student_Name,Student_Pass FROM student_account ";
      $sql.="WHERE Student_No = :userId AND CURDATE()<=Pass_Update";
      $stmt =self::$dbCon->prepare($sql);
      $stmt->bindValue(":userId", $id, PDO::PARAM_STR);
      $stmt->execute();
      $row = $stmt->fetch();

      return $row;
  }

    /**
     *  学生のパスワードを変更するメソッド
     *
     * @param $pass
     * @param $student
     *
     */
    public function update($pass,$student){
        $user = explode(':',$student);
        $today = date("Y/m/d",strtotime("+3 month"));
        $options = array('cost' => 10);
        $passWord = password_hash($pass,PASSWORD_DEFAULT,$options);
        $sql='UPDATE student_account ';
        $sql.='SET Student_Pass=:newPass,';
        $sql.='pass_update=:today ';
        $sql.='WHERE Student_No=:student';
        $stmt =self::$dbCon->prepare($sql);
        $stmt->bindValue(":newPass",$passWord, PDO::PARAM_STR);
        $stmt->bindValue(":today",$today, PDO::PARAM_STR);
        $stmt->bindValue(":student",$user[0], PDO::PARAM_STR);

        $stmt->execute();
    }

    /**
     * ログインしているユーザの全科目を表示するメソッド
     *
     * @param $student
     * @return array
     */
    public function getLessonDataList($student){
    $user=explode(":",$student);
    $sql='SELECT * FROM lesson ';
    $sql.='inner join subject ';
    $sql.='on subject.subject_code = lesson.subject_code ';
    $sql.='inner join student_account student ';
    $sql.='on student.department_code = lesson.department_code ';
    $sql.='where student.Student_No = :student ';
    $stmt = self::$dbCon->prepare($sql);
    $stmt->bindValue(":student",$user[0], PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetchAll();

    return $result;
    }

    /**
     * ログインしているユーザの各科目の成績を表示するメソッド
     *
     * @param $subject
     * @param $status
     * @param $student
     * @return array
     */
    public function getAchievementDataList($subject,$status,$student){
        $user=explode(":",$student);
        $sql="SELECT * FROM achievement ";
        $sql.='inner join student_account student ';
        $sql.='on student.student_no = achievement.student_no ';
        $sql.='WHERE achievement.subject_code = :subject ';
        $sql.='AND achievement.task_status = :status ';
        $sql.='AND achievement.student_no = :student ';
        $stmt = self::$dbCon->prepare($sql);
        $stmt->bindValue(":subject",$subject, PDO::PARAM_STR);
        $stmt->bindValue(":status", $status, PDO::PARAM_STR);
        $stmt->bindValue(":student",$user[0], PDO::PARAM_STR);
        $stmt->execute();
        $row =$stmt->fetchAll(PDO::FETCH_ASSOC);

        return $row;
    }

    /**
     * ログインしているユーザのパスワードの有効期限を表示するメソッド
     *
     * @param $user
     * @return mixed
     */
    public function getLimitPassWord($user){
        $sql="SELECT Pass_Update FROM student_account WHERE Student_No=:student";
        $stmt = self::$dbCon->prepare($sql);
        $stmt->bindValue(":student",$user, PDO::PARAM_STR);
        $stmt->execute();
        $result =$stmt->fetch();

        return $result;
    }

    /**
     * 全件情報を取得するメソッド
     *
     * @param $table
     * @return Generator
     */
    public function getAllDataList($table)
    {
        $sql="SELECT * FROM $table";
        $stmt = self::$dbCon->prepare($sql);
//      $stmt->bindValue(':selectTable',$table,PDO::PARAM_STR);
//      $stmt->bindValue(':field',$field,PDO::PARAM_STR);
//      $stmt->bindValue(':sort',$sort,PDO::PARAM_STR);
        $stmt->execute();
        $rows = null;
        while ($result = $stmt->fetch(PDO::FETCH_ASSOC)){
            yield $result;
        }
    }

    /**
     * 入力された文字から教師のデータを取得するメソッド
     *
     * @param $teacherName
     * @param $page
     * @param $TEACHER_PAGE
     * @return array
     */
    public function getTeacher($teacherName,$page,$TEACHER_PAGE){
        $offset = $TEACHER_PAGE * ($page - 1);
        $sql="SELECT * FROM teacher_account ";
        $sql.="where  teacher_name LIKE '%:teacher%' or teacher_name_kana LIKE '%:teacher%' or teacher_name_hira LIKE '%:teacher%'";
        $sql.="limit :offset,:page";
        $stmt = self::$dbCon->prepare($sql);
        $stmt->execute();
        $stmt->bindValue(":teacher",$teacherName, PDO::PARAM_STR);
        $stmt->bindValue(":offset", $offset, PDO::PARAM_INT);
        $stmt->bindValue(":page",$TEACHER_PAGE, PDO::PARAM_INT);
        $row =$stmt->fetchAll(PDO::FETCH_ASSOC);

        return $row;
    }

    /**
     * 教官情報を全件取得するメソッド
     *
     * @param $page
     * @param $TEACHER_PAGE
     * @return array
     */
    public function getTeacherList($page,$TEACHER_PAGE)
    {
        $offset = $TEACHER_PAGE * ($page - 1);
        $sql='SELECT *,';
        $sql.='DATEDIFF(CURDATE(),teacher_update) AS day,';
        $sql.='TIMEDIFF(teacher_times,CURTIME()) AS timestamp ';
        $sql.='FROM teacher_account ';
        $sql.='order by teacher_name_hira,teacher_name_kana ';
        $sql.='LIMIT :offset,:page';
        $stmt = self::$dbCon->prepare($sql);
        $stmt->bindValue(":offset", $offset, PDO::PARAM_INT);
        $stmt->bindValue(":page",$TEACHER_PAGE, PDO::PARAM_INT);
        $stmt->execute();
        $rows = $stmt->fetchAll();
        $result = $this->setStatusTeacher($rows);

        return $result;
    }

    /**
     * 教師の在籍状況を格納するメソッド
     *
     * @param $teacherList
     * @return array
     */
    private function setStatusTeacher($teacherList){
        $list = array();
        for ($i=0;$i<count($teacherList);$i++){
            $statusColor=$this->setStatusEnrollmentColor($teacherList[$i]['teacher_status']);
            $statusCharacter=$this->setStatusEnrollment($teacherList[$i]['teacher_status']);
            $timestamp = $this->setTimestamp($teacherList[$i]['timestamp'],$teacherList[$i]['day']);
            $list[$i]= array(
                'teacher'=>$teacherList[$i]['teacher_name'],
                'lampCharacter'=>$statusCharacter,
                'lampColor'=>$statusColor,
                'timestamp'=>$timestamp,
            );
        }
        return $list;
    }

    /**
     * 在籍状況のカラーを格納するメソッド
     *
     * @param $teacherStatus
     * @return null|string
     */
    private function setStatusEnrollmentColor($teacherStatus){
        $status =null;
        switch ($teacherStatus){
            case 1:
                $status ='lamp_color_green';
                break;
            case 2:
                $status ='lamp_color_orange';
                break;
            default :
                $status ='lamp_color_gray';
                break;
        }
        return $status;
    }

    /**
     * 在籍状況を格納するメソッド
     *
     * @param $teacherStatus
     * @return null|string
     */
    private function setStatusEnrollment($teacherStatus){
        switch ($teacherStatus){
            case 1:
                $character ='在籍中';
                break;
            case 2:
                $character ='離席中';
                break;
            default :
                $character = '不在中';
                break;
        }
        return $character;
    }

    /**
     * 教師の更新日時を格納するメソッド
     *
     * @param $timestamp
     * @param $day
     * @return null|string
     */
    private function setTimestamp($timestamp,$day){
        $before = null;
        if($day!=0){
            $before = $day.'日前';
        }else{
            $times=explode(':',$timestamp);
            if($times[0]!='00'){
                $time=explode('-',$times[0]);
                $before = (int) $time[1].'時間前';
            }else{
                $before = (int) $times[1].'分前';
            }
        }
        return $before;
    }

    /**
     * イベント情報を登録するメソッド
     *
     * @param $title
     * @param $category
     * @param $target
     * @param $contents
     * @param $eventDate
     * @param $student
     *
     * @return bool
     */
    public function setEvent($title,$category,$target,$contents,$eventDate,$student)
    {
        $no = null;
        $user=explode(":",$student);
        $postedDate = date('Y/m/d');
        $sql = "INSERT INTO events ";
        $sql.= "(events_no,events_title,event_category,events_target,events_contents,events_date,posted_date,student_no) ";
        $sql.= "VALUES (:no, :title, :category, :target, :contents, :eventDate, :postedDate, :student)";
        $stmt =self::$dbCon->prepare($sql);
        $stmt->bindValue(":no", $no, PDO::PARAM_INT);
        $stmt->bindValue(":title",$title, PDO::PARAM_STR);
        $stmt->bindValue(":category",$category, PDO::PARAM_STR);
        $stmt->bindValue(":target",$target, PDO::PARAM_STR);
        $stmt->bindValue(":contents",$contents, PDO::PARAM_STR);
        $stmt->bindValue(":eventDate",$eventDate, PDO::PARAM_STR);
        $stmt->bindValue(":postedDate",$postedDate, PDO::PARAM_STR);
        $stmt->bindValue(":student",$user[0], PDO::PARAM_STR);

        $result=$stmt->execute();

        return$result;
    }
    /**
     * イベント情報を取得するメソッド(全件)
     *
     * @param $page
     * @param $EVENT_PAGE
     * @param $student
     * @return null
     */
    public function getEventsInformation($student,$page,$EVENT_PAGE){
        $user=explode(":",$student);
        $offset = $EVENT_PAGE * ($page - 1);
        $sql ="SELECT * ";
        $sql.="FROM events ";
//        $sql.="inner join events_join ";
//        $sql.="on events.events_no = events_join.events_no ";
//        $sql.="where events_join.student_no NOT IN (:joinStudent) ";
//        $sql.="AND events.student_no NOT IN (:eventStudent) ";
        $sql.="ORDER By events.events_no DESC LIMIT :offset,:page";
        $stmt =self::$dbCon->prepare($sql);
//        $stmt->bindValue(":joinStudent",$user[0], PDO::PARAM_STR);
//        $stmt->bindValue(":eventStudent",$user[0], PDO::PARAM_STR);
        $stmt->bindValue(":offset", $offset, PDO::PARAM_INT);
        $stmt->bindValue(":page",$EVENT_PAGE, PDO::PARAM_INT);
        $stmt->execute();
        $rows = $stmt->fetchAll();
        $result = $this->setEventsList($rows);

        return $result;
    }

    /**
     * 登録されているイベント情報を格納するメソッド
     *
     * @param $event
     * @return array
     */
    private function setEventsList($event){
        $list = array();
        for ($i=0;$i<count($event);$i++){
            $category=$this->setStatusCategory($event[$i]['event_category']);
            $list[$i]= array(
                'title'=>$event[$i]['events_title'],
                'target'=>$event[$i]['events_target'],
                'category'=>$category,
                'date'=>$event[$i]['events_date'],
                'link'=>$event[$i]['events_no'],
            );
        }
        return $list;
    }

    /**
     * 登録されているカテゴリーを判定するメソッド
     *
     * @param $category
     * @return string
     */
    private function setStatusCategory($category){
        switch ($category){
            case 0:
                $character ='ゲーム';
                break;
            case 1:
                $character ='デザイン';
                break;
            case 2:
                $character ='ミュージック';
                break;
            case 3:
                $character ='IT';
                break;
            case 4:
                $character ='その他';
                break;
            default :
                $character = '不明';
                break;
        }
        return $character;
    }
    /**
     * 開催されるイベント詳細情報を取得するメソッド
     *
     * @param $no
     * @return array
     */
    public function getEventDetails($no)
    {
        $sql ="SELECT * from events WHERE events_no=:no";
        $stmt =self::$dbCon->prepare($sql);
        $stmt->bindValue(":no", $no, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetchAll();

        return $row;
    }

    public function setEventJoinDecision($eventNo,$student,$status){
        $no = null;
        $user=explode(":",$student);
        $date = date('Y/m/d');
        $sql = "INSERT INTO events_join ";
        $sql.= "(events_join,events_no,student_no,status,date) ";
        $sql.= "VALUES (:no, :eventNo, :student, :status, :date)";
        $stmt =self::$dbCon->prepare($sql);
        $stmt->bindValue(":no", $no, PDO::PARAM_INT);
        $stmt->bindValue(":eventNo",$eventNo, PDO::PARAM_STR);
        $stmt->bindValue(":student",$user[0], PDO::PARAM_STR);
        $stmt->bindValue(":status",$status, PDO::PARAM_STR);
        $stmt->bindValue(":date",$date, PDO::PARAM_STR);

        $result=$stmt->execute();

        return$result;
    }

    /**
     * 現在登録されている最大noを取得するメソッド
     *
     * @return string
     */
    public function getMaxLostArticleNo()
    {
        $sql="SELECT Max(LostArticle_No) as maxNo from LostArticle";
        $stmt =self::$dbCon->prepare($sql);
        $stmt->execute();

        while ($row = $stmt->fetch()) {
            $maxNo = $row["maxNo"];
        }
        if (empty($maxNo)) {
            $no = sprintf('%04d', 1); // 00001
        }
        else {
            $maxNo++;
            $no = sprintf('%04d', $maxNo);
        }
        return $no;
    }

    /**
     * 投稿されている忘れ物情報を取得するメソッド(全件)
     *
     * @param $page
     * @param $LOST_ARTICLE_PAGE
     * @return array
     */
    public function getLostArticlesList($page,$LOST_ARTICLE_PAGE)
    {
        $offset = $LOST_ARTICLE_PAGE * ($page - 1);
        $sql="SELECT * from lostarticle order by lostArticle_no desc limit :offset,:page";
        $stmt = self::$dbCon->prepare($sql);
        $stmt->bindValue(":offset", $offset, PDO::PARAM_INT);
        $stmt->bindValue(":page",$LOST_ARTICLE_PAGE, PDO::PARAM_INT);
        $stmt->execute();
        $rows = $stmt->fetchAll();
        $result = $this->setLostArticleCard($rows);
        return $result;
    }

    /**
     *　各教室の情報を配列に格納するメソッド
     *
     * @param $lostArticle
     * @return array
     */
    private function setLostArticleCard($lostArticle){
        $list = array();
        for ($i=0;$i<count($lostArticle);$i++){
            $category=$this->setCategoryStatus($lostArticle[$i]['lostArticle_category']);
            $list[$i]= array(
                'no'=>$lostArticle[$i]['lostArticle_no'],
                'title'=> $lostArticle[$i]['lostArticle_title'],
                'category'=>$category,
                'comment'=> $lostArticle[$i]['lostArticle_comment'],
                'image'=> $lostArticle[$i]['image'],
                'datetime'=>$lostArticle[$i]['datetime'],
                'student'=>$lostArticle[$i]['student_no'],
            );
        }
        return $list;
    }

    /**
     * 各教室のPortのステータスを確認するメソッド
     *
     * @param $CategoryStatus
     * @return null|string
     */
    private function setCategoryStatus($CategoryStatus){
        $status =null;
        switch ($CategoryStatus){
            case 1:
                $status ='貴重品';
                break;
            case 2:
                $status ='電化製品';
                break;
            case 3:
                $status ='文房具';
                break;
            case 4:
                $status ='その他';
                break;
        }
        return $status;
    }

    /**
     *  忘れ物情報を登録するメソッド
     *
     * @param $title
     * @param $category
     * @param $comment
     * @param $img
     * @param $student
     */
    public function setLostArticle($title,$category,$comment,$img,$student)
    {
        $datetime = date("Y/m/d/H:i:s");
        $no=null;
        $user=explode(":",$student);
        $sql = "INSERT INTO lostarticle (lostArticle_no,lostArticle_title,lostArticle_category,lostArticle_comment,image,datetime,student_no)";
        $sql.= " VALUES (:no, :title, :category, :comment, :image, :datetime, :student)";
        $stmt =self::$dbCon->prepare($sql);
        $stmt->bindValue(":no", $no, PDO::PARAM_INT);
        $stmt->bindValue(":title",$title, PDO::PARAM_STR);
        $stmt->bindValue(":category",$category, PDO::PARAM_STR);
        $stmt->bindValue(":comment",$comment, PDO::PARAM_STR);
        $stmt->bindValue(":image", $img, PDO::PARAM_STR);
        $stmt->bindValue(":datetime",  $datetime, PDO::PARAM_STR);
        $stmt->bindValue(":student",  $user[0], PDO::PARAM_STR);

        $stmt->execute();
    }

    /**
     * 全教室の全件情報を取得するメソッド
     *
     * @return array
     */
    public function getClassRoomDataList($page,$CLASSROOM_PAGE){
        $offset = $CLASSROOM_PAGE * ($page - 1);
        $sql='SELECT * FROM classroom LIMIT :offset,:page';
        $stmt = self::$dbCon->prepare($sql);
        $stmt->bindValue(":offset", $offset, PDO::PARAM_INT);
        $stmt->bindValue(":page",$CLASSROOM_PAGE, PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $result =$this->setPagination($row);

        return $result;
    }

    /**
     * 曜日ごとの教室情報を取得するメソッド
     *
     * @param $classNo
     * @return array
     */
    public function getSchedule($classNo){
        $sql='SELECT * FROM schedule ';
        $sql.='where schedule_weekNo =:weekNo AND schedule_no =:classNo ';
        $sql.='order by schedule_no,schedule_weekNo,schedule_limit';
        $stmt = self::$dbCon->prepare($sql);
        $stmt->bindValue(":weekNo",$date = date('w'), PDO::PARAM_INT);
        $stmt->bindValue(":classNo",$classNo, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $row;
    }

    /**
     * 登録されているデータをカウントするメソッド
     *
     * @param $table カウントするテーブル名
     * @return mixedn
     */
    public  function getCountDate($table){
        $sql='SELECT count(*) FROM '.$table;
        $stmt = self::$dbCon->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetchColumn();

        return $row;
    }
    /**
     *　各教室の情報を配列に格納するメソッド
     *
     * @param $roomListData
     * @return array
     */
    private function setPagination($roomListData){
        $list = array();
        for ($i=0;$i<count($roomListData);$i++){
            $lan=$this->setPortStatus($roomListData[$i]['lan_port']);
            $power=$this->setPortStatus($roomListData[$i]['power_port']);
            $list[$i]= array(
                'class'=> $roomListData[$i]['classroom_no'],
                'lan'=>$lan,
                'power'=>$power,
                'size'=>$roomListData[$i]['classroom_size'],
            );
        }
        return $list;
    }

    /**
     * 各教室のPortのステータスを確認するメソッド
     *
     * @param $portStatus
     * @return null|string
     */
    private function setPortStatus($portStatus){
        $status =null;
        switch ($portStatus){
            case 0:
                $status ='無';
                break;
            case 1:
                $status ='有';
                break;
        }
        return $status;
    }
    /**
     * 各教室の状況を取得するメソッド
     *
     * @return Generator
     */
    public function getClassSchedule(){
        $sql='SELECT * FROM schedule;';
        $stmt = self::$dbCon->prepare($sql);
        $stmt->execute();
        while ($result = $stmt->fetch(PDO::FETCH_ASSOC)){
            yield $result;
        }
    }

    /**
     *  入力されたお問い合わせデータを登録するメソッド
     * @param $title
     * @param $content
     * @param $student
     */
    public function setContact($title,$content,$student){
        $date = date("Y/m/d");
        $user=explode(":",$student);
        $no=null;
        $sql = "INSERT INTO inquiry (inquiry_no,inquiry_title,inquiry_contents,date,student_no) ";
        $sql.= " VALUES (:no,:title,:comment,:date,:student)";
        $stmt =self::$dbCon->prepare($sql);
        $stmt->bindValue(":no",$no, PDO::PARAM_STR);
        $stmt->bindValue(":title",$title, PDO::PARAM_STR);
        $stmt->bindValue(":comment",$content, PDO::PARAM_STR);
        $stmt->bindValue(":date", $date, PDO::PARAM_STR);
        $stmt->bindValue(":student",$user[0], PDO::PARAM_STR);

        $stmt->execute();
    }

    /**
     * ユーザに送られてきているメッセージを取得するメソッド
     * @param $student
     * @return array
     */
    public function getMessage($student){
        $user=explode(":",$student);
        $student=$this->getUserMailAddress($user[0]);
        $sql="SELECT * FROM message msg ";
        $sql.="inner join student_account student ";
        $sql.="on msg.message_To  = student_Mail ";
        $sql.="inner join teacher_account teacher ";
        $sql.="on msg.message_From = teacher.teacher_mailAddress ";
        $sql.="Where msg.message_To = :student";
        $stmt =self::$dbCon->prepare($sql);
        $stmt->bindValue(":student",$student['Student_Mail'], PDO::PARAM_STR);
        $stmt->execute();

        $result=$stmt->fetchAll();

        return $result;
    }

    /**
     * 学生のメールアドレスを取得するメソッド
     *
     * @param $user
     * @return mixed
     */
    private function getUserMailAddress($user){
        $sql="SELECT Student_Mail FROM student_account ";
        $sql.="where Student_No = :student";
        $stmt =self::$dbCon->prepare($sql);
        $stmt->bindValue(":student",$user, PDO::PARAM_STR);
        $stmt->execute();

        $result=$stmt->fetch(PDO::FETCH_ASSOC);

        return $result;
    }

    /**
     * 参加する予定のイベント情報を取得するメソッド
     *
     * @param $user
     * @param $status
     * @return array
     */
    public function getEventsSchedule($user){
        $student=explode(":",$user);
        $sql="SELECT * FROM StudentWorks.events_join ";
        $sql.="inner join events ";
        $sql.="on events.events_no = events_join.events_no ";
        $sql.="where date >= CURDATE() and events_join.student_no = :student ";
        $stmt =self::$dbCon->prepare($sql);
        $stmt->bindValue(":student",$student[0], PDO::PARAM_STR);
        $stmt->execute();
        $result=$stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    /**
     * 参加する予定のイベントと参加したイベント情報を取得するメソッド
     *
     * @param $user
     * @param $status
     * @return array
     */
    public function getEventsHistory($user,$status){
        $student=explode(":",$user);
        $sql="SELECT * FROM StudentWorks.events_join ";
        $sql.="inner join events ";
        $sql.="on events.events_no = events_join.events_no ";
        $sql.="where status = :status and date <= CURDATE() and events_join.student_no = :student ";
        $stmt =self::$dbCon->prepare($sql);
        $stmt->bindValue(":student",$student[0], PDO::PARAM_STR);
        $stmt->bindValue(":status",$status, PDO::PARAM_STR);
        $stmt->execute();
        $result=$stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }


    /**
     * ログインしているユーザがイベントに投稿しているデータを取得するメソッド
     *
     * @param $user
     * @return array
     */
    public function getEventsPostHistory($user){
        $student=explode(":",$user);
        $sql="SELECT * FROM events where student_no =:student";
        $stmt =self::$dbCon->prepare($sql);
        $stmt->bindValue(":student",$student[0], PDO::PARAM_STR);
        $stmt->execute();
        $result=$stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    /**
     * イベントに参加・不参加の情報をsetするメソッド
     *
     * @param $eventsNo
     * @param $status
     * @param $student
     */
    public function setEventJoinStatus($eventsNo,$status,$student){
        $date = date("Y/m/d");
        $user=explode(":",$student);
        $no=null;
        $sql = "INSERT INTO  (inquiry_no,inquiry_title,inquiry_contents,date,student_no) ";
        $sql.= " VALUES (:no,:title,:comment,:date,:student)";
        $stmt =self::$dbCon->prepare($sql);
        $stmt->bindValue(":no",$no, PDO::PARAM_STR);
        $stmt->bindValue(":eventsNo",$eventsNo, PDO::PARAM_STR);
        $stmt->bindValue(":student",$user[0], PDO::PARAM_STR);
        $stmt->bindValue(":status",$status, PDO::PARAM_STR);
        $stmt->bindValue(":date", $date, PDO::PARAM_STR);

        $stmt->execute();
    }

    /**
     * @param $request
     * @param $limit
     * @param $student
     * @return bool
     */
    public function setRequestClassRoom($request,$limit,$student){

        $user=explode(":",$student);
        $no=null;
        $status =0;
        $requestDate = '2018-02-06';
        $teacherNo = '1';
        $sql = "INSERT INTO reservation (reservation_no, reservation_classRoom, roomlimit, student, reservation_status, request_date ,date, responsibility) ";
        $sql.= " VALUES (:no,:requestNo,:limit,:student,:status,:requestDate,:today,:responsibility)";
        $stmt =self::$dbCon->prepare($sql);
        $stmt->bindValue(":no",$no, PDO::PARAM_INT);
        $stmt->bindValue(":requestNo",$request, PDO::PARAM_INT);
        $stmt->bindValue(":limit",$limit, PDO::PARAM_INT);
        $stmt->bindValue(":student",$user[0], PDO::PARAM_STR);
        $stmt->bindValue(":status", $status, PDO::PARAM_INT);
        $stmt->bindValue(":requestDate",$requestDate, PDO::PARAM_STR);
        $stmt->bindValue(":today", $date = date("Y/m/d"), PDO::PARAM_STR);
        $stmt->bindValue(":responsibility",$teacherNo, PDO::PARAM_INT);

        $row=$stmt->execute();
        $this->updateRequestClassRoom(2,$request,$limit);
        return $row;
    }

    /**
     * @param $status
     * @param $schedule
     * @param $limit
     * @return bool
     */
    private function updateRequestClassRoom($status,$schedule,$limit){
        $sql = " UPDATE schedule SET status = :status where schedule_no = :schedule AND schedule_weekNo = :weekNo AND schedule_limit =:limit ";
        $stmt =self::$dbCon->prepare($sql);
        $stmt->bindValue(":status",$status, PDO::PARAM_INT);
        $stmt->bindValue(":schedule",$schedule, PDO::PARAM_INT);
        $stmt->bindValue(":weekNo",$date = date('w'), PDO::PARAM_INT);
        $stmt->bindValue(":limit",$limit, PDO::PARAM_INT);

        $row=$stmt->execute();

        return $row;
    }

    public function getRequestRoom($student){
        $user=explode(":",$student);
        $sql='SELECT * FROM reservation ';
        $sql.='inner join student_account student ';
        $sql.='on student.student_No = reservation.student ';
        $sql.='inner join teacher_account teacher ';
        $sql.='on teacher.teacher_No = reservation.responsibility ';
        $sql.='where reservation.student =:student;';
        $stmt = self::$dbCon->prepare($sql);
        $stmt->bindValue(":student",$user[0], PDO::PARAM_STR);
        $stmt->execute();
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $row;
    }

    public function getAttend($student){
        $user=explode(":",$student);
        $sql='SELECT * FROM attend ';
        $sql.='inner join teacher_account teacher ';
        $sql.='on teacher.teacher_no = attend.teacher_code ';
        $sql.='inner join student_account student ';
        $sql.='on student.student_no = attend.student_no ';
        $sql.='inner join subject ';
        $sql.='on subject.subject_code = attend.subject_code ';
        $sql.='WHERE attend.student_no =:student;';
        $stmt = self::$dbCon->prepare($sql);
        $stmt->bindValue(":student",$user[0], PDO::PARAM_STR);
        $stmt->execute();
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $row;
    }

}


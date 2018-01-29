<?php
//require("DbManager.php");
class DataAccess
{
  const DSN ="mysql:host=localhost;dbname=StudentWorks;charset=utf8";//データベース名
  const USER_NAME ="root";//ユーザー名
  const PASSWORD ="root";//パスワード
  public static $dbCon;

  public function __construct()
  {
    self::$dbCon = new PDO(self::DSN,self::USER_NAME,self::PASSWORD);
    self::$dbCon->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    self::$dbCon->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    // self::$dbCon = new DbManager();
    // self::$dbCon ->DbConnection();
    // var_dump(self::$dbCon);
  }
  public function __destruct()
  {
    self::$dbCon = null;
    //unset(self::$dbCon);
  }

    /**
     * 現在登録されている最大値のnoを取得するメソッド
     *
     * @param $field
     * @param $table
     * @return string
     */
    public function getMaxNo($field,$table){

      $sql="SELECT Max($field) as maxNo from $table";
      $stmt =self::$dbCon->prepare($sql);
      $stmt->execute();

      while ($row = $stmt->fetch()) {
          $maxNo = $row["maxNo"];
      }
      if (empty($maxNo)) {
          $no = sprintf('%05d', 1); // 00001
      }
      else {
          $maxNo++;
          $no = sprintf('%05d', $maxNo);
      }
      return $no;
    }
    /**
     * ログインするユーザの情報を取得するメソッド
     *
     * @param $id   学籍番号
     * @return mixed
     */
  public function getLoginUserInformation($id)
  {
    $sql="SELECT Student_Name,Student_Pass FROM student_account WHERE Student_No = :userId AND CURDATE()<=Pass_Update";
    $stmt =self::$dbCon->prepare($sql);
    $stmt->bindValue(":userId", $id, PDO::PARAM_STR);
    $stmt->execute();
    $row = $stmt->fetch();
    return $row;
  }

    /**
     * ログインしているユーザの学籍番号を取得するメソッド
     *
     * @param $name
     * @return null
     */
    public function getUserId($name)
    {
        $sql="SELECT Student_No from Student_Account WHERE Student_Name=:userName";
        $stmt =self::$dbCon->prepare($sql);
        $stmt->bindValue(":userName", $name, PDO::PARAM_STR);
        $stmt->execute();
        $id =null;
        while ($row = $stmt->fetch()) {
            $id = $row["Student_Id"];
        }
        return $id;
    }

    /**
     *  学生のパスワードを変更するメソッド
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
     *
     *
     * @return array
     */
    public function getAchievementDataList(){
        $sql="select * From achievement a ";
        $sql.='inner join subject s ';
        $sql.='on s.subject_code = a.subject_code ';
        $sql.='inner join student_account student ';
        $sql.='on student.student_no = a.student_no ';
        $sql.='order by a.subject_code';
        $stmt = self::$dbCon->prepare($sql);
        $stmt->execute();
        $row =$stmt->fetchAll(PDO::FETCH_ASSOC);

        return $row;
    }

    /**
     *
     *
     * @return Generator
     */
    public function getLessonDataList(){
        $sql='SELECT sub.subject_code,sub.subject_name ';
        $sql.='FROM lesson ';
        $sql.='inner join subject sub ';
        $sql.='on sub.subject_code = lesson.subject_code ';
        $sql.='where department_code = "IH31"';
        $stmt = self::$dbCon->prepare($sql);
        $stmt->execute();
        $rows = null;
        while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
            yield $result;
        }
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
      $sql="SELECT * from teacher_account LIMIT :offset,:page";
      $stmt = self::$dbCon->prepare($sql);
      $stmt->bindValue(":offset", $offset, PDO::PARAM_INT);
      $stmt->bindValue(":page",$TEACHER_PAGE, PDO::PARAM_INT);
      $stmt->execute();
      $rows = $stmt->fetchAll();
      $result = $this->setStatusTeacher($rows);

      return $result;
  }

    /**
     *
     * @param $teacherList
     * @return array
     */
  private function setStatusTeacher($teacherList){
      $list = array();
      for ($i=0;$i<count($teacherList);$i++){
          $statusColor=$this->setStatusEnrollmentColor($teacherList[$i]['teacher_status']);
          $statusCharacter=$this->setStatusEnrollment($teacherList[$i]['teacher_status']);
          $list[$i]= array(
              'teacher'=>$teacherList[$i]['teacher_name'],
              'lampCharacter'=>$statusCharacter,
              'lampColor'=>$statusColor,
              'date'=>$teacherList[$i]['teacher_update'],
          );
      }
      return $list;
  }

    /**
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
     * @param $teacherStatus
     * @return null|string
     */
    private function setStatusEnrollment($teacherStatus){
        $status =null;
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
     * イベント情報を登録するメソッド
     *
     * @param $title
     * @param $category
     * @param $target
     * @param $contents
     * @param $eventDate
     * @param $student
     */
  public function setEvent($title,$category,$target,$contents,$eventDate,$student)
  {
      $no = null;
      $user=explode(":",$student);
      $postedDate = date('Y/m/d');
      $sql = "INSERT INTO events(events_no,events_title,event_category,events_target,events_contents,events_date,posted_date,student_no) ";
      $sql.= " VALUES (:no, :title, :category, :target, :contents, :eventDate, :postedDate, :student)";
      $stmt =self::$dbCon->prepare($sql);
      $stmt->bindValue(":no", $no, PDO::PARAM_INT);
      $stmt->bindValue(":title",$title, PDO::PARAM_STR);
      $stmt->bindValue(":category",$category, PDO::PARAM_STR);
      $stmt->bindValue(":target",$target, PDO::PARAM_STR);
      $stmt->bindValue(":contents",$contents, PDO::PARAM_STR);
      $stmt->bindValue(":eventDate",$eventDate, PDO::PARAM_STR);
      $stmt->bindValue(":postedDate",$postedDate, PDO::PARAM_STR);
      $stmt->bindValue(":student",$user[0], PDO::PARAM_STR);

      $stmt->execute();
  }
    /**
     * イベント情報を取得するメソッド(全件)
     *
     * @param $page
     * @param $EVENT_PAGE
     * @return array
     */
    public function getEventsInformation($page,$EVENT_PAGE){
        $offset = $EVENT_PAGE * ($page - 1);
        $sql="SELECT * from events  ORDER By events_No DESC LIMIT :offset,:page";
        $stmt =self::$dbCon->prepare($sql);
        $stmt->bindValue(":offset", $offset, PDO::PARAM_INT);
        $stmt->bindValue(":page",$EVENT_PAGE, PDO::PARAM_INT);
        $stmt->execute();
        $rows = $stmt->fetchAll();

        return $rows;
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
     * 参加する予定のイベントと参加したイベント情報を取得するメソッド
     *
     * @param $user
     * @param $status
     * @return array
     */
  public function getEventsSchedule($user,$status){
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

}


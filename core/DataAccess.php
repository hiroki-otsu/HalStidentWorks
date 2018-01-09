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
    public function getMaxEventNo($field,$table){

      $sql="SELECT Max(:field) as maxNo from :table";
      $stmt =self::$dbCon->prepare($sql);
      $stmt->bindValue(":field",$field, PDO::PARAM_STR);
      $stmt->bindValue(":table",$table, PDO::PARAM_STR);
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
     * @param $pass パスワード
     * @return mixed
     */
  public function getLoginUserInformation($id,$pass)
  {

    $sql="SELECT Student_Name from student_account WHERE Student_No = :userId and Student_Pass = :userPass";
    $stmt =self::$dbCon->prepare($sql);
    $stmt->bindValue(":userId", $id, PDO::PARAM_STR);
    $stmt->bindValue(":userPass",$pass, PDO::PARAM_STR);
    $stmt->execute();
    $row = $stmt->fetch();

    return $row;
  }

    /**
     *　ログインしているユーザの学籍番号を取得するメソッド
     *
     * @param  [type] $name [description]
     * @return [type]       [description]
     */
    public function getUserId($name)
    {
        $sql="SELECT Student_No from  Student_Account WHERE Student_Name=:userName";
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
     *
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
     * @return array
     */
  public function getTeacherList()
  {
    $sql="SELECT * FROM teacher_account";
    $stmt = self::$dbCon->prepare($sql);
    $stmt->execute();
    $rows = $stmt->fetchAll();
    return $rows;
  }

    /**
     * 全件情報を取得するメソッド
     *
     * @param $table
     * @param $field
     * @param $sort
     * @return array
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
     * 検索された教官情報を取得するメソッド
     *
     * @param $teacherName 先生の名前
     * @return row 取得した情報を返す
     */
  public function getSelectTeacher($teacherName)
  {
    $sql="SELECT * from Student_Account WHERE teacher = :teacher";
    $stmt = self::$dbCon->prepare($sql);
    $stmt->bindValue(":teacher", $teacherName, PDO::PARAM_STR);
    $stmt->execute();
    $row = $stmt->fetch();

    return $row;
  }
    /**
     *  開催予定のイベント情報を登録するメソッド
     *
     * @param $no
     * @param $user
     * @param $title
     * @param $comment
     * @param $eventDate
     * @param $time
     * @return bool
     */
  public function setEvent($no,$user,$title,$comment,$eventDate,$time)
  {
    $sql = "INSERT INTO Events(Events_No,Student_No,Events_Title,Events_Contents,Events_date,Events_Time) ";
    $sql.= " VALUES (:no,:user,:title,:comment,:date,:time)";
    $stmt =self::$dbCon->prepare($sql);
    $stmt->bindValue(":no", $no, PDO::PARAM_INT);
    $stmt->bindValue(":user", $user, PDO::PARAM_STR);
    $stmt->bindValue(":title",$title, PDO::PARAM_STR);
    $stmt->bindValue(":comment",$comment, PDO::PARAM_STR);
    $stmt->bindValue(":date", $eventDate, PDO::PARAM_STR);
    $stmt->bindValue(":time",  $time, PDO::PARAM_INT);
    $result = $stmt->execute();

    return $result;
  }

    /**
     * イベント情報を取得するメソッド(全件)
     *
     * @return null|string
     */
    public function getEventsInformation(){
        $sql="SELECT * from events ORDER By events_No DESC";
        $stmt =self::$dbCon->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll();
        $event=$this->showEventsList($rows);
        return $event;
    }

    private function showEventsList($list,$event= null){
        foreach ($list as $value) {
            $event ='<tr>';
            $event.='<td class="events_name">'.$value['events_title'].PHP_EOL.'</td>';
            $event.='<td class="school_year">'.$value['events_target'].PHP_EOL.'</td>';
            $event.='<td class="events_date">'.$value['events_date'].PHP_EOL.'</td>';
            $event.='<td class="details_link"><a href="events_details.php?event='.$value['events_no'].PHP_EOL.'">';
            $event.='<img src="image/icon/ic_expand_more_black_24dp_1x.png" width="24" height="24" alt="詳細リンク" /></a></td>';
            $event.='<tr>';
        }
        return $event;
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
   * @return [string] [最大値のnoを返す]
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
     *  投稿されている忘れ物情報を取得するメソッド(全件)
     *
     * @return array
     */
  public function getLostArticlesList()
  {
    $sql="SELECT * from LostArticle order by LostArticle_No desc";
    $stmt =self::$dbCon->prepare($sql);
    $stmt->execute();
    $rows = $stmt->fetchAll();

    return $rows;
  }

    /**
     *  忘れ物情報を登録するメソッド
     *
     * @param $no
     * @param $title
     * @param $comment
     * @param $img
     * @param $time
     * @return bool
     */
  public function setLostArticle($no,$title,$comment,$img,$time)
  {
    $sql = "INSERT INTO LostArticle(LostArticle_No,LostArticle_Title,LostArticle_comment,LostArticle_Image,LostArticle_Time)";
    $sql.= " VALUES (:no, :title, :comment, :image, :LostArticle_time)";
    $stmt =self::$dbCon->prepare($sql);
    $stmt->bindValue(":no", $no, PDO::PARAM_INT);
    $stmt->bindValue(":title",$title, PDO::PARAM_STR);
    $stmt->bindValue(":comment",$comment, PDO::PARAM_STR);
    $stmt->bindValue(":image", $img, PDO::PARAM_STR);
    $stmt->bindValue(":LostArticle_time",  $time, PDO::PARAM_INT);
    $result = $stmt->execute();

    return $result;
  }

    /**
     * 全教室の全件情報を取得するメソッド
     *
     * @return array
     */
  public function getClassRoomDataList(){
      $sql='SELECT * FROM classroom;';
      $stmt = self::$dbCon->prepare($sql);
      $stmt->execute();
      $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
      $result =$this->setPagination($row);

      return $result;
  }
    /**
     *
     *
     * @param $roomListData
     * @return array
     */
  private function setPagination($roomListData){
      $list = array();
      $COUNT=10;
      $number=0;
      for ($i=0;$i<count($roomListData);$i++){
          if($i===$COUNT){
              $number=0;
              $COUNT=$COUNT+10;
          }
          else{
              $lan=$this->setPortStatus($roomListData[$i]['lan_port']);
              $power=$this->setPortStatus($roomListData[$i]['power_port']);
              $list[$COUNT][$number++]= array(
                  'class'=> $roomListData[$i]['classroom_no'],
                  'lan'=>$lan,
                  'power'=>$power,
                  'size'=>$roomListData[$i]['classroom_size'],
              );
          }
      }
      return $list;
  }

    /**
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
     *  学生のパスワードを変更するメソッド
     * @param $pass
     * @param $student
     *
     */
  public function update($pass,$student){
      $user = explode(':',$student);
      $today = date("Y/m/d");
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

}


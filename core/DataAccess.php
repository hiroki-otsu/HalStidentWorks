<?php
require("DbManager.php");
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
   *学生名の情報を取得するメソッド
   *
   * @param [string] $id   [ユーザID]
   * @param [string] $pass [パスワード]
   *
   * @return $row 取得した情報返す。
   */
  public function getLoginUserInformation($id,$pass)
  {
    $sql="SELECT Student_Name from Student_Account WHERE Student_Id = :userId and Student_Pass = :userPass";
    $stmt =self::$dbCon->prepare($sql);
    $stmt->bindValue(":userId", $id, PDO::PARAM_STR);
    $stmt->bindValue(":userPass",$pass, PDO::PARAM_STR);
    $result = $stmt->execute();
    $row = $stmt->fetch();

    return $row;
  }
  /**
   *先生情報を取得するメソッド(全件)
   *
   * @return $row 取得した情報を返す
   */
  public function getTeacherList()
  {
    $sql="SELECT * FROM teacher_account";
    $stmt = self::$dbCon->prepare($sql);
    $result = $stmt->execute();
    $rows = $stmt->fetchAll();

    return $rows;
  }
  /**
   *イベント情報を取得するメソッド(全件)
   *
   * @return [Array] [イベント情報を返す]
   */
  public function getEventsInformation(){
    $sql="SELECT * from Events ORDER By Events_No DESC";
    $stmt =self::$dbCon->prepare($sql);
    $result = $stmt->execute();
    $rows = $stmt->fetchAll();

    return $rows;
  }
  /**
   * 現在投稿されいる最大値のnoを取得するメソッド
   *
   * @return [type] [description]
   */
  public function getMaxEventNo()
  {
    $sql="SELECT Max(Events_No) as maxNo from Events";
    $stmt =self::$dbCon->prepare($sql);
    $result = $stmt->execute();

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
   *
   *
   * @param  [type] $name [description]
   * @return [type]       [description]
   */
  public function getUserId($name)
  {
    $sql="SELECT Student_Id from  Student_Account WHERE Student_Name=:userName";
    $stmt =self::$dbCon->prepare($sql);
    $stmt->bindValue(":userName", $name, PDO::PARAM_STR);
    $result = $stmt->execute();
    while ($row = $stmt->fetch()) {
       $id = $row["Student_Id"];
     }
    return $id;
  }
  /**
   * イベントを新規投稿するメソッド
   *
   * @param [type] $no        [description]
   * @param [type] $title     [description]
   * @param [type] $eventdate [description]
   * @param [type] $comment   [description]
   */
  public function setEvent($no,$user,$title,$comment,$eventdate,$time)
  {
    $sql = "INSERT INTO Events(Events_No,Student_No,Events_Title,Events_Contents,Events_date,Events_Time) ";
    $sql.= " VALUES (:no,:user,:title,:comment,:date,:time)";
    $stmt =self::$dbCon->prepare($sql);
    $stmt->bindValue(":no", $no, PDO::PARAM_INT);
    $stmt->bindValue(":user", $user, PDO::PARAM_STR);
    $stmt->bindValue(":title",$title, PDO::PARAM_STR);
    $stmt->bindValue(":comment",$comment, PDO::PARAM_STR);
    $stmt->bindValue(":date", $eventdate, PDO::PARAM_STR);
    $stmt->bindValue(":time",  $time, PDO::PARAM_INT);
    $result = $stmt->execute();

    return $result;
  }
  /**
   * 詳細情報を取得するメソッド
   *
   * @param string $value [description]
   */
  public function getEventdetails($no)
  {
    $sql ="SELECT * from Events WHERE Events_No=:no";
    $stmt =self::$dbCon->prepare($sql);
    $stmt->bindValue(":no", $no, PDO::PARAM_INT);
    $result = $stmt->execute();
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
    $result = $stmt->execute();

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
   * @return [Array] [忘れ物情報を返す]
   */
  public function getLostArticlesList()
  {
    $sql="SELECT * from LostArticle order by LostArticle_No desc";
    $stmt =self::$dbCon->prepare($sql);
    $result = $stmt->execute();
    $rows = $stmt->fetchAll();

    return $rows;
  }
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
}
 ?>

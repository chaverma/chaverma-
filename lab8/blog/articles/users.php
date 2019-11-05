<?
class user{
  var $member =array();
  function check_user($act){
    global $mysqli;
    if ($act=='log') {
      $this->login();
    }elseif ($act=='logout') {
      $this->logout();
    }elseif ($act=='reg') {
      $this->registr();
    }else{
    if (isset($_SERVER['HTTP_REFERER'])) {
      $url=$_SERVER['HTTP_REFERER'];
    }else{$url='';}
    $autolog=0;
    $time=time();
    $user= array();
    $user_name='';
    $user_id='';
    $date = time()- (60*15);
    $mysqli->query("DELETE FROM `session` WHERE `log_date` < '$date' ");
    if (isset($_COOKIE['session_id'])) {
      $session_old=$_COOKIE['session_id'];
    }else{$session_old='';}
    $session_new = md5(time());
    $session_search=$mysqli->query("SELECT * FROM `session` WHERE `session_id` = '$session_old'");
    if (isset($session_old)) {
      if(mysqli_num_rows($session_search)){
        $session=mysqli_fetch_array($session_search);
        $user_id=$session['user_id'];
        $user_search=$mysqli->query("SELECT * FROM `users` WHERE `id` = '$user_id'");
        $user=mysqli_fetch_array($user_search);
        $user_id=$user['id'];
      }else{
        if (isset($_COOKIE['username']) and isset($_COOKIE['userpass'])) {
          $username=$_COOKIE['username'];
          $userpass=$_COOKIE['userpass'];
          $user_search=$mysqli->query("SELECT * FROM `users` WHERE `login` LIKE '$username' AND `pass` LIKE '$userpass'");
          if (mysqli_num_rows($user_search)) {
            $user=mysqli_fetch_array($user_search);
            $user_id=$user['id'];
          }else{
            $user_id = 0;
            $user['login'] = '';
            $user['pass'] = '';
          }
        }else{
          $user_id = 0;
          $user['login'] = '';
          $user['pass'] = '';
        }
      }
    }else{
      if (isset($_COOKIE['username']) and isset($_COOKIE['userpass'])) {
        $username=$_COOKIE['username'];
        $userpass=$_COOKIE['userpass'];
        $user_search=$mysqli->query("SELECT * FROM `users` WHERE `login` LIKE '$username' AND `pass` LIKE '$userpass'");
        if (mysqli_num_rows($user_search)) {
          $user=mysqli_fetch_array($user_search);
          $user_id=$user['id'];
        }else{
          $user_id = 0;
          $user['login'] = '';
          $user['pass'] = '';
        }
      }else{
        $user_id = 0;
        $user['login'] = '';
        $user['pass'] = '';
      }
    }
    $user_search=$mysqli->query("SELECT * FROM `users` WHERE `id` = '$user_id'");
    $user=mysqli_fetch_array($user_search);
    if (isset($_COOKIE['autolog'])) {
      $autolog=$_COOKIE['autolog'];
    }else{$autolog=0;}
    if ($autolog==1) {
      setcookie("username",$user['login'],time()+(60*60*24*365),'/site_step_3');
      setcookie("userpass",$user['pass'],time()+(60*60*24*365),'/site_step_3');
    }else{
      setcookie("username",$user['login'],time()+(60*15),'/site_step_3');
      setcookie("userpass",$user['pass'],time()+(60*15),'/site_step_3');
    }
    $mysqli->query("DELETE FROM `session` WHERE `session_id` = '$session_old' ");
    $this->member = $user;
    $user_id=$user['id'];
    $user_name=$user['login'];
    setcookie("session_id",$session_new,time()+(60*15),'/site_step_3');
    $mysqli->query("INSERT INTO `session` (`session_id`, `user_id`, `user_name`, `log_date`,`section`) VALUES ('$session_new', '$user_id', '$user_name', '$time','$url')");
        }
      }
  function login(){
    global $mysqli;
    if (isset($_SERVER['HTTP_REFERER'])) {
      $url=$_SERVER['HTTP_REFERER'];
    }else{$url='';}
    if(isset($_POST["log"])){
      $log=$_POST["log"];
      $pass=md5($_POST["pass"]);
      $check=$mysqli->query("SELECT * FROM `users` WHERE `login` = '$log' AND `pass` = '$pass'");
      if (mysqli_num_rows($check)){//если нашел
        $user = mysqli_fetch_array($check);
        $sessionid = md5(time());
        $userid=$user['id'];
        $username=$user['login'];
        $time=time();
        $mysqli->query("INSERT INTO `session` (`session_id`, `user_id`, `user_name`, `log_date`,`section`) VALUES ('$sessionid', '$userid', '$username', '$time','$url')");
          setcookie("session_id",$sessionid,time()+(60*15),'/site_step_3');
          setcookie("username",$username,time()+(60*15),'/site_step_3');
          setcookie("userpass",$pass,time()+(60*15),'/site_step_3');
          if (isset($_POST['check'])) {
          setcookie("autolog","1",time()+(60*60*24*365),'/site_step_3');
          }
          $this->member= $user;
      }
    }
    header("location: index.php");
    exit;
  }
  function registr(){
    global $mysqli;
    if (isset($_POST["log"]) and isset($_POST["pass"])){
      $log=$_POST["log"];
      $pass=md5($_POST["pass"]);
      $check=$mysqli->query("SELECT * FROM `users`WHERE `login` = '$log'");
      if (mysqli_num_rows($check)){//если нашел
        ?>
        alert('Данный логин уже имеется на сайте');
        <?
      }else{
        $mysqli->query("INSERT INTO `users` (`id`, `login`, `pass`) VALUES (NULL, '$log', '$pass');");
        setcookie("username","",time()-3600,'/site_step_3');
        setcookie("userpass","",time()-3600,'/site_step_3');
        setcookie("session_id","",time()-3600,'/site_step_3');
        header("location: index.php");
        exit;
      }
    }else{echo 'введите данные';}
  }
  function logout(){
    global $mysqli;
    $session=$_COOKIE['session_id'];
    $session_search=$mysqli->query("SELECT * FROM `session` WHERE `session_id` = '$session'");
    $usem=mysqli_fetch_array($session_search);
    $usemid=$usem['user_id'];
    $mysqli->query("DELETE FROM `session` WHERE `user_id` = '$usemid'");
    setcookie("username","",time()-3600,'/site_step_3');
    setcookie("userpass","",time()-3600,'/site_step_3');
    setcookie("session_id","",time()-3600,'/site_step_3');
    setcookie("autolog","",time()-3600,'/site_step_3');
    header("location: index.php");
    exit;
  }
}
?>

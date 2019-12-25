<?php
$dbhost = '45.40.164.100'; //Your database server address
$dbname = 'kipyatraining'; // Your Database Name
$dbuser = 'kipyatraining'; // ...db username
$dbpass = 'Growfaster@15'; // ...db password
$appname = "KipyaTraining"; 
$loggedin=FALSE; //is a user logged in
$usertype="";    //type of user logged in either 'student' or 'admin'
$courseChosen=FALSE;//flag for if the student has chosen a course to join a class
$userid=0;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require_once "mail/PHPMailer.php";
require_once "mail/Exception.php";
require_once "mail/OAuth.php";
require_once "mail/SMTP.php";
require_once "mail/POP3.php";

//connect to database
$connection = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
if ($connection->connect_error) die($connection->connect_error);


//function to create table
function createTable($name, $query)
{
  queryMysql("CREATE TABLE IF NOT EXISTS $name($query)");
  echo "Table '$name' created or already exists.<br>";
}

function dropTable($table){
  queryMysql("DROP TABLE IF EXISTS ".$table);
  echo "Table '$table' dropped or does not exist"."<br>";
}
function queryMysql($query)
{
global $connection;
$result = $connection->query($query);
if (!$result) die($connection->error);
return $result;
}
//destroying sessions
function destroySession()
{
$_SESSION=array();
if (session_id() != "" || isset($_COOKIE[session_name()]))
setcookie(session_name(), '', time()-2592000, '/');
session_destroy();
}
//remove malicious code from the users input
function sanitizeString($var)
{
global $connection;
$var = strip_tags($var);
$var = htmlentities($var);
$var = stripslashes($var);
return $connection->real_escape_string($var);
}


function login($email,$password){

  $query="SELECT * FROM user WHERE email='$email' AND hashed_password='$password' AND active=1;";

  $tryuser=queryMysql($query);
  if ($tryuser->num_rows) {
    $row = $tryuser->fetch_array(MYSQLI_ASSOC);
    $_SESSION['first_name']=$row['first_name'];
    $_SESSION['last_name']=$row['last_name'];
    $_SESSION['role']=$row['role'];
    $_SESSION['user_id']=$row['id'];
    $_SESSION['loggedin']=TRUE;
    return TRUE;
  }else{
    return FALSE;
  }
}

function logout(){
  session_start();
  if (isset($_SESSION['loggedin'])) {
      destroySession();
      return TRUE;
  } else {
      return FALSE;
  }
}

function send_email($email_addr,$email_body,$email_subj){
  $url = 'https://kipyamailer.herokuapp.com/training';
  $data = array('email' => $email_addr, 'emailbody' => $email_body,'emailsubject'=>$email_subj);
  
  // use key 'http' even if you send the request to https://...
  $options = array(
      'http' => array(
          'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
          'method'  => 'POST',
          'content' => http_build_query($data)
      )
  );
  $context  = stream_context_create($options);
  $result = file_get_contents($url, false, $context);
  if ($result === FALSE) { /* Handle error */ }
  
  var_dump($result);
}

function signup($first_name,$last_name,$role,$email,$password){
  $hash = md5(rand(0,1000));
  $link=$_SERVER['SERVER_NAME']."/".basename(dirname(__FILE__))."/services/training/verify.php?email=$email&hash=$hash";
  $link_special=$_SERVER['SERVER_NAME']."/kipya/services/training/verify.php?email=$email&hash=$hash";
  
  queryMysql("INSERT INTO user(first_name,last_name,role,email,hashed_password,hash,active) VALUES('$first_name','$last_name','$role','$email','$password','$hash',0);");
  $body=<<<_END
<p> Thank you for registering for the Kipya Training Platform </p>
<p> Use the link below to activate your account </p>

<a href="$link_special"> Activate </a>

_END;
  send_email($email,$body,"KIPYA TRAINING ACCOUNT VERIFICATION");
  return TRUE;
}

//display logged in user profile $user is the userid PK to the user table and $table is the user type table 
function showProfile($user,$table,$otherdata)
  {
    $picpath="profilepics/".$user.".jpg";
  if (file_exists($picpath)){
    echo '<img class="profilepic" onclick="editprofile();" src='."$picpath".'>';
  }else{
    echo '<div class="profilepic" onclick="editprofile();">&nbspP</div>';
  }
    $result = queryMysql("SELECT * FROM user NATURAL JOIN $table WHERE id=$user");
    if ($result->num_rows)
    {
    $row = $result->fetch_array(MYSQLI_ASSOC);
    $fname=$row['first_name'];
    $lname=$row['last_name'];
    $uno= $row['user_number'];
  echo <<<_END
      <p onclick="editprofile()" class="details"><em>$fname $lname<br/>$uno<br/>
      $otherdata</em></p>
_END;
  }
}
  ?>


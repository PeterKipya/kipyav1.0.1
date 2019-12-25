<?php
require_once '../../header.php';
if ($_SERVER['REQUEST_METHOD']=="POST") {
  $_SESSION['course_id']=$_POST['course_id'];
  if ($_SESSION['loggedin']) {
    $user_id=$_SESSION['user_id'];
    $course_id=$_SESSION['course_id'];
    $payment=queryMysql("SELECT * FROM payment WHERE user_id=$user_id AND course_id=$course_id;");
    if ($payment->num_rows) {
      header("Location:course.php");
      exit();
    }else{
      header("Location:payment.php");
      exit();
    }
  }else{
    header("Location:../../auth.php");
    exit();
  }
  
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Training - Kipya Africa</title>
    <link href="../../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../assets/css/style.css" rel="stylesheet">

    <link rel="shortcut icon" href="../../assets/images/kipya_iconv2.png" type="image/x-icon">
</head>
<body style="background-color: ghostwhite;">
<?php
    require_once "navin.php";
?>
<main>
<div style="margin-top: 2em;display: flex;flex-direction: row; flex-wrap: wrap;justify-content: center;">
<?php
  $courses=queryMysql("SELECT * FROM course");
  if ($courses->num_rows) {
    while ($courserow=$courses->fetch_array(MYSQLI_ASSOC)) {
      $course_id=$courserow['id'];
      $course_title=$courserow['title'];
      $course_description=$courserow['description'];
      $course_amount=$courserow['price'];
    $card=<<<_END
    <form action='' method='post' class='card' style='width: 18rem;margin:5px'>
      <img src="../../assets/images/training_image_2.jpg" class="card-img-top" alt="...">
      <div class="card-body">
        <h5 class="card-title">$course_title</h5>
        <h5 class="card-title text-success">$course_amount</h5>
        <p class="card-text">$course_description</p>
        <input type='hidden' name='course_id' value='$course_id'/>
        <button class="btn btn-primary" type='submit'>Enroll</button>
        </div>
    </form>
_END;
    echo $card;
    }
}else{
  echo "<h4>No courses at the moment, Check Back soon!</h4>";
}



?>
</div>
                
  <script src="../../assets/js/jquery.js"></script>
  <script src="../../assets/js/bootstrap.js"></script>
        </div>
</main>
</body>
</html>
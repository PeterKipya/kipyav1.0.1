<?php
session_start();
require_once "../../../utils.php";

if ($_SERVER['REQUEST_METHOD']=="POST") {
  $_SESSION['course_id']=$_POST['course_id'];  
  $course_id=$_POST['course_id'];  

  switch ($_POST['action']) {
    case 'edit':
      header("Location:editCourse.php");
      // exit();
      break;
    case 'add_module':
      header("Location:addModule.php");
      exit();
      break;
    case 'delete_course':
        queryMysql("DELETE FROM course WHERE id=$course_id;");
        break;
    case 'delete_user':
          $user_id=$_POST['user_id'];
          queryMysql("DELETE FROM user WHERE id=$user_id;");
          break;
    
    default:
      
      break;
  }
}
if ($_SESSION['loggedin'] and $_SESSION['role']=="admin") {
  // echo "admin user loggedin"; 
}else{
  header("Location:login.php");
  exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Kipya Training Admin</title>
  <link rel="stylesheet" href="../../../assets/css/bootstrap.css">
  <link rel="stylesheet" href="../../../assets/css/style.css">

</head>
<body>
<header>
<?php
require_once "nav.php";
?>
</header>


<main class="container" style="margin-top:80px">

  <ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item">
      <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Users</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Courses</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Enrollments</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" id="payments-tab" data-toggle="tab" href="#payments" role="tab" aria-controls="payments" aria-selected="false">Payments</a>
    </li>
  </ul>
  <div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
    <?php
  $users=queryMysql("SELECT * FROM user");
  if ($users->num_rows) {
    echo <<<_END
    <table class="table table-borderless">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">First Name</th>
        <th scope="col">Last Name</th>
        <th scope="col">Email</th>
        <th scope="col">Role</th>
        <th scope="col">Remove</th>

      </tr>
    </thead>
    <tbody>
_END;
    while ($userrow=$users->fetch_array(MYSQLI_ASSOC)) {
      $user_id=$userrow['id'];
      $first_name=$userrow['first_name'];
      $last_name=$userrow['last_name'];
      $email=$userrow['email'];
      $role=$userrow['role'];
    $card=<<<_END
    
    <form action='' method='post' class='card' style='width: 18rem;margin:5px'>
      <tr>
        <th scope="row">$user_id</th>
        <td>$first_name</td>
        <td>$last_name</td>
        <td>$email</td>
        <td>$role</td>
        <input type="hidden" name='action' value='delete_user'/>
        <input type="hidden" name='user_id' value='$user_id'/>
        <td><button class="btn btn-danger" type='submit'>delete</button></td>
      </tr>
    </form>
_END;
    echo $card;
    }
    echo "</tbody></table>";
}else{
  echo "<h4>No users at the moment, Check Back soon!</h4>";
}
    ?>
    
    </div>
    <div class="tab-pane fade container" id="profile" role="tabpanel" aria-labelledby="profile-tab">
    <div class="add_course text-center">

<a href="addCourse.php" class="mt-2 shadow-lg btn primary_btn">+ Add Course</a>
</div>
    <div class="" style="margin-top: 2em;display: flex;flex-direction: row; flex-wrap: wrap;justify-content: center;">

    <?php
  $courses=queryMysql("SELECT * FROM course");
  if ($courses->num_rows) {
    while ($courserow=$courses->fetch_array(MYSQLI_ASSOC)) {
      $course_id=$courserow['id'];
      $course_title=$courserow['title'];
      $course_description=$courserow['description'];
    $card=<<<_END
    <div class='card' style='width: 18rem;margin:5px'>
      <img src="../../../assets/images/training_image_2.jpg" class="card-img-top" alt="...">
      <div class="card-body">
        <h5 class="card-title">$course_title</h5>
        <p class="card-text">$course_description</p>
        <div style="display:flex">
          <form action="" method="post">
              <input type='hidden' name='course_id' value='$course_id'/>
              <input type='hidden' name='action' value='edit'/>
              <button class="btn btn-outline-primary" type='submit'>Edit Course</button>
          </form>
          <form action="" method="post">
              <input type='hidden' name='course_id' value='$course_id'/>
              <input type='hidden' name='action' value='add_module'/>
              <button class="btn btn-outline-info" type='submit'>Add Module</button>
          </form>
          <form action="" method="post">
              <input type='hidden' name='course_id' value='$course_id'/>
              <input type='hidden' name='action' value='delete'/>
              <button class="btn btn-outline-danger" type='submit'>Delete</button>
          </form>
        </div>
        </div>
    </div>
_END;
    echo $card;
    }
}else{
  echo "<br><h4>No courses at the moment, Check Back soon!</h4>";
}
    ?>
    
    </div>
    </div>
    <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
    <?php
    $courses=queryMysql("SELECT title,COUNT(*) AS number_of_users FROM enrollment INNER JOIN course ON course.id=enrollment.course_id GROUP BY course_id;");

    if ($courses->num_rows) {
      while ($courserow=$courses->fetch_array(MYSQLI_ASSOC)) {
        $course_title=$courserow['title'];
        $number_of_users=$courserow['number_of_users'];
      $card=<<<_END
      <div class="card text-primary border-primary mb-3 " style="max-width:18rem;margin:5px;">
      <div class="card-header">$course_title</div>
      <div class="card-body">
          <h2 class="card-title">$number_of_users Users</h2>
        </div>
      </div>
_END;
      echo $card;
      }
  }else{
    echo "<br><h4>No courses at the moment, Check Back soon!</h4>";
  }


    ?>
    
    
    </div>

    <div class="tab-pane fade" id="payments" role="tabpanel" aria-labelledby="payments-tab">
    <?php
    $courses=queryMysql("SELECT title,SUM(amount) as total_payment FROM payment INNER JOIN course ON course.id=payment.course_id GROUP BY course_id;");

    if ($courses->num_rows) {
      while ($courserow=$courses->fetch_array(MYSQLI_ASSOC)) {
        $course_title=$courserow['title'];
        $total_payment=$courserow['total_payment'];
      $card=<<<_END
      <div class="card shadow text-info border-success mb-3 " style="max-width:18rem;margin:5px;">
        <div class="card-header">$course_title</div>
      <div class="card-body">
          <h2 class="card-title">Kshs. $total_payment</h2>
        </div>
      </div>
_END;
      echo $card;
      }
  }else{
    echo "<br><h4>No courses at the moment, Check Back soon!</h4>";
  }


    ?>
    </div>
  </div>

</main>

<script src="../../../assets/js/jquery.js"></script>
<script src="../../../assets/js/bootstrap.js"></script>
<script src="../../../assets/js/popper.js"></script>


</body>
</html>
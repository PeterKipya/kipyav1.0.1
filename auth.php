<?php
session_start();
require_once 'utils.php';
$l_error="";
$s_error="";


if ($_SERVER['REQUEST_METHOD']=="POST") {
  if ($_POST['action']=='signup') {
    $first_name=sanitizeString($_POST['first_name']);
    $last_name=sanitizeString($_POST['last_name']);
    $email=sanitizeString($_POST['email']);
    $password=md5(sanitizeString($_POST['password']));
    $role=sanitizeString($_POST['role']);



    if(signup($first_name,$last_name,$role,$email,$password)){
      header("Location:auth.php");
      exit();
    }else{
      $s_error="<span class='text-danger'>Something went wrong!</span>";
    }
  } else {
    $email=sanitizeString($_POST['email']);
    $password=md5(sanitizeString($_POST['password']));
    if(login($email,$password)){
      header("Location:services/training/listCourses.php");
      exit();
    }else{
      $l_error="<span class='text-danger'>Invalid Credentials!</span>";
    }
  }
  
}

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v3.8.5">
    <title>Kipya | Authentication</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.3/examples/cover/">

    <!-- Bootstrap core CSS -->
<link href="assets/css/cover.css" rel="stylesheet" >
<link href="assets/css/bootstrap.css" rel="stylesheet" >
<link href="assets/css/style.css" rel="stylesheet" >


    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>
    <!-- Custom styles for this template -->
    <link href="cover.css" rel="stylesheet">
  </head>
  <body class="text-center">
    <div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">
  <header class="masthead mb-auto">
<?php
    require_once "nav.php";
?>
  </header>

  <main role="main" class="inner cover">
    <div id="login"  class="p-2 lead card col-6">
      <h1 class="cover-heading">Login</h1>
      <?php echo $l_error; ?>
      <form action="" method="post">
      <input type="hidden" name="action" value="login">

          <input type="text" name="email" class="form-control" placeholder="Email">
            <input type="password" name="password" id="" class="form-control">
            <div style="display: flex;flex-direction: row;justify-content: space-between;">
                <button type="submit" class="btn shadow primary_btn">
                    Login
                </button>
                <div onclick="showsignup()" style="cursor: pointer;"  class="btn shadow secondary_btn">
                    Signup
                </div>
            </div>
      </form>
    </div>
    <div id="signup" style="display: none;" class="lead p-2 card col-6">
      <h1 class="cover-heading">Signup</h1>
      <?php echo $s_error; ?>
      <form action="" method="post">
      <input type="hidden" name="action" value="signup">
      <input type="hidden" name="role" value="learner">

      <input type="text" name="first_name" class="form-control" placeholder="First Name">
      <input type="text" name="last_name" class="form-control" placeholder="Last Name">
      <input type="email" name="email" class="form-control" placeholder="Email">
      <input type="password" name="password" class="form-control" placeholder="Password">
      <input type="password" name="cpassword" class="form-control" placeholder="Retype Password">
      <div style="display: flex;flex-direction: row;justify-content: space-between;">
          <button type="submit" class="btn shadow primary_btn">
              Signup
          </button>
          <div onclick="showlogin()" style="cursor: pointer;"  class="btn shadow secondary_btn">
              Login
          </div>
      </div>
      </form>
    </div>
  </main>

  <footer class="mastfoot mt-auto">
    <div class="inner">
      <p>Cover template for <a href="http://africa-drilling-solutions.com/">Kipya Africa</a>, by <a href="https://twitter.com/fullstack_peter">Peter Kahenya</a>.</p>
    </div>
  </footer>
</div>
</body>
<script>

function showsignup(){
  document.getElementById('login').style.display="none";
  document.getElementById('signup').style.display="block";


}

function showlogin(){
  document.getElementById('signup').style.display="none";
  document.getElementById('login').style.display="block";
}

</script>
</html>

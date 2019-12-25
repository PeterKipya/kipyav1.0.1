<?php
session_start();
include_once "../../header.php";
$course_id= $_SESSION['course_id'];

$first_name=$_SESSION['first_name'];
$last_name=$_SESSION['last_name'];
$user_id=$_SESSION['user_id'];




if ($_SERVER['REQUEST_METHOD']=="POST") {

  $code=$_POST['code'];
  $account_no=$_POST['name'];
  $amount=$_POST['amount'];

  queryMysql("INSERT INTO payment(course_id,user_id,code,amount,account_no) VALUES('$course_id','$user_id','$code',$amount,'$account_no')");

  header("Location:course.php");

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
    <title>Kipya Africa · Training</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.3/examples/cover/">

    <!-- Bootstrap core CSS -->
<link href="../../assets/css/cover.css" rel="stylesheet" >
<link href="../../assets/css/bootstrap.css" rel="stylesheet" >
<link href="../../assets/css/style.css" rel="stylesheet" >
<script src="../../assets/js/jquery.js" rel="stylesheet" ></script>


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
   
  </head>
  <body class="text-center">
    <div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">
  <header class="masthead mb-auto">
<?php
    require_once "nav.php";
    echo $course_id;
?>
  </header>

  <main role="main" class="inner cover">
    
  <script src="../../assets/js/bootstrap.js"></script>
<div class="container d-flex align-items-center justify-content-center">
    <br><br>
    <div id="mpesa_step" class="card" style="display: block; font-size: 14px;width:30rem !important">
                        <img width="100px" src="../../assets/images/lipanampesa.png" alt="">
                        <br>
                        <?php
    // echo $_SESSION['course_id']; 
?>
                        <label>Go to the M-PESA Menu.</label>
                        <br>
                        <label>Select Pay Bill.</label>
                        <br>
                        <label>Enter Business No. <span class="font-weight-bold">749320 </span> </label>
                        <br>
                        <label>Enter Account No. <span class="font-weight-bold" id="fullname"><?php echo $first_name.$last_name       ?></span></label>
                        <br>
                        <label>Enter the Amount <span class="font-weight-bold" id="cost">Kshs. 20,000</span></label>
                        <br>
                        <label>Enter your M-Pesa PIN then send.</label>
                    
                    <div id="paymentstatus">
                        <div class="alert alert-secondary" role="alert">
                            Awaiting Payment...
                        </div>
                    </div>
                    <input type="hidden" value="<?php echo $first_name ?>" id="first_name">
                    <input type="hidden" value="<?php echo $last_name ?>" id="last_name">

                    <div class="d-flex">
                        <form action="" method="post">
                            <input type="hidden" name="code" id="mpesa_code" value="HFH3HHSHHF">
                            <input type="hidden" name="name" id="mpesa_name" value="PeterKahenya">
                            <input type="hidden" name="amount" id="mpesa_amount" value="20000">
                            <!-- <input type="hidden" name="purpose" id="purpose" value="<?php  echo $course_id;     ?>"> -->

                            

                                <button id="finishbtn"  type="submit" class="m-3 btn btn-success">
                                        Finish
                                </button>

                        </form>
                    </div>
    
    </div>
</div>


<script>
var interval = NaN
function enableFinishPayment() {
            document.getElementById("finishbtn").disabled = false;
}

function checkStatus() {
            fetch('https://eawaterspayments.herokuapp.com/ispaid')
                .then(response => {
                    if (response.ok) {
                        return response.json()
                    } else {
                        return
                    }
                }).then(res => {
                    if (res.status === 0) {
                        var msg = res.body
                        console.log(res)
                        if (msg.BillRefNumber.toUpperCase() === ($('#first_name').val() + $('#last_name').val()).toUpperCase()) {

                            $('#paymentstatus').html(
                                "<div class='alert alert-success' role='alert'>Thank You Payment Received for " +
                                msg.BillRefNumber + "</div>")
                            $('#mpesa_code').val(msg.TransID)
                            $('#mpesa_name').val(msg.BillRefNumber)
                            $('#mpesa_amount').val(msg.TransAmount)
                            enableFinishPayment()
                            clearInterval(interval)
                        }
                    } else {
                        console.log('waiting for payment')
                    }
                })
}
interval=setInterval(checkStatus, 100)


</script>
  </main>

  <footer class="mastfoot mt-auto">
    <div class="inner">
      <p>Cover template for <a href="https://getbootstrap.com/">Bootstrap</a>, by <a href="https://twitter.com/mdo">@mdo</a>.</p>
    </div>
  </footer>
</div>
</body>
</html>

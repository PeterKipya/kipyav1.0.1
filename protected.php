<?php
    session_start();
    require_once "utils.php";

    if ($_SESSION['loggedin']) {
        $user_id=$_SESSION['user_id'];
        $course_id=$_SESSION['course_id'];

        $payment=queryMysql("SELECT * FROM payment WHERE user_id=$user_id AND course_id=$course_id;");
        if ($payment->num_rows) {
            
        }else{
            if ($_SESSION['course_id']) {
                header("Location:payment.php");
                exit();
            }else{
                header("Location:index.php");
                exit();
            }
        }
    } else {
        header("Location:../../auth.php");
        exit();
    }
    

?>
<?php
    require_once "../../protected.php";

    $course_id=$_SESSION['course_id'];
    $user_id=$_SESSION['user_id'];
    $enrollment=queryMysql("SELECT * FROM enrollment WHERE course_id=$course_id AND user_id=$user_id;");
    
    if ($enrollment->num_rows==0) {
        queryMysql("INSERT INTO  enrollment(course_id,user_id) VALUES($course_id,$user_id)");
    }

    $course_modules=queryMysql("SELECT * FROM module WHERE course_id=".$course_id.";");
    if (isset($_SESSION['current_module'])) {
        $current_module=$_SESSION['current_module'];
    } else {
        $current_module=1;
        $_SESSION['current_module']=$current_module;
    }
    

    if ($_SERVER['REQUEST_METHOD']=="GET") {
        if ($_GET['action']=="prev") {
            $current_module=$current_module-1;
            $_SESSION['current_module']=$current_module;

        }elseif ($_GET['action']=="next") {
            $current_module=$current_module+1;
            $_SESSION['current_module']=$current_module;
        }
      }

?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Training - Kipya Africa</title>
    <link href="../../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../assets/css/style.css" rel="stylesheet">
    <link href="../../assets/css/course.css" rel="stylesheet">


    <link rel="shortcut icon" href="../../assets/images/kipya_iconv2.png" type="image/x-icon">
</head>

<body>
    <header>
        <?php
            require_once "navin.php";
            
        ?>
    </header>

    <main style="margin-top: 70px !important;display: flex;justify-content: flex-start;height: 100%;">
        <div class="modules">
            <?php
$module_no=1;
$current_content="";
$current_title="";
$current_intro="";

while ($modulerow=$course_modules->fetch_array(MYSQLI_ASSOC)) {
    $module_id=$modulerow['id'];
    $module_type=$modulerow['module_type'];
    $module_title=$modulerow['module_title'];
    $module_intro=$modulerow['module_intro'];
    $module_content=$modulerow['module_content'];
    if ($module_no==$current_module) {
        $current_title=$module_title;
        $current_intro=$module_intro;

        switch ($module_type) {
            case 'SLIDE':
            $current_content=<<<_END
            <div class="slide">
                    $module_content                          
            </div>
_END;
                break;
            case 'TEXT':
            $current_content=<<<_END
            <div class="card p-2 words">
                    $module_content                          
            </div>
_END;
                break;
            case 'VIDEO':
$current_content=<<<_END
                <div class="video-content">
                <video width="850" height="500" controls>
                    <source src="$module_content" type="video/mp4">
                </video>                        
                </div>
_END;
                    break;
            
            default:
                # code...
                break;
        }
        echo "<div class='module active'><div class='module-no m-2'>$module_no</div><h4 class='module-title p-2'>$module_title</h4></div><hr>";
    }else{
        echo "<div class='module'><div class='module-no m-2'>$module_no</div><h4 class='module-title p-2'>$module_title</h4></div><hr>";
    } 
$module_no=$module_no+1;
}

?>
        </div>
        <div class="module-content m-3">
            <div class="">
                <h2 class="text-center"><?php echo $current_title ?></h2>
                <div class="text-center"><?php echo $current_intro ?></div>
                <?php  echo $current_content;?>
            </div>
            <div class="advance text-center">
                <?php
if ($_SESSION['current_module']!=1) {

    echo <<<_END
    <form action="" method="get">
                    <input type="hidden" name="action" value="prev">
                    <button type="submit" class="btn shadow secondary_btn">
                        Previous
                    </button>

                </form>
_END;
}

if ($_SESSION['current_module']!=$module_no-1) {
    echo <<<_END
    <form action="" method="get">
    <input type="hidden" name="action" value="next">
    <button class="btn shadow  primary_btn">
        Next
    </button>
    </form>
_END;
}


?>
                
                
                
            </div>
    </main>
    <script src="../../assets/js/jquery.js">    </script>
    <script src="../../assets/js/bootstrap.js">    </script>

</body>

</html>
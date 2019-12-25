<?php
  include_once "../../header.php";

?>
<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-white" style="height: 70px;">
    <div class="container">
                  <a class="navbar-brand" href="" style="padding-right: 5px;display: flex;" >
                    <div style="display: flex;flex-direction: column;padding-right: 5px;">
                        <img src="../../assets/images/kipya_logov2.png" width="80px" style="margin-top: 10px;"  alt="">
                        <p class="subbrand">AFRICA DRILLING SOLUTIONS</p>    
                    </div>
                    <h3 style="border-left: 1px solid #fcca0a;padding-left: 5px;color: #fcca0a; display: flex;align-items: center;">TRAINING</h3>
                  </a>
                  <?php
                  
                  if (isset($_SESSION['course_id'])) {
                    $course_id=$_SESSION['course_id'];
                    $course=queryMysql("SELECT * FROM course WHERE id=$course_id;");
                    $row = $course->fetch_array(MYSQLI_ASSOC);
                    $title=$row['title'];
                    
                    echo "<h3>$title</h3>";

                    
                  }


                  ?>
                  <h3 class="text-bold text-center"></h3>
                  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#menubar"
                  aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
                  <span class="navbar-toggler-icon"></span>
                </button>

                
                
          
                  <div class="collapse navbar-collapse" id="menubar">
                    <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
                        <?php   
                        if ($_SESSION['loggedin']) {
                          echo <<<_END
                          <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-dark" href="about/" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
_END;
echo $_SESSION['first_name']." ".$_SESSION['last_name'];
echo <<<_END
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                              <a class="dropdown-item" href="#">Profile</a>
                              <a class="dropdown-item" href="logout.php">Logout</a>
                            </div>
                          <li>
_END;
                        }else{
                          echo <<<_END
                          <li class="nav-item">
                            <a class="shadow btn primary_btn" href="../../auth.php">Login</a>
                          </li>
_END;
                        }
                        
                        ?>
                    </ul>
                  </div>
                </div>
    
  </nav>
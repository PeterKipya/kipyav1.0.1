<?php
session_start();
if ($_SESSION['loggedin'] and $_SESSION['role']=="admin") {
  echo "admin user loggedin";
}else{
  header("Location:login.php");
  exit();
}

?>
<?php
require_once '../../../utils.php';

if ($_SERVER['REQUEST_METHOD']=="POST") {
    $title=$_POST['title'];
    $price=$_POST['price'];
    $description=$_POST['description'];

    $target_dir = $_SERVER['DOCUMENT_ROOT'] . "/kipya/content/";

    $target_file = $target_dir . basename($_FILES["image"]["name"]+"dfkdlkf.jpg");
    
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            queryMysql("INSERT INTO course(image_url,title,description,price) VALUES('$target_file','$title','$description',$price);");
            echo "The file ". basename( $_FILES["image"]["name"]). " has been uploaded.";
        } else {
            echo "Not uploaded because of error #".$_FILES["image"]["error"];
        }
    }

?>
<!DOCTYPE html>
<html>
<link href="../../../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../../assets/css/style.css" rel="stylesheet">
    <link href="../../../assets/css/course.css" rel="stylesheet">
    <?php
        require_once "nav.php";
    ?>
<title>Add Course</title>
<link rel="shortcut icon" href="../../assets/images/kipya_iconv2.png" type="image/x-icon">

<main class="container" style="margin-top: 80px;">
<div class="col-sm-12 col-md-6">
        <form action="" method="post"  enctype="multipart/form-data">
            <input class="form-control" type="text" name="title" placeholder="Course Title"/>
            <br>
            Select image to upload:
            <input type="file" name="image" id="fileToUpload">
            <br><br>
            <textarea rows="10" class="form-control" type="text" name="description" placeholder="Course Description"></textarea>
            <input type="number" name="price" id="" class="form-control" placeholder="Course Price">
            <input class="btn shadow primary_btn" type="submit" value="Add Course" name="submit">
        </form>
</div>

</main>
</body>
<script src="../../../assets/js/jquery.js"></script>
<script src="../../../assets/js/bootstrap.js"></script>

</html>
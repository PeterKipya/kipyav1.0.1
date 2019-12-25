<?php
session_start();
if ($_SESSION['loggedin'] and $_SESSION['role']=="admin") {
    
}else{
  header("Location:login.php");
  exit();
}

?>

<?php
require_once '../../../utils.php';
$course_id=$_SESSION['course_id'];

if ($_SERVER['REQUEST_METHOD']=="POST") {
    $title=$_POST['title'];
    $price=$_POST['price'];
    $description=$_POST['description'];

    $target_dir = $_SERVER['DOCUMENT_ROOT'] . "/kipyav1.0.1/content/course_images/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);

    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            queryMysql("UPDATE course SET title='$title',description='$description',price=$price,image_url='$target_file' WHERE id=$course_id;");
        } else {
        $query="UPDATE course SET title='$title',description='$description',price=$price WHERE id=$course_id;";
        echo $query;
        queryMysql($query);
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
<title>Edit Course</title>
<link rel="shortcut icon" href="../../assets/images/kipya_iconv2.png" type="image/x-icon">

<main class="container" style="margin-top: 80px;">
<div class="col-sm-12 col-md-6">
<?php
                  
                  if (isset($_SESSION['course_id'])) {
                    $course_id=$_SESSION['course_id'];
                    
                    $course=queryMysql("SELECT * FROM course WHERE id=$course_id;");
                    $row = $course->fetch_array(MYSQLI_ASSOC);
                    
                    $title=$row['title'];
                    $description=$row['description'];
                    $price=$row['price'];
                    $image_url=$row['image_url'];
                    
                    echo "<h2 class='text-center text-info'>$title</h2>";

                    
                  }


                  ?>
        <h3>Edit Course</h3>
        <form action="" method="post"  enctype="multipart/form-data">
            <input value="<?php echo $title; ?>" class="form-control" type="text" name="title" placeholder="Course Title"/>

            Select image to upload:
            <input type="file" name="image" id="fileToUpload">
            <br>
            <textarea rows="3" class="form-control" type="text" name="description" placeholder="Course Description"><?php echo $description; ?></textarea>
            <input value="<?php echo $price; ?>" type="number" name="price" id="" class="form-control" placeholder="Course Price">
            <button type="submit" class="btn primary_btn">
                Save
            </button>
        </form>
</div>

</main>
</body>
<script src="../../../assets/js/jquery.js"></script>
<script src="../../../assets/js/bootstrap.js"></script>

</html>
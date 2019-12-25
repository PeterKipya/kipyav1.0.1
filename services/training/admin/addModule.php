<?php
require_once "../../../header.php";
$course_id=$_SESSION['course_id'];
if ($_SERVER['REQUEST_METHOD']=="POST") {
    
    $module_type=$_POST['module_type'];
    $module_title=$_POST['module_title'];
    $module_intro=$_POST['module_intro'];
    $module_content=$_POST['module_content'];

    queryMysql("INSERT INTO module(course_id,module_type,module_title,module_intro,module_content) VALUES('$course_id','$module_type','$module_title','$module_intro','$module_content')");
    echo "Module Added";
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="../../../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../../assets/css/style.css" rel="stylesheet">
    <link href="../../../assets/css/course.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="../../../assets/js/bootstrap.js"></script>

    <script src="https://cdn.ckeditor.com/4.13.0/standard/ckeditor.js"></script>

    <link rel="shortcut icon" href="../../../assets/images/kipya_iconv2.png" type="image/x-icon">
    <title>Add Module</title>

</head>
<body>
        <?php
        require_once "nav.php";
    ?>
    <main>
            <div class="container" style="margin-top: 5em;">
            <?php
                  
                  if (isset($_SESSION['course_id'])) {
                    $course_id=$_SESSION['course_id'];
                    $course=queryMysql("SELECT * FROM course WHERE id=$course_id;");
                    $row = $course->fetch_array(MYSQLI_ASSOC);
                    $title=$row['title'];
                    
                    echo "<h2 class='text-center text-info'>$title</h2>";

                    
                  }


                  ?>
            <div class="col-8 m-auto">
                <h2>Add Module</h2>
                    <form action="" method="post">
                            <input  type="hidden" name="course_id" value="<?php echo $course_id;    ?>">
                            <select id="type" class="form-control" name="module_type" id="">
                                <option value="TEXT" selected >Module Type...</option>
                                <option value="VIDEO">Video</option>
                                <option value="TEXT">Text</option>
                                <option value="SLIDE">Slide</option>
                            </select>
                            <input class="form-control" type="text" name="module_title" placeholder="Module Title"  />
                            <textarea class="form-control" rows="5" name="module_intro" placeholder="Short Introduction to the Module"></textarea>
                            <textarea id="editor" class="form-control " rows="8"  name="module_content" placeholder="Module Content"></textarea>
                            <br>
                            <div class="text-center">
                            <button class="text-center btn primary_btn shadow m-auto" type="submit">Save</button>
                            
                            </div>
                            
                    </form>
            </div>
    </div>
</main>
<script>
CKEDITOR.replace( 'module_content' );
$('#type').on('change',(value)=>{
    if(value.target.value==="TEXT"){
        CKEDITOR.replace( 'module_content' );
    }else{
        if (value.target.value==="VIDEO") {
            CKEDITOR.instances.editor.destroy();
            $('#editor').attr('placeholder',"Input Video URL...")
            $('#editor').attr('rows',"1")

        } else {
            if (CKEDITOR.instances.editor) {
                CKEDITOR.instances.editor.destroy();
            }
            
            $('#editor').attr('placeholder',"Input Iframe from Google Slides...")
            $('#editor').attr('rows',"1")
        }
    }
})


</script>
</body>
</html>
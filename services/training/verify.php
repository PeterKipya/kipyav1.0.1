<?php

require_once "../../utils.php";
$verification_status=FALSE;
if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash'])){
    // Verify data
    $email = sanitizeString($_GET['email']); // Set email variable
    $hash = sanitizeString($_GET['hash']); // Set hash variable

    $search=queryMysql("SELECT * FROM user WHERE user.email='$email' AND user.hash='$hash';");
    if ($search->num_rows) {
        $row = $search->fetch_array(MYSQLI_ASSOC);
        $user_id=$row['id'];
        queryMysql("UPDATE user SET active=1 WHERE id=$user_id;");
        $verification_status=TRUE;
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Kipya Training Account Activation</title>
</head>
<body>
    <?php

    if ($verification_status) {
        echo <<<_END
<div class="card">
Your account has been verified
Login Now to learn more

</div>

_END;
    }


?>
</body>
</html>
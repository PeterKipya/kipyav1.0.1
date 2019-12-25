<!DOCTYPE html>
<html>
<head>
<title>Setting up database</title>
<link rel="stylesheet" type="text/css" href="../../assets/css/material.min.css">
<link rel="stylesheet" type="text/css" href="../../assets/css/MaterialIcons-Regular.woff">
 <script type="text/javascript" src="../../assets/js/material.js"></script>
   <style type="text/css">
  @font-face{
    font-family: 'Material Icons';
    font-style: normal;
    font-weight: 400;
    src:url('../../assets/css/MaterialIcons-Regular.woff');
  }
</style>
</head>
<body>
<h3>Setting up...</h3>
<?php
require_once '../../utils.php';


// create users table 
createTable('user',
  'id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  first_name VARCHAR(16),
  last_name VARCHAR(16),
  role VARCHAR(16),
  email VARCHAR(32) UNIQUE,
  hashed_password VARCHAR(32),
  active INT(1) NOT NULL DEFAULT 0,
  hash VARCHAR(32) NOT NULL,
  INDEX(id)'
);

//create course table
createTable('course',
  'id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(256),
  description VARCHAR(500),
  image_url VARCHAR(256),
  price DOUBLE'
);

//create enrollment table
createTable('enrollment',
  'id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  course_id INT UNSIGNED,
  user_id INT UNSIGNED,
  FOREIGN KEY(course_id) REFERENCES course(id) ON DELETE CASCADE,
  FOREIGN KEY(user_id) REFERENCES user(id) ON DELETE CASCADE'
);

//create module table
createTable('module',
    'id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    course_id INT UNSIGNED,
    module_type VARCHAR(256),
    module_title VARCHAR(256),
    module_intro VARCHAR(500),
    module_content LONGTEXT,
    FOREIGN KEY(course_id) REFERENCES course(id) ON DELETE CASCADE'
);

createTable('covered',
    'id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED,
    module_id INT UNSIGNED,
    FOREIGN KEY(module_id) REFERENCES module(id) ON DELETE CASCADE,
    FOREIGN KEY(user_id) REFERENCES user(id) ON DELETE CASCADE'
);


createTable('payment',
    'id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    course_id INT UNSIGNED,
    user_id INT UNSIGNED,
    code VARCHAR(256),
    amount DOUBLE,
    account_no LONGTEXT,
    payment_method VARCHAR(256),
    FOREIGN KEY(course_id) REFERENCES course(id) ON DELETE CASCADE,
    FOREIGN KEY(user_id) REFERENCES user(id) ON DELETE CASCADE'
);

// dropTable("user");
// dropTable("course");
// dropTable("module");
// dropTable("payment");
// dropTable("covered");
// dropTable("enrollment");

?>
</body>
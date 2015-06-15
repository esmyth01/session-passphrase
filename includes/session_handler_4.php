<?php

session_start();

//pass info

$PASS_INFO = array(
  'abc123'
);

// request password

define('USE_PASSWORD', false);



if(!function_exists('showPassword')) {

  // show password form

  function showPassword($error_msg) {
    ?>
    <html>
    <head>
      <title>Password Page</title>


    </head>
    <body>
    <style>
    input { border: 2px solid black; }
    </style>
    <div style="width:400px; margin-left:auto; margin-right:auto; text-align:center">
      <form method="post">
        <h3>Please enter your password</h3>
        <font color="red"><?php echo $error_msg; ?></font><br />
        <?php if (USE_PASSWORD) echo '<br />Password:<br />'; ?>
          <input type="password" name="get_password" /><p></p>
          <input type="submit" name="Submit" value="Submit" />
        </form>
        <br />

      </div>
    </body>
    </html>

    <?php


    // stop at this point
    die();
  }
}

// user provided password
if (isset($_POST['get_password'])) {


  $pass = $_POST['get_password'];
  if (!USE_PASSWORD && !in_array($pass, $PASS_INFO)
  || (USE_PASSWORD && ( !array_key_exists($PASS_INFO) || $PASS_INFO != $pass ))
  ) {
    showPassword("Incorrect password.");
  }
  else {

    unset($_POST['get_password']);
    unset($_POST['Submit']);
  }

}

else {

  // check if password session is set
  if (!isset($_SESSION['verify'])) {
    showPassword("");
  }

  // check if session is good
  $found = false;

  foreach($PASS_INFO as $key=>$val) {

    $lp = (USE_PASSWORD ? $key : '') .'%'.$val;

    if ($_SESSION['verify'] == md5($lp)) {

      $found = true;


      break;
    }
  }
  if (!$found) {
    showPassword("");
  }

}

?>

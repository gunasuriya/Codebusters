<?php
/* The password reset form, the link to this page is included
   from the forgot.php email message
*/
require 'db.php';
session_start();

// Make sure email and hash variables aren't empty
if( isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash']) )
{
    $email = $mysqli->escape_string($_GET['email']);
    $hash = $mysqli->escape_string($_GET['hash']);

    // Make sure user email with matching hash exist
    $result = $mysqli->query("SELECT * FROM hr WHERE email='$email' AND hash='$hash'");

    if ( $result->num_rows == 0 )
    {
        $_SESSION['message'] = "You have entered invalid URL for password reset!";
        header("location: error.php");
    }
}
else {
    $_SESSION['message'] = "Sorry, verification failed, try again!";
    header("location: error.php");
}
?>
<!DOCTYPE html>
<html >
<head>
  <meta charset="UTF-8">
  <title>Codebusters</title>
  <?php include 'css/css.html'; ?>
</head>

<body>
    <div class="form">

          <h1>Choose Your New Password</h1>

          <form id="form1" method="post">

          <div class="field-wrap">
            <label>
              New Password<span class="req">*</span>
            </label>
            <input type="password" minlength="6" maxlength="20" required name="newpassword" id="newpassword" autocomplete="off"/>
          </div>

          <div class="field-wrap">
            <label>
              Confirm New Password<span class="req">*</span>
            </label>
            <input type="password" minlength="6" maxlength="20" required name="confirmpassword" id="confirmpassword" autocomplete="off"/>
          </div>

          <!-- This input field is needed, to get the email of the user -->
          <input type="hidden" name="email" value="<?= $email ?>">
          <input type="hidden" name="hash" value="<?= $hash ?>">

          <button id="mismatch" class="button button-block"/>Apply</button>

          </form>

    </div>
<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src="js/index.js"></script>
<script>
$("#mismatch").click(function(){
  if($("#newpassword").val().length>=6&&$("#confirmpassword").val().length>=6){
    if($("#newpassword").val()==$("#confirmpassword").val()){
        $("#form1").attr("action","reset_password.php");
      $("#form1").trigger('submit');
    }
    else{
      alert("Passwords didn't match");
    }
  }
  else{
    alert("Passwords must have 6 characters atleast");
  }

});
</script>
</body>
</html>

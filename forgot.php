<?php
/* Reset your password form, sends reset.php password link */
require 'db.php';
session_start();

// Check if form submitted with method="post"
if ( $_SERVER['REQUEST_METHOD'] == 'POST' )
{
    $email = $mysqli->escape_string($_POST['email']);
    $result = $mysqli->query("SELECT * FROM users WHERE email='$email'");

    if ( $result->num_rows == 0 ) // User doesn't exist
    {
		$result_hr = $mysqli->query("SELECT * FROM hr WHERE email='$email'");
        if($result_hr->num_rows == 0){
			$_SESSION['message'] = "User with that email doesn't exist!";
			header("location: error.php");
		}
		else { // User exists (num_rows != 0)

			$user = $result_hr->fetch_assoc(); // $user becomes array with user data
			$email = $user['email'];
			$hash = $user['hash'];
			$first_name = $user['first_name'];
			// Session message to display on success.php
			$_SESSION['message'] = "<p>Please check your email <span>$email</span>"
			. " for a confirmation link to complete your password reset!<br>If mail is not in inbox, Check your spam!</p>";
			// Send registration confirmation link (reset.php)
			// $to      = $email;
			// $subject = 'Password Reset Link From Codebusters';
			// $message_body = '
			// Hello '.$first_name.',
      //
			// You have requested password reset!
      //
			// Please click this link to reset your password:
      //
			// http://geekypanda.tk/codebusters/reset_hr.php?email='.$email.'&hash='.$hash;
			// mail($to, $subject, $message_body);

      ?>
      <script src="https://code.jquery.com/jquery-3.2.1.js" integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE=" crossorigin="anonymous"></script>
      <script>
      function mailpo1(){
        // alert("Loop entered");
        $.ajax({
          type: "GET",
          url: "https://devilismytown.000webhostapp.com/mail/forgot_hr.php?mail=<?php echo $email;?>&first_name=<?php echo $first_name;?>&hash=<?php echo $hash;?>",
          dataType:"jsonp",
          success: function(data){
            window.location = "http://localhost/codebusters/success.php";
          },
          error: function(XMLHttpRequest, textStatus, errorThrown) {
                alert(  "Status: " + textStatus+"\n Password change request mail could not be sent. \n Check your network connectivity or try again later... ");
            }
        });
      }
      </script>
      <?php
      echo "<script>mailpo1();</script>";
		}
    }
    else { // User exists (num_rows != 0)

        $user = $result->fetch_assoc(); // $user becomes array with user data
        $email = $user['email'];
        $hash = $user['hash'];
        $first_name = $user['first_name'];
        // Session message to display on success.php
        $_SESSION['message'] = "<p>Please check your email <span>$email</span>"
        . " for a confirmation link to complete your password reset!<br>If mail is not in inbox, Check your spam!</p>";

        // // Send registration confirmation link (reset.php)
        // $to      = $email;
        // $subject = 'Password Reset Link From Codebusters';
        // $message_body = '
        // Hello '.$first_name.',
        //
        // You have requested password reset!
        //
        // Please click this link to reset your password:
        //
        // http://geekypanda.tk/codebusters/reset.php?email='.$email.'&hash='.$hash;
        // mail($to, $subject, $message_body);
        ?>
        <script src="https://code.jquery.com/jquery-3.2.1.js" integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE=" crossorigin="anonymous"></script>
        <script>
        function mailpo(){
          // alert("Loop entered");
          $.ajax({
            type: "GET",
            url: "https://devilismytown.000webhostapp.com/mail/forgot.php?mail=<?php echo $email;?>&first_name=<?php echo $first_name;?>&hash=<?php echo $hash;?>",
            dataType:"jsonp",
            success: function(data){
              window.location = "http://localhost/codebusters/success.php";
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                  alert(  "Status: " + textStatus +" &" +data+"\n Verification mail could not be sent. \n Check your network connectivity or try again later... ");
              }
          });
        }
        </script>
        <?php
        echo "<script>mailpo();</script>";
  }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Codebusters</title>
  <?php include 'css/css.html'; ?>
</head>

<body>

  <div class="form">

    <h1>Reset Your Password</h1>

    <form action="forgot.php" method="post">
     <div class="field-wrap">
      <label>
        Email Address<span class="req">*</span>
      </label>
      <input type="email"required autocomplete="off" name="email"/>
    </div>
    <button class="button button-block"/>Reset</button>
    </form>
  </div>

<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

<script src="js/index.js"></script>

</body>

</html>

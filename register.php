<?php

/* Registration process, inserts user info into the database
   and sends account confirmation email message
 */

// Set session variables to be used on profile.php page
$_SESSION['email'] = $_POST['email'];
$_SESSION['first_name'] = $_POST['firstname'];
$_SESSION['last_name'] = $_POST['lastname'];

// Escape all $_POST variables to protect against SQL injections
$first_name = $mysqli->escape_string($_POST['firstname']);
$last_name = $mysqli->escape_string($_POST['lastname']);
$email = $mysqli->escape_string($_POST['email']);
$username = substr($email, 0, strpos($email, "@"));
$password = $mysqli->escape_string(password_hash($_POST['password'], PASSWORD_BCRYPT));
$hash = $mysqli->escape_string( md5( rand(0,1000) ) );

// Check if user with that email already exists
$result = $mysqli->query("SELECT * FROM users WHERE email='$email'") or die($mysqli->error());

// We know user email exists if the rows returned are more than 0
if ( $result->num_rows > 0 ) {

    $_SESSION['message'] = 'User with this email already exists!';
    header("location: error.php");

}
else { // Email doesn't already exist in a database, proceed...
    // active is 0 by DEFAULT (no need to include it here)
    $sql = "INSERT INTO users (first_name, last_name, email, username, password, hash) "
            . "VALUES ('$first_name','$last_name','$email','$username','$password', '$hash')";


    // Add user to the database
    if ( $mysqli->query($sql) ){

        $_SESSION['active'] = 0; //0 until user activates their account with verify.php
        $_SESSION['logged_in'] = true; // So we know the user has logged in
        $_SESSION['message'] =

                 "Confirmation link has been sent to <span>$email</span>, please verify
                 your account by clicking on the link in the message!<br/><br/><br/>If mail is not received, Please check your spam!";


                 //creating directory for user
                 $username = substr($_SESSION['email'], 0, strpos($_SESSION['email'], "@"));
                 $dirname = "users/".$username;
                 $tagname_fib = "tagged/fibonacci/".$username;
                 $tagname_fac = "tagged/factorial/".$username;
                 $tagname_pal = "tagged/palindrome/".$username;
                 mkdir($dirname);
                 mkdir($dirname."/c");
                 mkdir($dirname."/cpp");
                 mkdir($dirname."/java");
                 mkdir($dirname."/python");
                 mkdir($dirname."/c/tagged");
                 mkdir($dirname."/cpp/tagged");
                 mkdir($dirname."/java/tagged");
                 mkdir($dirname."/python/tagged");
                 mkdir($tagname_fib."/c");
                 mkdir($tagname_fib."/cpp");
                 mkdir($tagname_fib."/java");
                 mkdir($tagname_fib."/python");
                 mkdir($tagname_fac."/c");
                 mkdir($tagname_fac."/cpp");
                 mkdir($tagname_fac."/java");
                 mkdir($tagname_fac."/python");
                 mkdir($tagname_pal."/c");
                 mkdir($tagname_pal."/cpp");
                 mkdir($tagname_pal."/java");
                 mkdir($tagname_pal."/python");
                 copy('img.png', 'users/'.$username.'/img.png');



        // Send registration confirmation link (verify.php)
        // $from = "shriarun97@gmail.com";
        // $to      = $email;
        // $subject = 'Account Verification From Codebusters';
        // $message_body = '
        // Hello '.$first_name.',
        //
        // Thank you for signing up!
        //
        // Please click this link to activate your account:
        //
        // https://devilismytown.000webhostapp.com/proj/proj/verify.php?email='.$email.'&hash='.$hash;
        //
        // $mail=mail($to, $subject, $message_body );
        // if($mail!=FALSE){
        //
        //     header("location: success.php");
        //     // echo "<script>alert('mail sent! ".$mail."')</script>";
        // }
        // elseif($mail==FALSE){
        //     $_SESSION['message'] = 'Your Registration is Successful. Check Your E-mail For verificatiuon Link... Check Spam if not in inbox... <br> Mail Not Sent! Check Mail Server';
        //       header("location: error.php");
        // // echo "<script>alert('mail not sent!')</script>";
        //
        // }


    }

    else {
        $_SESSION['message'] = 'Registration failed!';
        header("location: error.php");
        // echo "<script>alert('No db!')</script>";
    }

}
?>
<html>
<head>
<script src="https://code.jquery.com/jquery-3.2.1.js" integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE=" crossorigin="anonymous"></script>
</head>
<body>
<script>
$.ajax({

  type: "GET",
  url: "https://devilismytown.000webhostapp.com/mail/mail.php?mail=<?php echo $email;?>&first_name=<?php echo $first_name;?>&hash=<?php echo $hash;?>&user=coder",
  dataType:"jsonp",
  success: function(data){
    window.location = "http://localhost/codebusters/success.php";
  },
  error: function(XMLHttpRequest, textStatus, errorThrown) {
        alert(  "Status: " + textStatus+"\n Verification mail could not be sent. \n Check your network connectivity or try again later... ");
    }
});
</script>
</body>
</html>

<?php
/* Displays all successful messages */
session_start();
?>
<?php
$parameters = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);
parse_str($parameters);
  $_SESSION['message']= "Congratulations! Your Program got successfully executed in $execution_time seconds! Go to next program! ";
?>

<!DOCTYPE html>
<html>
<head>
  <title>Codebusters</title>
  <?php include 'css/css.html'; ?>
</head>
<body>
<div class="form">
    <h1><?= 'Success'; ?></h1>
    <p>
    <?php
    if( isset($_SESSION['message']) AND !empty($_SESSION['message']) ):
        echo $_SESSION['message'];
    else:
        header( "location: profile.php" );
    endif;
    ?>
    </p>
    <a href="compete.php"><button class="button button-block"/>Back to Coding Page</button></a>
</div>
</body>
</html>

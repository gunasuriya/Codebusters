<?php
$current="";
$lang="Select";
$err_string="";
$kat="";
$tags="Select";
$trick="";
// $temp="sit";
$answer="";
	$execution_time="";
  require 'db.php';
// $file="adi";
session_start();
// Check if user is logged in using the session variable

if ( $_SESSION['logged_in'] == 1 ) {
    $email = $_SESSION['email'];
    $username = substr($email, 0, strpos($email, "@"));

}
else {
  $_SESSION['message'] = "You must log in before viewing your profile page!";
  header("location: error.php");

}
// $email1 = $_SESSION['email'];
// $username1 = substr($email1, 0, strpos($email1, "@"));
if(isset($_POST['submit'])){
	$code = $_POST['cppcode'];
	$lang = $_POST['lang'];
  $tags = $_POST['tags'];
	$trick=$_POST['trick'];

	// echo "<script>console.log('trick=$trick');</script>";
}
if(isset($_POST['trick'])){
	$trick=$_POST['trick'];
	// echo "<script>console.log('trick=$trick');</script>";
}


if(!empty($_POST)){
	$current=$_POST['cppcode'];
	$lang = $_POST['lang'];
	// $trick=$_POST['trick'];
	$fib1="01123";
	$fib2="0112358";
	$fib3="011235813";
	$fact1="120";
	$fact2="5040";
	$fact3="40320";
	if($lang=='C'){
		$answer="";
		$goi = $_POST['inputa'];
		$file="users/$username/c/tagged/".$_POST['tags'].".c";
		// echo "<script>alert('$file"."<br>".$_POST['filename']."');</script>";
		// echo "<script>alert('trick=".$_POST['trick']." ".strcmp($_POST['trick'],"1")."');</script>";
		if(strcmp($trick,"execute")==0){
			$cinput="users/$username/c/tagged/".$_POST['tags']."_input.txt";
			$coutput="users/$username/c/tagged/".$_POST['tags']."_output.txt";
			$mass=$_POST['tags'].".exe";
			file_put_contents($file, $current);
			file_put_contents($cinput, $goi);
			putenv("PATH=compile\MinGW64\bin");
			$mass=$mass." < ".$cinput;
			$time_start = microtime(true);
			$kat="Error Occured\n".shell_exec("gcc users/$username/c/tagged/".$_POST['tags'].".c -o ".$_POST['tags'].".exe 2>&1");
			$time_end = microtime(true);
      $execution_time = ($time_end - $time_start);
			if(strlen($kat)>15){
				$answer="";
			}
			else{
				$kat="";
				$time_start = microtime(true);
				$answer = shell_exec("$mass");
				$time_end = microtime(true);
        $execution_time = ($time_end - $time_start);
        $tags = $_POST['tags'];
        $result = $mysqli->query("SELECT * FROM $tags WHERE username='$username' AND lang='$lang'");
        if( $result->num_rows > 0 ){
          $mysqli->query("UPDATE $tags SET exe_time = $execution_time WHERE username='$username' AND lang='$lang'");
        }
        else{
          $mysqli->query("INSERT INTO $tags (username,lang,exe_time) VALUES '('$username,$lang,$execution_time')'");
        }

				file_put_contents($coutput, $answer);
			}
		}
		else if(strcmp($trick,"save")==0){
			$tags = $_POST['tags'];
			file_put_contents($file, $current);
			echo "<script>alert('Your program is saved');</script>";
		}

	}
	if($lang=='C++'){
		$answer="";
		$kat="";
		$goi = $_POST['inputa'];
		$file="tagged/".$_POST['tags']."/$username/Cpp/".$_POST['tags'].".cpp";
		$time_start=array(0,0,0);
		$time_end=array(0,0,0);
		$execution_time=array(0,0,0);

		if(strcmp($trick,"execute")==0){
			$temp=0;
			for($i=0;$i<3;$i++){
				$cinput="tagged/".$_POST['tags']."/input".($i+1).".txt";
				$file1=
				$mass=$_POST['tags'].".exe";
				file_put_contents($file, $current);
				//file_put_contents($cinput, $goi);
				putenv("PATH=compile\MinGW64\bin");
				$mass=$mass." < ".$cinput;
				//$time_start = microtime(true);
				$kat="Error Occured\n".shell_exec("g++ tagged/".$_POST['tags']."/$username/Cpp/".$_POST['tags'].".cpp -o ".$_POST['tags'].".exe 2>&1");
				//$time_end = microtime(true);

				if(strlen($kat)>15){
					$answer="";
				}
				else{
						$coutput=file_get_contents("tagged/".$_POST['tags']."/output".($i+1).".txt");
						$kat="";
						$time_start[$i] = microtime(true);
						$answer = shell_exec("$mass");
						$time_end[$i] = microtime(true);
						file_put_contents("tagged/".$_POST['tags']."/$username/Cpp/output".($i+1).".txt", $answer);
						$user_output=file_get_contents("tagged/".$_POST['tags']."/$username/Cpp/output".($i+1).".txt");
						echo "<script>alert('alert: '+$coutput+' coutput: '+$user_output);</script>";
						if($coutput==$user_output){
							echo "<script>alert('Test case'". ($i+1)."' success')</script>";
							$execution_time[$i] = ($time_end[$i] - $time_start[$i]);
							$temp=$temp+1;
							$tags = $_POST['tags'];
							$result_time=array_sum($execution_time);
							$result = $mysqli->query("SELECT * FROM $tags WHERE username='$username' AND lang='Cpp'");
							if( $result->num_rows > 0 ){
							  $mysqli->query("UPDATE $tags SET exe_time = $result_time[$i] WHERE username='$username' AND lang='Cpp'");
							}
							else{
							  $mysqli->query("INSERT INTO $tags (username,lang,exe_time) VALUES ('$username','Cpp',$execution_time[$i])");
								require 'rank.php';
								// echo "INSERT INTO $tags (username,lang,exe_time) VALUES ('$username','$lang',$execution_time)";
							}
						}else{
							echo "<script>alert('Test case '". ($i+1)."' failed for input '".$cinput.")</script>";
						}


				}



			}
			if($temp==3){
				$result_time=array_sum($execution_time);
				header("location: nextprog.php?execution_time=$result_time");
			}

		}
	else if(strcmp($trick,"save")==0){
		$tags = $_POST['tags'];
		file_put_contents($file, $current);
		echo "<script>alert('Your program is saved');</script>";
	}

	}
	if($lang=='Java'){
		$answer="";
	chdir("users/$username/java/tagged/");
		$goi = $_POST['inputa'];
		$file=$_POST['tags'].".java";
		if(strcmp($trick,"execute")==0){
		$cinput=$_POST['tags']."_input.txt";
		$coutput=$_POST['tags']."_output.txt";
		$mass="java ".$_POST['tags'];
//echo $mass;
		file_put_contents($file, $current);
		file_put_contents($cinput, $goi);

putenv("PATH=..\..\..\..\compile\Java\bin");
      $time_start = microtime(true);
			$kat="Error Occured\n".shell_exec("javac ".$_POST['tags'].".java 2>&1");
      $time_end = microtime(true);
      $execution_time = ($time_end - $time_start);
		if(strlen($kat)>15){
			$tags = $_POST['tags'];
			$answer="";
		}
		else{
			$kat="";
			$time_start = microtime(true);
			$answer = shell_exec($mass." < ".$cinput." 2>&1");
			$time_end = microtime(true);
      $execution_time = ($time_end - $time_start);
			$tags = $_POST['tags'];
      $result = $mysqli->query("SELECT * FROM $tags WHERE username='$username' AND lang='$lang'");
      if( $result->num_rows > 0 ){
        $mysqli->query("UPDATE $tags SET exe_time = $execution_time WHERE username='$username' AND lang='$lang'");
      }
      else{
        $mysqli->query("INSERT INTO $tags (username,lang,exe_time) VALUES '('$username,$lang,$execution_time')'");
      }
			file_put_contents($coutput, $answer);
		}
	}
	else if(strcmp($trick,"save")==0){
		$tags = $_POST['tags'];
		file_put_contents($file, $current);
		echo "<script>alert('Your program is saved');</script>";
	}
		chdir("../../../../");
	}
	if($lang=='Python'){
		$answer="";
		$goi = $_POST['inputa'];
	chdir("users/$username/python/tagged/");
		$file=$_POST['tags'].".py";
		if(strcmp($trick,"execute")==0){
		$cinput=$_POST['tags']."_input.txt";
		$coutput=$_POST['tags']."_output.txt";
		$time_start = microtime(true);
		$mass="..\..\..\..\compile\python\python.exe ".$_POST['tags'].".py 2>&1";
		$time_end = microtime(true);
    $execution_time = ($time_end - $time_start);
		file_put_contents($file, $current);
		file_put_contents($cinput, $goi);
		$mass=$mass." < ".$cinput;
		$answer = shell_exec("$mass");
		$tags = $_POST['tags'];
    $result = $mysqli->query("SELECT * FROM $tags WHERE username='$username' AND lang='$lang'");
    if( $result->num_rows > 0 ){
      $mysqli->query("UPDATE $tags SET exe_time = $execution_time WHERE username='$username' AND lang='$lang'");
    }
    else{
      $mysqli->query("INSERT INTO $tags (username,lang,exe_time) VALUES '('$username,$lang,$execution_time')'");
    }
		file_put_contents($coutput, $answer);
	}
	else if(strcmp($trick,"save")==0){
		$tags = $_POST['tags'];
		file_put_contents($file, $current);
		echo "<script>alert('Your program is saved');</script>";
	}
		chdir("../../../../");
	}



}

?>

<html>
<head>
<title style="color:purple;">CODEBUSTERS</title>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<meta name="theme-color" content="rgba(0,0,0,1)">
<!-- <link rel='stylesheet prefetch' href='css/bootstrap.css'> -->
<!-- Latest compiled and minified CSS -->

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<link href="https://use.fontawesome.com/releases/v5.0.8/css/all.css" rel="stylesheet prefetch">
<script src="js/jquery.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js">
<script src="https://code.jquery.com/jquery-3.2.1.js" integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE=" crossorigin="anonymous"></script>
<script src="js/jqueryui.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.js"></script>
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> -->
<link rel="stylesheet" href="style_compete.css">
<style>
@font-face{
    font-family: "cons";
    src:url(consolaz.ttf);
}
  @font-face{
    font-family: "titan";
    src:url(thundertitan.ttf);
}



.container-fluid .txtarea{
  resize:none;
  outline:none;
  width:85%;
  margin:auto;
  height:500px;
  border-radius:10px;
  -webkit-box-shadow: 0px 0px 15px 5px rgba(29, 236, 247, .75);
  -moz-box-shadow: 0px 0px 15px 5px rgba(29, 236, 247, .75);
  box-shadow: 0px 0px 15px 5px rgba(29, 236, 247, .75);
  border:3px;
  padding:5px;
  background-position: bottom right;
  background-repeat:no-repeat;
  font-size: 25px;
  color:white;
  background-color:rgba(0,0,0,0.7);
  font-family:cons;
  word-wrap: break-word;
}
#acecppcode, #acecppcode2{
  resize:none;
  outline:none;
  width:85%;
  margin:auto;
  border-radius:10px;
  -webkit-box-shadow: 0px 0px 15px 5px rgba(29, 236, 247, .75);
  -moz-box-shadow: 0px 0px 15px 5px rgba(29, 236, 247, .75);
  box-shadow: 0px 0px 15px 5px rgba(29, 236, 247, .75);
  border:3px;
  padding:5px;
  background-position: bottom right;
  background-repeat:no-repeat;
  font-size: 25px;
  color:white;
  background-color:rgba(0,0,0,0.7);
  font-family:cons;
  word-wrap: break-word;
}

#vid{
  position:fixed;
  top:0;
  left:0;
  min-width:100%;
  min-height:100%;
  z-index:1;
  background-size:cover;
}
.bg{
  position:fixed;
  top:0;
  left:0;
  z-index:2;
  height:100%;
  width:100%;
}
#layer{
  background-color:rgba(0,0,0,0.7);
  width:100%;
  height:100%;
}
form{
  z-index:3;
  position:absolute;
  /* padding-top:10%; */
  width:100%;

}
/* #execute{
  padding-top:0px;
  text-align:center;
  border:none;
  -webkit-box-shadow: 0px 0px 1px 1px rgba(29, 236, 247, .75);
  -moz-box-shadow: 0px 0px 1px 1px rgba(29, 236, 247, .75);
  box-shadow: 0px 0px 1px 1px rgba(29, 236, 247, .75);
  border-radius:5px;
  font-size:18px;
  padding:3px;
  background-color:rgba(255,0,0,0.5);
  color:turquoise;
  font-family:cons;
} */
#execute, #save{
  text-align:center;
  border:none;
  -webkit-box-shadow: 0px 0px 1px 1px rgba(29, 236, 247, .75);
  -moz-box-shadow: 0px 0px 1px 1px rgba(29, 236, 247, .75);
  box-shadow: 0px 0px 1px 1px rgba(29, 236, 247, .75);
  border-radius:5px;
  font-size:18px;
  padding:3px;
  background-color:rgba(0,0,0,0.5);
  color:turquoise;
  font-family:cons;
  margin-top:10px;
}
#fun{
  text-shadow: 0 0 50px rgba(29, 236, 247, 1);
  text-align:center;
  /* top:5%; */
  width:100%;
  z-index:3;
  position:absolute;
  font-size:30px;
  font-family:titan;
  color:turquoise;
}
select{
  /* position: fixed; */
  background-color:rgba(0,0,0,1);
  border-radius:5px;
  color:turquoise;
  border-top-width:0px;
  border-left-width:0px;
  border-right-width:0px;
  border-bottom-width:1px;
  height:30px;
  font-family:cons;
  font-size:18px;
}
.marcen{
  padding-top:2%;
  padding-bottom:2%;
  margin:auto;
  text-align:center;
}
.bg1{
  background-color:red;
}
.bg2{
  background-color:green;
}
.bg3{
  background-color:blue;
}
/* .pdtp{
  padding-top:4%;
  padding-bottom:2%;
} */
body::-webkit-scrollbar {
  width: 0.5em;

}

body::-webkit-scrollbar-track {
  -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0);
  background-color:rgba(0,0,0,1);
}

body::-webkit-scrollbar-thumb {
  background-color: turquoise;
  border-radius:10px;
  outline: 1px solid slategrey;
}
#cppcode::-webkit-scrollbar, #cppcode2::-webkit-scrollbar {
  width: 0.3em;


}

#cppcode::-webkit-scrollbar-track, #cppcode2::-webkit-scrollbar-track {
  -webkit-box-shadow: inset 0 0 2px rgba(0,0,0,0.3);

}


#cppcode::-webkit-scrollbar-thumb {
  background-color: turquoise;
  border-radius:10px;
  outline: 1px solid slategrey;
  border-color:turquoise;
}
.unagi::-webkit-scrollbar-thumb {
  background-color: red;
  border-radius:10px;
  outline: 1px solid slategrey;
  border-color:red;
}
.unagi1::-webkit-scrollbar-thumb {
  background-color: turquoise;
  border-radius:10px;
  outline: 1px solid slategrey;
  border-color:turquoise;

}
.container-fluid .txtarea1{
  resize:none;
  outline:none;
  width:75%;
  margin-top:0px;
  /* margin:auto; */
  /* height:375px; */
  border-radius:10px;
  -webkit-box-shadow: 0px 0px 15px 5px rgba(29, 236, 247, .75);
  -moz-box-shadow: 0px 0px 15px 5px rgba(29, 236, 247, .75);
  box-shadow: 0px 0px 15px 5px rgba(29, 236, 247, .75);
  border:3px;
  /* padding:2px; */
  background-position: bottom right;
  background-repeat:no-repeat;
  font-size: 12px;
  color:white;
  background-color:rgba(0,0,0,0.7);
  font-family:cons;
}

#acecppcode1{
  resize:none;
  outline:none;
  width:75%;
  margin:auto;
  /* height:375px; */
  border-radius:10px;
  -webkit-box-shadow: 0px 0px 15px 5px rgba(29, 236, 247, .75);
  -moz-box-shadow: 0px 0px 15px 5px rgba(29, 236, 247, .75);
  box-shadow: 0px 0px 15px 5px rgba(29, 236, 247, .75);
  border:3px;
  /* padding:2px; */
  background-position: bottom right;
  background-repeat:no-repeat;
  font-size: 12px;
  color:white;
  background-color:rgba(0,0,0,0.7);
  font-family:cons;
}

/* Transparent
/*
/*.navbar-default {
background: none;
border: none;
}*/
#navda{
z-index:9998;
position:fixed;
width:100%;
}
.navbar{
background-color:rgba(0,0,0,0.9);
border-top:0px;
border-right:0px;
border-left:0px;
border-bottom:0px;
border-radius:0px;
box-shadow: 2px 2px 10px 0px turquoise;
}
@media (min-width: 768px) {
.navbar-nav {
  width: 100%;
  text-align: center;
}
.navbar-nav > li {
  margin-left:2%;
  float: none;
  display: inline-block;
}
.navbar-nav > li.navbar-right {
  float: right !important;
}
}
#butt{
border:none;
font-size:15px;
background-color:rgba(0,0,0,0);
color:turquoise;
}
#myVideo {
  position: fixed;
  right: 0;
  bottom: 0;
}
#filename{
font-size:18px;
font-family:cons;
color:turquoise;
background-color:rgba(0,0,0,0);
border-top-width:0px;
text-align:center;
border-right-width:0px;
border-left-width:0px;
border-bottom-width:1px;
border-color:turquoise;
}
#filename1{
margin-top:10px;
font-size:18px;
font-family:cons;
color:turquoise;
background-color:rgba(0,0,0,0);
border-top-width:0px;
text-align:center;
border-right-width:0px;
border-left-width:0px;
border-bottom-width:1px;
border-color:turquoise;
}
#filename1:hover{
border-color:white;
}
body{
background-color:black;
}

.prog_lang{
  width:100%;
  height:100%;
  background-color: black;
  padding:50px 20px;
  text-align: center;
  overflow-x: hidden;
}
#tags1{
  opacity:0.5;
}

.modal {
  text-align: left;
  background-color: rgba(0,0,0,0.9);
}
.modal-content::-webkit-scrollbar {
  width: 0.5em;

}

.modal-content::-webkit-scrollbar-track {
  -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0);
  background-color:rgba(0,0,0,1);
}

.modal-content::-webkit-scrollbar-thumb {
  background-color: turquoise;
  border-radius:10px;
  outline: 1px solid slategrey;
}

.modal-content {
  vertical-align: middle;

  overflow-x: hidden;
  color: turquoise;
  background-color: black;
  border: 1px solid turquoise;
  box-shadow: 0px 0px 2px 2px turquoise;
  font-family: cons;
}
.modal-body{
  padding: 20px 30px;
}
.noselection .ace_marker-layer .ace_selection {
   background: transparent;
}

.noselection .ace_cursor {
   color: transparent;
}

</style>
</head>
<body  oncontextmenu="return false">

<video style="opacity:1;" id="vid" autoplay muted loop>
  <source src="movie.mp4" type="video/mp4">
	<source src="movie.ogg" type="video/ogg">
 <!-- <source src="movie.ogg" type="video/ogg">-->
</video>
<div class="bg"><div id="layer"></div></div>
<div id="navda" style="width:100%;z-index:5!important;">
    <nav class="navbar navbar-default" role="navigation">
      <div class="navbar-header">
        <button style="padding-top:4%;" type="button" id="butt" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
						<i class="fas fa-bars"></i>
        </button>
				<a  href="profile.php" class="navbar-toggle" style="font-size:20px;font-family:cons;color:turquoise;font-weight:bold;border:none;float:left;top:0;text-decoration:none;">CodeBusters</a>
      </div>
      <div class="navbar-collapse collapse">
        <ul class="nav navbar-nav">

					<li class="navbar-left">
						<select id="lang1" name="lang1" style="margin-top:10px;">
							<option value="Select">Select</option>
							<option value="C">C</option>
							<option value="C++">C++</option>
							<option value="Java">Java</option>
							<option value="Python">Python</option>
						</select>
					</li>
					<li class="navbar-left">
            <select id="tags1" name="tags1" style="margin-top:10px;" disabled>
							<option value="Select">Select</option>
							<option value="fibonacci">Fibonacci</option>
							<option value="factorial">Factorial</option>
							<option value="palindrome">Palindrome</option>
						</select>
          </li>

          <li class="navbar-left"><button id="execute" style="z-index:5;" value="Execute" disabled>Execute</button></li>
					<li class="navbar-left"><button id="save" style="z-index:5;" value="save" disabled>Save</button></li>
          <li class="navbar-right"><a href="profile.php"  style="padding-top:15px;font-size:18px;font-family:cons;color:turquoise;">Home</a></li>
          <li class="navbar-right"></li>
        </ul>
      </div>
    </nav>
</div>

<h1 id="fun">LETS CODE</h1>

	<form id="form1" method="POST"  autocomplete="on">


				<div id="codearena" class="container-fluid"><!--col-md-5--><!---->
					<textarea id="cppcode" name="cppcode" placeholder="Enter your code here" class="txtarea" required><?php if(isset($_POST['cppcode'])){echo htmlentities($_POST['cppcode']);} ?></textarea>
					<div id="acecppcode"><?php if(isset($_POST['cppcode'])){echo htmlentities($_POST['cppcode']);} ?></div>
				</div>

			<div class="container-fluid" id="dial">
			<h1 id="console" style="text-align:center;font-family:titan;font-size:30px;color:turquoise;">CONSOLE</h1>
				<div id="nextie" class="row  marcen"  style="background-color:rgba(0,0,0,0.7);border-radius:20px;"><!--row -->
					<div class="col-lg-4" style="text-align:center;" ><!--col-md-2 pdtp -->
						<select id="lang" name="lang" style="height:0px;width:0px;left:0;">
							<option value="Select">Select</option>
							<option value="C">C</option>
							<option value="C++">C++</option>
							<option value="Java">Java</option>
							<option value="Python">Python</option>
						</select>
            <select id="tags" name="tags" style="height:0px;width:0px;left:0;position:absolute;">
              <option value="Select">Select</option>
							<option value="fibonacci">Fibonacci</option>
							<option value="factorial">Factorial</option>
							<option value="palindrome">Palindrome</option>
            </select>
						<!-- <input type="text" id="filename" name="filename" pattern="[A-Za-z]" placeholder="Enter filename" style="height:0px;width:0px;left:0;position:absolute;" value=""> -->
						<!-- <br><br> -->
						<textarea id="inputa" name="inputa"  placeholder="Inputs" class="txtarea1"><?php if(isset($_POST['inputa'])){echo htmlentities($_POST['inputa']);} ?></textarea>
						<div id="acecppcode1" class="noselection"></div>
						<!-- <button id="execute" style="margin:20px;z-index:9999;"type="submit" value="Execute">Execute</button> -->
						<input type="text" id="trick" name="trick" style="width:0;height:0;right:0;"></input>
					</div>
					<div class="col-lg-8" contenteditable="false" style="text-align:center;"><!--col-md-5 -->
						<textarea id="cppcode2" name="cppcode2"  placeholder="Output" class="txtarea" disabled><?php echo $answer; ?><?php echo $kat; ?></textarea>
						<div id="acecppcode2"></div>
					</div>

				</div>
			</div>

	</form>



	<div class="modal fade" id="rules" role="dialog">
	    <div class="modal-dialog modal-lg modal-dialog-centered">
	      <div class="modal-content" id="mod_con">
	        <div class="modal-header">
	          <button type="button" style="color:turquoise;"class="close" data-dismiss="modal">&times;</button>
	          <h3 class="modal-title">General Info for Competitive Coding</h3>
	        </div>
	        <div class="modal-body">
						<h4>1. Choose a preferred programming language.<br><br>2. Choose a program to solve.<br><br>
							3. Start typing your code.<br><br>4. Execute your program when finished. <br><br>
							5. If there are no errors, Save your program.<br><br>
							6. Input values are fed during runtime by Codebusters.<br><br>
							   &nbsp;&nbsp;&nbsp;&nbsp;i.e, Program should get a value during runtime.<br><br>
							7. If the Output is matched with output of our testcases, Only then the program is considered for ranking.<br><br>
							8. Additional words in the output will make your program invalid.<br><br>
							  &nbsp;&nbsp;&nbsp;&nbsp;In input, Get only the value.<br><br>
							  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Example: scanf("%d",$n);<br><br>
							  &nbsp;&nbsp;&nbsp;&nbsp;In output, post only the value.<br><br>
							  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Example: printf("%d",n);<br><br>
						</h4>

	        </div>

	      </div>
	    </div>
	  </div>
<script src="ace/ace.js" type="text/javascript" charset="utf-8"></script>
<script src="ace/ext-modelist.js" type="text/javascript" charset="utf-8"></script>
<script src="ace/ext-language_tools.js" type="text/javascript" charset="utf-8"></script>

<script>



$(window).on('load',function(){
			 $('#rules').modal('show');
});
	// var a,b,c;
	// a=window.innerHeight-80%;
	// b=$("#mod_con").innerHeight;
	// c=a-b;
	// alert (a+" "+b+" "+c);
	$(".modal-content").css("height",(80*window.innerHeight)/100);
	var editor = ace.edit("acecppcode");
	var editor1 = ace.edit("acecppcode1");
	var editor2 = ace.edit("acecppcode2");
	editor.getSession().setUseWrapMode(true);
	editor1.getSession().setUseWrapMode(true);
	editor2.getSession().setUseWrapMode(true);
	ace.require("ace/ext/language_tools");
editor.setOptions({
	  enableBasicAutocompletion: true,
    enableSnippets: true,
    enableLiveAutocompletion: true,
		fontSize: "16pt"

});
editor1.setOptions({
		fontSize: "13pt"
});
editor2.setOptions({
	readOnly: true,
		highlightActiveLine: false,
		highlightGutterLine: false ,
		fontSize: "16pt"
});
editor2.renderer.$cursorLayer.element.style.opacity=0;
function update() {
    var shouldShow = !editor.session.getValue().length;
		var shouldShow1 = !editor1.session.getValue().length;
		var shouldShow2 = !editor2.session.getValue().length;
    var node = editor.renderer.emptyMessageNode;
		var node1 = editor1.renderer.emptyMessageNode;
		var node2 = editor2.renderer.emptyMessageNode;
    if (!shouldShow && node) {
        editor.renderer.scroller.removeChild(editor.renderer.emptyMessageNode);
        editor.renderer.emptyMessageNode = null;
    } else if (shouldShow && !node) {
        node = editor.renderer.emptyMessageNode = document.createElement("div");
        node.textContent = "Enter your code here..."
        node.className = "ace_invisible ace_emptyMessage"
        node.style.padding = "0 9px"
        editor.renderer.scroller.appendChild(node);
    }
		if (!shouldShow1 && node1) {
        editor1.renderer.scroller.removeChild(editor1.renderer.emptyMessageNode);
        editor1.renderer.emptyMessageNode = null;
    } else if (shouldShow1 && !node1) {
        node1 = editor1.renderer.emptyMessageNode = document.createElement("div");
        node1.textContent ="Enter Inputs here..."
        node1.className = "ace_invisible ace_emptyMessage"
        node1.style.padding = "0 9px"
        editor1.renderer.scroller.appendChild(node1);
    }
		if (!shouldShow2 && node2) {
        editor2.renderer.scroller.removeChild(editor2.renderer.emptyMessageNode);
        editor2.renderer.emptyMessageNode = null;
    } else if (shouldShow2 && !node2) {
        node2 = editor2.renderer.emptyMessageNode = document.createElement("div");
        node2.textContent = "View output here..."
        node2.className = "ace_invisible ace_emptyMessage"
        node2.style.padding = "0 9px"
        editor2.renderer.scroller.appendChild(node2);
    }
}

editor.on("input", update);
editor1.on("input", update);
editor2.on("input", update);

setTimeout(update, 100);
	editor.setTheme("ace/theme/twilight");
	editor1.setTheme("ace/theme/twilight");
	editor2.setTheme("ace/theme/twilight");
	editor.session.setMode("ace/mode/c_cpp");
	editor1.session.setMode("ace/mode/text");
	editor2.session.setMode("ace/mode/text");
	var textarea = $('textarea[name="cppcode"]').hide();
	var textarea1 = $('textarea[name="inputa"]').hide();
	var textarea2 = $('textarea[name="cppcode2"]').hide();
	editor.getSession().setValue(textarea.val());
	editor1.getSession().setValue(textarea1.val());
	editor2.getSession().setValue(textarea2.val());
	$("#lang1").on('change',function(){
		// alert("changed to "+$("#lang").val());
		editor.setValue("");

		editor1.setValue("");
		if($("#lang1").val()=="C"||$("#lang1").val()=="C++"){
			if($("#lang1").val()=="C"){

				document.getElementById('lang').value = "C";
				editor.setValue("#include<stdio.h>\nint main(){\n\n\nreturn 0;\n}");
			}
			if($("#lang1").val()=="C++"){

				document.getElementById('lang').value = "C++";
				editor.setValue("#include<iostream>\nusing namespace std;\nint main(){\n\n\nreturn 0;\n}");
			}
			document.getElementById("tags1").disabled = false;
			document.getElementById("tags1").style.opacity = 1;
			editor.session.setMode("ace/mode/c_cpp");
			//setTimeout(function(){alert(editor.getSession().getMode().$id);},100);
		}
		else if($("#lang1").val()=="Java"){
      alert("Program name should be same as Class name!\nNote: Its case sensitive!");
			document.getElementById('lang').value = "Java";
			document.getElementById("tags1").disabled = false;
			document.getElementById("tags1").style.opacity = 1;
			editor.session.setMode("ace/mode/java");
			//setTimeout(function(){alert(editor.getSession().getMode().$id);},100);
		}
		else if($("#lang1").val()=="Python"){
			document.getElementById('lang').value = "Python";
			document.getElementById("tags1").disabled = false;
			document.getElementById("tags1").style.opacity = 1;
			editor.session.setMode("ace/mode/python");

			//setTimeout(function(){alert(editor.getSession().getMode().$id);},100);
		}
		else if($("#lang1").val()=="Select"){
			document.getElementById("tags1").disabled = true;
			document.getElementById("tags1").style.opacity = 0.5;
		}
	});

	$("#tags1").on('change',function(){
		if($("#tags1").val()=="fibonacci"||$("#tags1").val()=="factorial"||$("#tags1").val()=="palindrome"){
			document.getElementById("execute").disabled = false;
			document.getElementById("execute").style.opacity = 1;
			document.getElementById("save").disabled = false;
			document.getElementById("save").style.opacity = 1;
			editor.focus();
		}
		if($("#tags1").val()=="Select"){
			document.getElementById("execute").disabled = true;
			document.getElementById("save").disabled = true;
			document.getElementById("save").style.opacity = 0.5;
			document.getElementById("execute").style.opacity = 0.5;
		}
		if($("#tags1").val()=="fibonacci"){
			editor1.setValue("Find the fibonacci values for n natural numbers\nExample:\n	get n;\n\nTestCase 1:\n5\n\nOutput:\n0\n1\n1\n2\n3");
			editor1.setOptions({
				readOnly:true
			});
			editor1.css("overflow",'none');
		}
		if($("#tags1").val()=="factorial"){
			editor1.setValue("Find the factorial values for the given n numbers\nExample:\n	get n;\n\nTestCase 1:\n5\n\nOutput:\n120");
			editor1.setOptions({
				readOnly:true
			});
			editor1.css("overflow",'none');
		}
		if($("#tags1").val()=="palindrome"){
			editor1.setValue("Check if the given string is palindrome or not. Return true, if yes\nExample:\n	get s;\n\nTestCase 1:\ncodebusters\n\nOutput:\nNO\nTestCase 1:\namma\n\nOutput:\nYES");
			editor1.setOptions({
				readOnly:true
			});
			editor1.css("overflow",'none');
		}
	});
	editor.getSession().on('change', function(){
	textarea.val(editor.getSession().getValue());

});
editor1.getSession().on('change', function(){
textarea1.val(editor1.getSession().getValue());

});
editor2.getSession().on('change', function(){
textarea2.val(editor2.getSession().getValue());

});
</script>

<script>
$(document).ready(function(){
// alert($("#filename").val());


var myVid= document.getElementById("vid");
window.addEventListener('click',function(){
	myVid.play();
},false);

$("#vid").css({"width":window.innerWidth});
if(window.innerWidth<700){
	$("#vid").css({"width":"auto","height":window.innerHeight,"position":"fixed"});
}

	$("#execute").on("click",function(){
		$("#form1").attr("action","#console");
		if(editor.getSession().getValue().length>0){
			document.getElementById("tags").value=$("#tags1").val();
			$("#trick").val("execute");
			// alert($("#filename").val());
			if($("#lang").val()=="C"){

				$("#form1").trigger('submit');
			}
			if($("#lang").val()=="C++"){
				$("#form1").trigger('submit');
			}
			if($("#lang").val()=="Java"){
				$("#form1").trigger('submit');
			}
			if($("#lang").val()=="Python"){
				$("#form1").trigger('submit');
			}
		}
		else if(editor.getSession().getValue().length==0){
			alert("Start coding!");
		}
		// alert(document.getElementById("filename").value+" "+$("#lang").val());

	});

	$("#save").on("click",function(){
    window.location.hash="";
		$("#form1").attr("action","");
		if(editor.getSession().getValue().length>0){
			document.getElementById("tags").value=$("#tags1").val();
			$("#trick").val("save");
			// alert($("#cppcode").val());
			if($("#lang").val()=="C"){
				$("#form1").trigger('submit');
			}
			if($("#lang").val()=="C++"){
				$("#form1").trigger('submit');
			}
			if($("#lang").val()=="Java"){
				$("#form1").trigger('submit');
			}
			if($("#lang").val()=="Python"){
				$("#form1").trigger('submit');
			}
		}
		else if(editor.getSession().getValue().length==0){
			alert("Start coding!");
		}

	});

	$("#fun").css({"top":"8%"});
	$("#console").css({"top":"5%"});
	var winHeight=window.innerHeight;
	var edhukku=$("#fun").height()+parseInt($("#fun").css("margin-top"))+parseInt($("#fun").css("top"));
	var edhukku1=$("#console").height()+parseInt($("#console").css("margin-top"))+parseInt($("#console").css("top"));
	var setHeight=(winHeight-edhukku);
	var setHeight1=(winHeight-edhukku1);
	var podadai=winHeight-$("#fun").height();
	var podadai1=winHeight-$("#console").height();
	var dime=(5*podadai/100);
	var dime1=(5*podadai1/100);
	//alert(parseInt($("#fun").css("margin-top")));
	$("#acecppcode").css({"height":(85*setHeight/100)});
	$("#nextie").css({"top":winHeight-(10*winHeight/100)});
	$("#acecppcode1").css({"height":(80*setHeight1/100)});
	$("#acecppcode2").css({"height":(80*setHeight1/100)});
	//$("#inputa").css({"height":(80*setHeight/100)});
	$("#form1").css({"top":edhukku+(5*setHeight/100)});
	$("#dial").css({"margin-top":(10*setHeight/100)});
	//alert(dime);
			//document.getElementById('lang').value = "C";

			document.getElementById('lang').value = "<?php echo $lang ;?>";
			document.getElementById('tags').value = "<?php echo $tags ;?>";

			//alert($("#lang").val());
			document.getElementById('lang1').value = $("#lang").val();
			document.getElementById('tags1').value = $("#tags").val();

			if($("#lang").val()=="Select"){
				document.getElementById("execute").disabled = true;
				document.getElementById("execute").style.opacity = 0.5;
				document.getElementById("save").disabled = true;
				document.getElementById("save").style.opacity = 0.5;
			}

	//console.log($("#lang").val());
		 var err=parseInt("<?php echo strlen($kat) ?>");
		 console.log("Error length : "+err);
		 if(err>0){
			 $("#acecppcode2").css({"-webkit-box-shadow":" 0px 0px 15px 5px rgba(255, 0, 0, .75)","-webkit-scrollbar-thumb":"background-color:red"});
			$("#acecppcode2").removeClass("unagi1");
			$("#acecppcode2").addClass("unagi");

		 }else{
		 $("#acecppcode2").css({"-webkit-box-shadow":" 0px 0px 15px 5px rgba(29, 236, 247, .75)","-webkit-scrollbar-thumb":"background-color:turquoise"});
			$("#acecppcode2").addClass("unagi1");
			$("#acecppcode2").removeClass("unagi");
		 }

});
</script>

</body>
</html>

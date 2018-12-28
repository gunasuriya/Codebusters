<?php
/* Main page with two forms: sign up and log in */
require 'db.php';
$countppl=$mysqli->query("SELECT COUNT(email) FROM users") or die($mysqli->error());
$counthr=$mysqli->query("SELECT COUNT(email) FROM hr") or die($mysqli->error());
$count=0;
if($row = mysqli_fetch_assoc($countppl)) {
  $count=$row['COUNT(email)'];
}
if($row1 = mysqli_fetch_assoc($counthr)) {
  $count=$count+$row1['COUNT(email)'];
}
$countgal=$count;
$result = $mysqli->query("SELECT email FROM users union SELECT email FROM hr") or die($mysqli->error());
$str="[";
while($row = mysqli_fetch_assoc($result)) {
  if($count==1){
    $str=$str." '".$row['email']."'";
  }
  else{
    $str=$str." '".$row['email']."',";
  }
  $count--;
}
$str=$str."]";
session_start();
?>
<!DOCTYPE html>
<html>
<head>
  <title>Codebusters</title>
  <?php include 'css/css.html'; ?>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" >
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
</head>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    if (isset($_POST['login'])) { //user logging in

        require 'login.php';

    }
	elseif (isset($_POST['login_hr'])) { //HR logging in

        require 'login_hr.php';

    }

    elseif (isset($_POST['register'])) { //user registering

        require 'register.php';

    }
	elseif (isset($_POST['register_hr'])) { //HR registering

        require 'register_hr.php';

    }
}
?>
<style>

body{
	font-family:cons;
	overflow-x:hidden!important;
}
#navda{
	z-index:9998;
	position:fixed;
  top:0;
	width:100%;
}
.navbar{
  background-color:rgba(0,0,0,1);
	border-top:0px;
  	z-index:5;
	border-right:0px;
	border-left:0px;
	border-bottom:0px;
	border-radius:0px;
	box-shadow: 2px 2px 10px 0px turquoise;
}

.modal{
	background-color:rgba(0,0,0,0.8);
}
.modal-content{
	background-color:black;
	max-width: 600px;
	color:white;
	font-family:cons;
	box-shadow: 0px 0px 5px 0px  turquoise;
}
.modal-body{
	padding:0;
}
.form{
	box-shadow:none;
	border:0px;
}
label{
	font-family:cons;
}
.modal-footer > button{
	color:turquoise;
	background-color:black;
	box-shadow: 0px 0px 5px 0px  turquoise;
	border-color:turquoise;
}
.modal-footer > button:hover{
	color:white;
	background-color:black;
}
body{
	color:turquoise;
}
a{
	color:turquoise;
}
a:hover{
	color:#27d8c8;
	background-color:black;
}
.icon-bar{
	background-color:turquoise;
}
#test:hover{
	box-shadow: 0px 5px turquoise;
	background-color:black;
}
.video-container {
		overflow:hidden;
	  position: absolute;
	  top: 0;
	  left: 0;
	  width: 100vw;
	  max-width:100%;
	  height: 100vh;
	}
.video-container > video {
	  display: block;
	  position: absolute;
	  left: 50%;
	  top: 50%;
	  transform: translate(-50%, -50%);
	  z-index: 0;
	}
@media screen and (max-aspect-ratio: 1920/1080) {
	  .video-container > video {
	    height: 100%;
	  }
	}
@media screen and (min-aspect-ratio: 1920/1080) {
	  .video-container > video {
	    width: 100%;
	  }
	}

.slogan{
	font-family:titan;
	font-size:60px;
	color:turquoise;
	z-index:50;
}

.top-left {
    position: absolute;
    top: 70px;
    left: 20px;
}

.bottom-right {
    position: absolute;
    bottom: 18px;
    right: 20px;
}

.centered {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}

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

body{
	background-color:black;
}

.stuff{
	position:absolute;
	font-family:titan;
	/* color:white; */
	color:rgba(64,224,208,0.5);
	z-index:3;
	width:100%;
}
.stuff h1{
	font-size:60px;
}
#kudos{
  position:absolute;
   top:85%;
   left:0;
   	z-index:105;
   width:100%;
   text-align:center;
}
#fun{
	border-radius:5px;
	background-color:rgba(0,0,0,0.5);
	border-color:black;
	color:turquoise;
	font-size:22px;
	padding:5px 10px 5px 10px;
	border-width:1px;
  text-decoration: none;
	font-family: cons, cursive;
}
#fun:hover{
  color:#59f442;
}
#cmail{
  position: absolute;
  margin-right: 7%;
  right:0;
}
</style>
<body >

<nav class="navbar" >
  <div class="container-fluid">
    <div class="navbar-header">
	<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="index.php">CODEBUSTERS</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
		<ul class="nav navbar-nav navbar-right">
		  <li  data-toggle="modal" data-target="#signup" ><a href="#signup" id="test"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
		  <li  data-toggle="modal" data-target="#login"><a href="#login" id="test"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
		</ul>
	</div>
  </div>
</nav>

<div class="stuff" style="z-index:4;">
<!-- <h1>Learn Code Compete</h1> -->
<h1 id="_code" style="">COMPETE</h1><br>
<h1 id="_compete" style="text-align:center;">CODE</h1><br>
<h1 id="_conquer" style="">CONQUER</h1><br>
</div>

<div id="kudos">
  <a href="snippet.php" id="fun">Run Your Snippet</a>
</div>
<div class="video-container" style="z-index:1;">
<video style="opacity:0.5;" id="vid" autoplay muted loop>
  <source src="movie2.mp4" type="video/mp4">
 <source src="movie2.ogg" type="video/ogg">
</video>
</div>
<div class="modal fade" id="signup" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" style="color:white">&times;</button>
          <h4 class="modal-title" style="text-align:center;">Sign Up</h4>
        </div>
        <div class="modal-body">
		<div class="form">
          <form id="signupda" method="post" autocomplete="off">

          <div class="top-row">
            <div class="field-wrap">
              <label>
                First Name<span class="req">*</span>
              </label>
              <input type="text" required autocomplete="off" name='firstname' />
            </div>

            <div class="field-wrap">
              <label>
                Last Name<span class="req">*</span>
              </label>
              <input type="text"required autocomplete="off" name='lastname' />
            </div>
          </div>
          <label id="cmail"></label>
          <div class="field-wrap">

            <label>
              Email Address<span class="req">*</span>
            </label>
            <input id="check1" type="email" required autocomplete="off" name='email' />
          </div>

          <div class="field-wrap">
            <label>
              Set A Password<span class="req">*</span>
            </label>
            <input type="password" minlength="6" maxlength="20" required autocomplete="off" name='password'/>
          </div>

          <button id="_signup" class="button" name="register" style="width:49%;border-radius:5px;"/>Register</button>
          <button id="_signup_hr" class="button" name="register_hr" style="width:49%;border-radius:5px;" />Register As HR</button>

          </form>
        </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="login" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" style="color:white">&times;</button>
          <h4 class="modal-title" style="text-align:center;">Login</h4>
        </div>
        <div class="modal-body">
		<div class="form">
		<form action="index.php" method="post" autocomplete="off">

            <div class="field-wrap">
            <label>
              Email Address<span class="req">*</span>
            </label>
            <input type="email" required autocomplete="off" name="email"/>
          </div>

          <div class="field-wrap">
            <label>
              Password<span class="req">*</span>
            </label>
            <input type="password" minlength="6" maxlength="20" required autocomplete="off" name="password"/>
          </div>

          <p class="forgot"><a href="forgot.php">Forgot Password?</a></p>

          <button class="button" name="login" style="width:49%;border-radius:5px;"/>Login</button>
          <button class="button" name="login_hr" style="width:49%;border-radius:5px;"/>Login As Hr</button>

          </form>
        </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <script src="js/index.js"></script>
  <script>

  var emails=<?php echo $str?>;
  var count=<?php echo $countgal?>;
    var myVid= document.getElementById("vid");
    window.addEventListener('click',function(){
      myVid.play();
    },false);

    $(".stuff").css({"top":(window.innerHeight-$(".stuff").height())/2});
    if(window.innerWidth<700){
      $(".stuff").css({"text-align":"center","margin-left":"0"});
      $(".stuff h1").css({"font-size":"40px","color":"red"});
      $("#vid").css({"width":"auto","height":window.innerHeight,"position":"fixed"});
      $(".stuff").html("<h1>COMPETE</h1><br><h1>CODE</h1><br><h1>CONQUER</h1><br>");
    }else{
      $("#_code").css({"text-align":"left","padding-left":"5%"});
      $("#_conquer").css({"text-align":"right","padding-right":"5%"});
    }
    var i=0;
    $("#check1").on('input',function(){
      // alert("hello");
      for(i=0;i<count;i++){
        // console.log($("#check1").val()+" "+emails[i]);
        if($("#check1").val()==emails[i]){
          $('#cmail').html('&#10060;');
          break;
        }
        else if($("#check1").val()==""||$("#check1").val()==" "){
          $('#cmail').html('');
          break;
        }
        else{
          $('#cmail').html('&#9989;');
        }
      }
    });
    $("#_signup").on('click',function(){
      if($("#cmail").html()=='&#9989;'){
        $("#signupda").trigger('submit');
      }
    });
  </script>
</body>
</html>

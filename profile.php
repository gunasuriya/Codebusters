<?php
require "db.php";
require "rank.php";
/* Displays user information and some useful messages */
session_start();
// Check if user is logged in using the session variable
if ( $_SESSION['logged_in'] == 1 ) {
	// Makes it easier to read
    $first_name = $_SESSION['first_name'];
    $last_name = $_SESSION['last_name'];
    $email = $_SESSION['email'];
    $active = $_SESSION['active'];
    $username = substr($email, 0, strpos($email, "@"));
    $imgurl="";
    $jpgcheck=2;
    // $overall=0;
    $result=$mysqli->query('Select hash, C_rank,Cpp_rank, Java_rank, Python_rank,username from users where username="'.$username.'"');
    // echo $result;
    if($row=mysqli_fetch_assoc($result)){
      $c_rank=$row['C_rank'];
      $cpp_rank=$row['Cpp_rank'];
      $java_rank=$row['Java_rank'];
      $python_rank=$row['Python_rank'];
      $hash=$row['hash'];
    }
    if($c_rank=='0'){
      $c_rank='UNRANKED';
    }
    if($cpp_rank=='0'){
      $cpp_rank='UNRANKED';
    }
    if($java_rank=='0'){
      $java_rank='UNRANKED';
    }
    if($python_rank=='0'){
      $python_rank='UNRANKED';
    }
    $imgfile=glob('users/'.$username.'/*.png');
    foreach($imgfile as $file){
      if(is_file($file)){
        $imgurl=$file;
        // echo "<script>alert('$imgurl');</script>";
        $jpgcheck=0;
      }
    }
    if($jpgcheck==2){
      $imgfile=glob('users/'.$username.'/*.jpg');
      foreach($imgfile as $file){
        if(is_file($file)){
          $imgurl=$file;
          // echo "<script>alert('$imgurl');</script>";
          $jpgcheck=0;
        }
      }
    }
    if($jpgcheck==2){
      $imgfile=glob('users/'.$username.'/*.jpeg');
      foreach($imgfile as $file){
        if(is_file($file)){
          $imgurl=$file;
          // echo "<script>alert('$imgurl');</script>";
          $jpgcheck=0;
        }
      }
    }

}
else {
  $_SESSION['message'] = "You must log in before viewing your profile page!";
  header("location: error.php");

}
?>
<?php
chdir("users/$username/c");
$dai="";
$dai1="";
$dai2="";
$dai3="";
$c_files=glob('*.{c}', GLOB_BRACE);
foreach ($c_files as $value) {

  $dai=$dai." <a href=\"http://localhost/codebusters/code.php?lang=c&filename=$value\" target=\"_blank\"><h3>$value </h3></a>";
};
if($dai=="")
{
  $dai="<h3>No C Programs </h3>";
}


// $dai=implode(", ", $c_files);
// echo $dai;
chdir("../cpp");
$cpp_files=glob('*.{cpp}', GLOB_BRACE);
// $dai1=implode(", ", $cpp_files);
foreach ($cpp_files as $value) {
  $dai1=$dai1." <a href=\"http://localhost/codebusters/code.php?lang=cpp&filename=$value\" target=\"_blank\"><h3>$value </h3></a>";
};
if($dai1=="")
{
  $dai1="<h3>No C++ Programs </h3>";
}
chdir("../java");
$java_files=glob('*.{java}', GLOB_BRACE);
// $dai2=implode(", ", $java_files);
foreach ($java_files as $value) {
  $dai2=$dai2." <a href=\"http://localhost/codebusters/code.php?lang=java&filename=$value\" target=\"_blank\"><h3>$value </h3></a>";
};
if($dai2=="")
{
  $dai2="<h3>No JAVA Programs </h3>";
}
chdir("../python");
$python_files=glob('*.{py}', GLOB_BRACE);
// $dai3=implode(", ", $python_files);
foreach ($python_files as $value) {
  $dai3=$dai3." <a href=\"http://localhost/codebusters/code.php?lang=python&filename=$value\" target=\"_blank\"><h3>$value </h3></a>";
};

if($dai3=="")
{
  $dai3="<h3>No PYTHON Programs </h3>";
}
chdir("../../../");

?>
<!DOCTYPE html>
<html >
<head>
  <meta charset="UTF-8">
  <title>Codebusters</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" >
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <?php include 'css/css.html'; ?>
<style>
.navbar{
	color:turquoise;
	border-radius:0;
	box-shadow: 0 0 10px 0 turquoise;
	background-color:black;
	z-index:5;
	height:52px;
}
.form{
  color:white;
  text-align: center;
}
#test:hover{
	box-shadow: 0px 5px turquoise;
	background-color:black;
}
.icon-bar{
	background-color:turquoise;
}
.row{
	height:100%;
}
#left{
	text-align:center;

	height:100%;
}
#left > img{
	box-shadow: 0px 0px 20px 0px turquoise;
}
#right{
	text-align:center;
	border-left:1px solid turquoise;
}
.btn{
	color:turquoise;
	background-color:black;
	border:1px solid turquoise;
}
.btn:hover{
	box-shadow: 0 0 10px 0 turquoise;
	color:turquoise;
}
.folder{
	padding:20px;
	text-decoration:none;
}
.folder>a:hover{
	text-decoration:none;

}
hr, p{
	color:turquoise;
}
.modal{
	background-color:rgba(0,0,0,0.8);

}
.modal-content{
	background-color:black;
	max-width: 600px;
	color:white;
	font-family:cons;
	text-align:center;
	box-shadow: 0px 0px 5px 0px  turquoise;
}
.modal-body{
	padding:0;
}
.modal-footer > button{
	color:turquoise;
	background-color:black;
	border:1px solid turquoise;
}
.modal-footer > button:hover{
	color:turquoise;
	background-color:black;
	box-shadow: 0px 0px 5px 0px  turquoise;
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


  #dp{
    background-color:black;
    position:absolute;
    top:10%;
  }
  #dp1{
    background-color:rgba(0,0,0,0.8);
    width:236px;
    height:236px;
    /* display: none; */
    opacity: 0;
    border-radius:100%;
    text-decoration: none;

  }
  #dpcent{
    margin:auto;
    text-align:center;
    /* background-color:blue; */
    position:absolute;
    top:10%;
    left:0;
  }
  #user_details{
    position:absolute;
    width:100%;
    text-align:center;
    left:0;
  }
  #dpchange{
    /* background-color:rgba(255,0,0,1); */
    position:absolute;
    text-align:center;
    word-wrap: break-word;
    width:100%;
    left:0;
    top: 70%;
  }

  #dpchange  a{
    cursor:pointer;
    text-decoration: none;
  }


  /* The Modal (background) */
  #mc .modal {
      display: none; /* Hidden by default */
      position: fixed; /* Stay in place */
      z-index: 9998; /* Sit on top */
      padding-top: 100px; /* Location of the box */
      left: 0;
      top: 0;
      /* margin: auto 25%; */
      /* background-color: rgba(255,0,0,0.5); */
      text-align: center;
      width: 100%; /* Full width */
      height: 100%; /* Full height */
      overflow: auto; /* Enable scroll if needed */
      background-color: rgba(0,0,0,0.8); /* Fallback color */
      /* background-color: rgba(255,0,0,1); /* Black w/ opacity */ */
  }

  /* Modal Content */
  #mc .modal-content {
      position: relative;
      background-color: rgba(0,0,0,0.5);
      font-family:cons;
      color:turquoise;
      margin: auto 37.5%;
      padding: 0;
      width: 25%;
      /* box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19); */
      -webkit-animation-name: animatetop;
      -webkit-animation-duration: 0.4s;
      animation-name: animatetop;
      animation-duration: 0.4s
  }

  /* Add Animation */
  @-webkit-keyframes animatetop {
      from {top:-300px; opacity:0}
      to {top:0; opacity:1}
  }

  @keyframes animatetop {
      from {top:-300px; opacity:0}
      to {top:0; opacity:1}
  }

  /* The Close Button */
  .closeda, .close, .close1 {
      color: turquoise;
      float: right;
      z-index:9999;
      margin-right:5%;
      font-size: 28px;
      font-weight: bold;

  }


  .closeda:hover,
  .closeda:focus,  .close1:hover, .close1:focus, .close:hover, .close:focus {
      color: #42f445;
      text-decoration: none;
      cursor: pointer;
  }
  input[type=submit]{
    background-color:rgba(0,0,0,0.9);
    border:none;
    font-size:20px;
      border-radius:10px;
      color:#08ff00;
    text-align:center;
    font-family:cons;
  }
  input[type=file]{
    background-color:rgba(0,0,0,0.9);
    border:none;
    font-size:20px;

      border-radius:10px;
    text-align:center;
    font-family:cons;
  }
</style>
</head>

<body>
<nav class="navbar" >
  <div class="container-fluid">
    <div class="navbar-header">
	<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="profile.php">CODEBUSTERS</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
		<ul class="nav navbar-nav navbar-right">
		  <li> <a href="logout.php" id="test"><span class="glyphicon glyphicon-log-out"></span> Log Out</a></li>
		</ul>
	</div>
  </div>
</nav>
<?php

// Keep reminding the user this account is not active, until they activate
if ( $active==0 ){
    echo
    '<div class="form">
    Welcome <br><br><br><h1 style="padding:0;">'.$first_name.' '.$last_name.'</h1><span>'.$email.'</span><br><br><br>
    <div class="info">
    Account is unverified, please confirm your email by clicking
    on the link sent to your E-mail Id!

    </div>
    <button onclick="mailpo1();" class="button button-block"/>Resend Verification Mail</button><br><br>
    <a href="logout.php"><button class="button button-block"/>Log Out</button></a>
    </div>';
}
else if($active==1){
?>
<div class="row container-fluid">
	<div class="col-lg-3 col-md-4" id="left">
    <img src="<?php echo $imgurl;?>" class="img-circle" id="dp" alt="Avatar" width="236" height="236">
    <div id="dpcent"><div id="dp1"><div  id="dpchange"><a id="over">Change profile picture</a></div></div></div>
		<br/><br/><br/>
    <div id="user_details">
		    <h2 style="font-family:digi;color:turquoise;"><?php echo $first_name.' '.$last_name; ?></h2>
		    <h3 style="font-family:digi;color:turquoise;"><?php echo $email; ?></h3>
        <h3 style="font-family:digi;color:turquoise;text-decoration:underline;">Ranks</h3>
        <h4 style="font-family:digi;color:turquoise;">C : <?php echo $c_rank; ?></h4>
        <h4 style="font-family:digi;color:turquoise;">C++ : <?php echo $cpp_rank; ?></h4>
        <h4 style="font-family:digi;color:turquoise;">JAVA : <?php echo $java_rank; ?></h4>
        <h4 style="font-family:digi;color:turquoise;">PYTHON : <?php echo $python_rank; ?></h4>
    </div>
	</div>
	<div class="col-lg-9 col-md-8" id="right">
			<h2>COMPETE . CODE . CONQUER </h2><br/><br/>
			<p>A platform built for students to code and prove their glory<br><br/>Compete and get ranked!</p>
			<a href="code.php" class="btn" type="button">Run Your Snippet</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="compete.php" class="btn" type="button">Compete</a>
		<br/><hr><br/>
		<div class="snip">
			<h2>Your Snippets</h2>
			<br/>
			<div class="col-lg-3 col-md-3 folder">
			<a href="#c_prog" data-toggle="modal" data-target="#c_prog"><img src="img/01.png"  width="150"height="150" alt="C Programs" /><br><p>C Programs</p></a>

			</div>
			<div class="col-lg-3 col-md-3 folder">
			<a href="#c_plus" data-toggle="modal" data-target="#c_plus"><img src="img/02.png" width="150"height="150" alt="C++ Programs" /><br><p>C++ Programs</p></a>

			</div>
			<div class="col-lg-3 col-md-3 folder">
			<a href="#java_prog" data-toggle="modal" data-target="#java_prog"><img src="img/03.png" width="150"height="150" alt="Java Programs" /><br><p>JAVA Programs</p></a>

			</div>
			<div class="col-lg-3 col-md-3 folder">
			<a href="#python_prog" data-toggle="modal" data-target="#python_prog"><img src="img/04.png" style="padding:10px;"width="150"height="150" alt="PYTHON Programs" /><br><p>PYTHON Programs</p></a>

			</div>

		</div>
	</div>
</div>

<?php
}
?>
<div class="modal fade" id="c_prog" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">C Programs</h4>
        </div>
        <div class="modal-body">
          <p><?php echo $dai?> </p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
<div class="modal fade" id="c_plus" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">C++ Programs</h4>
        </div>
        <div class="modal-body">
          <p><?php echo $dai1?> </p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
<div class="modal fade" id="java_prog" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">JAVA Programs</h4>
        </div>
        <div class="modal-body">
          <p><?php echo $dai2?> </p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
<div class="modal fade" id="python_prog" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">PYTHON Programs</h4>
        </div>
        <div class="modal-body">
          <p><?php echo $dai3?> </p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src="js/index.js"></script>
<div id="mc">
  <div id="myModal" class="modal">
    <div class="modal-content">
    <!-- Modal content -->
        <h2 class="closeda" style="opacity:1;position:absolute;right:0;">&times;</h2>
        <h4 style="width:100%;text-align:center;color:white;">Update Profile Picture</h4><br>
        <form action="upload.php" method="post" enctype="multipart/form-data">
            <input type="file" name="fileToUpload" id="fileToUpload">
            <input type="submit" value="Upload Image" name="submit">
        </form>
    </div>
  </div>
</div>
<script>

$("#dpcent").css("width",parseInt($("#left").css("width")));
var dpcent=(parseInt($("#dpcent").css("width"))-$("#dp1").width())/2;
// alert(parseInt($("#dpcent").css("width")));
$("#dp1").css({"margin-left":dpcent});
$("#user_details").css({"top":parseInt($("#dp").css("height"))+50});
$("#dp").css({"left":dpcent});

$("#dp").on('hover',function(){
    $("#dp1").css({"display":"block"});
});

$("#dpcent").mouseenter(function(){
      $("#dp1").css({"opacity":"1"});
});
$("#dpcent").mouseleave(function(){
      $("#dp1").css({"opacity":"0"});
});

var modal = document.getElementById('myModal');
var btn = document.getElementById("over");
var span = document.getElementsByClassName("closeda")[0];
btn.onclick = function() {
    modal.style.display = "block";
}
span.onclick = function() {
    modal.style.display = "none";
}
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>
<script src="https://code.jquery.com/jquery-3.2.1.js" integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE=" crossorigin="anonymous"></script>
<script>
function mailpo1(){
  // alert("Loop entered");
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
}
</script>
</body>
</html>

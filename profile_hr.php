<?php
require_once("db.php");
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
    $result=$mysqli->query('Select hash,username from users where username="'.$username.'"');
    if($row=mysqli_fetch_assoc($result)){
      $hash=$row['hash'];
    }
    $result1 = mysqli_query($mysqli, "SELECT * FROM users where C_rank>0 order by C_rank asc ") or die($mysqli->error());
    $result2 = mysqli_query($mysqli, "SELECT * FROM users where Cpp_rank>0 order by Cpp_rank asc ") or die($mysqli->error());
    $result3 = mysqli_query($mysqli, "SELECT * FROM users where Java_rank>0 order by Java_rank asc ") or die($mysqli->error());
    $result4 = mysqli_query($mysqli, "SELECT * FROM users where Python_rank>0 order by Python_rank asc ") or die($mysqli->error());
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

<!DOCTYPE html>
<html >
<head>
  <meta charset="UTF-8">
  <title>Codebusters</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" >
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script defer src="https://use.fontawesome.com/releases/v5.0.9/js/all.js" integrity="sha384-8iPTk2s/jMVj81dnzb/iFR2sdA7u06vHJyyLlAd4snFpCl/SnyUjRrbdJsw1pGIl" crossorigin="anonymous"></script>
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
body{
	overflow:hidden;
}
.users::-webkit-scrollbar {
    width: 0.5em;

	}

	.users::-webkit-scrollbar-track {
		-webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0);
		background-color:rgba(0,0,0,1);
	}

	.users::-webkit-scrollbar-thumb {
	  background-color: turquoise;
	  border-radius:10px;
	  outline: 1px solid slategrey;
	}
	hr{
		color:turquoise;
		background-color:turquoise;
		border:0.5px solid turquoise;
	}


    #dp{
      background-color:red;
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
    .modal {
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
    .modal-content {
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
    .close, .close1 {
        color: turquoise;
        float: right;
    		z-index:9999;
    		margin-right:5%;
        font-size: 28px;
        font-weight: bold;

    }


    .close:hover,
    .close:focus, .close1:hover, .close1:focus {
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

    h4{
      text-align:center;
      color:turquoise;
    }
    #right>ul>li{
      margin-top: 50px;
      width:100px;
      font-size: 20px;
    }
    #right>ul>li:focus{
      background-color: turquoise!important;
      color:white;

    }
  .nav-tabs > li > a:hover{
    background-color: rgba(0, 0, 0, 0); !important;
    border: 1px solid turquoise;
    color:turquoise;
  }
  .nav-tabs > li > a>.active{
    background-color: rgba(0, 0, 0, 0); !important;
    border: 1px solid turquoise;
    box-shadow: 0px 0px 10px 0px turquoise;
    color:turquoise;
  }

  .form{
    color:white;
    text-align: center;
  }
  .users{
    width:100%;
    overflow-y:scroll;
    text-align:left;
    padding-bottom:15%;
    }
  .inner1{
    font-family: digi;
    border: 1px solid turquoise;
    float: left;
    width:100%;
    padding:5px 15px;
    margin:5px;
  }
  .inner1>h2, .inner1>h4{
    text-align: left;
  }
  #table{
    /* margin: 20px; */
    color:turquoise;
    text-align: center;
    font-size: 20px;
    margin-top: 20px;
  }
  #table>thead>tr>th{
    text-align: center;
  }
  .fa-hand-point-up:hover{
    color:black;
  }
  #table>tbody>tr:hover{
    background-color: rgba(64, 224, 208,0.5);
    color:white;
  }
  #table>tbody>tr>td{
    width: 200px;
    border:none;
    line-height: 50px;
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
		    <p style="font-family:digi;color:turquoise;font-size:18px;"><?php echo $email; ?></p>
    </div>
	</div>
	<div class="col-lg-9 col-md-8" id="right">
		<h2>Our Coders</h2>
    <ul class="nav nav-tabs">
      <li class="active"><a data-toggle="tab" href="#c_prog">C</a></li>
      <li><a data-toggle="tab" href="#cpp_prog">C++</a></li>
      <li><a data-toggle="tab" href="#java">JAVA</a></li>
      <li><a data-toggle="tab" href="#python">PYTHON</a></li>
    </ul>
    <div class="tab-content">
    <div id="c_prog" class="tab-pane fade in active">
      <div class="users">
        <table class="table table-hover" id="table">
          <thead>
            <tr>
              <th>Rank</th>
              <th>Firstname</th>
              <th>Lastname</th>
              <th>Email</th>
              <th>Poke</th>
            </tr>
          </thead>
          <tbody>
            <?php
            while ($row = mysqli_fetch_array($result1)) {
            ?>
            <tr>
              <td><?php echo $row['C_rank']?></td>
              <td><?php echo $row['first_name']?></td>
              <td><?php echo $row['last_name']?></td>
              <td><?php echo $row['email']?></td>
              <?php
              $ufn=$row['first_name'];
              $uln=$row['last_name'];
              $um=$row['email'];
              ?>
              <td><i class="far fa-hand-point-up" onclick="mailpo('<?php echo $ufn; ?>','<?php echo $uln; ?>','<?php echo $um; ?>');"></i></td>
            </tr>
            <?php
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
    <div id="cpp_prog" class="tab-pane fade">
      <div class="users">
        <table class="table table-hover" id="table">
          <thead>
            <tr>
              <th>Rank</th>
              <th>Firstname</th>
              <th>Lastname</th>
              <th>Email</th>
              <th>Poke</th>
            </tr>
          </thead>
          <tbody>
            <?php
            while ($row = mysqli_fetch_array($result2)) {
            ?>
            <tr>
              <td><?php echo $row['Cpp_rank']?></td>
              <td><?php echo $row['first_name']?></td>
              <td><?php echo $row['last_name']?></td>
              <td><?php echo $row['email']?></td>
              <?php
              $ufn=$row['first_name'];
              $uln=$row['last_name'];
              $um=$row['email'];
              ?>
              <td><i class="far fa-hand-point-up" onclick="mailpo('<?php echo $ufn; ?>','<?php echo $uln; ?>','<?php echo $um; ?>');"></i></td>
            </tr>
            <?php
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
    <div id="java" class="tab-pane fade">
      <div class="users">
        <table class="table table-hover" id="table">
          <thead>
            <tr>
              <th>Rank</th>
              <th>Firstname</th>
              <th>Lastname</th>
              <th>Email</th>
              <th>Poke</th>
            </tr>
          </thead>
          <tbody>
            <?php
            while ($row = mysqli_fetch_array($result3)) {
            ?>
            <tr>
              <td><?php echo $row['Java_rank']?></td>
              <td><?php echo $row['first_name']?></td>
              <td><?php echo $row['last_name']?></td>
              <td><?php echo $row['email']?></td>
              <?php
              $ufn=$row['first_name'];
              $uln=$row['last_name'];
              $um=$row['email'];
              ?>
              <td><i class="far fa-hand-point-up" onclick="mailpo('<?php echo $ufn; ?>','<?php echo $uln; ?>','<?php echo $um; ?>');"></i></td>
            </tr>
            <?php
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
    <div id="python" class="tab-pane fade">
      <div class="users">
        <table class="table table-hover" id="table">
          <thead>
            <tr>
              <th>Rank</th>
              <th>Firstname</th>
              <th>Lastname</th>
              <th>Email</th>
              <th>Poke</th>
            </tr>
          </thead>
          <tbody>
            <?php
            while ($row = mysqli_fetch_array($result4)) {
            ?>
            <tr>
              <td><?php echo $row['Python_rank']?></td>
              <td><?php echo $row['first_name']?></td>
              <td><?php echo $row['last_name']?></td>
              <td><?php echo $row['email']?></td>
              <?php
              $ufn=$row['first_name'];
              $uln=$row['last_name'];
              $um=$row['email'];
              ?>
              <td><i class="far fa-hand-point-up" onclick="mailpo('<?php echo $ufn; ?>','<?php echo $uln; ?>','<?php echo $um; ?>');"></i></td>
            </tr>
            <?php
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

	</div>
</div>

<?php
}
?>












<div id="myModal" class="modal">
  <div class="modal-content">
  <!-- Modal content -->
      <h2 class="close" style="opacity:1;position:absolute;right:0;">&times;</h2>
      <h4 style="width:100%;text-align:center;color:white;">Update Profile Picture</h4><br>
      <form action="upload_hr.php" method="post" enctype="multipart/form-data">
          <input type="file" name="fileToUpload" id="fileToUpload">
          <input type="submit" value="Upload Image" name="submit">
      </form>
  </div>
</div>


<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src="js/index.js"></script>
<script>
	$(".users").css({"height":window.innerHeight-$(".navbar").height()});
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
	var span = document.getElementsByClassName("close")[0];
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
var ufn=uln=um="";
function mailpo(ufn, uln, um){
  alert("You have poked our coder... \nHe will be sent a mail regarding this...\nYour email will be shared with him...\nHe (or) She will contact you soon...");
  /*alert("https://testingtheboss.000webhostapp.com/mail/poke.php?mail=<?php// echo $email;?>&first_name=<?php// echo $first_name;?>&last_name=<?php //echo $last_name;?>&um="+um+"&ufn="+ufn+"&uln="+uln);*/
  $.ajax({
    type: "GET",
    url: "https://testingtheboss.000webhostapp.com/mail/poke.php?mail=<?php echo $email;?>&first_name=<?php echo $first_name;?>&last_name=<?php echo $last_name;?>&um="+um+"&ufn="+ufn+"&uln="+uln,
    dataType:"jsonp",
    success: function(data){
      alert("Mail Sent");
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
          alert(  "Status: " + textStatus +" &" +data+"\nCouldn't poke the coder\nCheck your network connectivity or try again later... ");
      }
  });

}
</script>
<script>
function mailpo1(){
  // alert("Loop entered");
  $.ajax({
    type: "GET",
  url: "https://devilismytown.000webhostapp.com/mail/mail.php?mail=<?php echo $email;?>&first_name=<?php echo $first_name;?>&hash=<?php echo $hash;?>&user=hr",
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

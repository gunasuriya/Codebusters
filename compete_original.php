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
		$file="users/$username/cpp/tagged/".$_POST['tags'].".cpp";
		if(strcmp($trick,"execute")==0){
		$cinput="users/$username/cpp/tagged/".$_POST['tags']."_input.txt";
		$coutput="users/$username/cpp/tagged/".$_POST['tags']."_output.txt";
		$mass=$_POST['tags'].".exe";
		file_put_contents($file, $current);
		file_put_contents($cinput, $goi);
		putenv("PATH=compile\MinGW64\bin");
		$mass=$mass." < ".$cinput;
		$time_start = microtime(true);
		$kat="Error Occured\n".shell_exec("g++ users/$username/cpp/tagged/".$_POST['tags'].".cpp -o ".$_POST['tags'].".exe 2>&1");
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
        $mysqli->query("INSERT INTO $tags (username,lang,exe_time) VALUES ('$username','$lang',$execution_time)");
        // echo "INSERT INTO $tags (username,lang,exe_time) VALUES ('$username','$lang',$execution_time)";
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
<title style="color:purple;">CODE FIRE</title>
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

</style>
</head>
<body  oncontextmenu="return false">

<video style="opacity:1;" id="vid" autoplay muted loop>
  <source src="movie.mp4" type="video/mp4">
	<source src="movie.ogg" type="video/ogg">
 <!-- <source src="movie.ogg" type="video/ogg">-->
</video>
<div class="bg"><div id="layer"></div></div>
<div id="navda" style="width:100%;">
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
            <select id="tags1" name="tags1" style="margin-top:10px;">
							<option value="Select">Select</option>
							<option value="fibonacci">Fibonacci</option>
							<option value="factorial">Factorial</option>
							<option value="palindrome">Palindrome</option>
							<!-- <option value="Python">Python</option> -->
						</select>
          </li>
					<li class="navbar-left">
						<select id="lang1" name="lang1" style="margin-top:10px;">
							<option value="Select">Select</option>
							<option value="C">C</option>
							<option value="C++">C++</option>
							<option value="Java">Java</option>
							<option value="Python">Python</option>
						</select>
					</li>

          <li class="navbar-left"><button id="execute" style="z-index:9999;" value="Execute">Execute</button></li>
					<li class="navbar-left"><button id="save" style="z-index:9999;" value="save">Save</button></li>
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
						<div id="acecppcode1"></div>
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

<script src="ace/ace.js" type="text/javascript" charset="utf-8"></script>
<script src="ace/ext-modelist.js" type="text/javascript" charset="utf-8"></script>
<script src="ace/ext-language_tools.js" type="text/javascript" charset="utf-8"></script>

<script>

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
		fontSize: "18pt"
});
editor1.setOptions({
		fontSize: "18pt"
});
editor2.setOptions({
	readOnly: true,
		highlightActiveLine: false,
		highlightGutterLine: false ,
		fontSize: "18pt"
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
			}
			if($("#lang1").val()=="C++"){

				document.getElementById('lang').value = "C++";
			}

			document.getElementById("execute").disabled = false;
			document.getElementById("execute").style.opacity = 1;
			document.getElementById("save").disabled = false;
			document.getElementById("save").style.opacity = 1;
			editor.session.setMode("ace/mode/c_cpp");
			//setTimeout(function(){alert(editor.getSession().getMode().$id);},100);
		}
		if($("#lang1").val()=="Java"){
      alert("Keep the class name as the program name");
			document.getElementById('lang').value = "Java";
			document.getElementById("execute").disabled = false;
			document.getElementById("execute").style.opacity = 1;
			document.getElementById("save").disabled = false;
			document.getElementById("save").style.opacity = 1;
			editor.session.setMode("ace/mode/java");
			//setTimeout(function(){alert(editor.getSession().getMode().$id);},100);
		}
		if($("#lang1").val()=="Python"){
			document.getElementById('lang').value = "Python";
			document.getElementById("execute").disabled = false;
			document.getElementById("execute").style.opacity = 1;
			document.getElementById("save").disabled = false;
			document.getElementById("save").style.opacity = 1;
			editor.session.setMode("ace/mode/python");
			//setTimeout(function(){alert(editor.getSession().getMode().$id);},100);
		}
		if($("#lang1").val()=="Select"){
		document.getElementById('lang').value = "Select";
			document.getElementById("execute").disabled = true;
			document.getElementById("save").disabled = true;
			document.getElementById("save").style.opacity = 0.5;
			document.getElementById("execute").style.opacity = 0.5;
			editor.session.setMode("ace/mode/python");
			//setTimeout(function(){alert(editor.getSession().getMode().$id);},100);
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
editor.focus();

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

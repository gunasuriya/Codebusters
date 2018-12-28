<?php
  require 'db.php';
  $i=0;
  $j=0;
  $progs=array("fibonacci","factorial","palindrome");
  $lang=array("C","Cpp","Java","Python");
  for($j=0;$j<count($lang);$j++){
          for($i=0;$i<count($progs);$i++){
            $result1=$mysqli->query("SELECT username,lang,exe_time,$lang[$j]_ranking FROM $progs[$i] where lang='$lang[$j]' order by exe_time asc ");
            // echo "SELECT username,lang,exe_time,".$lang[$j]."_ranking FROM $progs[$i] where lang='$lang[$j]' order by exe_time asc ";
            $ranking=1;
            while($row = mysqli_fetch_assoc($result1)) {
                 // echo $row['username'],$row['exe_time']."<br>";
                $mysqli->query("UPDATE ".$progs[$i]." SET ".$lang[$j]."_ranking = ".$ranking." WHERE username='".$row['username']."' AND lang='".$row['lang']."'");

                 $ranking=$ranking+1;
             }

          }
             $result2=$mysqli->query("SELECT username,$lang[$j]_prog_count,$lang[$j]_ranking FROM users");
             while($row = mysqli_fetch_assoc($result2)) {
               $progcalc=0;
               $rankingcalc=0;
               for($i=0;$i<count($progs);$i++){
                 $result=$mysqli->query("SELECT username,".$lang[$j]."_ranking,lang FROM $progs[$i] where lang='$lang[$j]'");
                 while($row1 = mysqli_fetch_assoc($result)) {
                    if($row['username']==$row1['username']){
                      $progcalc=$progcalc+1;
                      $rankingcalc=$rankingcalc+$row1[$lang[$j].'_ranking'];
                    }
                 }
               }
                 $mysqli->query('UPDATE users SET '.$lang[$j].'_prog_count = '.$progcalc.','.$lang[$j].'_ranking='.$rankingcalc.' WHERE username="'.$row['username'].'"');
             }
             $overall=1;
             $result3=$mysqli->query("SELECT username,$lang[$j]_prog_count,$lang[$j]_ranking,$lang[$j]_rank FROM users where $lang[$j]_ranking>0 order by $lang[$j]_prog_count desc, $lang[$j]_ranking asc");
            // echo "SELECT username,$lang[$j]_prog_count,$lang[$j]_ranking,$lang[$j]_rank FROM users order by $lang[$j]_prog_count desc, $lang[$j]_ranking asc";
             while($row = mysqli_fetch_assoc($result3)) {
               // echo $row['username']." ".$row['prog_count']." ".$row['ranking']." ".$row['overall_rank']."<br>";
               $mysqli->query('UPDATE users SET '.$lang[$j].'_rank = '.$overall.' WHERE username="'.$row['username'].'"');
               $overall=$overall+1;
             }
    }

?>


<html>
 <head>
  <title>
   Query Results
  </title>
 </head>
 <body>
  <style>
   html {overflow-y:hidden; overflow-x:hidden;}
   body {font-family:verdana; background-image:url("pic/bg3.jpg");}
   #top {position:fixed; top:50%; left:50%; margin-top:-272; margin-left:-272; color:black; z-index:10}
   #content {position:absolute; border-radius:8px; width:1200px; top:50%; left:50%; margin-top:-300px; margin-left:-600px; text-align:center; clear:both; z-index:5}
   #end {position:absolute; text-align:center; padding-top:5px; padding-bottom:5px; color:white; width:100%; height:20px; bottom:0; left:0; background:rgba(192,192,192,0.7);}
   .rainbow {
    background-image: -webkit-gradient( linear, left top, right top, color-stop(0, #f22), color-stop(0.15, #f2f), color-stop(0.3, #22f), color-stop(0.45, #2ff), color-stop(0.6, #2f2),color-stop(0.75, #2f2), color-stop(0.9, #ff2), color-stop(1, #f22) );
    background-image: gradient( linear, left top, right top, color-stop(0, #f22), color-stop(0.15, #f2f), color-stop(0.3, #22f), color-stop(0.45, #2ff), color-stop(0.6, #2f2),color-stop(0.75, #2f2), color-stop(0.9, #ff2), color-stop(1, #f22) );
    color:transparent;
    -webkit-background-clip: text;
    background-clip: text;
   }
  </style>
  <center>
  <div id="content" style="border:1px solid; background:white;">
   <?php
    //Don't forget to change the table!
    session_start();
    
    if ($_SESSION["mar"] == 'y'){
      $mar = mysqli_connect($_SESSION["im"],$_SESSION["um"],$_SESSION["pm"],"marinduque_info");
      $con = $mar;
    } else if ($_SESSION["pal"] == 'y'){
      $pal = mysqli_connect($_SESSION["ip"],$_SESSION["up"],$_SESSION["pp"],"palawan_info");
       $con = $pal;
    } else if ($_SESSION["com"] == 'y'){
      $com = mysqli_connect($_SESSION["ic"],$_SESSION["uc"],$_SESSION["pc"],"combined");
      $con = $com;
    }
      print_r($_SESSION);
    
    //Different queries
    if ( isset($_POST['queries']) &&$_POST['queries'] == 'Submit Query 1') {
     $sql = "v";
       // mysqli_begin_transaction($con, MYSQLI_TRANS_START_READ_WRITE);
    } else if( isset($_POST['edit']) && $_POST['edit'] == 'Edit User Info 1' && $_SESSION['mar']=='y' && isset($_POST['v1'])){
      $sql = "cm1";
    } else if( isset($_POST['edit']) && $_POST['edit'] == 'Edit User Info 1' && $_SESSION['pal']=='y' && isset($_POST['v1'])){
      $sql = "cp1";
    } else if( isset($_POST['edit']) && $_POST['edit'] == 'Edit User Info 2' && $_SESSION['mar']=='y' && isset($_POST['v2'])){
      $sql ="cm2";
    }  else if( isset($_POST['edit']) && $_POST['edit'] == 'Edit User Info 2' && $_SESSION['pal']=='y' && isset($_POST['v2'])){
      $sql ="cp2";
    }  else if( isset($_POST['edit']) && $_POST['edit'] == 'Edit User Info 3' && $_SESSION['mar']=='y' && isset($_POST['v3'])){
      $sql ="cm3";
    }  else if( isset($_POST['edit']) && $_POST['edit'] == 'Edit User Info 3' && $_SESSION['pal']=='y'){
      $sql ="cp3";
    }
    
    //Execution time in milliseconds
    // try{
      $exec = microtime(true);
      switch($sql){
        case "v": {
          $result = mysqli_query($con, "SELECT COUNT(DISTINCT `main.id`) FROM hpq_mem
            WHERE educind = 2 AND jobind = 2 AND regvotind = 1;") or die(mysqli_error($con));
          $exec = microtime(true)-$exec;
          echo 'Execution Time: ' . ($exec * 1000) . ' ms';
          
           mysqli_query($con, $sql);
          
          //Print the column names
          echo '<table>';
          echo '<tr>';
          while ($field_info = mysqli_fetch_field($result)) {
           echo '<td>' . $field_info->name . '</td>';
          }
          echo '</tr>';
          
          //Print the data
          while($row = mysqli_fetch_row($result)) {
           echo "<tr>";
           foreach($row as $value) {
            echo "<td>" . $value . "</td>";
           }
           echo "</tr>";
          }
          echo '</table>';
          mysqli_close($con);
        }; break;
        case "cp1": mysqli_query($con, "UPDATE hpq_mem SET educind = ".$_POST['v1']." WHERE hpq_mem.`main.id`=69279 AND hpq_mem.`memno`=15") or die("Unable to update Palawan".die(mysqli_error($con))); break;
        case "cm1": mysqli_query($con, "UPDATE hpq_mem SET educind =".$_POST['v1']." WHERE hpq_mem.`main.id`=199036 AND hpq_mem.`memno`=1") or die("Unable to update Marinduque".die(mysqli_error($con))); break;
        case "cp2": mysqli_query($con, "UPDATE hpq_mem SET jobind = ".$_POST['v1']." WHERE hpq_mem.`main.id`=69279 AND hpq_mem.`memno`=15") or die("Unable to update Palawan".die(mysqli_error($con))); break;
        case "cm2": mysqli_query($con, "UPDATE hpq_mem SET jobind =".$_POST['v1']." WHERE hpq_mem.`main.id`=199036 AND hpq_mem.`memno`=1") or die("Unable to update Marinduque".die(mysqli_error($con))); break;
        case "cp3": mysqli_query($con, "UPDATE hpq_mem SET regvotind = ".$_POST['v1']." WHERE hpq_mem.`main.id`=69279 AND hpq_mem.`memno`=15") or die("Unable to update Palawan".die(mysqli_error($con))); break;
        case "cm3": mysqli_query($con, "UPDATE hpq_mem SET regvotind =".$_POST['v1']." WHERE hpq_mem.`main.id`=199036 AND hpq_mem.`memno`=1") or die("Unable to update Marinduque".die(mysqli_error($con))); break;
      }
      
    // } catch{

    // }
   ?>
  </div>
  </center>
 </body>
</html>

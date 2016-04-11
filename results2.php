
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
    if ($_POST['queries'] == 'Submit Query 1') {
     $sql = "SELECT COUNT(DISTINCT `id`) FROM hpq_mem
       WHERE educind = 2 AND jobind = 2 AND regvotind = 1;";
    }
    
    //Execution time in milliseconds
    $exec = microtime(true);
    mysqli_query($con, $sql);
    $exec = microtime(true)-$exec;
    echo 'Execution Time: ' . ($exec * 1000) . ' ms';
    
    $result = mysqli_query($con, $sql) or die(mysqli_error($con));
    
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
   ?>
  </div>
  </center>
 </body>
</html>

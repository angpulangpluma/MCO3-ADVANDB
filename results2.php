

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

    $paldetect = false;
    $mardetect = false;
    $comdetect = false;
    //detect which user is initiating transaction    
    if ($_SESSION["mar"] == 'y'){
      $mar = mysqli_connect($_SESSION["im"],$_SESSION["um"],$_SESSION["pm"],"marinduque_info");
      $mardetect = true;
      $con1 = $mar;
    } else if ($_SESSION["pal"] == 'y'){
      $pal = mysqli_connect($_SESSION["ip"],$_SESSION["up"],$_SESSION["pp"],"palawan_info");
       $paldetect = true;
       $con1 = $pal;
    } else if ($_SESSION["com"] == 'y'){
      $com = mysqli_connect($_SESSION["ic"],$_SESSION["uc"],$_SESSION["pc"],"combined");
      $comdetect = true;
      if($paldetect===true || $mardetect===true)
        $con2 = $com;
      else {
        $existcon = false;
        $con1 = $com; 
      }
    }

    switch($_POST['isol']){
      case 's': $isolevel = "SET TRANSACTION LEVEL SERIALIZABLE"; break;
      case 'rr': $isolevel = "SET TRANSACTION LEVEL REPEATABLE READ"; break;
      case 'rc': $isolevel = "SET TRANSACTION LEVEL READ COMMITTED"; break;
      case 'ru': $isolevel = "SET TRANSACTION LEVEL READ UNCOMMITTED"; break;
      case 'n': break;
    }

    //detect type of query
      if ( isset($_POST['queries']) &&$_POST['queries'] == 'Submit Query 1' ) { //v - view results
         $sql = "v";
         $sql1 = "SELECT COUNT(DISTINCT `main.id`) FROM hpq_mem
                WHERE educind = 2 AND jobind = 2 AND regvotind = 1;";
         if(($paldetect===true || $mardetect===true)&&$comdetect===true)
            $sql2 = "SELECT COUNT(DISTINCT `main.id`) FROM hpq_mem
                WHERE educind = 2 AND jobind = 2 AND regvotind = 1;";
         
      }else if( isset($_POST['edit']) && $_POST['edit'] == 'Edit User Info 1' && $_SESSION['mar']=='y' && isset($_POST['v1'])){ //cm1 - edit eduind at marinduque
        $sql = "cm1";
        $sql1 = "UPDATE hpq_mem SET educind =".$_POST['v1']." WHERE hpq_mem.`main.id`=199036 AND hpq_mem.`memno`=1";
         if(($paldetect===true || $mardetect===true)&&$comdetect===true)
            $sql2 = "UPDATE hpq_mem SET educind =".$_POST['v1']." WHERE hpq_mem.`main.id`=199036 AND hpq_mem.`memno`=1";
         
      } else if( isset($_POST['edit']) && $_POST['edit'] == 'Edit User Info 1' && $_SESSION['pal']=='y' && isset($_POST['v1'])){ //cp1 - edit eduind at palawan
        $sql = "cp1";
        $sql1 = "UPDATE hpq_mem SET educind = ".$_POST['v1']." WHERE hpq_mem.`main.id`=69279 AND hpq_mem.`memno`=15";
         if(($paldetect===true || $mardetect===true)&&$comdetect===true)
            $sql2 = "UPDATE hpq_mem SET educind = ".$_POST['v1']." WHERE hpq_mem.`main.id`=69279 AND hpq_mem.`memno`=15";
         
      } else if (isset($_POST['edit']) && $_POST['edit'] == 'Edit User Info 1' && isset($_POST['v1']) && $_SESSION['com']=='y' && isset($_POST['o1'])){//edit at combined
        switch($_POST['o1']){
          case '1':{
            $sql = "cm1";
            $sql1 = "UPDATE hpq_mem SET educind =".$_POST['v1']." WHERE hpq_mem.`main.id`=199036 AND hpq_mem.`memno`=1";
             if(($paldetect===true || $mardetect===true)&&$comdetect===true)
                $sql2 = "UPDATE hpq_mem SET educind =".$_POST['v1']." WHERE hpq_mem.`main.id`=199036 AND hpq_mem.`memno`=1";
          }; break;
          case '2':{
            $sql = "cp1";
            $sql1 = "UPDATE hpq_mem SET educind = ".$_POST['v1']." WHERE hpq_mem.`main.id`=69279 AND hpq_mem.`memno`=15";
             if(($paldetect===true || $mardetect===true)&&$comdetect===true)
                $sql2 = "UPDATE hpq_mem SET educind = ".$_POST['v1']." WHERE hpq_mem.`main.id`=69279 AND hpq_mem.`memno`=15";
          }; break;
        }
      }else if( isset($_POST['edit']) && $_POST['edit'] == 'Edit User Info 2' && $_SESSION['mar']=='y' && isset($_POST['v2'])){ //cm2 - edit jobind at marinduque
        $sql ="cm2";
        $sql1 = "UPDATE hpq_mem SET jobind =".$_POST['v1']." WHERE hpq_mem.`main.id`=199036 AND hpq_mem.`memno`=1";
         if(($paldetect===true || $mardetect===true)&&$comdetect===true)
            $sql2 = "UPDATE hpq_mem SET jobind =".$_POST['v1']." WHERE hpq_mem.`main.id`=199036 AND hpq_mem.`memno`=1";
         
      }  else if( isset($_POST['edit']) && $_POST['edit'] == 'Edit User Info 2' && $_SESSION['pal']=='y' && isset($_POST['v2'])){  //cp2 - edit jobind at palawan
        $sql ="cp2";
        $sql1 = "UPDATE hpq_mem SET jobind = ".$_POST['v1']." WHERE hpq_mem.`main.id`=69279 AND hpq_mem.`memno`=15";
         if(($paldetect===true || $mardetect===true)&&$comdetect===true)
            $sql2 = "UPDATE hpq_mem SET jobind = ".$_POST['v1']." WHERE hpq_mem.`main.id`=69279 AND hpq_mem.`memno`=15";
         
      }  else if (isset($_POST['edit']) && $_POST['edit'] == 'Edit User Info 2' && isset($_POST['v2']) && $_SESSION['com']=='y' && isset($_POST['o2'])){//edit at combined
        switch($_POST['o2']){
          case '1':{
            $sql ="cm2";
            $sql1 = "UPDATE hpq_mem SET jobind =".$_POST['v1']." WHERE hpq_mem.`main.id`=199036 AND hpq_mem.`memno`=1";
             if(($paldetect===true || $mardetect===true)&&$comdetect===true)
                $sql2 = "UPDATE hpq_mem SET jobind =".$_POST['v1']." WHERE hpq_mem.`main.id`=199036 AND hpq_mem.`memno`=1";
          }; break;
          case '2':{
            $sql ="cp2";
            $sql1 = "UPDATE hpq_mem SET jobind = ".$_POST['v1']." WHERE hpq_mem.`main.id`=69279 AND hpq_mem.`memno`=15";
             if(($paldetect===true || $mardetect===true)&&$comdetect===true)
                $sql2 = "UPDATE hpq_mem SET jobind = ".$_POST['v1']." WHERE hpq_mem.`main.id`=69279 AND hpq_mem.`memno`=15";
          }; break;
        }
      }else if( isset($_POST['edit']) && $_POST['edit'] == 'Edit User Info 3' && $_SESSION['mar']=='y' && isset($_POST['v3'])){ //cm3 - edit regvotind at marinduque
        $sql ="cm3";
        $sql1 = "UPDATE hpq_mem SET regvotind =".$_POST['v1']." WHERE hpq_mem.`main.id`=199036 AND hpq_mem.`memno`=1";
         if(($paldetect===true || $mardetect===true)&&$comdetect===true)
            $sql2 = "UPDATE hpq_mem SET regvotind =".$_POST['v1']." WHERE hpq_mem.`main.id`=199036 AND hpq_mem.`memno`=1";
         
      }  else if( isset($_POST['edit']) && $_POST['edit'] == 'Edit User Info 3' && $_SESSION['pal']=='y' && isset($_POST['v3'])){ //cp3 - edit regvotind at palawan
        $sql ="cp3";
        $sql1 = "UPDATE hpq_mem SET regvotind = ".$_POST['v1']." WHERE hpq_mem.`main.id`=69279 AND hpq_mem.`memno`=15";
         if(($paldetect===true || $mardetect===true)&&$comdetect===true)
            $sql2 = "UPDATE hpq_mem SET regvotind = ".$_POST['v1']." WHERE hpq_mem.`main.id`=69279 AND hpq_mem.`memno`=15";
         
      } else if (isset($_POST['edit']) && $_POST['edit'] == 'Edit User Info 3' && isset($_POST['v3']) && $_SESSION['com']=='y' && isset($_POST['o3'])){//edit at combined
        switch($_POST['o2']){
          case '1':{
            $sql ="cm3";
            $sql1 = "UPDATE hpq_mem SET regvotind =".$_POST['v1']." WHERE hpq_mem.`main.id`=199036 AND hpq_mem.`memno`=1";
             if(($paldetect===true || $mardetect===true)&&$comdetect===true)
                $sql2 = "UPDATE hpq_mem SET regvotind =".$_POST['v1']." WHERE hpq_mem.`main.id`=199036 AND hpq_mem.`memno`=1";
          }; break;
          case '2':{
            $sql ="cp3";
            $sql1 = "UPDATE hpq_mem SET regvotind = ".$_POST['v1']." WHERE hpq_mem.`main.id`=69279 AND hpq_mem.`memno`=15";
             if(($paldetect===true || $mardetect===true)&&$comdetect===true)
                $sql2 = "UPDATE hpq_mem SET regvotind = ".$_POST['v1']." WHERE hpq_mem.`main.id`=69279 AND hpq_mem.`memno`=15";
          }; break;
        }
      }

      // print_r($_SESSION);

      try{
          //read write, if you want to read only replace it with READ_ONLY
          if($sql!=='v'){
            mysqli_begin_transaction($con1, MYSQLI_TRANS_START_READ_WRITE);
            if(($paldetect===true || $mardetect===true)&&$comdetect===true && $sql!=='v')
              mysqli_begin_transaction($con2, MYSQLI_TRANS_START_READ_WRITE);
          }

          if($_POST['isol']!='n'){
            $db1query = mysqli_query($con1, $isolevel);
            if(($paldetect===true || $mardetect===true)&&$comdetect===true)
              $db2query = mysqli_query($con2, $isolevel);
          else ;
          } 

          $db1query = mysqli_query($con1,$sql1);
          if(($paldetect===true || $mardetect===true)&&$comdetect===true)
            $db1query = mysqli_query($con2, $sql2);
          else ;

          if ($sql==='v'){
            //Print the column names
            echo '<table border="1">';
            echo '<tr>';
            while ($field_info = mysqli_fetch_field($db1query)) {
             echo '<td>' . $field_info->name . '</td>';
            }
            echo '</tr>';
            
            //Print the data
            while($row = mysqli_fetch_row($db1query)) {
             echo "<tr>";
             foreach($row as $value) {
              echo "<td>" . $value . "</td>";
             }
             echo "</tr>";
            }
            echo '</table>';
          } else{
            if($db1query===true){
              $db1query = mysqli_commit($con1);
              if($db1query===false)
                throw new Exception("query has not committed perfectly");
            }
            else if(($paldetect===true || $mardetect===true)&&$comdetect===true &&
                $db2query===true){
                $db2query = mysqli_commit($con2);
                if($db2query===false)
                  throw new Exception("query has not committed perfectly");
            }
            else throw new Exception("query has not executed perfectly");
          }

      } catch (Exception $e){
        //rollback
        echo "No changes have been made due to loss of connection between the communicating databases";
        mysqli_rollback($con1);
        if(($paldetect===true || $mardetect===true)&&$comdetect===true)
          mysqli_rollback($con2);
        exit;
      }

   ?>
  </div>
  </center>
 </body>
</html>

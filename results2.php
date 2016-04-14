

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

    try{
      $paldetect = false;
      $mardetect = false;
      $comdetect = false;
      //detect which user is initiating transaction    
      if ($_SESSION["mar"] == 'y'){
        if(filter_var($_SESSION["im"], FILTER_VALIDATE_IP)===false && $_SESSION['im']!='localhost'){
          throw new Exception("invalid ip addresss for marinduque connection");
        } else{
          $mar = mysqli_connect($_SESSION["im"],$_SESSION["um"],$_SESSION["pm"],"marinduque_info");
          $mardetect = true;
          $con1 = $mar;
        }
      } if ($_SESSION["pal"] == 'y'){
        if(filter_var($_SESSION["ip"], FILTER_VALIDATE_IP)===false && $_SESSION['ip']!='localhost'){
          throw new Exception("invalid ip addresss for palawan connection");
        } else{
          $pal = mysqli_connect($_SESSION["ip"],$_SESSION["up"],$_SESSION["pp"],"palawan_info");
           $paldetect = true;
           if($_SESSION["mar"]=='y'){
            $con2 = $pal;
           } else $con1 = $pal;
        }
      } if ($_SESSION["com"] == 'y'){
        if(filter_var($_SESSION["ic"], FILTER_VALIDATE_IP)===false && $_SESSION['ic']!='localhost'){
          throw new Exception("invalid ip addresss for combined connection");
        } else{
          $com = mysqli_connect($_SESSION["ic"],$_SESSION["uc"],$_SESSION["pc"],"combined");
          $comdetect = true;
          if($paldetect===true && $mardetect===true){
            $con3 = $com;
          } else if (($paldetect===true && $mardetect===false) || 
              ($paldetect===false && $mardetect===true)){
            $con2 = $com;
          }
          else {
            // $existcon = false;
            $con1 = $com; 
          }
        }
      }

      //check connections
      if($paldetect===false && $mardetect===true && 
        $comdetect===true && ($con1===false || $con2===false)){ //for marinduque user
        throw new Exception("cannot connect");
      } else if ($paldetect===true && $mardetect===false && 
        $comdetect===true && ($con1===false || $con2===false)){ //for palawan user
        throw new Exception("cannot connect");
      } else if ($paldetect===true && $mardetect===true &&
        $comdetect===true && 
        ($con1===false || $con2===false || $con3===false)){ //for combined user
        throw new Exception("cannot connect");
      } else if($con1===false){//one database only
        throw new Exception("cannot connect");
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
         // if (($paldetect===true && $mardetect===false) || 
         //  ($paldetect===false && $mardetect===true) && $comdetect===true){
         //  $sql2 = "SELECT COUNT(DISTINCT `main.id`) FROM hpq_mem
         //        WHERE educind = 2 AND jobind = 2 AND regvotind = 1;";
         // } else if ($paldetect===true && $mardetect===true && $comdetect===true){
         //  $sql2 = "SELECT COUNT(DISTINCT `main.id`) FROM hpq_mem
         //        WHERE educind = 2 AND jobind = 2 AND regvotind = 1;";
         // }
         
      }else if( isset($_POST['edit']) && $_POST['edit'] == 'Edit User Info 1' && $_SESSION['mar']=='y' && isset($_POST['v1'])){ //cm1 - edit eduind at marinduque
        $sql = "cm1";
        $sql1 = "UPDATE hpq_mem SET educind =".$_POST['v1']." WHERE hpq_mem.`main.id`=199036 AND hpq_mem.`memno`=1";
         if ($paldetect===false && $mardetect===true && $comdetect===true){
            $sql2 = "UPDATE hpq_mem SET educind =".$_POST['v1']." WHERE hpq_mem.`main.id`=199036 AND hpq_mem.`memno`=1";
          }
         
      } else if( isset($_POST['edit']) && $_POST['edit'] == 'Edit User Info 1' && $_SESSION['pal']=='y' && isset($_POST['v1'])){ //cp1 - edit eduind at palawan
        $sql = "cp1";
        $sql1 = "UPDATE hpq_mem SET educind = ".$_POST['v1']." WHERE hpq_mem.`main.id`=69279 AND hpq_mem.`memno`=15";
         if ($paldetect===true && $mardetect===false && $comdetect===true){
            $sql2 = "UPDATE hpq_mem SET educind = ".$_POST['v1']." WHERE hpq_mem.`main.id`=69279 AND hpq_mem.`memno`=15";
        }
         
      } else if (isset($_POST['edit']) && $_POST['edit'] == 'Edit User Info 1' && isset($_POST['v1']) && $_SESSION['com']=='y' && isset($_POST['o1'])){//edit at combined
        switch($_POST['o1']){
          case '1':{
            $sql = "cm1";
            $sql1 = "UPDATE hpq_mem SET educind =".$_POST['v1']." WHERE hpq_mem.`main.id`=199036 AND hpq_mem.`memno`=1";
             if ($paldetect===false && $mardetect===true && $comdetect===true)
                $sql2 = "UPDATE hpq_mem SET educind =".$_POST['v1']." WHERE hpq_mem.`main.id`=199036 AND hpq_mem.`memno`=1";
          }; break;
          case '2':{
            $sql = "cp1";
            $sql1 = "UPDATE hpq_mem SET educind = ".$_POST['v1']." WHERE hpq_mem.`main.id`=69279 AND hpq_mem.`memno`=15";
             if ($paldetect===true && $mardetect===false && $comdetect===true)
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
        $sql1 = "UPDATE hpq_mem SET jobind = ".$_POST['v2']." WHERE hpq_mem.`main.id`=69279 AND hpq_mem.`memno`=15";
         if ($paldetect===false && $mardetect===true && $comdetect===true)
            $sql2 = "UPDATE hpq_mem SET jobind = ".$_POST['v2']." WHERE hpq_mem.`main.id`=69279 AND hpq_mem.`memno`=15";
        $sql1 = "UPDATE hpq_mem SET jobind = ".$_POST['v1']." WHERE hpq_mem.`main.id`=69279 AND hpq_mem.`memno`=15";
         if(($paldetect===true || $mardetect===true)&&$comdetect===true)
            $sql2 = "UPDATE hpq_mem SET jobind = ".$_POST['v1']." WHERE hpq_mem.`main.id`=69279 AND hpq_mem.`memno`=15";
         
      }  else if (isset($_POST['edit']) && $_POST['edit'] == 'Edit User Info 2' && isset($_POST['v2']) && $_SESSION['com']=='y' && isset($_POST['o2'])){//edit at combined
        switch($_POST['o2']){
          case '1':{
            $sql ="cm2";
            $sql1 = "UPDATE hpq_mem SET jobind =".$_POST['v2']." WHERE hpq_mem.`main.id`=199036 AND hpq_mem.`memno`=1";
             if ($paldetect===false && $mardetect===true && $comdetect===true)
                $sql2 = "UPDATE hpq_mem SET jobind =".$_POST['v2']." WHERE hpq_mem.`main.id`=199036 AND hpq_mem.`memno`=1";
          }; break;
          case '2':{
            $sql ="cp2";
            $sql1 = "UPDATE hpq_mem SET jobind = ".$_POST['v2']." WHERE hpq_mem.`main.id`=69279 AND hpq_mem.`memno`=15";
             if ($paldetect===true && $mardetect===false && $comdetect===true)
                $sql2 = "UPDATE hpq_mem SET jobind = ".$_POST['v2']." WHERE hpq_mem.`main.id`=69279 AND hpq_mem.`memno`=15";
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
        $sql1 = "UPDATE hpq_mem SET regvotind =".$_POST['v3']." WHERE hpq_mem.`main.id`=199036 AND hpq_mem.`memno`=1";
         if ($paldetect===false && $mardetect===true && $comdetect===true)
            $sql2 = "UPDATE hpq_mem SET regvotind =".$_POST['v3']." WHERE hpq_mem.`main.id`=199036 AND hpq_mem.`memno`=1";
         
      }  else if( isset($_POST['edit']) && $_POST['edit'] == 'Edit User Info 3' && $_SESSION['pal']=='y' && isset($_POST['v3'])){ //cp3 - edit regvotind at palawan
        $sql ="cp3";
        $sql1 = "UPDATE hpq_mem SET regvotind = ".$_POST['v3']." WHERE hpq_mem.`main.id`=69279 AND hpq_mem.`memno`=15";
         if ($paldetect===true && $mardetect===false && $comdetect===true)
            $sql2 = "UPDATE hpq_mem SET regvotind = ".$_POST['v3']." WHERE hpq_mem.`main.id`=69279 AND hpq_mem.`memno`=15";
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
            $sql1 = "UPDATE hpq_mem SET regvotind =".$_POST['v3']." WHERE hpq_mem.`main.id`=199036 AND hpq_mem.`memno`=1";
             if ($paldetect===false && $mardetect===true && $comdetect===true)
                $sql2 = "UPDATE hpq_mem SET regvotind =".$_POST['v3']." WHERE hpq_mem.`main.id`=199036 AND hpq_mem.`memno`=1";
          }; break;
          case '2':{
            $sql ="cp3";
            $sql1 = "UPDATE hpq_mem SET regvotind = ".$_POST['v3']." WHERE hpq_mem.`main.id`=69279 AND hpq_mem.`memno`=15";
             if ($paldetect===true && $mardetect===false && $comdetect===true)
                $sql2 = "UPDATE hpq_mem SET regvotind = ".$_POST['v3']." WHERE hpq_mem.`main.id`=69279 AND hpq_mem.`memno`=15";
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
      if($sql!=='v'){
        mysqli_autocommit($con1, TRUE);
        if($comdetect===true && $sql!=='v')
          mysqli_autocommit($com3, TRUE);
       //  if(($paldetect===true || $mardetect===true)&&$comdetect===true && $sql!=='v')
        // mysqli_autocommit($con2, TRUE);
      }
      // print_r($_SESSION);

      try{
          //read write, if you want to read only replace it with READ_ONLY
          if($sql!=='v'){
            mysqli_begin_transaction($con1, MYSQLI_TRANS_START_READ_WRITE);
            if(($paldetect===true || $mardetect===true)&&$comdetect===true && $sql!=='v')
              mysqli_begin_transaction($con2, MYSQLI_TRANS_START_READ_WRITE);
          }
          $editpal = false;
          $editmar = false;
          if($_POST['isol']!='n'){
            if($paldetect===true && $mardetect===true && $comdetect===true){
              if(mysqli_ping($con1))
                $db1query = mysqli_query($con1, $isolevel); //marinduque
              else {
                throw new Exception("query has not executed perfectly");
              }
              if(mysqli_ping($con2))
                $db2query = mysqli_query($con2, $isolevel); //palawan
              else{
                throw new Exception("query has not executed perfectly");
              }
              if(mysqli_ping($con3))
                $db3query = mysqli_query($con3, $isolevel); //combined
              else{
                throw new Exception("query has not executed perfectly");
              }
            } else if (($paldetect===false && $mardetect===true) ||
                 ($paldetect===true && $mardetect===false)
                 && $comdetect===true){
              if(mysqli_ping($con1))
                $db1query = mysqli_query($con1, $isolevel); //marinduque or palawan
              else{
                throw new Exception("query has not executed perfectly");
              }
              if(mysqli_ping($con2))
                $db2query = mysqli_query($con2, $isolevel); //combined
              else{
                throw new Exception("query has not executed perfectly");
              }
              } else {
                if(mysqli_ping($con1))
                  $db1query = mysqli_query($con1, $isolevel); //mar or pal or com
                else
                  throw new Exception("query has not executed perfectly");
            }
            // if(($paldetect===true || $mardetect===true)&&$comdetect===true)
            //   $db2query = mysqli_query($con2, $isolevel);
          } else ;

          if(isset($_POST['edit']) && $_POST['edit'] == 'Edit User Info 1' &&
            $_SESSION['com']=='y'){
              switch($_POST['o1']){
                case '1':{//marinduque
                  $db1query = mysqli_query($con1, $sql1);
                  $db2query = mysqli_query($con3, $sql2);
                  $editmar = true;
                }; break;
                case '2':{//palawan
                  $db1query = mysqli_query($con2, $sql1);
                  $db2query = mysqli_query($con3, $sql2);
                  $editpal = true;
                }; break; 
              }
          } else if(isset($_POST['edit']) && $_POST['edit'] == 'Edit User Info 2' &&
            $_SESSION['com']=='y'){
              switch($_POST['o2']){
                case '1':{//marinduque
                  $db1query = mysqli_query($con1, $sql1);
                  $db2query = mysqli_query($con3, $sql2);
                  $editmar = true;
                }; break;
                case '2':{//palawan
                  $db1query = mysqli_query($con2, $sql1);
                  $db2query = mysqli_query($con3, $sql2);
                  $editpal = true;
                }; break; 
              }
          } else if(isset($_POST['edit']) && $_POST['edit'] == 'Edit User Info 3' &&
            $_SESSION['com']=='y'){
              switch($_POST['o3']){
                case '1':{//marinduque
                  $db1query = mysqli_query($con1, $sql1);
                  $db2query = mysqli_query($con3, $sql2);
                  $editmar = true;
                }; break;
                case '2':{//palawan
                  $db1query = mysqli_query($con2, $sql1);
                  $db2query = mysqli_query($con3, $sql2);
                  $editpal = true;
                }; break; 
              }
          }else if($paldetect===false && $mardetect===true
                 && $comdetect===true){
            $db1query = mysqli_query($con1, $sql1);
            $db2query = mysqli_query($con3, $sql2);
            $editmar = true;
          }else if($paldetect===true && $mardetect===false
                 && $comdetect===true){
            $db1query = mysqli_query($con1, $sql1);
            $db2query = mysqli_query($con3, $sql2);
            $editpal = true;
          } else if(isset($_POST['queries']) && $_POST['queries']=='Submit Query 1' && ($paldetect===false &&
                 $mardetect===true &&
                  $comdetect===true)||
                ($paldetect===true &&
                  $mardetect===false &&
                   $comdetect===true)){
              $db1query = mysqli_query($con1, $sql1);
              $db2query = mysqli_query($con2, $sql1);
            
          } else if(isset($_POST['queries']) && $_POST['queries']=='Submit Query 1' && $paldetect===true && $mardetect===true
                 && $comdetect===true){
              $db1query = mysqli_query($con3, $sql1);
              $db2query = mysqli_query($con3, $sql1);
          }

          // $db1query = mysqli_query($con1,$sql1);
          // if(($paldetect===true || $mardetect===true)&&$comdetect===true)
          //   $db1query = mysqli_query($con2, $sql2);
          // else ;

          if ($sql==='v' && $db1query===true && $db2query===true){
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
          } else if ($editmar===true && $db1query===true && $db2query===true){
            echo "Marinduque edit complete.";
          } else if($editpal===true && $db1query===true && $db2query===true){
            echo "Palawan edit complete.";
          } else throw new Exception("query has not executed perfectly");
      
      /*else{
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

    } catch(Exception $e){
      echo $e->getMessage();
      if($e->getMessage()==='query has not executed perfectly'){
        mysqli_rollback($con1);
        if(($paldetect===true || $mardetect===true)&&$comdetect===true)
          mysqli_rollback($con2);
      }
      echo '<br>Please try again.<a href="home.php">Back</a>';
    }

    

      // print_r($_SESSION);

      // try{
          //read write, if you want to read only replace it with READ_ONLY
          /* if($sql!=='v'){
            mysqli_begin_transaction($con1, MYSQLI_TRANS_START_READ_WRITE);
            if(($paldetect===true || $mardetect===true)&&$comdetect===true && $sql!=='v')
              mysqli_begin_transaction($con2, MYSQLI_TRANS_START_READ_WRITE);
          } */
		  
		  

      // } catch (Exception $e){
        //rollback
        // echo "No changes have been made due to loss of connection between the communicating databases";
        // echo $e->getMessage();
        // exit;
      // }

   ?>
  </div>
  </center>
 </body>
</html>

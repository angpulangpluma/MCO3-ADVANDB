
<html>
 <body>
  <style>
   html {<!--overflow-y:hidden; overflow-x:hidden;-->}
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
  <title>
   GUTEN TAG!
  </title>
  <?php
   session_start();
   
   //Marinduque Information
   if(!isset($_POST['mar']) ||
    !isset($_POST['pal']) ||
    !isset($_POST['com'])){
      echo'select either palawan, marinduque or combined then fill out the necessary detail.<a href="login.html">Back</a>';
      exit;
   }
    else{
      if (isset($_POST["mar"])) $_SESSION["mar"] = "y";
   if (isset($_POST["mar"]) && $_POST["im"] != "") $_SESSION["im"] = $_POST["im"];
   else $_SESSION["mar"] = "n";
   if (isset($_POST["mar"]) && $_POST["um"] != "") $_SESSION["um"] = $_POST["um"];
   else $_SESSION["mar"] = "n";
   if (isset($_POST["mar"])) $_SESSION["pm"] = $_POST["pm"];
   
   //Palawan Information
   if (isset($_POST["pal"])) $_SESSION["pal"] = "y";
   if (isset($_POST["pal"]) && $_POST["ip"] != "") $_SESSION["ip"] = $_POST["ip"];
   else $_SESSION["pal"] = "n";
   if (isset($_POST["pal"]) && $_POST["up"] != "") $_SESSION["up"] = $_POST["up"];
   else $_SESSION["pal"] = "n";
   if (isset($_POST["pal"])) $_SESSION["pp"] = $_POST["pp"];
   
   //Combined Information
   if (isset($_POST["com"])) $_SESSION["com"] = "y";
   if (isset($_POST["com"]) && $_POST["ic"] != "") $_SESSION["ic"] = $_POST["ic"];
   else $_SESSION["com"] = "n";
   if (isset($_POST["com"]) && $_POST["uc"] != "") $_SESSION["uc"] = $_POST["uc"];
   else $_SESSION["com"] = "n";
   if (isset($_POST["com"])) $_SESSION["pc"] = $_POST["pc"];
    }

  ?>
  <div id="content" style="border:1px solid; background:white;">
   <p style="padding-top:25px;">
   <img src="pic/gt.png">
   <p style="padding-top:25px; padding-right:0px;">
   <b>!GAT NETUG</b></p>
   <form name="mahjong" action="results2.php" method="post">
    <?php
    // print_r($_POST);
    ?>
    <!-- <p style="padding-left:10px; padding-right:10px; text-align:left;">
    <b>Queries:</b></p> -->
    <p style="padding-left:30px; padding-right:10px; text-align:left;">
      ISOLATION LEVEL:
    <select name="isol">
      <option value='n'>AS IS</option>
      <option value='s'>SERIALIZABLE</option>
      <option value='rr'>REPEATABLE READ</option>
      <option value='rc'>READ COMMITTED</option>
      <option value='ru'>READ UNCOMMITTED</option>
    </select><br><br>
    <input style="padding-left:5px; height:25px;" name="queries" type="submit" value="Submit Query 1">Number of community members that are registered voters but are not studying and are unemployed
    <br><br>
    <!-- <input style="padding-left:5px; height:25px;" name="queries" type="submit" value="Submit Query 2">    <b>2.</b> Number of community members that are working students and are minor <br><br>
    <input style="padding-left:5px; height:25px;" name="queries" type="submit" value="Submit Query 3">    <b>3.</b> Number of deaths per municipality that were caused by common diseases <br><br>
    Show by...
    <select name="query3">
     <option value='m'>Municipality</option>
     <option value='b'>Barangay</option>
     <option value='p'>Purok</option>
    </select>
    <br><br>
    <input style="padding-left:5px; height:25px;" name="queries" type="submit" value="Submit Query 4">     <b>4.</b> Crimes that are being done to people per municipality <br><br>
    Show by...
    <select name="query4">
     <option value='m'>Municipality</option>
     <option value='b'>Barangay</option>
     <option value='p'>Purok</option>
    </select>
    <br><br>
    <input style="padding-left:5px; height:25px;" name="queries" type="submit" value="Submit Query 5">  <b>5.</b> Average number of crops harvested by people who work in the crop industry per municipality for the last 12 months <br><br>
    <input style="adding-left:5px; height:25px;" name="queries" type="submit" value="Submit Query 6">  <b>6.</b> Average number of seafood fished from the sea per municipality from the people in the crop industry for the last 12 months <br><br>
    <input style="padding-left:5px; height:25px;" name="queries" type="submit" value="Submit Query 7">  <b>7.</b> Income of the fishing, crop, and livestock industry per municipality with the average yield of crops and fish for the last 12 months <br><br> -->
    <input style="padding-left:5px; height:25px;" name="edit" type="submit" value="Edit User Info 1"><b>1.</b>Edit eduind:
    <select name="v1">
      <option value="1">1</option>
      <option value="2">2</option>
    </select><br><br>
    <input style="padding-left:5px; height:25px;" name="edit" type="submit" value="Edit User Info 2"><b>2.</b>Edit jobind: 
    <select name="v2">
      <option value="1">1</option>
      <option value="2">2</option>
    </select><br><br>
    <input style="padding-left:5px; height:25px;" name="edit" type="submit" value="Edit User Info 3"><b>3.</b>Edit regvotind: 
    <select name="v3">
      <option value="1">1</option>
      <option value="2">2</option>
    </select><br><br>
     </p>
    <!--<a style="color:gray;" href="terms.html"><i>Don't have an account? Click here!</i></a>-->
   </form>
  </div>
 </body>
</html>

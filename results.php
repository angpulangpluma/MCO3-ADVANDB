html>
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
                $con = mysqli_connect("25.36.228.32","root","","marinduque");
                session_start();
                
                //Tables used
                $fac = 0;
                $abt = 0;
                $eda = 0;
                $vot = 0;
                
                //Select variables
                //About
                $sex = '';
                $age = '';
                $edu = '';
                $job = '';
                $lit = '';
                
                //Education
                $grd = '';
                $sch = '';
                $yno = '';
                $yot = '';
                $eat = '';
                
                //Voters
                $reg = '';
                $las = '';
                
                //Where variables
                //About
                $wse = '';
                $ag1 = $_POST['ag1'];
                $ag2 = $_POST['ag2'];
                $wed = '';
                $wjo = '';
                $wli = '';
                
                //Education
                $wsc = '';
                $gr1 = $_POST['gr1'] - 1;
                $gr2 = $_POST['gr2'] + 1;
                $wyn = '';
                $ea1 = $_POST['ea1'] - 1;
                $ea2 = $_POST['ea2'] + 1;
                
                //Voters
                $wre = '';
                $wla = '';
                
                //Select variables
                if (isset($_POST['sex'])) {
                    $sex = 'sex';
                    $fac = 1;
                    $abt = 1;
                }
                if (isset($_POST['age'])) {
                    $age = 'age_yr';
                    $fac = 1;
                    $abt = 1;
                }
                if (isset($_POST['edu'])) {
                    $edu = 'educind';
                    $fac = 1;
                    $abt = 1;
                }
                if (isset($_POST['job'])) {
                    $job = 'jobind';
                    $fac = 1;
                    $abt = 1;
                }
                if (isset($_POST['lit'])) {
                    $lit = 'literind';
                    $fac = 1;
                    $abt = 1;
                }
                if (isset($_POST['grd'])) {
                    $grd = 'gradel';
                    $fac = 1;
                    $eda = 1;
                }
                if (isset($_POST['sch'])) {
                    $sch = 'sch_type';
                    $fac = 1;
                    $eda = 1;
                }
                if (isset($_POST['yno'])) {
                    $yno = 'ynotsch';
                    $fac = 1;
                    $eda = 1;
                }
                if (isset($_POST['yot'])) {
                    $yot = 'ynotsch_o';
                    $fac = 1;
                    $eda = 1;
                }
                if (isset($_POST['eat'])) {
                    $eat = 'educal';
                    $fac = 1;
                    $eda = 1;
                }
                if (isset($_POST['reg'])) {
                    $reg = 'regvotind';
                    $fac = 1;
                    $vot = 1;
                }
                if (isset($_POST['las'])) {
                    $las = 'voted_last_election';
                    $fac = 1;
                    $vot = 1;
                }
                
                //Where variables
                if ($_POST['wse'] == 'm') $wse = '1';
                else if ($_POST['wse'] == 'f') $wse = '2';
                
                if ($_POST['wed'] == 'i') $wed = '1';
                else if ($_POST['wed'] == 'o') $wed = '2';
                
                if ($_POST['wjo'] == 'i') $wjo = '1';
                else if ($_POST['wjo'] == 'o') $wjo = '2';
                
                if ($_POST['wli'] == 'i') $wli = '1';
                else if ($_POST['wli'] == 'o') $wli = '2';
                
                if ($_POST['wsc'] == 'i') $wli = '1';
                else if ($_POST['wsc'] == 'o') $wli = '2';
                
                if ($_POST['wyn'] != 'n') $wyn = $_POST['wyn'];
                
                if ($_POST['wre'] == 'i') $wre = '1';
                else if ($_POST['wre'] == 'o') $wre = '2';
                
                if ($_POST['wla'] == 'i') $wla = '1';
                else if ($_POST['wla'] == 'o') $wla = '2';
                else if ($_POST['wla'] == 'p') $wla = '3';
                
                //Query building (SELECT)
                $query = "SELECT ";
                $accept = 0;
                for ($i = 1; $i < 13; $i++) {
                    if ($i == 1) { 
                        if (!($sex == '')) {
                            $query .= 'sex';
                            $accept = 1;
                        }
                    }
                    else if ($i == 2) { 
                        if (!($age == '')) {
                            if ($accept == 1) {
                                $accept = 0;
                                $query .= ', ';
                            }
                            $query .= 'age_yr';
                            $accept = 1;
                        }
                    }
                    else if ($i == 3) { 
                        if (!($edu == '')) {
                            if ($accept == 1) {
                                $accept = 0;
                                $query .= ', ';
                            }
                            $query .= 'educind';
                            $accept = 1;
                        }
                    }
                    else if ($i == 4) { 
                        if (!($job == '')) {
                            if ($accept == 1) {
                                $accept = 0;
                                $query .= ', ';
                            }
                            $query .= 'jobind';
                            $accept = 1;
                        }
                    }
                    else if ($i == 5) { 
                        if (!($lit == '')) {
                            if ($accept == 1) {
                                $accept = 0;
                                $query .= ', ';
                            }
                            $query .= 'literind';
                            $accept = 1;
                        }
                    }
                    else if ($i == 6) { 
                        if (!($grd == '')) {
                            if ($accept == 1) {
                                $accept = 0;
                                $query .= ', ';
                            }
                            $query .= 'gradel';
                            $accept = 1;
                        }
                    }
                    else if ($i == 7) { 
                        if (!($sch == '')) {
                            if ($accept == 1) {
                                $accept = 0;
                                $query .= ', ';
                            }
                            $query .= 'sch_type';
                            $accept = 1;
                        }
                    }
                    else if ($i == 8) { 
                        if (!($yno == '')) {
                            if ($accept == 1) {
                                $accept = 0;
                                $query .= ', ';
                            }
                            $query .= 'ynotsch';
                            $accept = 1;
                        }
                    }
                    else if ($i == 9) { 
                        if (!($yot == '')) {
                            if ($accept == 1) {
                                $accept = 0;
                                $query .= ', ';
                            }
                            $query .= 'ynotsch_o';
                            $accept = 1;
                        }
                    }
                    else if ($i == 10) { 
                        if (!($eat == '')) {
                            if ($accept == 1) {
                                $accept = 0;
                                $query .= ', ';
                            }
                            $query .= 'educal';
                            $accept = 1;
                        }
                    }
                    else if ($i == 11) { 
                        if (!($reg == '')) {
                            if ($accept == 1) {
                                $accept = 0;
                                $query .= ', ';
                            }
                            $query .= 'regvotind';
                            $accept = 1;
                        }
                    }
                    else if ($i == 12) { 
                        if (!($las == '')) {
                            if ($accept == 1) {
                                $accept = 0;
                                $query .= ', ';
                            }
                            $query .= 'voted_last_election';
                            $accept = 1;
                        }
                    }
                }
                $query .= " FROM VoterFact";
                
                //Query building (FROM / JOIN)
                //$fac, $abt, $eda, $vot
                //VoterFact, dimAbout, dimEduc, dimVoter
                $tables = 0;
                if ($fac == 1 && $abt == 1) $query .= " INNER JOIN dimAbout ON VoterFact.aboutid = dimAbout.ID";
                if ($fac == 1 && $eda == 1) $query .= " INNER JOIN dimEduc ON VoterFact.educid = dimEduc.ID";
                if ($fac == 1 && $vot == 1) $query .= " INNER JOIN dimVoter ON VoterFact.voterid = dimVoter.ID";
                
                //Query building (WHERE)
                $where = 1;
                $accept = 0;
                for ($i = 1; $i < 12; $i++) {
                    if ($i == 1) {                    
                        if (!($wse == '')) {
                            if ($where == 1) {
                                $query .= " WHERE ";
                                $where = 0;
                            }
                            $query .= "sex = '" . $wse . "'";
                            $accept = 1;
                        }
                    }
                    else if ($i == 2) { 
                        if ($ag1 != '-1/-1/-1' || $ag2 != '-1/-1/-1') {
                            if ($where == 1) {
                                $query .= " WHERE ";
                                $where = 0;
                            }
                            if ($accept == 1) {
                                $accept = 0;
                                $query .= ' AND ';
                            }
                            $query .= "age_yr BETWEEN '" . $ag1 . "' AND '" . $ag2 . "'";
                            $accept = 1;
                        }
                    }
                    else if ($i == 3) { 
                        if (!($wed == '')) {
                            if ($where == 1) {
                                $query .= " WHERE ";
                                $where = 0;
                            }
                            if ($accept == 1) {
                                $accept = 0;
                                $query .= ' AND ';
                            }
                            $query .= "educind = '" . $wed . "'";
                            $accept = 1;
                        }
                    }
                    else if ($i == 4) { 
                        if (!($wjo == '')) {
                            if ($where == 1) {
                                $query .= " WHERE ";
                                $where = 0;
                            }
                            if ($accept == 1) {
                                $accept = 0;
                                $query .= ' AND ';
                            }
                            $query .= "jobind = '" . $wjo . "'";
                            $accept = 1;
                        }
                    }
                    else if ($i == 5) { 
                        if (!($wli == '')) {
                            if ($where == 1) {
                                $query .= " WHERE ";
                                $where = 0;
                            }
                            if ($accept == 1) {
                                $accept = 0;
                                $query .= ' AND ';
                            }
                            $query .= "literind = '" . $wli . "'";
                            $accept = 1;
                        }
                    }
                    else if ($i == 6) { 
                        if ($gr1 + 1 != -1 || $gr2 - 1 != -1) {
                            if ($where == 1) {
                                $query .= " WHERE ";
                                $where = 0;
                            }
                            if ($accept == 1) {
                                $accept = 0;
                                $query .= ' AND ';
                            }
                            $query .= "gradel BETWEEN '" . $gr1 ."' AND '" . $gr2 . "'";
                            $accept = 1;
                        }
                    }
                    else if ($i == 7) { 
                        if (!($wsc == '')) {
                            if ($where == 1) {
                                $query .= " WHERE ";
                                $where = 0;
                            }
                            if ($accept == 1) {
                                $accept = 0;
                                $query .= ' AND ';
                            }
                            $query .= "sch_type = '" . $wsc . "'";
                            $accept = 1;
                        }
                    }
                    else if ($i == 8) { 
                        if (!($wyn == '')) {
                            if ($where == 1) {
                                $query .= " WHERE ";
                                $where = 0;
                            }    
                            if ($accept == 1) {
                                $accept = 0;
                                $query .= ' AND ';
                            }
                            $query .= "ynotsch = '" . $wyn . "'";
                            $accept = 1;
                        }
                    }
                    else if ($i == 9) { 
                        if ($ea1 + 1 != -1 || $ea2 - 1 != -1) {
                            if ($where == 1) {
                                $query .= " WHERE ";
                                $where = 0;
                            }
                            if ($accept == 1) {
                                $accept = 0;
                                $query .= ' AND ';
                            }
                            $query .= "educal BETWEEN '" . $ea1 . "' AND '" . $ea2 . "'";
                            $accept = 1;
                        }
                    }
                    else if ($i == 10) { 
                        if (!($wre == '')) {
                            if ($where == 1) {
                                $query .= " WHERE ";
                                $where = 0;
                            }
                            if ($accept == 1) {
                                $accept = 0;
                                $query .= ' AND ';
                            }
                            $query .= "regvotind = '" . $wre . "'";
                            $accept = 1;
                        }
                    }
                    else if ($i == 11) { 
                        if (!($wla == '')) {
                            if ($where == 1) {
                                $query .= " WHERE ";
                                $where = 0;
                            }
                            if ($accept == 1) {
                                $accept = 0;
                                $query .= ', ';
                            }
                            $query .= "voted_last_election = '" . $wla . "'";
                            $accept = 1;
                        }
                    }
                }
                
                //Query building (GROUP BY)
                $group = 1;
                $accept = 0;
                for ($i = 1; $i < 12; $i++) {
                    if ($i == 1) {                    
                        if (!($sex == '')) {
                            if ($group == 1) {
                                $query .= " GROUP BY ";
                                $group = 0;
                            }
                            $query .= "sex";
                            $accept = 1;
                        }
                    }
                    else if ($i == 2) { 
                        if (!($age == '')) {
                            if ($group == 1) {
                                $query .= " GROUP BY ";
                                $group = 0;
                            }
                            if ($accept == 1) {
                                $accept = 0;
                                $query .= ', ';
                            }
                            $query .= "age_yr";
                            $accept = 1;
                        }
                    }
                    else if ($i == 3) { 
                        if (!($wed == '')) {
                            if ($group == 1) {
                                $query .= " GROUP BY ";
                                $group = 0;
                            }
                            if ($accept == 1) {
                                $accept = 0;
                                $query .= ', ';
                            }
                            $query .= "educind";
                            $accept = 1;
                        }
                    }
                    else if ($i == 4) { 
                        if (!($wjo == '')) {
                            if ($group == 1) {
                                $query .= " GROUP BY ";
                                $group = 0;
                            }
                            if ($accept == 1) {
                                $accept = 0;
                                $query .= ', ';
                            }
                            $query .= "jobind";
                            $accept = 1;
                        }
                    }
                    else if ($i == 5) { 
                        if (!($wli == '')) {
                            if ($group == 1) {
                                $query .= " GROUP BY ";
                                $group = 0;
                            }
                            if ($accept == 1) {
                                $accept = 0;
                                $query .= ', ';
                            }
                            $query .= "literind";
                            $accept = 1;
                        }
                    }
                    else if ($i == 6) { 
                        if ($gr1 + 1 != -1 || $gr2 - 1 != -1) {
                            if ($group == 1) {
                                $query .= " GROUP BY ";
                                $group = 0;
                            }
                            if ($accept == 1) {
                                $accept = 0;
                                $query .= ', ';
                            }
                            $query .= "gradel";
                            $accept = 1;
                        }
                    }
                    else if ($i == 7) { 
                        if (!($wsc == '')) {
                            if ($group == 1) {
                                $query .= " GROUP BY ";
                                $group = 0;
                            }
                            if ($accept == 1) {
                                $accept = 0;
                                $query .= ', ';
                            }
                            $query .= "sch_type";
                            $accept = 1;
                        }
                    }
                    else if ($i == 8) { 
                        if (!($wyn == '')) {
                            if ($group == 1) {
                                $query .= " GROUP BY ";
                                $group = 0;
                            }    
                            if ($accept == 1) {
                                $accept = 0;
                                $query .= ', ';
                            }
                            $query .= "ynotsch";
                            $accept = 1;
                        }
                    }
                    else if ($i == 9) { 
                        if ($ea1 + 1 != -1 || $ea2 - 1 != -1) {
                            if ($group == 1) {
                                $query .= " GROUP BY ";
                                $group = 0;
                            }
                            if ($accept == 1) {
                                $accept = 0;
                                $query .= ', ';
                            }
                            $query .= "educal";
                            $accept = 1;
                        }
                    }
                    else if ($i == 10) { 
                        if (!($wre == '')) {
                            if ($group == 1) {
                                $query .= " GROUP BY ";
                                $group = 0;
                            }
                            if ($accept == 1) {
                                $accept = 0;
                                $query .= ', ';
                            }
                            $query .= "regvotind";
                            $accept = 1;
                        }
                    }
                    else if ($i == 11) { 
                        if (!($wla == '')) {
                            if ($group == 1) {
                                $query .= " GROUP BY ";
                                $group = 0;
                            }
                            if ($accept == 1) {
                                $accept = 0;
                                $query .= ', ';
                            }
                            $query .= "voted_last_election";
                            $accept = 1;
                        }
                    }
                }
                echo '<b>' . $query . '</b>';
                
                if ($group == 0 && ($_POST['query'] == 'r' || $_POST['query'] == 'dr') && (($gr1 + 1 != -1 || $gr2 - 1 != -1) XOR ($ea1 + 1 != -1 || $ea2 - 1 != -1))) $query .= " WITH ROLL UP";
                //else if ($group == 0 && $_POST['query'] == 'dr') $query .= " WITH ROLL UP";
                
                //Execution time in milliseconds
                $exec = microtime(true);
                mysqli_query($con, $query);
                $exec = microtime(true)-$exec;
                echo 'Execution Time: ' . ($exec * 1000) . ' ms';
                
                $result = mysqli_query($con, $query) or die(mysqli_error());
                
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
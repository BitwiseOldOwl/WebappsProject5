<!-- index.php -->
<html>
    <head>
        <title>
            RatVan PCA
        </title>
        <link rel="stylesheet" type="text/css" href="css/styles.css">
    </head>
    <body bgcolor="#445577">
        <div class="centerContent">
        <?php
            // which project to view voting results from
            $whichProject = 1; 

            // connect to database
            $db = mysqli_connect("james.cedarville.edu","cs3220","","cs3220")
                or die("Error: unable to connect to database");

            /*
            // query for list of student login names and student IDs
            $query = "SELECT student_id, login_name
                      FROM RatVan_PCA_Student;";
            $login_name_and_id = mysqli_query($db, $query)
                or die("Error: unsuccessful query");
            */
 
            // query for list of awards to display in the main table
            $query = "SELECT q1.team_id, team_members, vote_count FROM
                        (SELECT team_id, SUM(vote_value) as vote_count
                        FROM RatVan_PCA_Vote
                        WHERE project_id=$whichProject
                        GROUP BY team_id)
                          as q1,
                        (SELECT team_id, GROUP_CONCAT(login_name SEPARATOR ', ') as team_members
                        FROM RatVan_PCA_StudentTeam as StudentTeam, RatVan_PCA_Student as Student
                        WHERE StudentTeam.student_id = Student.student_id
                          AND team_id in (SELECT team_id
                                          FROM RatVan_PCA_Team
                                          WHERE project_id=$whichProject)
                        GROUP BY team_id)
                          as q2
                      WHERE q1.team_id=q2.team_id;";
            $votingResults = mysqli_query($db, $query)
                or die("Error: unsuccessful query");

            // close database connection
            mysqli_close($db);

            // process the results of the 'awards' database query and populate
            // a multidimensional array which represents the awards that should
            // be shown in the main table on this page
            for($rowNum = 0; $rowNum < mysqli_num_rows($awards); $rowNum++) {
                $row = mysqli_fetch_assoc($awards);
                $awardTable[$row["student_id"]][$row["project_id"]] = $row["award_type"];
            }

            ////
            //// Start of content
            ////
            print "<h1>People's Choice Awards</h1>";
            print "<h3>
                <a href=\"http://judah.cedarville.edu/~ratkey/WebappsProject5/index.php\">HOME</a>
                &nbsp;|&nbsp;
                <a href=\"http://judah.cedarville.edu/~ratkey/WebappsProject5/voting.php\">VOTING</a>
                &nbsp;|&nbsp;
                <a href=\"http://judah.cedarville.edu/~ratkey/WebappsProject5/results.php\">RESULTS</a>
                &nbsp;|&nbsp;
                <a href=\"http://judah.cedarville.edu/~ratkey/WebappsProject5/admin.php\">ADMIN</a>
                    </h3>";

            // login form
            print " <form action=\"http://judah.cedarville.edu/~ratkey/WebappsProject5/index.php\"
                          method=\"GET\">
                        <strong>Login:&nbsp;&nbsp;</strong>
                        <select name=\"username\">";
            for($rowNum = 0; $rowNum < mysqli_num_rows($login_names); $rowNum++) {
                $row = mysqli_fetch_assoc($login_names);
                print "<option value=\"";
                print $row["login_name"];
                print "\">";
                print $row["login_name"];
                print "</option>";
            }
            print "     </select>
                        <input type=\"password\" 
                               name=\"password\" 
                               value=\"\" 
                               size=\"12\">
                        <input type=\"SUBMIT\" value=\"Submit\" />
                    </form>";


            // table header row
            print " <table>
                        <tr>
                            <th></th>
                            <th>Project 1</th>
                            <th>Project 2</th>
                            <th>Project 3</th>
                            <th>Project 4</th>
                            <th>Project 5</th>
                            <th>Project 6</th>
                            <th>Project 7</th>
                        </tr>";

            for($rowNum = 0; $rowNum < mysqli_num_rows($login_name_and_id); $rowNum++) {
                $row = mysqli_fetch_assoc($login_name_and_id);
                print "<tr>";
                print "<td>";
                print htmlspecialchars($row["login_name"]);
                print "</td>";
                for($colNum = 1; $colNum < 8; $colNum++) {
                    print "<td>";
                    print $awardTable[$row["student_id"]][$colNum];
                    print "</td>";
                }
                print "</tr>";
            }

            print "</table>";

        ?>
        </div>
    </body>
</html>


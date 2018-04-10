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
            // connect to database
            $db = mysqli_connect("james.cedarville.edu","cs3220","","cs3220")
                or die("Error: unable to connect to database");

            // query for list of student login names and student IDs
            $query = "SELECT student_id, login_name
                      FROM RatVan_PCA_Student;";
            $login_name_and_id = mysqli_query($db, $query)
                or die("Error: unsuccessful query");
 
            // query for list of awards to display in the main table
            $query = "SELECT project_id, award_type, 
                             Student.student_id AS student_id, login_name
                      FROM RatVan_PCA_Award AS Award,
                           RatVan_PCA_StudentTeam AS StudentTeam,
                           RatVan_PCA_Student AS Student
                      WHERE Award.team_id = StudentTeam.team_id
                        AND StudentTeam.student_id = Student.student_id;";
            $awards = mysqli_query($db, $query)
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


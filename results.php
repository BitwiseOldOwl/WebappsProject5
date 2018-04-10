<!-- results.php -->
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
            //$whichProject = 1; 
            if (isset($_GET['projectNum'])) {
                $whichProject = filter_input(INPUT_GET,"projectNum",FILTER_SANITIZE_STRING);
            } else {
                $whichProject = 1;
            }

            // connect to database
            $db = mysqli_connect("james.cedarville.edu","cs3220","","cs3220")
                or die("Error: unable to connect to database");

            // query to get list of projects that are closed or open
            $query = "SELECT *
                      FROM RatVan_PCA_Project
                      WHERE status IN ('closed','open');";
            $listOfProjects = mysqli_query($db, $query)
                or die("Error: unsuccessful query");
 
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

            // project selection form
            print " <form action=\"http://judah.cedarville.edu/~ratkey/WebappsProject5/results.php\"
                          method=\"GET\">
                        <strong>View results for project:&nbsp;&nbsp;</strong>
                        <select name=\"projectNum\">";
            for($rowNum = 0; $rowNum < mysqli_num_rows($listOfProjects); $rowNum++) {
                $row = mysqli_fetch_assoc($listOfProjects);
                print "<option value=\"";
                print htmlspecialchars($row["project_id"]);
                print "\">";
                print htmlspecialchars($row["project_id"]);
                print "</option>";
            }
            print "    <input type=\"SUBMIT\" value=\"View\" />
                    </form>";


            print "<h2>Project $whichProject - Voting Results</h2>";

            // table header row
            print " <table>
                        <tr>
                            <th>Team Members</th>
                            <th>Votes</th>
                            <th>Total Votes Comparison</th>
                        </tr>";

            for($rowNum = 0; $rowNum < mysqli_num_rows($votingResults); $rowNum++) {
                $row = mysqli_fetch_assoc($votingResults);
                print "<tr>";
                print "<td>";
                print htmlspecialchars($row["team_members"]);
                print "</td>
                       <td>";
                print htmlspecialchars($row["vote_count"]);
                print "</td>
                       <td>";
                for($i = 0; $i < $row["vote_count"]; $i++) {
                    print "&#9606;";
                }
                print "&nbsp;&nbsp;&nbsp;&nbsp;";
                print "</td>";
                print "</tr>";
            }

            print "</table>";

        ?>
        </div>
    </body>
</html>


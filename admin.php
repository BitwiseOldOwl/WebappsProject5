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
            // Get variables
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
                      FROM RatVan_PCA_Project;";
            $listOfProjects = mysqli_query($db, $query)
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

            print "<br><h2>Administrator Options</h2><br>";

            // project selection form
            print "<h3>Open/Close Projects</h3>";
            print " <form action=\"http://judah.cedarville.edu/~ratkey/WebappsProject5/admin.php\"
                          method=\"GET\">
                        <strong>Project:&nbsp;</strong>
                        <select name=\"projectNum\">";
            for($rowNum = 0; $rowNum < mysqli_num_rows($listOfProjects); $rowNum++) {
                $row = mysqli_fetch_assoc($listOfProjects);
                print "<option value=\"";
                print htmlspecialchars($row["project_id"]);
                print "\">";
                print htmlspecialchars($row["project_id"]);
                print "</option>";
            }
            print "     </select>
                        <br><br>
                        <strong>Status:&nbsp;</strong>
                        <select name=\"setStatus\">
                            <option value=\"closed\">closed</option>
                            <option value=\"open\">open</option>
                            <option value=\"new\">new</option>
                        </select>
                        <br><br>";
            print "    <input type=\"SUBMIT\" value=\"Set Status\" />
                    </form>";

        ?>
        </div>
    </body>
</html>


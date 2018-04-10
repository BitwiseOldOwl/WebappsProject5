<!-- voting.php -->
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
            /*
            // connect to database
            $db = mysqli_connect("james.cedarville.edu","cs3220","","cs3220")
                or die("Error: unable to connect to database");

            // query to get list of projects that are closed or open
            $query = "SELECT *
                      FROM RatVan_PCA_Project
                      WHERE status IN ('closed','open');";
            $listOfProjects = mysqli_query($db, $query)
                or die("Error: unsuccessful query");

            // close database connection
            mysqli_close($db);
            */

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

            print "<br><br><h2>Voting Page</h2><br><br><br>";
        ?>
        </div>
    </body>
</html>


<!-- index.php -->
<html>
    <head>
        <title>
            RatVan PCA
        </title>
    </head>
    <body>
        <?php
            print "<h1>People's Choice Awards</h1><br>";

            $db = mysqli_connect("james.cedarville.edu","cs3220","","cs3220")
                or die("Error: unable to connect to database");

            $query = "SELECT login_name FROM RatVan_PCA_Student;";
            $login_names = mysqli_query($db, $query)
                or die("Error: unsuccessful query");
 
            mysqli_close($db);

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

            for($rowNum = 0; $rowNum < mysqli_num_rows($login_names); $rowNum++) {
                $row = mysqli_fetch_assoc($login_names);
                print "<tr>";
                print "<td>";
                print htmlspecialchars($row["login_name"]);
                print "</td>";
                print "</tr>";
            }

            print "</table>";

        ?>
    </body>
</html>


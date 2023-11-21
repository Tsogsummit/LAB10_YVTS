<html>
<head>
    <title>Search Data</title>
</head>
<body>
    <h1>Search Data</h1>
    <form action="searchdata.php" method="post">
        <input type="text" name="search" placeholder="Search">
        <input type="submit" value="Search">
    </form>
    <?php
        $conn = mysqli_connect("localhost", "root", "", "HouseholdDatabase");
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        if (isset($_POST['search'])) {
            $searchq = $_POST['search'];
            // Sanitize the input to prevent SQL injection
            $searchq = mysqli_real_escape_string($conn, $searchq);
            $searchq = preg_replace("/[^\w\s'-]/", "", $searchq);
            
            $query = mysqli_query($conn, "SELECT * FROM data WHERE name LIKE '%$searchq%'") or die("Could not search!");

            $count = mysqli_num_rows($query);
            printf("count: %d\n", $count);
            if ($count == 0) {
                $output = "There were no search results!";
            } else {
                while ($row = mysqli_fetch_array($query)) {
                    $name = htmlspecialchars($row['name']); // Sanitize output to prevent XSS
                    $email = htmlspecialchars($row['email']); // Sanitize output to prevent XSS
                    $output .= '<div>' . $name . ' ' . $email . '</div>';
                }
            }
        }
        error_reporting(E_ALL);
        ini_set('display_errors', '1');
    ?>
</body>
</html>

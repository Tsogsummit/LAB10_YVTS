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
        error_reporting(E_ALL);
        ini_set('display_errors', '1');

        $conn = mysqli_connect("localhost", "root", "", "HouseholdDatabase");
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        if (isset($_POST['search'])) {
            $searchq = $_POST['search'];
            $searchq = mysqli_real_escape_string($conn, $searchq);
            $searchq = preg_replace("/[^\w\s'-]/", "", $searchq);

            echo "Sanitized Search Query: $searchq<br>";


            $query = mysqli_query($conn, "
                SELECT Users.user_name, Items.item_name, ItemUsage.quantity
                FROM ItemUsage
                JOIN Users ON ItemUsage.user_id = Users.user_id
                JOIN Items ON ItemUsage.item_id = Items.item_id
                WHERE Users.user_name LIKE '%$searchq%'
                OR Items.item_name LIKE '%$searchq%'
                OR ItemUsage.quantity LIKE '%$searchq%'
            ") or die(mysqli_error($conn));

            $output = '';


            while ($row = mysqli_fetch_array($query)) {
                $user_name = htmlspecialchars($row['user_name']);
                $item_name = htmlspecialchars($row['item_name']);
                $quantity = htmlspecialchars($row['quantity']);

                $output .= '<div>User: ' . $user_name . ' | Item: ' . $item_name . ' | Quantity: ' . $quantity . '</div>';
            }


            echo $output;
        }
?>



</body>
</html>

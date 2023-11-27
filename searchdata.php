<?php
    if( $_SERVER['REQUEST_METHOD'] == 'GET'){
        error_reporting(E_ALL);
        ini_set('display_errors', '1');

        $conn = mysqli_connect("localhost", "root", "", "HouseholdDatabase");
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        
        $search = $_GET['search'];
        if (!empty($search)) {
            $searchq = $search;
            $searchq = mysqli_real_escape_string($conn, $searchq);
            $searchq = preg_replace("/[^\w\s'-]/", "", $searchq);

            echo "Sanitized Search Query: $searchq<br>";


            $query = mysqli_query($conn, "
                SELECT Users.user_id, Items.item_id
                FROM ItemUsage
                JOIN Users ON ItemUsage.user_id = Users.user_id
                JOIN Items ON ItemUsage.item_id = Items.item_id
                WHERE Users.user_name LIKE '%$searchq%'
                OR Items.item_name LIKE '%$searchq%'
            ") or die(mysqli_error($conn));

            $output = '';


            while ($row = mysqli_fetch_array($query)) {
                $user_id = htmlspecialchars($row['user_id']);
                $item_id = htmlspecialchars($row['item_id']);
                $output .= '<div>User: ' . $user_id . ' | Item: ' . $item_id . '</div>';
                $output .= '<button onclick="loadXMLDocDetail()">Details</button>';

            }
            
            echo $output;
        }
    }
?>

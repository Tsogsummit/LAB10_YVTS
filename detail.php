<?php
    if( $_SERVER['REQUEST_METHOD'] == 'GET'){
        error_reporting(E_ALL);
        ini_set('display_errors', '1');

        $conn = mysqli_connect("localhost", "root", "", "HouseholdDatabase");
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        
        $original = $_GET['id'];
        $table = $_GET['table'];
        $search = ucwords($original);
        if (!empty($search)) {
            $searchq = $search;
            $searchq = mysqli_real_escape_string($conn, $searchq);
            $searchq = preg_replace("/[^\w\s'-]/", "", $searchq);

            echo "Sanitized Search Query: $searchq<br>";

            if($table == "users")
                $query = mysqli_query($conn, "
                    SELECT *
                    FROM ItemUsage
                    WHERE user_id LIKE '%$searchq%'
                ") or die(mysqli_error($conn));
            else 
                $query = mysqli_query($conn, "
                    SELECT *
                    FROM ItemUsage
                    WHERE item_id LIKE '%$searchq%'
                ") or die(mysqli_error($conn));

            $output = '';


            while ($row = mysqli_fetch_array($query)) {
                if($table == "users"){
                    $output .= '<div id="usage_id">' . htmlspecialchars($row['usage_id']) . '</div>';
                    $item_id = htmlspecialchars($row['item_id']);
                    $query1 = mysqli_query($conn, "
                        SELECT *
                        FROM Items
                        WHERE item_id LIKE '%$item_id%'
                    ") or die(mysqli_error($conn));
                    $row1 = mysqli_fetch_array($query1);
                    $output .= '<div>' . htmlspecialchars($row1['item_name']) . '</div>';
                    $output .= '<div>' . htmlspecialchars($row['quantity']) . '</div>';
                }
                else{
                    $output .= '<div id="usage_id">' . htmlspecialchars($row['usage_id']) . '</div>';
                    $user_id = htmlspecialchars($row['user_id']);
                    $query1 = mysqli_query($conn, "
                        SELECT *
                        FROM Users
                        WHERE user_id LIKE '%$user_id%'
                    ") or die(mysqli_error($conn));
                    $row1 = mysqli_fetch_array($query1);
                    $output .= '<div>' . htmlspecialchars($row1['user_name']) . '</div>';
                    $output .= '<div>' . htmlspecialchars($row['quantity']) . '</div>';
                } 


            }
            
            echo $output;
        }
    }
?>

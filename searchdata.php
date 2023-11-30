<?php
    if( $_SERVER['REQUEST_METHOD'] == 'GET'){
        error_reporting(E_ALL);
        ini_set('display_errors', '1');

        $conn = mysqli_connect("localhost", "root", "", "HouseholdDatabase");
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        
        $original = $_GET['search'];
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
                    FROM $table
                    WHERE user_name LIKE '%$searchq%'
                ") or die(mysqli_error($conn));
            else 
                $query = mysqli_query($conn, "
                    SELECT *
                    FROM $table
                    WHERE item_name LIKE '%$searchq%'
                ") or die(mysqli_error($conn));

            $output = '';

            $output .= '<div id="table_id">' . $table . '</div>';

            while ($row = mysqli_fetch_array($query)) {
                if($table == "users"){
                    $output .= '<div id="id_res">' . htmlspecialchars($row['user_id']) . '</div>';
                    $output .= '<div>' . htmlspecialchars($row['user_name']) . '</div>';
                    $output .= '<div id="res_cont"> <span id="res"> </span> </div>';
                    $output .= '<button onclick="loadXMLDocDetail(' . htmlspecialchars($row['user_id']) . ', 1' . ')">Details</button>';
                }
                else{
                    $output .= '<div id="id_res">' . htmlspecialchars($row['item_id']) . '</div>';
                    $output .= '<div>' . htmlspecialchars($row['item_name']) . '</div>';
                    $output .= '<div id="res_cont"> <span id="res"> </span> </div>';
                    $output .= '<button onclick="loadXMLDocDetail(' . htmlspecialchars($row['item_id']) . ', 2' . ')">Details</button>';
                } 

            }
            
            echo $output;
        }
    }
?>

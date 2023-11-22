<html>
    <head>
        <title>Detail</title>
    </head>
    <body>
        <form action="detail.php" method="post">
            <input type="text" name="table" placeholder="Table name">
            <input type="number" name="row_id" placeholder="Row Id">
            <input type="submit" value="result">
        </form>

        <?php
        error_reporting(E_ALL);
        ini_set('display_errors', '1');

        $conn = mysqli_connect("localhost", "root", "", "HouseholdDatabase");
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        if (isset($_POST['table']) && isset($_POST['row_id'])) {
            $table = $_POST['table'];
            $row_id = $_POST['row_id'];
            if($table == "Items") $id = "item_id"; 
            else if($table == "Users"){
                $id = "user_id";
                $row_id += 100;
            }
            else if($table == "ItemUsage") {
                $id = "usage_id";
                $row_id += 1000;
            }
            else die("Invalid table name");

            $query = mysqli_query($conn, "
                SELECT *
                FROM $table
                WHERE $id = $row_id") or die(mysqli_error($conn));

            $output = '';
            // want every data to be displayed
            while ($row = mysqli_fetch_array($query)) {
                $output .= '<div>';
                foreach($row as $key => $value) {
                    $output .= $key . ': ' . $value . '<br>';
                }
                $output .= '</div>';
            }
            echo $output;
        }
        ?>



    </body>
</html>

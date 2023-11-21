<?php

        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "HouseholdDatabase";

        try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }

        function fetchDataAsArray($conn, $tableName) {
            $stmt = $conn->prepare("SELECT * FROM $tableName");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        $tables = ['Items', 'Users', 'ItemUsage'];

        $data = [];

        foreach ($tables as $table) {
            $data[$table] = fetchDataAsArray($conn, $table);
        }

        $jsonData = json_encode($data, JSON_PRETTY_PRINT);

        header('Content-Type: application/json');
        echo $jsonData;

        $conn = null;
        ?>
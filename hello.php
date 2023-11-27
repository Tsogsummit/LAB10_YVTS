<?php if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $fahrenheit = $_GET['fahrenheit'];
    $celsius = (($fahrenheit - 32) * 5) / 9;
    printf('%.2f', $celsius);
} 
?>
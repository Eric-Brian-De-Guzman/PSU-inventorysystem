<?php
// Replace these with your actual database credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "inventory_system";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch sales data from the database
function join_sales_table($conn) {
    $query = "
        SELECT s.id AS ID, p.name as Product_Name, v.vendor_name as Vendor, s.qty AS Quantity, s.price as Price, s.price*s.qty as Total, s.remarks as Remarks, s.date
        FROM sales s
        INNER JOIN products p ON p.id = s.id
        INNER JOIN vendor v ON v.id = s.vendor_id
        ORDER BY s.id ASC
    ";

    $result = $conn->query($query);

    $sales_data = [];
    while ($row = $result->fetch_assoc()) {
        $sales_data[] = $row;
    }

    return $sales_data;
}

$sales = join_sales_table($conn);

// Close the database connection
$conn->close();
// Filter Data
function filterData(&$str) {
    $str = preg_replace("/\t/", "\\t", $str);
    $str = preg_replace("/\r?\n/", "\\n", $str);
    if (strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
}

// File Name & Content Header For Download
$file_name = "sales_data.xls";
header("Content-Disposition: attachment; filename=\"$file_name\"");
header("Content-Type: application/vnd.ms-excel");

// To define column name in the first row.
$column_names = false;
// Run loop through each row in $sales
foreach ($sales as $row) {
    if (!$column_names) {
        echo implode("\t", array_keys($row)) . "\n";
        $column_names = true;
    }
    array_walk($row, 'filterData');
    echo implode("\t", array_values($row)) . "\n";
}
exit;
?>
<?php
require '../InventorySystem_PHP/PhpSpreadsheet-master/src/PhpSpreadsheet/Spreadsheet.php';
require '../InventorySystem_PHP/PhpSpreadsheet-master/src/PhpSpreadsheet/Writer/Xlsx.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "inventory_system";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$query = "
    SELECT s.id AS ID, p.name as Product_Name, v.vendor_name as Vendor, s.qty AS Quantity, s.price as Price, s.price*s.qty as Total, s.remarks as Remarks, s.date
    FROM sales s
    INNER JOIN products p ON p.id = s.product_id
    INNER JOIN vendor v ON v.id = s.vendor_id
    ORDER BY s.id ASC
";

$result = $conn->query($query);

$rowCount = 1;
while ($row = $result->fetch_assoc()) {
    $objPHPExcel->getActiveSheet()->setCellValue('A'.$rowCount, $row['Product_Name']);
    $objPHPExcel->getActiveSheet()->setCellValue('B'.$rowCount, $row['Quantity']);
    $objPHPExcel->getActiveSheet()->setCellValue('C'.$rowCount, $row['Price']);
    $objPHPExcel->getActiveSheet()->setCellValue('D'.$rowCount, $row['Total']);
    $objPHPExcel->getActiveSheet()->setCellValue('E'.$rowCount, $row['Vendor']);
    $objPHPExcel->getActiveSheet()->setCellValue('F'.$rowCount, $row['Remarks']);
    $objPHPExcel->getActiveSheet()->setCellValue('G'.$rowCount, $row['date']);
    $rowCount++;
}

$conn-> close();

$objWriter = new Xlsx($objPHPExcel);
$objWriter->save('some_excel_file.xlsx');
?>
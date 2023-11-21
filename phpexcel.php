<?php
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "inventory_system";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$spreadsheet = new Spreadsheet;

$firstSheet = $spreadsheet->getActiveSheet();
$firstSheet->setTitle('Overall Summary');

// Set column headers for the first sheet
$firstSheetHeaders = ['Category ID', 'Category Name', 'Total Sales'];
$firstSheet->fromArray([$firstSheetHeaders], null, 'A1');

// Fetch overall summary data for all categories
$sql = "SELECT 
    c.id AS CategoryID,
    c.name AS CategoryName,
    SUM(s.qty * s.price) AS TotalSales
FROM 
    sales s
RIGHT JOIN 
    categories c ON c.id = s.category_id
GROUP BY 
    c.id, c.name";

// Use the connection variable you've already created
$categoryResult = $conn->query($sql);
$categorySummaries = $categoryResult->fetch_all(MYSQLI_ASSOC);

// Add overall summary rows to the first sheet
$row = 2;
foreach ($categorySummaries as $categorySummary) {
    $firstSheet->fromArray([$categorySummary['CategoryID'], $categorySummary['CategoryName'], $categorySummary['TotalSales']], null, 'A' . $row);
    $row++;
}

// Reset the pointer to the beginning of the result set
$categoryResult->data_seek(0);

while ($category = $categoryResult->fetch_assoc()) {
    $categoryId = $category['CategoryID'];
    $categoryName = $category['CategoryName'];

    // Create a sheet for each category
    $sheet = $spreadsheet->createSheet();
    $sheet->setTitle($categoryName);

    // Query to retrieve sales data for each category
    $salesQuery = "
        SELECT v.vendor_name as Vendor, s.id AS ID, p.name as Product_Name, s.qty AS Quantity, s.price as Price, s.price * s.qty as Total, s.remarks as Remarks, s.date
        FROM vendor v
        RIGHT JOIN sales s ON v.id = s.vendor_id
        RIGHT JOIN products p ON p.id = s.product_id
        WHERE s.category_id = $categoryId
        ORDER BY v.vendor_name ASC, MONTH(s.date), p.name ASC, s.id ASC
    ";

    $salesResult = $conn->query($salesQuery);

    $rowCount = 1;
    $currentVendor = null;
    $currentMonth = null;

    while ($row = $salesResult->fetch_assoc()) {
        $saleMonth = date('F Y', strtotime($row['date']));

        if ($row['Vendor'] != $currentVendor || $saleMonth != $currentMonth) {
            $currentVendor = $row['Vendor'];
            $currentMonth = $saleMonth;

            $sheet->mergeCells('A'.$rowCount.':F'.$rowCount);
            $style = $sheet->getStyle('A');
            $alignment = $style->getAlignment();
            $alignment->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->setCellValue('A'.$rowCount, $row['Vendor'] . ' - ' . $saleMonth);
            $rowCount++;

            // Add headers
            $sheet->setCellValue('A'.$rowCount, 'Product_Name');
            $sheet->setCellValue('B'.$rowCount, 'Quantity');
            $sheet->setCellValue('C'.$rowCount, 'Price');
            $sheet->setCellValue('D'.$rowCount, 'Total');
            $sheet->setCellValue('E'.$rowCount, 'Remarks');
            $sheet->setCellValue('F'.$rowCount, 'Date');
            $rowCount++;
        }

        $sheet->setCellValue('A'.$rowCount, $row['Product_Name']);
        $sheet->setCellValue('B'.$rowCount, $row['Quantity']);
        $sheet->setCellValue('C'.$rowCount, $row['Price']);
        $sheet->setCellValue('D'.$rowCount, $row['Total']);
        $sheet->setCellValue('E'.$rowCount, $row['Remarks']);
        $sheet->setCellValue('F'.$rowCount, $row['date']);
        $rowCount++;
    }
}

$timestamp = date('Ymd_His');
$filename = 'sales_' . $timestamp . '.xlsx';
$objWriter = new Xlsx($spreadsheet);
$objWriter->save($filename);

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');

header('Location: sales.php');
exit;
?>
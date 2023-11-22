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
$totalOverallSales = 0; // Initialize a variable to store the grand total

foreach ($categorySummaries as $categorySummary) {
    $firstSheet->fromArray([$categorySummary['CategoryID'], $categorySummary['CategoryName'], $categorySummary['TotalSales']], null, 'A' . $row);
    $totalOverallSales += $categorySummary['TotalSales']; // Accumulate the total sales
    $row++;
}

// Display the grand total in a designated cell
$grandTotalRow = $row + 1; // Adjust the row to leave space for headers
$firstSheet->setCellValue('A' . $grandTotalRow, 'Grand Total');
$firstSheet->setCellValue('C' . $grandTotalRow, $totalOverallSales);

// Reset the pointer to the beginning of the result set
$categoryResult->data_seek(0);

while ($category = $categoryResult->fetch_assoc()) {
    $categoryId = $category['CategoryID'];
    $categoryName = $category['CategoryName'];

    // Create a sheet for each category
    $sheet = $spreadsheet->createSheet();
    $sheet->setTitle($categoryName);

    // Fetch stock data for the current category
    $stockQuery = "SELECT p.stock_code, s.product_id, s.category_id, c.name, s.quantity, s.date 
        FROM stocks s
        LEFT JOIN products p ON p.id = s.product_id
        LEFT JOIN categories c ON c.id = s.category_id
        WHERE c.id = $categoryId";

    $stockResult = $conn->query($stockQuery);
    $stockData = $stockResult->fetch_all(MYSQLI_ASSOC);

    // Set column headers for the stock sheet
    $stockSheetHeaders = ['Stock ID', 'Product ID', 'Category ID', 'Category Name', 'Quantity', 'Date'];
    $sheet->fromArray([$stockSheetHeaders], null, 'A1');

    // Add stock data rows to the stock sheet
    $stockRow = 2;
    foreach ($stockData as $stock) {
        $sheet->fromArray([$stock['stock_code'], $stock['product_id'], $stock['category_id'], $stock['name'], $stock['quantity'], $stock['date']], null, 'A' . $stockRow);
        $stockRow++;
    }

    // Query to retrieve sales data for each category
    $salesQuery = "
        SELECT v.vendor_name as Vendor, s.id AS ID, p.name as Product_Name, s.qty AS Quantity, s.price as Price, s.price * s.qty as Total, s.remarks as Remarks, s.date
        FROM vendor v
        LEFT JOIN sales s ON v.id = s.vendor_id
        LEFT JOIN products p ON p.id = s.product_id
        WHERE s.category_id = $categoryId
        ORDER BY MONTH(s.date), v.vendor_name DESC, p.name ASC, s.id ASC
    ";

    $salesResult = $conn->query($salesQuery);

    $rowCount = 0;
    $currentVendor = null;
    $currentMonth = null;

    while ($row = $salesResult->fetch_assoc()) {
        $saleMonth = date('F Y', strtotime($row['date']));

        if ($row['Vendor'] != $currentVendor || $saleMonth != $currentMonth) {
            $currentVendor = $row['Vendor'];
            $currentMonth = $saleMonth;

            $startColumn = 'A';
            $endColumn = chr(ord($startColumn) + 5);
            $sheet->fromArray([$row['Vendor'] . ' - ' . $saleMonth], null, $startColumn . '1');

            // Add headers in the next columns
            $sheet->setCellValue($startColumn . '2', 'Product_Name');
            $sheet->setCellValue(chr(ord($startColumn) + 1) . '2', 'Quantity');
            $sheet->setCellValue(chr(ord($startColumn) + 2) . '2', 'Price');
            $sheet->setCellValue(chr(ord($startColumn) + 3) . '2', 'Total');
            $sheet->setCellValue(chr(ord($startColumn) + 4) . '2', 'Remarks');
            $sheet->setCellValue(chr(ord($startColumn) + 5) . '2', 'Date');
            $rowCount = 3;
        }

        $sheet->setCellValue($startColumn . $rowCount, $row['Product_Name']);
        $sheet->setCellValue(chr(ord($startColumn) + 1) . $rowCount, $row['Quantity']);
        $sheet->setCellValue(chr(ord($startColumn) + 2) . $rowCount, $row['Price']);
        $sheet->setCellValue(chr(ord($startColumn) + 3) . $rowCount, $row['Total']);
        $sheet->setCellValue(chr(ord($startColumn) + 4) . $rowCount, $row['Remarks']);
        $sheet->setCellValue(chr(ord($startColumn) + 5) . $rowCount, date('Y-m-d', strtotime($row['date'])));
        $rowCount++;
    }
}

$timestamp = date('Ymd_His');
$filename = 'inventory_' . $timestamp . '.xlsx';
$objWriter = new Xlsx($spreadsheet);
$objWriter->save($filename);

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');

header('Location: sales.php');
exit;
?>
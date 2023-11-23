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

    // Query to retrieve sales data for each category
    $salesQuery = "
        SELECT v.vendor_name as Vendor, s.id AS ID, p.name as Product_Name, s.qty AS Quantity, s.price as Price, s.price * s.qty as Total, s.remarks as Remarks, s.date
        FROM sales s
        LEFT JOIN vendor v ON v.id = s.vendor_id
        LEFT JOIN products p ON p.id = s.product_id
        WHERE s.category_id = $categoryId
        ORDER BY MONTH(s.date), v.vendor_name DESC, p.name ASC, s.id ASC
    ";

    $salesResult = $conn->query($salesQuery);

    $rowCount = 0;
    $Columncount = 0;
    $currentVendor = null;
    $currentMonth = null;
    $previousVendor = null;
    $previousMonth = null;
    
    while ($row = $salesResult->fetch_assoc()) {
        echo($row);
        $saleMonth = date('F Y', strtotime($row['date']));

        if ($row['Vendor'] != $previousVendor || $saleMonth != $previousMonth) {
            $previousVendor = $row['Vendor'];
            $previousMonth = $saleMonth;
            // char A = 65 ASCII code
            // char H = 72 ASCII code
            // char D = 68
            $startColumn = $sheet->getCell('A1')->getValue();
            echo($startColumn);
            $endColumn = chr(72 + $Columncount);
            $vendorEndColumn = chr(68 + $Columncount);
            
            

            if ($previousVendor != null || $previousVendor != $row['Vendor']) {
               // Add headers in the next columns only if there's a vendor
               if ($Columncount < 4) {
                   // Limit to 4 columns for saleMonth
                   $endColumn = chr(72 + ($Columncount  - 4));
               }
                $sheet->mergeCells($startColumn . '1:' . $endColumn . '1');
                $style = $sheet->getStyle($startColumn . '1');
                $alignment = $style->getAlignment();
                $alignment->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $style2 = $sheet->getStyle($startColumn . '2');
                $alignment2 = $style2->getAlignment();
                $alignment2->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->setCellValue($startColumn . '1', $saleMonth);
                $sheet->mergeCells($startColumn . '2:' . $vendorEndColumn . '2');
                $sheet->setCellValue($startColumn . '2', $row['Vendor']);
                $sheet->setCellValue(chr(ord($startColumn)) . '3', 'Quantity');
                $sheet->setCellValue(chr(ord($startColumn) + 1) . '3', 'Price');
                $sheet->setCellValue(chr(ord($startColumn) + 2) . '3', 'Total');
                $sheet->setCellValue(chr(ord($startColumn) + 3) . '3', 'Remarks');
                $rowCount = 4;
            }
        }

        if ($previousVendor != null) {
            // Add data only if there's a vendor
            $sheet->setCellValue($startColumn . $rowCount, $row['Quantity']);
            $sheet->setCellValue(chr(ord($startColumn) + 1) . $rowCount, $row['Price']);
            $sheet->setCellValue(chr(ord($startColumn) + 2) . $rowCount, $row['Total']);
            $sheet->setCellValue(chr(ord($startColumn) + 3) . $rowCount, $row['Remarks']);
            $rowCount++;
        }

        $Columncount += 4;
    }
 }

$timestamp = date('Ymd_His');
$filename = 'sales_' . $timestamp . '.xlsx';
$objWriter = new Xlsx($spreadsheet);
$objWriter->save($filename);

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');


// Redirect back to the same page
header('Location: sales.php');
exit;

?>
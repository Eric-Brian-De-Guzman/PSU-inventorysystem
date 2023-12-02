<?php
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// MySQL Setup
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "inventory_system";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SPREADSHEET

$spreadsheet = new Spreadsheet;

$firstSheet = $spreadsheet->getActiveSheet();
$firstSheet->setTitle('Overall Summary');

// Set column headers for the first sheet *overall summary*
$firstSheetHeaders = ['Category ID', 'Category Name', 'Total Sales'];
$firstSheet->fromArray([$firstSheetHeaders], null, 'A1');

// Get the year parameter from the URL, default to the current year if not provided
$year = isset($_GET['year']) ? intval($_GET['year']) : date('Y');

// Fetch overall summary data for all categories for the specified year
$sql = "SELECT 
    c.id AS CategoryID,
    c.name AS CategoryName,
    -- s.id AS ID,
    -- COUNT(s.id) as NumberOfSales,
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
    // $totalProducts = $categorySummary['NumberOfSales'];
}

// Display the grand total in a designated cell
$grandTotalRow = $row + 1; // Adjust the row to leave space for headers
$firstSheet->setCellValue('A' . $grandTotalRow, 'Grand Total');
$firstSheet->setCellValue('C' . $grandTotalRow, $totalOverallSales);
$firstSheet->setCellValue('I'.  6, 'BO '. $year .' trend');
$firstSheet->setCellValue('I'.  7, 'BO '. $year .' (after adjustment)');
$firstSheet->setCellValue('J'.  7, $totalOverallSales);
$firstSheet->setCellValue('K'.  7, ($totalOverallSales/7));

// Reset the pointer to the beginning of the result set
$categoryResult->data_seek(0);

while ($category = $categoryResult->fetch_assoc()) {
    $categoryId = $category['CategoryID'];
    $categoryName = $category['CategoryName'];

    // Create a sheet for each category
    $sheet = $spreadsheet->createSheet();
    $sheet->setTitle($categoryName);


    // Query to retrieve sales data for each category
   $stocksQuery = "
    SELECT p.stock_code as Stock_Number, p.id as ID, p.name as Product_Name
    FROM products p
    LEFT JOIN
    categories c on c.id = p.categorie_id
    WHERE p.categorie_id = $categoryId
   
"; 
    $stocksResult = $conn->query($stocksQuery);
    $rowStock = 0;
    $stocksResult->data_seek(0);
    $rowCount = 0;
    
while ($rows = $stocksResult->fetch_assoc()) {
            $sheet->setCellValue([1,3],'Stock Code');
        $sheet->setCellValue([2,3],'Product Name');
         $sheet->setCellValue([1 , $rowStock + 4], $rows['Stock_Number']);
            $sheet->setCellValue([2 , $rowStock + 4], $rows['Product_Name']);
            $rowStock++;
    $stockCode = $rows['ID'];


//Query for sales table
$salesQuery= "
    SELECT  v.vendor_name as Vendor, s.stock_code as Stock_Number, s.id AS ID,
            p.name as Product_Name, s.qty AS Quantity, s.price as Price, s.price * s.qty as Total,
            s.remarks as Remarks, s.date, s.product_id, t.stock_onhand AS OnHand, t.submitted_usage as SubUsage, t.req_qty AS ReqQty,
            ((t.req_qty *6)-t.stock_onhand)/3 AS total_qty,
            CONCAT('Q', QUARTER(s.date), ' ', YEAR(s.date)) as Quarter
            FROM sales s
            LEFT JOIN vendor v ON v.id = s.vendor_id
            LEFT JOIN products p ON p.id = s.product_id
            LEFT JOIN stocks t on t.stock_code = s.stock_code
            WHERE s.product_id = $stockCode
            ORDER BY Quarter DESC, v.vendor_name DESC
";
    $salesResult = $conn->query($salesQuery);


    $Columncount = 0;
    $previousVendor = null;
    $previousMonth = null;
    $startColumn = 7;
    $endColumn = 10;
    $vendorEndColumn = 10;
    //Sorted by Vendor and Month
    while ($row = $salesResult->fetch_assoc()) {
        $saleQuarter = $row['Quarter'];
        if ( $row['Vendor'] != $previousVendor  || $saleQuarter != $previousMonth) {
            
            $previousVendor = $row['Vendor'];
            $previousMonth = $saleQuarter;
            
            $startColumn = $startColumn + $Columncount;
            $endColumn = $endColumn + $Columncount;
            $vendorEndColumn = $vendorEndColumn + $Columncount;
            
         if ($previousVendor != null) {
            // center at merge yung cell F:1-I1 at F:2-I2
            $style = $sheet->getStyle([$startColumn, '1']);
            $alignment = $style->getAlignment();
            $alignment->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->mergeCells([$startColumn , '1' , $endColumn , '1']);
            $sheet->setCellValue([$startColumn , '1' , $endColumn , '1'], $saleQuarter);
            $style = $sheet->getStyle([$startColumn , '2']);
            $alignment = $style->getAlignment();
            $alignment->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->mergeCells([$startColumn , '2' , $vendorEndColumn , '2']);
            $sheet->setCellValue([$startColumn , '2'], $row['Vendor']);
            $style = $sheet->getStyle([3, 2]);
            $alignment = $style->getAlignment();
            $alignment->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->mergeCells([3 , 2 , 5 , 2]);
            $sheet->setCellValue([3 , 2 , 5 , 2], 'STOCKS');
            $sheet->setCellValue([3,3],'STOCK ON HAND');
            $sheet->setCellValue([4,3],'SUBMITTED USAGE');
            $sheet->setCellValue([5,3],'REQUIRED QUANTITY');
            $sheet->setCellValue([6,3],'TOTAL QTY');
            
            $sheet->setCellValue([$startColumn , '3'], 'Quantity');
            $sheet->setCellValue([$startColumn + 1 , '3'], 'Price');
            $sheet->setCellValue([$startColumn + 2 , '3'], 'Total');
            $sheet->setCellValue([$startColumn + 3 , '3'], 'Remarks');

    }}
    //Query of Sales data
         if ($previousVendor != null) {
            $sheet->setCellValue([3 , $rowCount+4], $row['OnHand']);
            $sheet->setCellValue([4 , $rowCount+4], $row['SubUsage']);
            $sheet->setCellValue([5 , $rowCount+4], $row['ReqQty']);
            $sheet->setCellValue([6 , $rowCount+4], $row['total_qty']);
            $sheet->setCellValue([$startColumn , $rowCount+4], $row['Quantity']);
            $sheet->setCellValue([$startColumn + 1 , $rowCount+4], $row['Price']);
            $sheet->setCellValue([$startColumn + 2 , $rowCount+4], $row['Total']);
            $sheet->setCellValue([$startColumn + 3 , $rowCount+4], $row['Remarks']);
            $Columncount =+ 4;
            
}
}
$rowCount++;
}


// $highestColumn = $sheet->getHighestColumn();
// $columnIndex = PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn);
// $s4sheet = $sheet->getCell('T4'); //current price of the product
// $S4 = $s4sheet->getValue();
// $g4sheet = $sheet->getCell('H4'); //previous price of the product last quarter with the same vendor
// $G4 = $g4sheet->getValue();
// $r4sheet = $sheet->getCell('S4'); //current quantity of the product
// $R4 = $r4sheet->getValue();
// $negotiatedPrice = ($S4 - $G4) * $R4;
// $sheet->setCellValue([$columnIndex + 1, 3],'Negotiated Cost Price');
// $sheet->setCellValue([$columnIndex + 1, 4],$negotiatedPrice);


// $highestColumn = $sheet->getHighestColumn();
// $columnIndex = PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn);
// $s4sheet = $sheet->getCell('T4'); //
// $S4 = $s4sheet->getValue();
// $f4sheet = $sheet->getCell('G4');
// $F4 = $g4sheet->getValue();
// $r4sheet = $sheet->getCell('S4');
// $R4 = $r4sheet->getValue();
// $negotiatedPrice2 = ($R4 - $F4)*$S4;
// $sheet->setCellValue([$columnIndex + 1, 3],'Adjusted Quantity');
// $sheet->setCellValue([$columnIndex + 1, 4],$negotiatedPrice2);
}



$timestamp = date('Ymd_His');
$filename = 'sales_' . $year . '_' . $timestamp . '.xlsx';
$objWriter = new Xlsx($spreadsheet);
$objWriter->save($filename);

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');

// Redirect back to the same page
header('Location: sales.php');
exit;
?>
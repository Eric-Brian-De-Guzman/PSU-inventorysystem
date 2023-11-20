<?php
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use \PhpOffice\PhpSpreadsheet\IOFactory;


// Replace these with your database credentials
$host = 'localhost';
$dbname = 'inventory_system';
$user = 'root';
$password = '';

// Create a PDO connection to the database
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Create a new spreadsheet
$spreadsheet = new Spreadsheet();

// Fetch categories from the database
$categoriesSql = "SELECT name from categories;";
$categoriesStmt = $pdo->query($categoriesSql);
$categories = $categoriesStmt->fetchAll(PDO::FETCH_COLUMN);
// ...

// Create the first sheet for overall summary
$firstSheet = $spreadsheet->getActiveSheet();
$firstSheet->setTitle('Overall Summary');

// Set column headers for the first sheet
$firstSheetHeaders = ['Category ID', 'Category Name', 'Total Sales'];
$firstSheet->fromArray($firstSheetHeaders, null, 'A1');

// Fetch overall summary data for all categories
$sql = "SELECT 
    c.id AS CategoryID,
    c.name AS CategoryName,
    SUM(s.qty * s.price) AS TotalSales
FROM 
    sales s
LEFT JOIN 
    categories c ON c.id = s.category_id
GROUP BY 
    c.id, c.name";
$stmt = $pdo->query($sql);
$categorySummaries = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Add overall summary rows to the first sheet
$row = 2;
foreach ($categorySummaries as $categorySummary) {
    $firstSheet->fromArray([$categorySummary['CategoryID'], $categorySummary['CategoryName'], $categorySummary['TotalSales']], null, 'A' . $row);
    $row++;
}



// Loop through each category
foreach ($categories as $category) {
    // Add a new sheet for each category
    $sheet = $spreadsheet->createSheet();
    $sheet->setTitle($category);

    // Set column headers
    $header = ['Vendor'];
    $sheet->mergeCells('A1:H1');
    $style = $sheet->getStyle('A1');
    $alignment = $style->getAlignment();
    $alignment->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    $sheet->fromArray($header, null, 'A1');
    $headers = ['ID', 'Product', 'Quantity', 'Category', 'Price', 'Total', 'Remarks', 'Date'];
    $sheet->fromArray($headers, null, 'A2');

    // Fetch unique vendors for the current category
    $vendorSql = "SELECT DISTINCT v.vendor_name
                  FROM sales s
                  LEFT JOIN vendor v ON v.id = s.vendor_id
                  LEFT JOIN categories c ON c.id = s.category_id
                  WHERE c.name = :category";
    $vendorStmt = $pdo->prepare($vendorSql);
    $vendorStmt->bindParam(':category', $category);
    $vendorStmt->execute();
    $vendors = $vendorStmt->fetchAll(PDO::FETCH_COLUMN);

    // Loop through each vendor
    foreach ($vendors as $vendor) {
        // Fetch data for the current category and vendor from the database
        $sql = "SELECT 
            s.id AS ID, 
            p.name as Product_Name, 
            c.name as Category, 
            s.qty AS Quantity, 
            s.price as Price, 
            s.price * s.qty as Total, 
            s.remarks as Remarks, 
            DATE_FORMAT(s.date, '%Y-%m') as month_year
        FROM 
            sales s
        LEFT JOIN 
            categories c ON c.id = s.category_id
        LEFT JOIN 
            products p ON p.id = s.product_id
        LEFT JOIN 
            vendor v ON v.id = s.vendor_id
        WHERE c.name = :category AND v.vendor_name = :vendor
        GROUP BY 
            month_year, s.id, p.name, v.vendor_name, c.name, s.qty, s.price, s.remarks
        ORDER BY 
            month_year ASC, s.id ASC";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':category', $category);
        $stmt->bindParam(':vendor', $vendor);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_NUM);

        // Add data to the current sheet and assign random colors to each row
        $row = $sheet->getHighestRow() + 1; // Start from the next available row
        $currentMonth = null;
        foreach ($data as $rowData) {
            // If the month changes, add an empty row as a separator
            if ($currentMonth !== null && $currentMonth !== $rowData[7]) { // Assuming the date column is the 8th column (index 7)
                $row++;
                $sheet->fromArray(['', '', '', '', '', '', '', ''], null, 'A' . $row);
            }

            $sheet->fromArray($rowData, null, 'A' . $row);

            // Assign random color to the row
            $color = sprintf('#%06X', mt_rand(0, 0xFFFFFF));
            $sheet->getStyle('A' . $row . ':H' . $row)->applyFromArray([
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => $color],
                ],
            ]);

            $row++;
            $currentMonth = $rowData[7];
        }

        // Add overall summary row at the bottom for the current vendor
        $lastRow = $sheet->getHighestRow();
        $summaryRow = ['Total', '', '', '', '', '=SUM(F2:F' . $lastRow . ')', '', ''];
        $sheet->fromArray($summaryRow, null, 'A' . ($lastRow + 1));
    }
}

foreach ($categories as $category) {
    // Add a new sheet for each category
    $sheet = $spreadsheet->createSheet();
    $sheet->setTitle($category);

    // Set column headers
    $header = ['Vendor'];
    $sheet->mergeCells('A1:H1');
    $style = $sheet->getStyle('A1');
    $alignment = $style->getAlignment();
    $alignment->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    $sheet->fromArray($header, null, 'A1');
    $headers = ['ID', 'Product', 'Quantity', 'Category', 'Price', 'Total', 'Remarks', 'Date'];
    $sheet->fromArray($headers, null, 'A2');

    // Fetch unique vendors for the current category
    $vendorSql = "SELECT DISTINCT v.vendor_name
                  FROM sales s
                  LEFT JOIN vendor v ON v.id = s.vendor_id
                  LEFT JOIN categories c ON c.id = s.category_id
                  WHERE c.name = :category";
    $vendorStmt = $pdo->prepare($vendorSql);
    $vendorStmt->bindParam(':category', $category);
    $vendorStmt->execute();
    $vendors = $vendorStmt->fetchAll(PDO::FETCH_COLUMN);

    // Loop through each vendor
    foreach ($vendors as $vendor) {
        // Fetch data for the current category and vendor from the database
        $sql = "SELECT 
            s.id AS ID, 
            p.name as Product_Name, 
            c.name as Category, 
            s.qty AS Quantity, 
            s.price as Price, 
            s.price * s.qty as Total, 
            s.remarks as Remarks, 
            DATE_FORMAT(s.date, '%Y-%m') as month_year
        FROM 
            sales s
        LEFT JOIN 
            categories c ON c.id = s.category_id
        LEFT JOIN 
            products p ON p.id = s.product_id
        LEFT JOIN 
            vendor v ON v.id = s.vendor_id
        WHERE c.name = :category AND v.vendor_name = :vendor
        GROUP BY 
            month_year, s.id, p.name, v.vendor_name, c.name, s.qty, s.price, s.remarks
        ORDER BY 
            month_year ASC, s.id ASC";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':category', $category);
        $stmt->bindParam(':vendor', $vendor);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_NUM);

        // Add data to the current sheet and assign random colors to each row
        $row = $sheet->getHighestRow() + 1; // Start from the next available row
        $currentMonth = null;
        foreach ($data as $rowData) {
            // If the month changes, add an empty row as a separator
            if ($currentMonth !== null && $currentMonth !== $rowData[7]) { // Assuming the date column is the 8th column (index 7)
                $row++;
                $sheet->fromArray(['', '', '', '', '', '', '', ''], null, 'A' . $row);
            }

            $sheet->fromArray($rowData, null, 'A' . $row);

            // Assign random color to the row
            $color = sprintf('#%06X', mt_rand(0, 0xFFFFFF));
            $sheet->getStyle('A' . $row . ':H' . $row)->applyFromArray([
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => $color],
                ],
            ]);

            $row++;
            $currentMonth = $rowData[7];
        }

        // Add overall summary row at the bottom for the current vendor
        $lastRow = $sheet->getHighestRow();
        $summaryRow = ['Total', '', '', '', '', '=SUM(F2:F' . $lastRow . ')', '', ''];
        $sheet->fromArray($summaryRow, null, 'A' . ($lastRow + 1));
    }
}

// ...




// Save the spreadsheet
$timestamp = date('Ymd_His');
$filename = 'sales_' . $timestamp . '.xlsx';
$writer = new Xlsx($spreadsheet);
$writer->save($filename);

// ...


// Set appropriate headers for file download
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');

// Redirect back to the same page
header('Location: sales.php');
exit;
?>
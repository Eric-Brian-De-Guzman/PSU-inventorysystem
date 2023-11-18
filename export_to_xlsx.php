<?php
  $page_title = 'Edit sale';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(3);
?>
<?php
$all_vendors = find_all('vendor');
$all_sales = find_all('sales');
$all_product = find_all('products');

?>
<?php foreach ($all_sales as $sale); ?>
<?php
// ... (connection code here)

// Fetch data from the database
$sql = "SELECT s.id,s.qty,s.price,s.remarks,s.date,p.name,v.vendor_name AS vendor
FROM sales s
INNER JOIN products p ON p.id = s.id
INNER JOIN vendor v ON v.id = s.vendor_id
ORDER BY s.id ASC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Open a file handle for writing
    $file = fopen('exported_data.csv', 'w');

    // Write column headers
    fputcsv($file, ['id', 'Product Name', 'Vendor', 'Quantity', 'Remarks', 'Date']);

    // Fetch and write data to the CSV file
    while ($data = $result->fetch_assoc()) {
        fputcsv($file, [$data['id'], $data['firstname'], $data['lastname']]);
    }

    // Close the file handle
    fclose($file);

    // Provide a download link
    echo '<p>Data has been exported to <a href="exported_data.csv">CSV file</a>.</p>';
} else {
    echo "0 results";
}

// Close connection
$conn->close();
?>
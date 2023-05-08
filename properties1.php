<?php

require __DIR__ . '/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

$spreadsheet = IOFactory::load('gnb_di_test.xlsx');

$sheet = $spreadsheet->getActiveSheet();
$highestColumn = $sheet->getHighestColumn();
$highestRow = $sheet->getHighestRow();

$mysqli = new mysqli('localhost', 'admin', 'admin', 'di_test');

if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

for ($row = 2; $row <= $highestRow; $row++) {
    $rowData = [];
    for ($col = 'A'; $col <= $highestColumn; $col++) {
        $value = $sheet->getCell($col.$row)->getValue();
        array_push($rowData, $mysqli->real_escape_string($value));
    }

    $sql = "INSERT INTO properties (
                property_ref, address_line1, address_line2, city, county, postcode,
                property_category, property_class, property_price, deposit, commission,
                landlord_id, tenant_buyer_id
            ) VALUES ('" . implode("','", $rowData) . "')";

    if (!$result = $mysqli->query($sql)) {
        die('There was an error running the query [' . $mysqli->error . ']');
    }
}
$mysqli->close();



echo "Data migrated successfully";
exit();
?>

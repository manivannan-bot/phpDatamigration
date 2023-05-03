<?php

require __DIR__ . '/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

$spreadsheet = IOFactory::load('gnb_di_test.xlsx');

// Get the active sheet
$sheet = $spreadsheet->getActiveSheet();

// Get the highest column and row numbers
$highestColumn = $sheet->getHighestColumn();
$highestRow = $sheet->getHighestRow();

$mysqli = new mysqli('localhost', 'manivannan', '123456789', 'di_test');

// Loop through each row and column
for ($row = 1; $row <= $highestRow; $row++) {
    for ($col = 'A'; $col <= $highestColumn; $col++) {
        // Get the value in the current cell
        $value = $sheet->getCell($col.$row)->getValue();
        echo $value . " ";
    }
    echo "\n";
}

echo "mani"; 
exit();
<?php
// Database credentials
$servername = "localhost";
$username = "admin";
$password = "admin";
$dbname = "di_test";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Include PHP Office library
require_once 'vendor/autoload.php';

// Read Excel file
$inputFileName = 'gnb_di_test.xlsx';
$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($inputFileName);

// Get worksheet dimensions
$worksheet = $spreadsheet->getActiveSheet();
$highestRow = $worksheet->getHighestRow();
$highestColumn = $worksheet->getHighestColumn();

// Loop through each row of the worksheet
for ($row = 2; $row <= $highestRow; $row++) {
  // Get cell values for columns M, N, and O
  $nValue = $worksheet->getCell('N' . $row)->getValue();
  $oValue = $worksheet->getCell('O' . $row)->getValue();
  $pValue = $worksheet->getCell('P' . $row)->getValue();
  $qValue = $worksheet->getCell('Q' . $row)->getValue();

  // Insert data into MySQL database
  
  $sql = "INSERT INTO clients (`client_ref`,`name`, `email`, `contact_no`,`type`) VALUES ('$nValue', '$oValue', '$pValue','$qValue','landlord')";
  if ($conn->query($sql) === TRUE) {
    echo "landlord created successfully";
    $last_inserted_id = $conn->insert_id;
  }
  
  $aValue = $worksheet->getCell('A' . $row)->getValue();
  $bValue = $worksheet->getCell('B' . $row)->getValue();
  $cValue = $worksheet->getCell('C' . $row)->getValue();
  $dValue = $worksheet->getCell('D' . $row)->getValue();
  $eValue = $worksheet->getCell('E' . $row)->getValue();
  $fValue = $worksheet->getCell('F' . $row)->getValue();
  $gValue = $worksheet->getCell('G' . $row)->getValue();
  $hValue = $worksheet->getCell('H' . $row)->getValue();
  $iValue = $worksheet->getCell('I' . $row)->getValue();
  $jValue = $worksheet->getCell('J' . $row)->getValue();
//   $kValue = $worksheet->getCell('K' . $row)->getValue();
//   $lValue = $worksheet->getCell('M' . $row)->getValue();
  $mValue = $worksheet->getCell('N' . $row)->getValue();

  // Insert data into MySQL database
  $sql = "INSERT INTO properties (`property_ref`, `address_line1`, `address_line2`,`city`,`county`,`postcode`, `property_category`, `property_class`,`property_price`,`deposit`, `commission`,`landlord_id`) 
                          VALUES ('$aValue', '$bValue', '$cValue','$dValue', '$eValue','$fValue', '$gValue', '$hValue','$iValue', '$jValue', '$mValue','$last_inserted_id')";

  if ($conn->query($sql) === TRUE) {
    echo "New landlord created successfully";
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
}

for ($row = 2; $row <= $highestRow; $row++) {
    $sValue = $worksheet->getCell('U' . $row)->getValue();
    
    if(empty($sValue)){
            $wValue = $worksheet->getCell('U' . $row)->getValue();
            $xValue = $worksheet->getCell('V' . $row)->getValue();
            $yValue = $worksheet->getCell('W' . $row)->getValue();
        
            // Insert data into MySQL database
            $sql = "INSERT INTO clients (`name`, `email`, `contact_no`,`type`) VALUES ('$wValue', '$xValue', '$yValue','buyer')";
            if ($conn->query($sql) === TRUE) {
            echo "New buyer created successfully";
            } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
            }
    }
  }

// Close connection
$conn->close();
?>
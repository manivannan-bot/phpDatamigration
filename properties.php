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
    echo "landlord created successfully"."<br>";
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
  $property_price = $worksheet->getCell('I' . $row)->getValue();
  $jValue = $worksheet->getCell('J' . $row)->getValue();
  $deposit=$property_price*$jValue;
  $mValue = $worksheet->getCell('M' . $row)->getValue();
  $commissionPercentage = $worksheet->getCell('L' . $row)->getValue();
  $rent = $worksheet->getCell('K' . $row)->getValue();
  $commission = $rent * ($commissionPercentage / 100);

  $tValue = $worksheet->getCell('T' . $row)->getValue();

  // Insert data into MySQL database
  $sql = "INSERT INTO properties (`property_ref`, `address_line1`, `address_line2`,`city`,`county`,`postcode`, `property_category`, `property_class`,`property_price`,`deposit`, `commission`,`landlord_id`,`tenant_buyer_id`) 
                          VALUES ('$aValue', '$bValue', '$cValue','$dValue', '$eValue','$fValue', '$gValue', '$hValue','$property_price', '$deposit', '$commission','$last_inserted_id','$tValue')";

  if ($conn->query($sql) === TRUE) {
    echo "New landlord created successfully"."<br>";
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
}

for ($row = 2; $row <= $highestRow; $row++) {
    $sValue = $worksheet->getCell('S' . $row)->getValue();
    
    if(empty($sValue)){
      $uValue = $worksheet->getCell('U' . $row)->getValue();
      $vValue = $worksheet->getCell('V' . $row)->getValue();
      $wValue = $worksheet->getCell('W' . $row)->getValue();
  
      // Check if the email already exists in the database
      $emailExistsQuery = "SELECT COUNT(*) as count FROM clients WHERE email = '$vValue'";
      $emailExistsResult = $conn->query($emailExistsQuery);
      $emailExistsData = $emailExistsResult->fetch_assoc();
      $emailCount = $emailExistsData['count'];
  
      if ($emailCount > 0) {
        echo "Skipped - Email already exists: $vValue<br>";
      } else {
        // Insert data into MySQL database
        $sql = "INSERT INTO clients (`name`, `email`, `contact_no`, `type`) VALUES ('$uValue', '$vValue', '$wValue', 'buyer')";
  
        if ($conn->query($sql) === TRUE) {
          echo "New Buyer created successfully<br>";
        } else {
          echo "Error: " . $sql . "<br>" . $conn->error;
        }
      }

    }
  }

// Close connection
$conn->close();
?>
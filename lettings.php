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

for ($row = 2; $row <= $highestRow; $row++) {
  $sValue = $worksheet->getCell('U' . $row)->getValue();
  if(!empty($sValue)){
   
        $wValue = $worksheet->getCell('U' . $row)->getValue();
        $xValue = $worksheet->getCell('V' . $row)->getValue();
        $yValue = $worksheet->getCell('W' . $row)->getValue();
      
        // Insert data into MySQL database
        $sql = "INSERT INTO clients (`name`, `email`, `contact_no`,`type`) VALUES ('$wValue', '$xValue', '$yValue','Tenant')";

        if ($conn->query($sql) === TRUE) {
          echo "New Tenant created successfully"."<br>";
        } else {
          echo "Error: " . $sql . "<br>" . $conn->error;
        }
   }
  }

  // Loop through each row of the worksheet
for ($row = 2; $row <= $highestRow; $row++) {
    
    $aValue = $worksheet->getCell('A' . $row)->getValue();
    $rValue = $worksheet->getCell('R' . $row)->getValue();
    
    //$rValue = DateTime::createFromFormat('Y-m-d', $rValue);
    // echo "cell val".$rValue->format('Y-m-d');exit();
    $sValue = $worksheet->getCell('S' . $row)->getValue();
    
    // Insert data into MySQL database
    $sql = "INSERT INTO lettings (`property_ref`, `let_start_date`, `let_end_date`) VALUES ('$aValue', '$rValue', '$sValue')";
    if ($conn->query($sql) === TRUE) {
      echo "New lettings created successfully"."<br>";
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
  }

// Close connection
$conn->close();
?>
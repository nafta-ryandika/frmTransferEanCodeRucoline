<?php

include("../../configuration.php");
include("../../connection.php");
include("../../endec.php");


//Cek Get Data
if(isset($_POST['nmSQL'])){
  $txtSQL = $_POST['nmSQL'];
}else{
  $txtSQL = "";
}

// Get data records from table.
$result=mysql_query($txtSQL);

// Functions for export to excel.
function xlsBOF() {
echo pack("ssssss", 0x809, 0x8, 0x0, 0x10, 0x0, 0x0);
return;
}
function xlsEOF() {
echo pack("ss", 0x0A, 0x00);
return;
}
function xlsWriteNumber($Row, $Col, $Value) {
echo pack("sssss", 0x203, 14, $Row, $Col, 0x0);
echo pack("d", $Value);
return;
}
function xlsWriteLabel($Row, $Col, $Value ) {
$L = strlen($Value);
echo pack("ssssss", 0x204, 8 + $L, $Row, $Col, 0x0, $L);
echo $Value;
return;
}
header("Pragma: public");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Content-Type: application/force-download");
header("Content-Type: application/octet-stream");
header("Content-Type: application/download");;
header("Content-Disposition: attachment;filename=orderlist.xls ");
header("Content-Transfer-Encoding: binary ");

xlsBOF();

/*
Make a top line on your excel sheet at line 1 (starting at 0).
The first number is the row number and the second number is the column, both are start at '0'
*/

xlsWriteLabel(0,0,"Laporan User");

// Make column labels. (at line 3)
xlsWriteLabel(2,0,"No.");
xlsWriteLabel(2,1,"ID");
xlsWriteLabel(2,2,"User");
xlsWriteLabel(2,3,"Password");
xlsWriteLabel(2,4,"Group");
xlsWriteLabel(2,5,"Name");

$xlsRow = 3;
$NoRow = 1;

// Put data records from mysql by while loop.
while($row=mysql_fetch_array($result)){

xlsWriteNumber($xlsRow,0,$NoRow);
xlsWriteLabel($xlsRow,1,$row['xid']);
xlsWriteLabel($xlsRow,2,$row['xuser']);
xlsWriteLabel($xlsRow,3,$row['xpass']);
xlsWriteLabel($xlsRow,4,$row['xgroup']);
xlsWriteLabel($xlsRow,5,$row['xname']);

$NoRow++;
$xlsRow++;
}
xlsEOF();
mysql_close($conn);
exit();

?>


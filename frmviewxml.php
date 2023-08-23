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

// Step 1
$sql = $txtSQL; //"select * from books";
$result = mysql_query($sql) or die ( mysql_error() );

echo "<tabel>"; // Step 2

// Step 3
while ($line = mysql_fetch_assoc($result) ) {
  // Step 4
  echo "<baris>";
	echo "<id>" . $line['xid'] . "</id>";
	echo "<user>" . $line['xuser'] . "</user>";
	echo "<password>" . $line['xpass'] . "</password>";
	echo "<group>" . $line['xgroup'] . "</group>";
	echo "<name>" . $line['xname'] . "</name>";
  echo "</baris>";
}

// Step 4
echo "</tabel>";
mysql_close($conn);
?>


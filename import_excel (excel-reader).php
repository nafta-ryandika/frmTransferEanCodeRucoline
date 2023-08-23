<?php
include("../../configuration.php");
include("../../connection.php");

require_once('excelReader/php-excel-reader/excel_reader2.php');
require_once('excelReader/SpreadsheetReader.php');

$fileName = $_FILES['file']['name'];
$fileSize = $_FILES['file']['size'];
$fileError = $_FILES['file']['error'];


if($fileSize > 0 || $fileError == 0){
   $targetPath = 'temp/'.$fileName;
   $move = move_uploaded_file($_FILES['file']['tmp_name'], $targetPath);

   chmod($targetPath,0777);

   if ($move) {
   $data = new Spreadsheet_Excel_Reader($targetPath,false);
   $baris = $data->rowcount($sheet_index=0);

   if (
      $data->val(1, 1) != "PO_Code" || 
      $data->val(1, 2) != "PO_Number" || 
      $data->val(1, 3) != "PO_Date" || 
      $data->val(1, 4) != "Row" || 
      $data->val(1, 5) != "Article" || 
      $data->val(1, 6) != "Description" || 
      $data->val(1, 7) != "Color_Code" || 
      $data->val(1, 8) != "Color_Name" || 
      $data->val(1, 9) != "Size" || 
      $data->val(1, 10) != "Qty_Size_Order" || 
      $data->val(1, 11) != "Qty_Item" ||
      $data->val(1, 12) != "Ean_Code" ||  
      $data->val(1, 13) != "Unit_Price"){
      
      echo(0);
   }
   else{
      for ($i=2; $i<=$baris; $i++){
         $po_code = $data->val($i, 1); 
         $po_number = $data->val($i, 2);
         $po_date = $data->val($i, 3); 
         $row = $data->val($i, 4); 
         $article = $data->val($i, 5); 
         $description = $data->val($i, 6); 
         $color_code = $data->val($i, 7); 
         $color_name = $data->val($i, 8);
         $size = $data->val($i, 9);
         $qty_size_order = $data->val($i, 10);
         $qty_item = $data->val($i, 11);
         $ean_code = $data->val($i, 12);
         $unit_price = $data->val($i, 13);

         $sql = "INSERT INTO temp_eancoderucoline
                (xid, po_code, po_number, po_date, `row`, article, description, color_code, color_name, size, qty_size_order, qty_item, ean_code, unit_price, access, komp, userby)
                VALUES
                (
                  '',
                  '".$po_code."',
                  '".$po_number."',
                  '".$po_date."',
                  '".$row."',
                  '".$article."',
                  '".$description."',
                  '".$color_code."',
                  '".$color_name."',
                  '".$size."',
                  '".$qty_size_order."',
                  '".$qty_item."',
                  '".$ean_code."',
                  '".$unit_price."',
                  now(),
                  '".$_SESSION[$domainApp."_mygroup"]." # ".$_SESSION[$domainApp."_mylevel"]."',
                  '".$_SESSION[$domainApp."_myname"]."'
               )";

      if ($po_code != "" && $po_number != "" && $po_date != "" && $article != "" && $color_code != "" && $size != "" && $qty_size_order != "" && $qty_item != "" && $ean_code != "") {
         mysql_query($sql,$conn);
      }
         flush();
      }
      // echo("Upload Sukses");
      echo($sql);
   }
   }
   else{
      echo("Upload Gagal !");
   }
   unlink($targetPath);
}
?>
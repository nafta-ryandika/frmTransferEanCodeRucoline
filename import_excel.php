<?php
include("../../configuration.php");
include("../../connection.php");

require_once '../../PHPExcel/PHPExcel/IOFactory.php';

$fileName = $_FILES['file']['name'];
$fileSize = $_FILES['file']['size'];
$fileError = $_FILES['file']['error'];


if($fileSize > 0 || $fileError == 0){
   $targetPath = 'temp/'.$fileName;
   $move = move_uploaded_file($_FILES['file']['tmp_name'], $targetPath);

   chmod($targetPath,0777);

   if ($move) {
      $excel = PHPExcel_IOFactory::load($targetPath);

      foreach($excel->getWorksheetIterator() as $data){
         $max_row = $data->getHighestRow();

         if (
            $data->getCellByColumnAndRow(0,1)->getValue() != "PO_Code" || 
            $data->getCellByColumnAndRow(1,1)->getValue() != "PO_Number" || 
            $data->getCellByColumnAndRow(2,1)->getValue() != "PO_Date" || 
            $data->getCellByColumnAndRow(3,1)->getValue() != "Row" || 
            $data->getCellByColumnAndRow(4,1)->getValue() != "Article" || 
            $data->getCellByColumnAndRow(5,1)->getValue() != "Description" || 
            $data->getCellByColumnAndRow(6,1)->getValue() != "Color_Code" || 
            $data->getCellByColumnAndRow(7,1)->getValue() != "Color_Name" || 
            $data->getCellByColumnAndRow(8,1)->getValue() != "Size" || 
            $data->getCellByColumnAndRow(9,1)->getValue() != "Qty_Size_Order" || 
            $data->getCellByColumnAndRow(10,1)->getValue() != "Qty_Item" ||
            $data->getCellByColumnAndRow(11,1)->getValue() != "Ean_Code" ||  
            $data->getCellByColumnAndRow(12,1)->getValue() != "Unit_Price"){
            
            echo($data->getCellByColumnAndRow(0,1)->getValue());
         }
         else{
            for($i = 2; $i <= $max_row; $i++){ 
               $po_code = $data->getCellByColumnAndRow(0,$i)->getValue(); 
               $po_number = $data->getCellByColumnAndRow(1,$i)->getValue();
               $po_date = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($data->getCellByColumnAndRow(2,$i)->getValue()));
               $row = $data->getCellByColumnAndRow(3,$i)->getValue(); 
               $article = $data->getCellByColumnAndRow(4,$i)->getValue(); 
               $description = $data->getCellByColumnAndRow(5,$i)->getValue(); 
               $color_code = $data->getCellByColumnAndRow(6,$i)->getValue(); 
               $color_name = $data->getCellByColumnAndRow(7,$i)->getValue();
               $size = $data->getCellByColumnAndRow(8,$i)->getValue();
               $qty_size_order = $data->getCellByColumnAndRow(9,$i)->getValue();
               $qty_item = $data->getCellByColumnAndRow(10,$i)->getValue();
               $ean_code = $data->getCellByColumnAndRow(11,$i)->getValue();
               $unit_price = $data->getCellByColumnAndRow(12,$i)->getValue();

               $sql = "INSERT INTO temp_eancoderucoline
                      (xid, po_code, po_number, po_date, row, article, description, color_code, color_name, size,
                        qty_size_order, qty_item, ean_code, unit_price, access, komp, userby)
                      VALUES
                      (
                        '',
                        '".trim($po_code)."',
                        '".trim($po_number)."',
                        '".trim($po_date)."',
                        '".trim($row)."',
                        '".trim($article)."',
                        '".trim($description)."',
                        '".trim($color_code)."',
                        '".trim($color_name)."',
                        '".trim($size)."',
                        '".trim($qty_size_order)."',
                        '".trim($qty_item)."',
                        '".trim($ean_code)."',
                        '".trim($unit_price)."',
                        now(),
                        '".$_SESSION[$domainApp."_mygroup"]." # ".$_SESSION[$domainApp."_mylevel"]."',
                        '".$_SESSION[$domainApp."_myname"]."'
                     )";

               if ($po_code != "" && $po_number != "" && $po_date != "" && $article != "" && $color_code != "" && $size != "" && $qty_size_order != "" && $qty_item != "" && $ean_code != "") {
                  mysql_query($sql,$conn);
               }    
               flush();
            }
            echo("Upload Sukses");
         }
      }
   }
   else{
      echo("Upload Gagal!");
   }
   unlink($targetPath);
}
?>
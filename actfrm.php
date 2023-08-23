<?php

    include("../../configuration.php");
    include("../../connection.php");
    include("../../endec.php");

  if(isset($_POST['intxtmode'])){
    $intxtmode = $_POST['intxtmode'];
  }
  if(isset($_POST['nopo'])){
    $nopo = strtoupper(htmlspecialchars($_POST['nopo']));
  }


if($intxtmode=='checktemp') {
  $sql = "SELECT xid FROM temp_eancoderucoline WHERE userby = '".$_SESSION[$domainApp."_myname"]."'";  
  $result =  mysql_query($sql,$conn);
  $row =  mysql_num_rows($result);

  if ($row > 0) {
    echo 1;
  }
  else{
    echo 0;
  }
  mysql_free_result($result);
}
else if($intxtmode=='checkpo') {
  $sql = "SELECT po_number FROM temp_eancoderucoline LIMIT 1";  
  $result =  mysql_query($sql,$conn);
  $data = mysql_fetch_array($result);

  $sql_1 = "SELECT nopo FROM tbl_rucoline_po WHERE nopo = '".$data["po_number"]."'";
  $result_1 =  mysql_query($sql_1,$conn);
  $row_1 =  mysql_num_rows($result_1);

  if ($row_1 > 0) {
    echo $data["po_number"];
  }
  else{
    echo 0;
  }
  mysql_free_result($result);
}
else if($intxtmode=='delete_ean') {
  $sql = "DELETE FROM tbl_rucoline_po WHERE nopo = '".$nopo."'";  
 
  if (!mysql_query($sql,$conn)){
    die('Error: ' . mysql_error());
  }
  else{
    echo "delete tbl_rucoline_po";
  }
}
else if($intxtmode=='delete_temp') {
  $sql = "DELETE FROM temp_eancoderucoline WHERE po_number = '".$nopo."'";

  if (!mysql_query($sql,$conn)){
    die('Error: ' . mysql_error());
  }
  else{
    echo "delete temp_eancoderucoline";
  }
}
else if($intxtmode=='transfer') {
  $sql = "SELECT * FROM temp_eancoderucoline WHERE userby = '".$_SESSION[$domainApp."_myname"]."'";  
  $result =  mysql_query($sql,$conn);

  $sukses = 0;
  $gagal = 0;

  while($data = mysql_fetch_array($result)){
    $xid = $data["xid"];
    $po_code =  $data["po_code"];
    $po_number =  $data["po_number"];
    $po_date =  $data["po_date"];
    $row =  $data["row"];
    $article =  $data["article"];
    $description =  $data["description"];
    $color_code =  $data["color_code"];
    $color_name =  $data["color_name"];
    $size =  $data["size"];
    $qty_size_order =  $data["qty_size_order"];
    $qty_item =  $data["qty_item"];
    $ean_code =  $data["ean_code"];
    $unit_price =  $data["unit_price"];


    $sql_2 = "INSERT INTO tbl_rucoline_po
              (cod_doc,
              nopo,
              tglpo,
              n_rigo,
              artikel,
              deskripsi,
              warna,
              nmwarna,
              size,
              qty_size,
              qty_rigo,
              eancode,
              qtyqcpass)
              VALUES
              ('".$po_code."',
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
              ''
              )";

    if (mysql_query($sql_2,$conn)) {
      $sukses++;
    }
    else{
      $gagal++;
    }

    $sql_3 = "DELETE FROM temp_eancoderucoline WHERE xid = '".$xid."'";
    mysql_query($sql_3,$conn); 
  }

  echo(($sukses + $gagal)."|".$sukses."|".$gagal);
  mysql_free_result($result);
}

// close connection !!!!
mysql_close($conn)


?>
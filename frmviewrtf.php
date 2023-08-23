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


$tpl_file = "pribadi_tpl.rtf";

if (file_exists($tpl_file)) {
    $target = "DataPribadi.rtf";

    $f = fopen($tpl_file, "r+");
    $isi = fread($f, filesize($tpl_file));
    fclose($f);

    $sql_data="SELECT `xid`, `xuser`, `xpass`, `xgroup`, `xname` FROM `user_login` where xid=1 ";
    $qry_data=mysql_query($sql_data, $conn) or die ("Gagal query pribadi");
    $data = mysql_fetch_array($qry_data) or die ("Gagal mendapatkan data".mysql_error());

    //$isi = str_replace('xid', date('d-m-Y'), $isi);
    $isi = str_replace('xid', $data['xid'], $isi);
    $isi = str_replace('xuser', $data['xuser'], $isi);
    $isi = str_replace('xpass', $data['xpass'], $isi);
    //$isi = str_replace('datakelamin', $data['kelamin'], $isi);
    //$isi = str_replace('datatgl', $data['tgl_lahir'], $isi);
    //echo $isi;

    $f = fopen($target, "w+");
    fwrite($f, $isi);
    fclose($f);

    mysql_close($conn);

    echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=0;URL=$target>";

}
?>



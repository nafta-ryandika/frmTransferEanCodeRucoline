<?php
include("../../configuration.php");
include("../../connection.php");

if($_SESSION[$domainApp."_mydevelop"] == 0){
$url = $_SERVER['REQUEST_URI'];
$xurl = explode("/",$url);
//print_r($xurl);

foreach ($xurl as $key => $value) {
    $no += 1;
    
    if($no > 2){
        $link .= $value."/";
    }
}

$xlink = rtrim($link,'/');

$result = mysql_query("select * from xmenu a left join user_menu b on a.xid = b.xid_menu where b.id_user= ".$_SESSION[$domainApp."_myxid"]." and a.xlink_menu = '".$xlink."' ");
$data = mysql_fetch_array($result);
$myakses = $data['akses'];

}else{
    $myakses = "0-1-2-3";
}
//echo $data['akses'];
$id_tombol = explode("-",$myakses);
//die();
?>

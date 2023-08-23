<?php

include("../../configuration.php");
include("../../connection.php");
include("actsearch.php");

    // Get Variabel

    //Cek Get Data
if(isset($_POST['txtpage'])){
  $txtpage = $_POST['txtpage'];
  $showPage = $txtpage;
  $noPage = $txtpage;
}else{
  $txtpage = 1;
  $showPage = $txtpage;
  $noPage = $txtpage;
}
if(isset($_POST['txtperpage'])){
  $txtperpage=$_POST['txtperpage'];
}else{
  $txtperpage=10;
}

$offset = ($txtpage - 1) * $txtperpage;
$sqlLIMIT = " LIMIT $offset, $txtperpage";
$sqlWHERE = " ";

if(isset($_POST['txtfield'])){
  if($_POST['txtfield']!=''){
    $txtfield = $_POST['txtfield'];

    if(isset($_POST['txtparameter'])){
      if ($_POST['txtparameter']!=''){
        $txtparameter = $_POST['txtparameter'];
      }
    }

    if(isset($_POST['txtdata'])){
      if ($_POST['txtdata']!=''){
        $txtdata = $_POST['txtdata'];
      }
    }

    $txtfieldx = explode("|",rtrim($txtfield,'|'));
    $txtparameterx = explode("|",rtrim($txtparameter,'|'));
    $txtdatax = explode("|",rtrim($txtdata,'|'));

    for($a=0;$a<count($txtfieldx);$a++){
      $sqlWHERE .= multisearch('kmsoh',$txtfieldx[$a],$txtparameterx[$a],$txtdatax[$a]);
    }
  }
}

    //echo $sqlWHERE;
    // die();
//    echo "<INPUT id=\"filterkdsup\" class=\"textbox\" type=\"hidden\" name=\"filterkdsup\" value=\"$txtkdsup\">";
//    echo "<INPUT id=\"filtersupplier\" class=\"textbox\" type=\"hidden\" name=\"filtersupplier\" value=\"$txtsuplier\">";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <title>Form View</title>
</head>

<!--<link rel="stylesheet" href="css/style.css" type="text/css" />-->
<!--<link rel="stylesheet" type="text/css" href="css/frmstyle.css" />-->
<?php
$xrdm = date("YmdHis");
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"css/style.css?verion=$xrdm\" />";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"css/frmstyle.css?version=$xrdm\" />";
?>


  <body>
    <table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td>
         <div id="frmisi">
          <table id="myTable" class="tablesorter">
            <thead>
              <tr>
               <th align="center" rowspan="2">No</th>
               <th align="center" colspan="6">Sales Order</th>
               <th align="center" colspan="2">Master Barang Jadi</th>
               <th align="center" rowspan="2" width="5%">Status</th>
               <th align="center" rowspan="2" width="5%">...</th>
             </tr>
             <tr>
              <th align="center">No SO</th>
              <th align="center">Tgl SO</th>
              <th align="center"> Customer</th>
              <th align="center">Art. Customer</th>
              <th align="center">Art. KMBS</th>
              <th align="center">Kode Barang</th>
              <th align="center">Kode Master Barang Jadi</th>
              <th align="center">Deskripsi</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $sqlCOUNT = "SELECT *, IF(dt2.dkdbrg != '' AND dt3.spkdbrg != '', 1, 0) AS status
                        FROM
                        (
                        SELECT a.slnoso, a.sltglso, a.slkdcust
                        FROM kmsoh a
                        ) AS dt1
                        JOIN
                        (
                        SELECT b.dnoso, b.dkdbrg, b.dartcust, b.dartprod
                        FROM kmsod b
                        ) AS dt2 
                        ON dt1.slnoso = dt2.dnoso
                        LEFT JOIN
                        (
                        SELECT c.spkdbrg, c.spnmbrg
                        FROM kmbrgjadi c
                        ) AS dt3 
                        ON dt2.dkdbrg = dt3.spkdbrg
                        LEFT JOIN
                        (
                        SELECT d.cust, d.nama FROM kmcustomer d
                        ) AS dt4 
                        ON dt4.cust = dt1.slkdcust 
                        WHERE 1";
            $sqlCOUNT = $sqlCOUNT.$sqlWHERE;
          //echo $sqlCOUNT.'<br>';
            $result=mysql_query($sqlCOUNT);
            $count=mysql_num_rows($result);
//          mysql_free_result($result);

            $sql = "SELECT *, IF(dt2.dkdbrg != '' AND dt3.spkdbrg != '', 1, 0) AS status
                    FROM
                    (
                    SELECT a.slnoso, a.sltglso, a.slkdcust
                    FROM kmsoh a
                    ) AS dt1
                    JOIN
                    (
                    SELECT b.dnoso, b.dkdbrg, b.dartcust, b.dartprod
                    FROM kmsod b
                    ) AS dt2 
                    ON dt1.slnoso = dt2.dnoso
                    LEFT JOIN
                    (
                    SELECT c.spkdbrg, c.spnmbrg
                    FROM kmbrgjadi c
                    ) AS dt3 
                    ON dt2.dkdbrg = dt3.spkdbrg
                    LEFT JOIN
                    (
                    SELECT d.cust, d.nama FROM kmcustomer d
                    ) AS dt4 
                    ON dt4.cust = dt1.slkdcust 
                    WHERE 1";
            $sql=$sql.$sqlWHERE.$sqlLIMIT;
          // echo $sql;
            $result=mysql_query($sql);

          // menentukan jumlah halaman yang muncul berdasarkan jumlah semua data
            $jumPage = ceil($count/$txtperpage);

          //echo $count;
            if($count>0){
          // Register $myusername, $mypassword and redirect to file "login_success.php"
          //  $row = mysql_fetch_row($result);
              $row = $offset;
              while ($data = mysql_fetch_array($result, MYSQL_BOTH)){
                $row += 1;
                ?>
                <tr onMouseOver="this.className='highlight'" onMouseOut="this.className='normal'">
                  <td align="center" nowrap><?php echo $row; ?></td>
                  <td align="left" nowrap><?php echo $data["slnoso"]; ?></td>
                  <td align="center" nowrap><?php echo $data["sltglso"]; ?></td>
                  <td align="center" nowrap><?php echo $data["nama"]; ?></td>
                  <td align="center" nowrap><?php echo $data["dartcust"]; ?></td>
                  <td align="center" nowrap><?php echo $data["dartprod"]; ?></td>
                  <td align="left" nowrap><?php echo $data["dkdbrg"]; ?></td>
                  <td align="left" nowrap><?php echo $data["spkdbrg"]; ?></td>
                  <td align="left" nowrap><?php echo $data["spnmbrg"]; ?></td>
                  <td align="center" nowrap>
                  <?php $status = $data["status"]; 
                    if ($status == 1) {
                      $img = "img/s_okay.png";
                    }
                    else{
                      $img = "img/s_error.png";
                    }
                  ?>
                    <img src="<?=$img?>">
                  </td>
                  <td align="center" nowrap>
                    <div style="margin: auto;">
                    <?php
                    if ($status != 1) {
                      ?>
                      <input type="button" value="[+]" onclick="parent.createNewTab('dhtmlgoodies_tabView1','Master Barang Jadi','','frmarea.php?cdx=frmMasterBrgJadi ',true);return false" title="158 - Master Barang Jadi">
                      <!-- <a style="margin: auto;" onclick="parent.createNewTab('dhtmlgoodies_tabView1','Master Barang Jadi','','frmarea.php?cdx=frmMasterBrgJadi ',true);return false" title="158 - Master Barang Jadi" href="#">Add New</a> -->
                      <?php
                    }
                  ?>
                    </div>
                  </td>
                </tr>
                <?php
              }
              mysql_free_result($result);
            }
            ?>
          </tbody>
        </table>
      </div>
    </td>
  </tr>
  <tr>
    <td>
      <table width="100%"  border="0" cellspacing="0" cellpadding="0" class="info_fieldset">
        <tr>
          <td><div align="left"><input id="jumpage" name="nmjmlrow" type="hidden" value="<?php echo $jumPage; ?>">Records: <?php echo ($offset + 1); ?> / <?php echo $row; ?> of <?php echo $count; ?> </div></td>
          <td>
            <div align="right">
              <?php

              echo "Page [ ";

// menampilkan link previous

              if ($txtpage > 1) {$prevpage = $txtpage - 1; echo  "<a href='#' onClick='showpage(".$prevpage.")'>&lt;&lt; Prev</a>";}

// memunculkan nomor halaman dan linknya

              for($page = 1; $page <= $jumPage; $page++)
              {
               if ((($page >= $noPage - 10) && ($page <= $noPage + 10)) || ($page == 1) || ($page == $jumPage))
               {
                if (($showPage == 1) && ($page != 2))  echo "...";
                if (($showPage != ($jumPage - 1)) && ($page == $jumPage))  echo "...";
                if ($page == $noPage) echo " <b>".$page."</b> ";
                else echo " <a href='#' onClick='showpage(".$page.")'>".$page."</a> ";
                $showPage = $page;
              }

//    echo " <a href='#' onClick='showpage(".$page.")'>".$page."</a> ";

            }

// menampilkan link next

            if ($txtpage < $jumPage) {$nextpage = $txtpage + 1; echo "<a href='#' onClick='showpage(".$nextpage.")'>Next &gt;&gt;</a>";}

            echo " ] ";

            ?>
          </div>
        </td>
      </tr>
    </table>
  </td>
</tr>
</table>
<FORM id="formexport" name="nmformexport" action="export.php" method="post" onsubmit="window.open ('', 'NewFormInfo', 'scrollbars,width=730,height=500')" target="NewFormInfo">
  <input id="txtSQL" name="nmSQL" type="hidden" value="<?php echo $sql; ?>">
</FORM>
<?php //echo $sql; ?>
</body>

</html>
<?php
mysql_close($conn);
?>

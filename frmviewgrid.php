<?php

    include("../../configuration.php");
    include("../../connection.php");
    include("../../endec.php");

    // Get Variabel
    // var data = "txtpage="+$("#txtpage").val()+"&txtperpage="+$("#txtperpage").val()+"&txtid="+$("#txtid").val()+"&txtuser="+$("#txtuser").val()+"&txtgroup="+$("#txtgroup").val()+"&txtname="+$("#txtname").val();
    //$txtpage=$_POST['txtpage'];
    //$txtperpage=$_POST['txtperpage'];
    //$txtid=$_POST['txtid'];
    //$txtuser=$_POST['txtuser'];
    //$txtgroup=$_POST['txtgroup'];
    //$txtname=$_POST['txtname'];
    // echo $page;

    //Cek Get Data
    if(isset($_POST['nmSQL'])){
      $txtSQL = $_POST['nmSQL'];
    }else{
      $txtSQL = "";
    }
    //echo 'aden'.$txtSQL;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <title>Form View</title>
</head>

<link rel="stylesheet" href="css/style.css" type="text/css" />
<link rel="stylesheet" type="text/css" href="css/frmstyle.css" />
<script type="text/javascript" src="js/jquery-latest.js"></script>
<script type="text/javascript" src="js/jquery.tablesorter.js"></script>

<script type="text/javascript">

$(document).ready(function()
    {
        $("#myTable").tablesorter();
    }
);

</script>


<body>
<div align="center">Laporan User</div>
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>
	<div id="frmisi">
		<table id="myTable" class="tablesorter">
		<thead>
		<tr>
			<th>No</th>
			<!--<th>...</th>-->
			<th>ID</th>
			<th>User</th>
			<th>Password</th>
            <th>Group</th>
            <th>Name</th>
		</tr>
		</thead>
		<tbody>
<?php
          $sqlCOUNT = $txtSQL;
          //$sqlCOUNT = $sqlCOUNT.$sqlWHERE;
          //echo $sqlCOUNT;
          $result=mysql_query($sqlCOUNT);
          $count=mysql_num_rows($result);
          mysql_free_result($result);

          $sql = $txtSQL;
          //$sql=$sql.$sqlWHERE.$sqlLIMIT;
          $result=mysql_query($sql);

          // menentukan jumlah halaman yang muncul berdasarkan jumlah semua data
          //$jumPage = ceil($count/$txtperpage);

          //echo $count;
          if($count>0){
          // Register $myusername, $mypassword and redirect to file "login_success.php"
          //  $row = mysql_fetch_row($result);
            $row = $offset;
            while ($data = mysql_fetch_array($result, MYSQL_BOTH)){
            $row += 1;
?>
		<tr onMouseOver="this.className='highlight'" onMouseOut="this.className='normal'">
            <td><?php echo $row; ?></td>
            <!--<td><?php echo "<input id='chk'".$data['xid']." type='checkbox' name='chk'".$data['xid']." value='".$data["xid"]."' >"; ?></td>-->
			<td><?php echo $data["xid"]; ?></td>
			<td><?php echo $data["xuser"]; ?></td>
			<td><?php echo $data["xpass"]; ?></td>
			<td><?php echo $data["xgroup"]; ?></td>
			<td><?php echo $data["xname"]; ?></td>
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
    </td>
  </tr>
</table>
<?php //echo $sql; ?>
</body>

</html>
<?php
mysql_close($conn);
?>

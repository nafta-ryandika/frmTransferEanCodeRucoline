<?php

include("../../configuration.php");
include("../../connection.php");
include("../../endec.php");
include("akses.php");
require_once('calendar/classes/tc_calendar.php');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <title>Form Transfer EAN Code RUCOLINE</title>
  <META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta http-equiv="expires" content="0">
    <META HTTP-EQUIV="PRAGMA" CONTENT="NO-CACHE">
    </head>


   <script language="javascript" src="calendar/calendar.js"></script>

    <link rel="stylesheet" href="../../theme/south-street/jquery-ui-1.8.13.custom.css">
    <!-- <script src="../../js/jquery-1.5.1.js"></script> -->
    <script src="../../js/ui/jquery.ui.core.js"></script>
    <script src="../../js/ui/jquery.ui.widget.js"></script>
    <script src="../../js/ui/jquery.ui.datepicker.js"></script>
    <link rel="stylesheet" href="css/demos.css">

    <!-- MODAL DIALOG -->
    <script type="text/javascript" src="../../js/jquery.js"></script>
    <script type="text/javascript" src="../../js/jquery-ui.js"></script>
    <link rel="stylesheet" href="../../css/jquery-ui.css"/>

    <?php
    $xrdm = date("YmdHis");
    echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"css/style.css?verion=$xrdm\" />";
    echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"css/frmstyle.css?version=$xrdm\" />";
    ?>
    <link href="calendar/calendar.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="js/frm1.js"></script>


    <body>
      <table id="tabelview" width="100%"  border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td>
            <table width="100%"  border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td colspan="2">
                  <div align="left">
                    <span style="font-size: 14px;font:Arial, Helvetica, sans-serif;font-weight: bold;">
                      Form Transfer EAN Code RUCOLINE
                    </span>
                    <hr />
                  </div>
                </td>
              </tr>
            </table>
          </td>
        </tr>
        <tr>
          <td>
            <div>
              <fieldset class="info_fieldset"><legend>Import File Excel</legend>
                <iframe name="upload-frame" id="upload-frame" style="display:none;"></iframe>
                <form id="formupload" name="formupload" method="POST" enctype="multipart/form-data" target="upload-frame" onSubmit="">
                  <div style="width: 100%; text-align: center;">
                    <input type="file" name="file" id="file"  style="margin: 5px; width: 500px;" onchange="importxls()">
                    <img align="center" src="img/loading1.gif" id="loader" style="display:none" />
                    <span id="upload-status"></span>
                    <br/>
                    <INPUT id="cmdupload" class="buttonadd" type="submit" name="import" value="Upload" onclick="return upload()">
                    <INPUT id="cmdtransfer" class="buttongofind" type="button" name="nmcmdfind" value="Transfer" onclick="transfer()">
                    <INPUT id="cmdcancel" class="buttondelete" type="button" name="nmcmdcancel" value="Clear" onclick="clearinput()">
                  </div>
                </form>
              </fieldset>
            </div>
          </td>
        </tr>
        <tr>
          <td>
            &nbsp;
          </td>
        </tr>
      </table>

      <table id="tabelinput" width="100%"  border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td>
            <input id="intxtmode" name="innmmode" type="hidden" value="">Mode: <span id="mode"></span>
          </td>
        </tr>
        <tr>
          <td><hr></td>
        </tr>
        <tr>
          <td>
            <div id="areaedit" style="display:none"></div>
            <div id="areainput"></div>
          </td>
        </tr>
      </table>

      <div id="dialog-open"></div>

    </body>

    </html>
    <?php
    mysql_close($conn);
    ?>

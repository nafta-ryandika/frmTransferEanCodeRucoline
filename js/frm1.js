$(document).ready(function(){
  $("#frmloading").hide();
  $("#tabelinput").hide();

  $('#insize,#insize_1,#insln_tukar').keydown(function(e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if (
          $.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
          // Allow: Ctrl/cmd+A
          (e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
          // Allow: Ctrl/cmd+C
          (e.keyCode == 67 && (e.ctrlKey === true || e.metaKey === true)) ||
          // Allow: Ctrl/cmd+X
          (e.keyCode == 88 && (e.ctrlKey === true || e.metaKey === true)) ||
          // Allow: home, end, left, right
          (e.keyCode >= 35 && e.keyCode <= 39)
        ) {
          // let it happen, don't do anything
          return;
        }
        // Ensure that it is a number and stop the keypress
        if (
          (e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) &&
          (e.keyCode < 96 || e.keyCode > 105)
        ) {
          e.preventDefault();
        }
      });

  $("input[name=insize],input[name=insize_1],input[name=insetsize],select").bind("keydown", function(event) {
    if (event.which === 13) {
        event.stopPropagation();
        event.preventDefault();
       $(':input:eq(' + ($(':input').index(this) + 1) +')').focus();
    }
  });

  $('#formupload').on('submit', function(event){  
    event.preventDefault();
    if (confirm("Upload Data ?")){
      $("#cmdupload").prop("disabled", true);
      $.ajax({  
          url:"import_excel.php",  
          method:"POST",  
          data:new FormData(this),  
          contentType:false,
          cache:false,  
          processData:false,
          beforeSend: function() {
            $("#loader").show();
            $("#upload-status").css('color','green');
            $("#upload-status").text("Please Wait ... Still Uploading Data");
            disabled();
          },
          success:function(data){
            if (data == 0){
              alert("Format Kolom Excel Tidak Sesuai !");
              clearinput();
              $("#loader").hide();
              $("#upload-status").text("");
              enabled();
            }
            else {
              if (data == "Upload Gagal!") {
                alert(data);
                $("#loader").hide();
                $("#upload-status").text("");
                enabled();
              }
              else {
                alert(data);  
                // clearinput();
                $("#loader").hide();
                $("#upload-status").text("");
                enabled();
                // $("#cmdupload").hide();
              }
            }
          }  
      })
    }
    $("#cmdupload").prop("disabled", false);
  });

});

function enterfind(event){
  if(event.keyCode==13){
    findclick();
  }else{
    return ;
  }
};

function findclick(){
  var n = $(".txtfield").length;
  var txtfield = '';
  var txtparameter = '';
  var txtdata = '';
  var data = '';
  
  if(n > 1){
    $(".txtfield").each(function () {
      txtfield += $(this).val()+"|";
    });
    
    $(".txtparameter").each(function () {
      txtparameter += $(this).val()+"|";
    });
        
    $(".txtdata").each(function () {
      txtdata += $(this).val()+"|";
    });
            
    data = "txtpage="+$("#txtpage").val()+
         "&txtperpage="+$("#txtperpage").val()+
         "&txtfield="+txtfield+
         "&txtparameter="+txtparameter+
         "&txtdata="+txtdata+
         "";   
  }
  else{
    data = "txtpage="+$("#txtpage").val()+
         "&txtperpage="+$("#txtperpage").val()+
         "&txtfield="+$(".txtfield").val()+
         "&txtparameter="+$(".txtparameter").val()+
         "&txtdata="+$(".txtdata").val()+
         "";
  }
               
  $("#frmbody").slideUp('slow',function(){
    $("#frmloading").slideDown('slow',function(){
      $.ajax({
        url: "frmview.php",
        type: "POST",
        data: data,
        cache: false,
        success: function (html) {
                $("#frmcontent").html(html);
                $("#frmbody").slideDown('slow',function(){
                $("#frmloading").slideUp('slow');
          });
          }
      });
    });
  });
};

function addnewclick(){
  showinput();
  clearinput();
  $("#intxtmode").val('add');
  $("#mode").text('Add New');
  $("#inkdin").val('~AUTO~');
  $("#tabelview").fadeOut("slow",function(){
    $("#tabelinput").fadeIn("slow");
  });
};

function showinput(){
  $.ajax({
    url: "frminput.php",
    cache: false,
    success: function(html) {
      $("#areainput").html(html);
    }
  });
}

function deleteclick(){
  $("input:checked").each(function () {
      //alert('coba');
      $("#intxtmode").val('delete');
      var data = "intxtmode=delete&inkode="+$(this).val()+"";
      $.ajax({
       url: "actfrm.php",
       type: "POST",
       data: data,
       cache: false,
       success: function(data) {
        alert(data);
      }
    });
    });
  findclick();
};

function editclick(){
  var n = $("input:checked").length;
  if (n>1){
    alert('Just one select for edit');
  }else if(n==0){
    alert('You must select One for edit');
  }else{
    showinput();
    clearinput();
    $("#intxtmode").val('edit');
    $("#mode").text('Edit');
    var data = "intxtmode=getedit&inkode="+$("input:checked").val()+"";
    $.ajax({
    	url: "actfrm.php",
    	type: "POST",
    	data: data,
    	cache: false,
    	success: function(data) {
        $("#areaedit").html(data);
                setinput();
        $("#tabelview").fadeOut("slow",function(){
          $("#tabelinput").fadeIn("slow");
        });
      }
    });
  };
};

function exportclick(){
  var randomnumber=Math.floor(Math.random()*11)
  var exptype = $("#exporttype").val();
  switch (exptype)
  {
    case 'grd':
    $("#formexport").attr('action', 'frmviewgrid.php');
    $("#formexport").submit();
    break;
    case 'pdf':
    $("#formexport").attr('action', 'frmviewpdf.php');
    $("#formexport").submit();
    break;
    case 'xls':
    $("#formexport").attr('action', 'frmviewxls.php');
    $("#formexport").submit();
    break;
    case 'csv':
    $("#formexport").attr('action', 'frmviewcsv.php');
    $("#formexport").submit();
    break;
    case 'txt':
    $("#formexport").attr('action', 'frmviewtxt.php');
    $("#formexport").submit();
    break;
    default:
    alert('Unidentyfication Type');
  }
};

function setinput(){
  $("#inkode").val($("#getKODE").text());
  $("#indata1").val($("#getDATA1").text());
  $("#indata2").val($("#getDATA2").text());
  $("#indata3").val($("#getDATA3").text());
  $("#indata4").val($("#getDATA4").text());
  $("#indata5").val($("#getDATA5").text());
};

function clearinput(){
  $("#file").val('');
  $("#indkdassort").val('');
  $("#innmassort").text('');
  $("#insln_tukar").val('');
};

function disabled(){
  $("#file").attr('disabled',true);
  $("#indkdassort").attr('disabled',true);
  $("#innmassort").attr('disabled',true);
  $("#insln_tukar").attr('disabled',true);
}

function enabled(){
  $("#file").attr('disabled',false);
  $("#indkdassort").attr('disabled',false);
  $("#innmassort").attr('disabled',false);
  $("#insln_tukar").attr('disabled',false);
}

function saveclick(){
  $("#cmdsave").attr('disabed','disabled');

  var data = "intxtmode="+$("#intxtmode").val()+
  "&inkode="+$("#inkode").val()+
  "&indata1="+encodeURIComponent($("#indata1").val())+
  "&indata2="+encodeURIComponent($("#indata2").val())+
  "&indata3="+encodeURIComponent($("#indata3").val())+
  "&indata4="+encodeURIComponent($("#indata4").val())+
  "&indata5="+encodeURIComponent($("#indata5").val())+
  "";
  //alert(data);
  $.ajax({
    url: "actfrm.php",
    type: "POST",
    data: data,
    cache: false,
    success: function(data) {
      alert("Data Loaded: " + data);
      if ($("#intxtmode").val()=='edit'){
        cancelclick();
      }else{
        clearinput();
      }
        $("#cmdsave").attr('disabed','');
    }
  });
};

function cancelclick(){
  clearinput();
  $("#intxtmode").val('');
  $("#mode").text('');
  $("#tabelinput").fadeOut("slow",function(){
    $("#tabelview").fadeIn("slow",findclick());
  });
};

function searchclick(){
  if ($("#areasearch").is(":hidden")) {
    $("#areasearch").slideDown("slow");
  } else {
    $("#areasearch").slideUp("slow");
  }
};

function setnama(){
    var data ="intxtmode=setnmassort&inkdassort="+$("#indkdassort").val()+"";
    $.ajax({
        url: "actfrm.php",
        type: "POST",
        data: data,
        cache: false,
        success: function (data) {
            $("#innmassort").text(data);
        }
    });
};

function openDialog() {
    $.ajax({
      url: "frmModal.php",
      type: "POST",
      cache: false,
      success: function(html) {
        $("#frmbody").slideDown("slow");
        $("#dialog-open").html(html);

        var width = screen.width;
        var height = screen.height;
        var lebar = width * 60 / 100;
        var tinggi = height * 40 / 100;

        $("#dialog-open").dialog({
          autoOpen: true,
          modal: true,
          height: tinggi,
          width: lebar,
          title: "View Customer",
          close: function(event) {
            $("#dialog-open").hide();
            $("#dialog-open").html("");
          }
        });
      }
    });
}

function setFilterData(rowx) {
  if ($("#txtfield" + rowx).val() == "IF(dt2.dkdbrg != '' AND dt3.spkdbrg != '', 1 , 0)") {
    var data_select =
      "Data : \n\
      <select class='txtdata'>\n\
      <option value=''>-</option>\n\
      <option value='1'>OK</option>\n\
      <option value='0'>Belum Dibuat</option>\n\
      </select>";
    $("#filter_data" + rowx).html(data_select);
  } else {
    var data_select =
      "Data : <input type='text' class='txtdata' onkeydown='enterfind(event)'>";

    $("#filter_data" + rowx).html(data_select);
  }
}

function check(){
    var data ="intxtmode=checktemp";
    $.ajax({
        url: "actfrm.php",
        type: "POST",
        data: data,
        cache: false,
        success: function (data) {
            return "ok";
        }
    });
};

function transfer(){
  if (confirm("Transfer Data ?")){
  var data ="intxtmode=checktemp";
    $.ajax({
      url: "actfrm.php",
      type: "POST",
      data: data,
      cache: false,
      beforeSend: function() {
            $("#loader").show();
            $("#upload-status").css('color','green');
            $("#upload-status").text("Please Wait ... Still Saving Data");
            disabled();
          },
      success: function (data) {
          if (data == 0){
            $("#loader").hide();
            $("#upload-status").text("");
            alert("Data Tidak Ditemukan !");
            enabled();
          }
          else{
            var data ="intxtmode=checkpo";
            $.ajax({
              url: "actfrm.php",
              type: "POST",
              data: data,
              cache: false,
              success: function (data) {
                if (data == 0){
                  insert();
                }
                else {
                  if (confirm("Data No. P O Tersebut Sudah Ada..! \nUpdate Data...!?")){
                    delete_ean(data);
                    insert();
                  }
                  else{
                    delete_temp(data);
                    $("#loader").hide();
                    $("#upload-status").text("");
                    enabled();
                    clearinput();
                  }
                }
              }
            })
          }
      }
    });
  }
}

function insert(){
  $("#cmdtransfer").prop("disabled", true);
    var data ="intxtmode=transfer";
    $.ajax({
      url: "actfrm.php",
      type: "POST",
      data: data,
      cache: false,
      success: function (data) {
        var result = data.split('|');
        alert(" Import Success \n Jumlah Data : "+result[0]+" \n Import Success : "+result[1]+" \n Import Gagal : "+result[2]+"");
        // $("#cmdupload").show();
        $("#loader").hide();
        $("#upload-status").text("");
        enabled();
        clearinput();
      }
    });
  $("#cmdtransfer").prop("disabled", false);
}

function delete_temp(nopo){
  var data ="intxtmode=delete_temp&nopo="+nopo+"";
    $.ajax({
        url: "actfrm.php",
        type: "POST",
        data: data,
        cache: false,
        success: function (data) {
            // alert("temp file deleted");
        }
    });
}

function delete_ean(nopo){
  var data ="intxtmode=delete_ean&nopo="+nopo+"";
    $.ajax({
        url: "actfrm.php",
        type: "POST",
        data: data,
        cache: false,
        success: function (data) {
            // alert("ean file deleted");
        }
    });
}

function hasExtension(inputID, exts) {
  var fileName = document.getElementById(inputID).value;
  return (new RegExp('(' + exts.join('|').replace(/\./g, '\\.') + ')$')).test(fileName);
}

function upload(){
  if ($("#file").val() == "") {
    alert("Input File Excel Kosong !");
    $("#file").focus();
    return false;
  }
  else if(!hasExtension('file', ['.xls']) && !hasExtension('file', ['.XLS'])){
    alert("Invalid Format File Excel !");
    return false;
  }
}

// ******************************* START JS MULTISEARCH ***************************************
var xrow = 1;
function addSearch(){
  var table = document.getElementById("tblSearch");

        // Create an empty <tr> element and add it to the 1st position of the table:
        var row = table.insertRow(xrow);

        // Insert new cells (<td> elements) at the 1st and 2nd position of the "new" <tr> element:
        var cell1 = row.insertCell(0);
        var cell2 = row.insertCell(1);
        var cell3 = row.insertCell(2);
        var cell4 = row.insertCell(3);
        var cell5 = row.insertCell(4);
        
//        cell2.className = 'txtmultisearch';

        // Add some text to the new cells:
        cell1.innerHTML = 
        "Field : \n\
        <select class='txtfield' id='txtfield" +
        xrow +
        "' onchange=\"setFilterData(" +
        xrow +
        ")\">\n\
        <option value=''>-</option>\n\
        <option value='slnoso'>No. SO</option>\n\
        <option value=\"DATE_FORMAT(sltglso,'%d/%m/%Y')\" >Tgl. SO</option>\n\
        <option value='slkdcust' >Kode Customer</option>\n\
        <option value='dartcust' >Art. Customer</option>\n\
        <option value='dartprod' >Art. KMBS</option>\n\
        <div id='filter_data"+xrow+"'>Data : \n\
        <option value=\"IF(dt2.dkdbrg != '' AND dt3.spkdbrg != '', 1 , 0)\">Status (Kode Barang Jadi)</option>\n\
        </div>\n\
        </select>";
        cell2.innerHTML = "<select class='txtparameter' id='txtparameter"+xrow+"'>\n\
        <option value='equal'>equal</option>\n\
        <option value='notequal'>not equal</option>\n\
        <option value='less'>less</option>\n\
        <option value='lessorequal'>less or equal</option>\n\
        <option value='greater'>greater</option>\n\
        <option value='greaterorequal'>greater or equal</option>\n\
        <option value='isnull'>is null</option>\n\
        <option value='isnotnull'>is not null</option>\n\
        <option value='isnotnull'>is not null</option>\n\
        <option value='isin'>is in</option>\n\
        <option value='isnotin'>is not in</option>\n\
        <option value='like'>like</option>\n\
        </select>";
        cell3.innerHTML = 
        "<div id='filter_data" +
          xrow +
          "'>Data : <input type='text' class='txtdata' onkeydown='enterfind(event)'></div>";
        cell4.innerHTML = "<input type='button' value='[+]' onclick='addSearch()'>";
        cell5.innerHTML = "<input type='button' value='remove' onclick=\"deleteRow(this)\" style='cursor:pointer;'>";
        
        xrow++;
      }

      function deleteRow(btn) {
      //
      if (btn == "rmv1") {
        $("#txtfield0").val("");
        $("#txtparameter0").val("equal");

        var data_select =
        "Data : <input type='text' class='txtdata' onkeydown='enterfind(event)'>";

        $("#filter_data0").html(data_select);
        $("#txtdata0").val("");
      } else {
        var row = btn.parentNode.parentNode;
        row.parentNode.removeChild(row);
        xrow--;
      }
    }

// ******************************* END JS MULTISEARCH ***************************************

function showpage(page){
  $("#txtpage").val(page);
  findclick();
}

function prevpage(){
  var n = eval($("#txtpage").val())-1 ;
  if (n >= 1) {
    $("#txtpage").val(n);
    findclick();
  }
}

function nextpage(){
  var n = eval($("#txtpage").val())+1 ;
  if (eval(n)<=eval($("#jumpage").val())){
    $("#txtpage").val(n);
    findclick();
  }
}

$(function() {
  $( "#tglmasuk" ).datepicker({
    dateFormat: "dd/mm/yy",
    changeMonth : true,
    changeYear  : true
  });
  $( "#tglkontrak" ).datepicker({
    dateFormat: "dd/mm/yy",
    changeMonth : true,
    changeYear  : true
  });
  $( "#intxttglmasuk" ).datepicker({
    dateFormat: "dd/mm/yy",
    changeMonth : true,
    changeYear  : true
  });
  $( "#intxttglkontrak" ).datepicker({
    dateFormat: "dd/mm/yy",
    changeMonth : true,
    changeYear  : true
  });
});


function MyValidDate(dateString){
    var validformat=/^\d{1,2}\/\d{1,2}\/\d{4}$/ //Basic check for format validity
    if (!validformat.test(dateString)){
      return ''
    }else{ //Detailed check for valid date ranges
      var dayfield=dateString.substring(0,2);
      var monthfield=dateString.substring(3,5);
      var yearfield=dateString.substring(6,10);
      var MyNewDate = monthfield + "/" + dayfield + "/" + yearfield;
      if (checkValidDate(MyNewDate)==true){
        var SQLNewDate = yearfield + "/" + monthfield + "/" + dayfield;
        return SQLNewDate;
      }else{
        return '';
      }
    }
  }

  function checkValidDate(dateStr) {
    // dateStr must be of format month day year with either slashes
    // or dashes separating the parts. Some minor changes would have
    // to be made to use day month year or another format.
    // This function returns True if the date is valid.
    var slash1 = dateStr.indexOf("/");
    if (slash1 == -1) { slash1 = dateStr.indexOf("-"); }
    // if no slashes or dashes, invalid date
    if (slash1 == -1) { return false; }
    var dateMonth = dateStr.substring(0, slash1)
    var dateMonthAndYear = dateStr.substring(slash1+1, dateStr.length);
    var slash2 = dateMonthAndYear.indexOf("/");
    if (slash2 == -1) { slash2 = dateMonthAndYear.indexOf("-"); }
    // if not a second slash or dash, invalid date
    if (slash2 == -1) { return false; }
    var dateDay = dateMonthAndYear.substring(0, slash2);
    var dateYear = dateMonthAndYear.substring(slash2+1, dateMonthAndYear.length);
    if ( (dateMonth == "") || (dateDay == "") || (dateYear == "") ) { return false; }
    // if any non-digits in the month, invalid date
    for (var x=0; x < dateMonth.length; x++) {
      var digit = dateMonth.substring(x, x+1);
      if ((digit < "0") || (digit > "9")) { return false; }
    }
    // convert the text month to a number
    var numMonth = 0;
    for (var x=0; x < dateMonth.length; x++) {
      digit = dateMonth.substring(x, x+1);
      numMonth *= 10;
      numMonth += parseInt(digit);
    }
    if ((numMonth <= 0) || (numMonth > 12)) { return false; }
    // if any non-digits in the day, invalid date
    for (var x=0; x < dateDay.length; x++) {
      digit = dateDay.substring(x, x+1);
      if ((digit < "0") || (digit > "9")) { return false; }
    }
    // convert the text day to a number
    var numDay = 0;
    for (var x=0; x < dateDay.length; x++) {
      digit = dateDay.substring(x, x+1);
      numDay *= 10;
      numDay += parseInt(digit);
    }
    if ((numDay <= 0) || (numDay > 31)) { return false; }
    // February can't be greater than 29 (leap year calculation comes later)
    if ((numMonth == 2) && (numDay > 29)) { return false; }
    // check for months with only 30 days
    if ((numMonth == 4) || (numMonth == 6) || (numMonth == 9) || (numMonth == 11)) {
      if (numDay > 30) { return false; }
    }
    // if any non-digits in the year, invalid date
    for (var x=0; x < dateYear.length; x++) {
      digit = dateYear.substring(x, x+1);
      if ((digit < "0") || (digit > "9")) { return false; }
    }
    // convert the text year to a number
    var numYear = 0;
    for (var x=0; x < dateYear.length; x++) {
      digit = dateYear.substring(x, x+1);
      numYear *= 10;
      numYear += parseInt(digit);
    }
    // Year must be a 2-digit year or a 4-digit year
    if ( (dateYear.length != 2) && (dateYear.length != 4) ) { return false; }
    // if 2-digit year, use 50 as a pivot date
    if ( (numYear < 50) && (dateYear.length == 2) ) { numYear += 2000; }
    if ( (numYear < 100) && (dateYear.length == 2) ) { numYear += 1900; }
    if ((numYear <= 0) || (numYear > 9999)) { return false; }
    // check for leap year if the month and day is Feb 29
    if ((numMonth == 2) && (numDay == 29)) {
      var div4 = numYear % 4;
      var div100 = numYear % 100;
      var div400 = numYear % 400;
        // if not divisible by 4, then not a leap year so Feb 29 is invalid
        if (div4 != 0) { return false; }
        // at this point, year is divisible by 4. So if year is divisible by
        // 100 and not 400, then it's not a leap year so Feb 29 is invalid
        if ((div100 == 0) && (div400 != 0)) { return false; }
      }
    // date is valid
    return true;
  }

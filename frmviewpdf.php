<?php

include("../../configuration.php");
include("../../connection.php");
include("../../endec.php");

//Class For Pdf
//require('mysql_report.php');
require('../../fpdf16/mc_table1.php');

//Cek Get Data
if(isset($_POST['nmSQL'])){
  $txtSQL = $_POST['nmSQL'];
}else{
  $txtSQL = "";
}


$image1 = "img/logokmbs.jpg";



$xname = $_SESSION[$domainApp."_myname"];
$xgroup = $_SESSION[$domainApp."_mygroup"];

class PDF extends PDF_MC_Table
 {
   //Fungsi Untuk Membuat Header
 function Header()
 {
  global $image1,$xname,$xgroup,$brandApp;
  $this->SetLeftMargin(10);
// $image1 = "logokmbs.jpg";
  $this->SetFont("arial","B",7);
  $this->Cell(10.25, 7.5, $this->Image($image1, $this->GetX(), $this->GetY(), 10.25,7.5), 0, 0, 'L', false );
  $this->Cell(0,7.5,"PT KARYAMITRA BUDISENTOSA",'',0,'L');
  $this->ln(10);
  $this->SetFont("arial","B",7);
  $this->Cell(0,5,"CONTOH LAPORAN",'',0,'L');
  $this->ln();

  $this->SetFont("arial","B",5);
  $this->Cell(5,4,"NO",'RLBT',0,'C');
  $this->Cell(100,4,"PICTURE",'RLBT',0,'C');
  $this->Cell(80,4,"KETERANGAN",'RLBT',0,'C');
  $this->ln();

 }

  function Footer()
 {
  global $xname,$xgroup,$brandApp;
 //Position at "n" cm from bottom
 $this->SetY(-20);
 //Arial italic 8
 $this->SetFont('Arial','',6);
 //Page number
// $this->Cell(0,10,'FM-MCH-008 - 4 Januari 13-01','',0,'L');
 $today = date("d/m/Y H:i:s");
 $this->Cell(0,10,'Tgl Cetak : '.$today .' by '.$xname.' # '.$xgroup,0,0,'L');
 $this->Cell(0,10,'Halaman ke : '.$this->PageNo().'/{nb}',0,0,'R');
 }

 }

 $pdf=new PDF('P','mm','A4');
 $pdf->AliasNbPages();
 $pdf->Open();
 $pdf->AddPage();
//left body margin
 $pdf->SetLeftMargin(10);

  $pdf->SetWidths(array(5,100,80));
  srand(microtime()*1000000);

  $batas = 6;
  $row = 1;
  $result = mysql_query($txtSQL);
  
  $dataX = 115;
  $dataY = 30;
  $looping = 25;
  while($data = mysql_fetch_array($result)){
//      $row +=1;

    $pdf->SetFont('arial','',6);

    if($row==$batas){
        $pdf->AddPage();
	 $dataX = 115;
  	$dataY = 30;
    //left body margin
        $pdf->SetLeftMargin(10);
        $batas = $batas+5;
    }

//
    $pdf->Row(array($row,"img/adidas.jpg|img/sneakers.jpg|img/sepatu_hitam.jpg",
                        "Data1@#@".$data['data1']."@|@".
                        "Data1@#@".$data['data2']."@|@".
                        "Data1@#@".$data['data3']
                  ),
                array('C','C','L'),
                array($dataX,$dataX,$dataX),
                array($dataY,$dataY,$dataY)
            );

    
    $dataY = $dataY+$looping;
    $row++;
  }


$pdf->Output("ContohLaporan.pdf",'I');
?>

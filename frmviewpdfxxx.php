<?php

include("../../configuration.php");
include("../../connection.php");
include("../../endec.php");

//Class For Pdf
//require('mysql_report.php');
require('../../fpdf16/fpdf.php');

//Cek Get Data
if(isset($_POST['nmSQL'])){
  $txtSQL = $_POST['nmSQL'];
}else{
  $txtSQL = "";
}


// Get Varibel



// Create Class PDF extends

class PDF extends FPDF
 {

 //Fungsi Untuk Membuat Header
 function Header()
 {
  global $namePT,$nameDivision,$domainApp;

    $today = date("d/m/Y H:i:s");
 //Pilih font Arial bold 15
   $this->SetFont("Arial","B",12);
  //left header margin
//   $this->SetTopMargin(0.1);
   $this->SetLeftMargin(2);
   $judul='Contoh Judul Laporan';
   $this->Ln();
   $this->Cell(0,1,$namePT,0,0,'L');
   $this->Ln(0.5);
   $this->Cell(0,1,$judul,0,0,'L');
   $this->Ln(0.5);
   $this->SetFont("Arial","",10);
   
   $this->Cell(0,1,'Tgl Cetak : '.$today.'   by  '.$_SESSION[$domainApp."_myname"],0,0,'R');

   //Ganti baris 1 cm
 $this->Ln(1);
 $this->SetFont("Arial","B",9);
 $this->Cell(0.5,0.5,'No','LRT',0,'C');
 $this->Cell(5,0.5,'Kolom 1','LRT',0,'C');
 $this->Cell(5,0.5,'Kolom 2','LRT',0,'C');
 $this->Cell(5,0.5,'Kolom 3','LRT',0,'C');
 $this->Cell(5,0.5,'Kolom 4','LRT',0,'C');
 $this->Cell(5,0.5,'Kolom 5','LRT',0,'C');
 $this->Ln();
 }

 //Fungsi Untuk Membuat Footer
 function Footer()
 {
 //Position at "n" cm from bottom
 $this->SetY(-6);
 //Arial italic 8
 $this->SetFont('Arial','I',8);
 //Page number
 $this->Cell(0,10,'Halaman ke : '.$this->PageNo().'/{nb}',0,0,'R');
 }
 }

// Create Data in PDF
 //create pdf
 $pdf = new PDF('L','cm','A4');
 $pdf->AliasNbPages();
 $pdf->Open();
 $pdf->AddPage();
//left body margin

$pdf->SetLeftMargin(2);

 $query=$txtSQL;
 //echo $query;
 $db_query = mysql_query($query) or die("Query gagal");

 //Variabel untuk iterasi
 $i = 0;

 //Mengambil nilai dari query database
 while ($data = mysql_fetch_array($db_query, MYSQL_BOTH))
 {
        $i++;
     //menampilkan data dari hasil query database
         $pdf->SetFont('Arial','',8);
         $pdf->Cell(0.5,0.5,$i,'LBTR',0,'C');
         $pdf->Cell(5,0.5,$data['data1'],'LBTR',0,'L');
         $pdf->Cell(5,0.5,$data['data2'],'LBTR',0,'L');
         $pdf->Cell(5,0.5,$data['data3'],'LBTR',0,'L');
         $pdf->Cell(5,0.5,$data['data4'],'LBTR',0,'L');
         $pdf->Cell(5,0.5,$data['data5'],'LBTR',0,'L');
         $pdf->Ln();
  }
 //menampilkan output berupa halaman PDF
 $pdf->Output("LaporanData.pdf",'I');


?>

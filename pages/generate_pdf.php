<?php
require('../fpdf182/fpdf.php'); 
include '../db.php'; 

class PDF extends FPDF
{
    // Header
    function Header()
    {
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(0, 10, 'Laporan Pengadaan Aset Desa Sukamukti', 0, 1, 'C');
        $this->Ln(5);
    }

    // Footer
    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Halaman ' . $this->PageNo(), 0, 0, 'C');
    }

    // Table
    function AssetTable($header, $data)
    {
        // Header
        $this->SetFont('Arial', 'B', 10);
        $w = array(25, 70, 50, 30, 35, 25, 30, 30, 40, 40); 
        for($i=0; $i<count($header); $i++) {
            $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C');
        }
        $this->Ln();

        // Data
        $this->SetFont('Arial', '', 8);
        foreach ($data as $row) {
            $this->Cell($w[0], 6, $row['code'], 1, 0, 'C');
            $this->Cell($w[1], 6, $row['name'], 1);
            $this->Cell($w[2], 6, $row['brand'], 1);
            $this->Cell($w[3], 6, $row['volume'], 1, 0, 'C');
            $this->Cell($w[4], 6, $row['ownership_proof'], 1);
            $this->Cell($w[5], 6, $row['year_bought'], 1, 0, 'C');
            $this->Cell($w[6], 6, number_format($row['acquisition_value'], 0, ',', '.'), 1, 0, 'R');
            $this->Cell($w[7], 6, $row['condition'], 1);
            $this->Cell($w[8], 6, $row['responsible'], 1);
            $this->Cell($w[9], 6, $row['placement'], 1, 0, 'C');
            $this->Ln();
        }
    }
}

// Mengambil data dari database
$sql = "SELECT * FROM asset_usage";
$result = $conn->query($sql);

// Menyiapkan data untuk PDF
$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

// Header tabel
$header = array('Kode Aset', 'Nama Aset', 'Merk', 'Volume', 'Bukti Kepemilikan', 'Tahun', 'Harga', 'Kondisi', 'Penanggung Jawab', 'Ruang Penempatan');

// PDF dalam bentuk Landscape
$pdf = new PDF('L', 'mm', 'A3'); 
$pdf->SetFont('Arial', '', 14);
$pdf->AddPage();
$pdf->AssetTable($header, $data);
$pdf->Output('D', 'Laporan_Aset_Desa.pdf'); 
?>
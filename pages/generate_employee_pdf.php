<?php
require('../fpdf182/fpdf.php');
include '../db.php';

class PDF extends FPDF
{
    // Header
    function Header()
    {
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, 'Laporan Data Karyawan Desa Sukamukti', 0, 1, 'C');
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
    function EmployeeTable($header, $data)
    {
        // Header
        $this->SetFont('Arial', 'B', 10);
        $w = array(35, 35, 40, 45, 40, 40, 40);
        for ($i = 0; $i < count($header); $i++) {
            $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C');
        }
        $this->Ln();

        // Data
        $this->SetFont('Arial', '', 8);
        foreach ($data as $row) {
            $this->Cell($w[0], 6, $row['name'], 1);
            $this->Cell($w[1], 6, $row['position'], 1);
            $this->Cell($w[2], 6, $row['address'], 1);
            $this->Cell($w[3], 6, $row['birth_details'], 1);
            $this->Cell($w[4], 6, $row['contact'], 1);
            $this->Cell($w[5], 6, $row['sk_number'], 1);
            $this->Cell($w[6], 6, $row['tmt'], 1);
            $this->Ln();
        }
    }
}

// Mengambil data dari database
$sql = "SELECT * FROM employees";
$result = $conn->query($sql);

// Menyiapkan data untuk PDF
$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

// Header tabel
$header = array('Nama', 'Jabatan', 'Alamat', 'Tempat, Tanggal Lahir', 'Kontak', 'Nomor SK', 'TMT');

// PDF dalam bentuk Landscape
$pdf = new PDF('L', 'mm', 'A4');
$pdf->SetFont('Arial', '', 14);
$pdf->AddPage();
$pdf->EmployeeTable($header, $data);
$pdf->Output('D', 'Laporan_Karyawan.pdf');
?>
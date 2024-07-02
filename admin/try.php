<?php
session_start();
if (isset($_SESSION['id']) && isset($_SESSION['user_name'])) {
    include('includes/header.php');
    include('includes/navbar.php');
    require 'db_conn.php';

    // Include the FPDF library
    require('fpdf/fpdf.php');

    // Create a new PDF instance
    $pdf = new FPDF();
    $pdf->AddPage();

    // Output the PDF content
    $pdf->SetFont('Arial','B',16);
    $pdf->Cell(40,10,'Hello World!');
    $pdfContent = $pdf->Output('', 'S');

    // Set the appropriate HTTP headers for downloading a PDF file
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="medical_records.pdf"');
    header('Content-Length: ' . strlen($pdfContent));

    // Output the PDF content to the browser
    echo $pdfContent;
}
?>

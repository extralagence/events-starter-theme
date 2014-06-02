<?php
// Import class
require_once('classes/fpdf.php'); 
require_once('classes/fpdi.php'); 
// Init
$pdf = new FPDI();
$pdf->AddPage(); 
// Open file
$pdf->setSourceFile('bank_transfer_model.pdf'); 
// Select page
$tplIdx = $pdf->importPage(1); 
$pdf->useTemplate($tplIdx, 0, 0, 0, 0, true); 
// Init text
$pdf->SetFont('Arial', '', '11'); 
$pdf->SetTextColor(0,0,0);
// Price
$pdf->SetXY(105.5, 79.4);
$pdf->Write(0, '1000,25 €');
// Command number
$pdf->SetXY(39, 137.3);
$pdf->Write(0, 'CR 2014 - Aurélien Bermond');
// Export the file
$pdf->Output('bank_transfer_'.time().'.pdf', 'F');
?>
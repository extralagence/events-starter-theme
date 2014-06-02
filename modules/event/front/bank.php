<?php
/**********************
 *
 *
 *
 * GENERATE PDF, THEN RETURN THE URL
 * 
 *
 *
 *********************/
function generate_iban_url($first_name, $last_name, $price) {
	
	global $pdf_path;
	
	$upload_dir = wp_upload_dir();
	// Import class
	require_once THEME_PATH . '/modules/event/front/pdf/fpdf.php';
	require_once THEME_PATH . '/modules/event/front/pdf/fpdi.php';
	// Init
	$pdf = new FPDI();
	$pdf->AddPage(); 
	// Open file
	$pdf->setSourceFile(THEME_PATH . '/modules/event/front/bank_transfer_model.pdf');
	// Select page
	$tplIdx = $pdf->importPage(1); 
	$pdf->useTemplate($tplIdx, 0, 0, 0, 0, true); 
	// Init text
	$pdf->SetFont('Arial', '', '11'); 
	$pdf->SetTextColor(0,0,0);
	// Price
	$pdf->SetXY(105.3, 79.4);
	$pdf->Write(0, iconv("UTF-8", "CP1252", $price));
	// Command number
	$pdf->SetXY(39, 137.3);
	$pdf->Write(0, iconv("UTF-8", "CP1252", 'CR 2014 - '.$first_name.' '.$last_name));
	
	// CURRENT TIME
	$file = strtolower(sanitize_file_name(remove_accents('bank_transfer_'.$first_name.'_'.$last_name)));
	// PDF PATH
	$pdf_path = $upload_dir["path"].'/'.$file.'.pdf';
	// OUTPUT
	$pdf->Output($pdf_path, 'F');
	
	// HOOK WP MAIL TO ADD ATTACHMENT
	add_filter('wp_mail', 'extra_iban_attachment_wp_mail', 10, 1);
	
	return $upload_dir["url"].'/'.$file.'.pdf';
}
/**********************
 *
 *
 *
 * ATTACH PDF TO MAIL
 * 
 *
 *
 *********************/
function extra_iban_attachment_wp_mail($params) {
	global $pdf_path;
	$attachments = array($pdf_path);
	$params['attachments'] = $attachments;
	
	// IN CASE OF, REMOVE HOOK
	remove_filter('wp_mail', 'extra_iban_attachment_wp_mail', 10, 1);
	
	// RETURN ATTACHMENT
	return $params;
}
?>
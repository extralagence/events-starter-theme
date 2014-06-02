<?php
/**********************
 *
 *
 *
 * FILTER PRICE
 * 
 *
 *
 *********************/
function extra_booking_calculate_price($price, $EM_Booking){
	//$price = round($price * 1.2, 2);
	$EM_Tickets_Bookings = $EM_Booking->get_tickets_bookings();
	foreach($EM_Tickets_Bookings as $EM_Ticket_Booking) {
		$paypal_vars = extra_change_paypal_vars(array(), $EM_Booking, null, true);
		if(!empty($paypal_vars)) {
			$items_count = sizeof($paypal_vars) / 3;
			for($i = 2; $i < ($items_count + 2); $i++) {
				$price += $paypal_vars["quantity_".$i] * $paypal_vars["amount_".$i]; 
			}
		}
	}
	$EM_Booking->booking_price = $price;
	return $price;
}
add_filter('em_booking_calculate_price', 'extra_booking_calculate_price', 10, 2);
?>
<?php
/**********************
 *
 *
 *
 * CHANGE FINAL PRICE
 *
 *
 *
 *********************/
function extra_change_paypal_vars($paypal_vars, $EM_Booking, $EM_Gateway_Paypal){
	global $extra_event_metabox, $hotel_metabox;

	$date_format = get_option("dbem_date_format");
	// EVENT POST TYPE ID
	$eventPostID = $EM_Booking->event->post_id;
	$attributes = $extra_event_metabox->the_meta($eventPostID);
	$counter = count($EM_Booking->get_tickets_bookings()->tickets_bookings);
	/**********************
	 *
	 *
	 *
	 * HEBERGEMENT
	 *
	 *
	 *
	 *********************/
	if (!empty($EM_Booking->booking_meta['booking']['extra_hosting']) && !empty($EM_Booking->booking_meta['booking']['extra_arrival_date']) && !empty($EM_Booking->booking_meta['booking']['extra_departure_date'])){
		$arrival_date = date_create_from_format($date_format, $EM_Booking->booking_meta['booking']['extra_arrival_date']);
		$departure_date = date_create_from_format($date_format, $EM_Booking->booking_meta['booking']['extra_departure_date']);

		if ($departure_date === true | $departure_date === false) {
			var_dump($departure_date);
			var_dump($arrival_date);
			var_dump($EM_Booking->booking_meta['booking']['extra_hosting']);
			die;
		}
		$departure_timestamp = date_format($departure_date, "U");
		$arrival_timestamp = date_format($arrival_date, "U");

		$days = intval(($departure_timestamp - $arrival_timestamp)/86400);
		$price = 0;

		$extra_hotel_id = $EM_Booking->booking_meta['booking']['extra_hotel'];
		$extra_hotel_meta = $hotel_metabox->the_meta($extra_hotel_id);

		if($EM_Booking->booking_meta['booking']['extra_room_type'] == "Simple") {
			$price = $extra_hotel_meta['price_single'];
		} else {
			$price = $extra_hotel_meta['price_double'];
		}

		$counter++;
		$paypal_vars['item_name_'.$counter] = wp_kses_data(__("Hotel", "extra"));
		$paypal_vars['quantity_'.$counter] = $days;
		$paypal_vars['amount_'.$counter] = $price;
	}
	/**********************
	 *
	 *
	 *
	 * COCKTAIL
	 *
	 *
	 *
	 *********************/
	if (!empty($EM_Booking->booking_meta['booking']['extra_cocktail'])){
		$counter++;
		$paypal_vars['item_name_'.$counter] = wp_kses_data(__("Cocktail", "extra"));
		$paypal_vars['quantity_'.$counter] = 1;
		$paypal_vars['amount_'.$counter] = $attributes["extra_cocktail_price"];
	}
	/**********************
	 *
	 *
	 *
	 * GALA
	 *
	 *
	 *
	 *********************/
	if (!empty($EM_Booking->booking_meta['booking']['extra_gala'])){
		$gala_num = 1;
		// HAS GUEST ?
		if(!empty($EM_Booking->booking_meta['booking']['extra_guest'])) {
			$gala_num = $gala_num + intval($EM_Booking->booking_meta['booking']['extra_guest_num']);
		}
		$counter++;
		$paypal_vars['item_name_'.$counter] = wp_kses_data(__("Diner de gala", "extra"));
		$paypal_vars['quantity_'.$counter] = $gala_num;
		$paypal_vars['amount_'.$counter] = $attributes["extra_cocktail_price"];
	}

	//var_dump($paypal_vars);

	return $paypal_vars;
}
add_filter('em_gateway_paypal_get_paypal_vars','extra_change_paypal_vars', 1, 3);
/**********************
 *
 *
 *
 * FILTER PRICE
 *
 *
 *
 *********************/
//function extra_ticket_booking_get_price($ticket_booking_price, $EM_Ticket_Booking, $add_tax) {
//	echo $ticket_booking_price;
//	echo $EM_Ticket_Booking;
//	$ticket_booking_price = $EM_Ticket_Booking->ticket_booking_price;
//	$paypal_vars = extra_change_final_price(array(), $EM_Ticket_Booking->booking, null);
//	if(!empty($paypal_vars)) {
//		$items_count = sizeof($paypal_vars) / 3;
//		for($i = 2; $i < ($items_count + 2); $i++) {
//			$ticket_booking_price += $paypal_vars["quantity_".$i] * $paypal_vars["amount_".$i];
//		}
//	}
//	return $ticket_booking_price;
//}
//add_filter('em_ticket_booking_get_price', 'extra_ticket_booking_get_price', 10, 3);
/**********************
 *
 *
 *
 * TOTAL PRICE
 *
 *
 *
 *********************/
//function extra_booking_calculate_price_summary($summary, $EM_Booking){
//	$ticket_booking_price = $summary["total_base"];
//	$ticket_booking = current(current($EM_Booking->tickets_bookings));
//	$paypal_vars = extra_change_paypal_vars(array(), $ticket_booking->booking, null);
//	if(!empty($paypal_vars)) {
//		$items_count = sizeof($paypal_vars) / 3;
//		for($i = 2; $i < ($items_count + 2); $i++) {
//			$ticket_booking_price += $paypal_vars["quantity_".$i] * $paypal_vars["amount_".$i];
//		}
//	}
//	$summary["total"] = $ticket_booking_price;
//	return $summary;
//}
//add_filter("em_booking_calculate_price_summary", "extra_booking_calculate_price_summary", 10, 2);
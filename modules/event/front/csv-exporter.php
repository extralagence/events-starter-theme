<?php
function extra_em_cols() {
	//echo "TEST::e".print_r($_REQUEST['cols'], true)."</pre>";
	if (!empty($_REQUEST['action']) && $_REQUEST['action'] == 'export_bookings_csv' && wp_verify_nonce($_REQUEST['_wpnonce'], 'export_bookings_csv')) {
		$_REQUEST['cols'] = array(
			"event_name"                => 1,
			"booking_status"            => 1,
			"booking_date"              => 1,
			"i_will_not_attend"         => 1,
			"travel_by_car"             => 1,
			"no_need_pickup"            => 1,
			"fname"                     => 1,
			"lname"                     => 1,
			"user_email"                => 1,
			"civility"                  => 1,
			"function"                  => 1,
			"localization"              => 1,
			"country"                   => 1,
			"office_phone_number"       => 1,
			"cellular_phone_number"     => 1,
			"assistant_phone_number"    => 1,
			"assistant_email"           => 1,
			"arrival_date"              => 1,
			"arrival_flight_number"     => 1,
			"arrival_airline_company"   => 1,
			"arrival_from"              => 1,
			"arrival_time"              => 1,
			"departure_date"            => 1,
			"departure_flight_number"   => 1,
			"departure_airline_company" => 1,
			"departure_destination"     => 1,
			"departure_time"            => 1,
			"visa_needed"               => 1,
			"specific_diet"             => 1,
			"allergies_health_issues"   => 1,
			"comments"                  => 1
		);
	}
}

add_action('init', 'extra_em_cols', 1);
function extra_bookings_table_rows_col($val, $col, $EM_Booking, $this, $csv) {
	if ($csv) {

		// &
		$val = str_replace("&amp;", "and", $val);
		$val = str_replace("&", "and", $val);

		// ;
		$val = str_replace(";", "", $val);


		// LINE BREAKS
		$val       = str_replace(array("\r\n", "\r"), "\n", $val);
		$lines     = explode("\n", $val);
		$new_lines = array();

		foreach ($lines as $i => $line) {
			if (!empty($line))
				$new_lines[] = trim($line);
		}
		$val = implode($new_lines);
	}

	return $val;

}

add_filter('em_bookings_table_rows_col', 'extra_bookings_table_rows_col', 10, 5);
?>
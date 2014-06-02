<?php


function extra_extract_first_attendee_identity($EM_Event, $EM_Booking, $post_validation) {
	global $EM_Event, $EM_Booking, $EM_Person;

	$attendes = $EM_Booking->booking_meta['attendees'];
	$attendes = array_pop($attendes);
	$first_attendee = $attendes[0];

	$first_name = $first_attendee['extra_attendee_first_name'];
	$last_name = $first_attendee['extra_attendee_last_name'];

	if (!empty($first_name)) {
		$_REQUEST['first_name'] = $first_name;
	}
	if (!empty($last_name)) {
		$_REQUEST['last_name'] = $last_name;
	}
	if (!empty($first_name) || !empty($last_name)) {
		$_REQUEST['user_name'] = $first_name.' '.$last_name;
	}
}
add_action('em_booking_add', 'extra_extract_first_attendee_identity', 10, 3);
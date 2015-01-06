<?php
/**********************
 *
 *
 *
 * CUSTOM VALIDATION
 *
 *
 *
 *********************/
/**
 * @param $result
 * @param $field
 * @param $value
 * @param $EM_Form EM_Form
 *
 * @return bool
 */
function extra_emp_form_validate_field($result, $field, $value, $EM_Form) {

	// get global booking
	/* @var $EM_Booking EM_Booking */
	/* @var $extra_event_metabox ExtraMetaBox */
	global $EM_Booking, $extra_event_metabox;
	$event_meta = $extra_event_metabox->the_meta($EM_Booking->event->post_id);
	$metas = $EM_Booking->booking_meta['booking'];

	if ($metas['extra_gala'] == true && $metas['extra_guest'] == true && $field['fieldid'] == 'extra_guest_names') {
		// THERE IS GUESTS
		// GUESTS NAMES
		$guest_names = $value;
		$guest_names_array = explode("\n", preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $guest_names));
		// NUMBER OF GUESTS
		$guest_numbers = $metas['extra_guest_num'];
		// VERIF
		if(sizeof($guest_names_array) != intval($guest_numbers)) {
			$result = false;
			$EM_Form->add_error(__('Veuillez renseigner tous les noms des invités.', 'extra'));
			//$EM_Booking->add_error(__('Veuillez renseigner tous les noms des invités.', 'extra'));
		}
	}

	// DIET
	if ($metas['extra_diet'] == true && $field['fieldid'] == 'extra_diet_text') {
		if (str_word_count($value) < 1) {
			$result = false;
			//$EM_Booking->add_error(__("Vous n'avez pas indiqué votre régime.", "extra"));
			$EM_Form->add_error(__("Vous n'avez pas indiqué votre régime.", "extra"));

//			var_dump('add error');
//			var_dump("Vous n'avez pas indiqué votre régime.");
		}
	}


	if ($metas['extra_hosting'] == true && $field['fieldid'] == 'extra_arrival_date') {
		if (empty($value)) {
			$result = false;
			$EM_Form->add_error(__("Vous n'avez pas indiqué votre jour d'arrivé.", "extra"));
		}
	}
	if ($metas['extra_hosting'] == true && $field['fieldid'] == 'extra_departure_date') {
		$result = false;
		$EM_Form->add_error(__("Vous n'avez pas indiqué votre jour de départ.", "extra"));
	}


	//ACTIVITIES AND RESTAURANTS
	//if ($metas['activities'] ==)

//	if ($field['fieldid'] == 'activity_selector') {
//		var_dump($result);
//		var_dump($field);
//		var_dump($value);
//	}

	return $result;
}
add_filter('emp_form_validate_field', 'extra_emp_form_validate_field', 10, 4);
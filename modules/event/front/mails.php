<?php
/**********************
 *
 *
 *
 * CHANGE MAIL FROM
 * 
 *
 *
 *********************/
function extra_mail_from( $email ) {
	return 'demo@mycorpevent.com';
}
add_filter( 'wp_mail_from', 'extra_mail_from' );
function extra_mail_from_name( $name ) {
	return 'MyCorpEvent Demo';
}
add_filter( 'wp_mail_from_name', 'extra_mail_from_name' );
/**********************
 *
 *
 *
 * CUSTOM MESSAGES
 * 
 *
 *
 *********************/
function extra_booking_email_messages($msg, $EM_Booking) {
	$userID = $EM_Booking->person_id;
	$user_meta = get_user_meta($userID);
	$date_format = 'd/m/Y';

//	var_dump($user_meta);
//	die;
//	$attendees = array_pop($EM_Booking->meta['attendees']);

	switch($EM_Booking->booking_status) {
    	case 0:
    	case 5:
			/* WAITING PAIEMENT */
			
			// PDF URL
			$pdf_url = generate_iban_url(reset($user_meta['first_name']), reset($user_meta['last_name']), $EM_Booking->format_price($EM_Booking->booking_price));
			
			// USER
			$user_msg = extra_get_header_mail($EM_Booking, $date_format);

			$user_msg .= '
			<p> '.__("Cher", "extra").' '.reset($user_meta['first_name']).' '.reset($user_meta['last_name']).'</p>';
			$user_msg .= '
			<p>'.__("Nous sommes ravis que vous participiez à notre événement", "extra").'</p>';
			if($EM_Booking->booking_meta['gateway'] == 'offline') {
				$user_msg .= '<p>'.__("Vous avez choisi de payer par virement bancaire. S'il vous plaît télécharger le fichier joint à cet e-mail afin de procéder au paiement.", "extra").'</p>';
			}

			$user_msg .= extra_get_resume_booking_mail($EM_Booking, $date_format);

			$user_msg .= '<p>'.__("Votre inscription sera complétée avec succès une fois que votre paiement reçu. Votre facture sera envoyée dans les 30 jours.", "extra").'</p>';
			$user_msg .= '<p>'.__("Cordialement, <br> L'équipe MyCorpEvent Demo", "extra").'</p>';

			$user_msg .= extra_get_footer_mail($EM_Booking, $date_format);
    		//$msg['user']['subject'] = get_option('dbem_bookings_email_confirmed_subject');
    		$msg['user']['body'] = $user_msg;
			// ADMIN
    		/*$msg['admin']['subject'] = get_option('dbem_bookings_contact_email_subject');
    		$msg['admin']['body'] = get_option('dbem_bookings_contact_email_body');*/
    		break;
    	case 1:
			// USER
			$user_msg = extra_get_header_mail($EM_Booking, $date_format);

			$user_msg .= '<p>'.__("Cher", "extra").' '.reset($user_meta['first_name']).' '.reset($user_meta['last_name']).'</p>
			';	
			$user_msg .= '<p>'.__("Nous sommes ravis que vous participiez à notre événement", "extra").'</p><p>'.__("Veuillez garder une copie de cette confirmation pour vos dossiers.", "extra").'</p>
			';

			$user_msg .= extra_get_resume_booking_mail($EM_Booking, $date_format);

			$user_msg .= '<p>'.__("Votre inscription est maintenant terminée. Merci !", "extra").'</p>';
			$user_msg .= '<p>'.__("Nous avons hâte de vous voir à notre événement", "extra").'<br />'.__("N'hésitez pas à nous contacter pour toute information complémentaire.", "extra").'</p><p>'.__("Cordialement,<br /> L'équipe MyCorpEvent Demo", "extra").'</p>
			';

			$user_msg .= extra_get_footer_mail($EM_Booking, $date_format);
    		//$msg['user']['subject'] = get_option('dbem_bookings_email_confirmed_subject');
    		$msg['user']['body'] = $user_msg;
			// ADMIN
    		//$msg['admin']['subject'] = get_option('dbem_bookings_contact_email_subject');
    		//$msg['admin']['body'] = get_option('dbem_bookings_contact_email_body');
    		break;
    	case 3:
			// USER
			$user_msg = extra_get_header_mail($EM_Booking, $date_format);

			$user_msg .= '<p>'.__("Cher", "extra").' '.reset($user_meta['dbem_gender']).' '.reset($user_meta['first_name']).' '.reset($user_meta['last_name']).'</p>';
			$user_msg .= '<p>'.__("Votre réservation a été annulée.", "extra").'</p>';
			$user_msg .= '<p>'.__("Cordialement,<br /> L'équipe MyCorpEvent Demo", "extra").'</p>
			';
			$user_msg .= extra_get_footer_mail($EM_Booking, $date_format);
    		//$msg['user']['subject'] = get_option('dbem_bookings_email_confirmed_subject');
    		$msg['user']['body'] = $user_msg;
			// ADMIN
    		/*$msg['admin']['subject'] = get_option('dbem_bookings_contact_email_subject');
    		$msg['admin']['body'] = get_option('dbem_bookings_contact_email_body');*/
    		break;
	}
	return $msg;
}
add_filter('em_booking_email_messages', 'extra_booking_email_messages', 10, 2);


function extra_get_header_mail($EM_Booking, $date_format) {
	$user_msg = '<center><table width="500" border="0" cellspacing="0" cellpadding="0" style="border-spacing: 0; border-collapse:collapse; margin: 0px; padding: 0px;"><tr><td colspan="3"><img src="'.home_url("/").'emails/header.png" width="500" height="250" alt="MyCorpEvent" /></td></tr><tr><td width="50"></td><td style="font-family:Georgia, serif; font-size: 14px; color: #606060; font-style: normal; line-height: 17px;">
	';

	return $user_msg;
}
function extra_get_footer_mail($EM_Booking, $date_format) {
	$user_msg = '</td></tr><tr><td colspan="3"><img src="'.home_url("/").'emails/bottom.png" width="500" height="60" alt="MyCorpEvent - Copyright 2013" /></td></tr></table></center>
	';

	return $user_msg;
}

/**
 * @param $EM_Booking EM_Booking
 * @param $date_format
 *
 * @return string
 */
function extra_get_resume_attendee_mail($EM_Booking, $date_format) {
	$attendees = $EM_Booking->booking_meta['attendees'];
	$attendees = array_pop($attendees);

	$user_msg = '';
	if (isset($attendees[1]) && !empty($attendees[1])) {
		$second_attendee = $attendees[1];
		if (!empty($second_attendee)&& !empty($second_attendee['extra_attendee_first_name']) && !empty($second_attendee['extra_attendee_last_name'])) {
			$user_msg .= '<p>'.__("Vous avez reservé au nom des personnes suivantes :", "extra").'</p>
			';

			$user_msg .= '<ul>
			';
			$first = true;
			foreach ($attendees as $attendee) {
				$first_name = $attendee['extra_attendee_first_name'];
				$last_name = $attendee['extra_attendee_last_name'];

				$first_msg = '';
				if ($first) {
					$first = false;
					$first_msg = ' '.__("(Vous)", "extra");
				}
				$user_msg .= '<li>'.$first_name.' '.$last_name.$first_msg.'</li>
				';
			}
			$user_msg .= '</ul>
			';
			$user_msg .= '<p>'.__("Avec comme options :", "extra").'</p>
			';
		}
	}
	return $user_msg;
}

function extra_get_resume_booking_mail($EM_Booking, $date_format) {
	$user_msg = extra_get_resume_attendee_mail($EM_Booking, $date_format);
	$user_msg .= '<ul>';
	// HOSTING
	if (!empty($EM_Booking->booking_meta['booking']['extra_hosting'])) {
		// DAYS NUMBER TO STAY AT THE HOTEL
		$arrival_date = date_create_from_format($date_format, $EM_Booking->booking_meta['booking']['extra_arrival_date']);
		$departure_date = date_create_from_format($date_format, $EM_Booking->booking_meta['booking']['extra_departure_date']);
		$days = intval((date_format($departure_date, "U") - date_format($arrival_date, "U"))/86400);

		// HOTEL POST
		$selected_hotel = $EM_Booking->booking_meta['booking']['extra_hotel'];
		$hotel = get_post($selected_hotel);

		// ROOM TYPE
		$room_type = $EM_Booking->booking_meta['booking']['extra_room_type'];


		$user_msg .= '<li>'.__("MyCorpEvent gérera votre hébergement", "extra").'<br />';
		$user_msg .= 'Vous passerez '.$days.' '.(($days > 1) ? 'jours' : 'jour').' à '.$hotel->post_title.' dans une chambre '.strtolower($room_type).'.</li>';
	} else {
		$user_msg .= '<li>'.__("Vous gérerez votre hébergement", "extra").'</li>';
	}
	// COCKTAIL
	if (!empty($EM_Booking->booking_meta['booking']['extra_cocktail'])) {
		$user_msg .= '<li>'.__("Vous assisterez au cocktail", "extra").'</li>';
	} else {
		$user_msg .= '<li>'.__("Vous n'assisterez pas au cocktail", "extra").'</li>';
	}
	// GALA
	if (!empty($EM_Booking->booking_meta['booking']['extra_gala'])) {
		$user_msg .= '<li>'.__("Vous assisterez au dîner de gala", "extra");
		if(!empty($EM_Booking->booking_meta['booking']['extra_guest'])) {
			$user_msg .= ' '.__("avec comme invité", "extra").' : '.$EM_Booking->booking_meta['booking']['extra_guest_names'];
		}
		$user_msg .= '</li>';
	} else {
		$user_msg .= '<li>'.__("Vous n'assisterez pas au dîner de gala", "extra").'</li>';
	}

	$activity = null;
	$activity_slug = $EM_Booking->booking_meta['booking']['activity_selector'];
	$activities = get_posts(array(
		'name' => $activity_slug,
		'post_type' => 'activity',
		'post_status' => 'publish',
		'numberposts' => 1
	));
	if ($activities) {
		$activity = $activities[0];
		$user_msg .= '<li>'.__("Vous participerez à ", "extra").$activity->post_title.'</li>';
	}

	$restaurant = null;
	$restaurant_slug = $EM_Booking->booking_meta['booking']['restaurant_selector'];
	$restaurants = get_posts(array(
		'name' => $restaurant_slug,
		'post_type' => 'restaurant',
		'post_status' => 'publish',
		'numberposts' => 1
	));
	if ($restaurants) {
		$restaurant = $restaurants[0];
		$user_msg .= '<li>'.__("Vous avez choisi le restaurant ", "extra").$restaurant->post_title.'</li>';
	}

	$user_msg .= '</ul>
	';
	return $user_msg;
}
?>
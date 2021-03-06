<?php
/**********************
 *
 *
 *
 * CUSTOM INPUT
 * 
 *
 *
 *********************/
function extra_custom_fields_emp_forms_output_field_input($return, $fields, $field, $post) {
	// GET THE CORRECT FIELD
	if($field["fieldid"] == "extra_hotel") {
		global $EM_Event;
		$bookings = $EM_Event->get_bookings();
		$rooms_used = array();	
		if(!empty($bookings)){
			foreach($bookings as $booking) {
				$metas = $booking->booking_meta["booking"];
				if($metas["extra_hosting"] == 1) {
					$room_id = $metas["extra_hotel"];
					if (array_key_exists($room_id, $rooms_used)) {
						$rooms_used[$room_id]++;
					} else {
						$rooms_used[$room_id] = 1;
					}
				}
			}
		}
	
		$return = "";
		
		////
		//// HOTELS
		////
		
		// PREPARE THE SELECT
		$return .= '<select id="'.$field["fieldid"].'" class="'.$field["fieldid"].'" name="'.$field["fieldid"].'">';
			
			// DEFAULT VALUE
			$return .= '<option value="">'.__("Choisir...", "extra").'</option>';
			
			// LOOP IN ALL ACTIVITIES
			global $hotels_query;
			global $hotel_metabox;
			foreach($hotels_query as $hotel) {
				$hotel_metabox->the_meta($hotel->ID);

//				$is_selected = (array_key_exists($field["fieldid"], $_POST) && $_POST[$field["fieldid"]] == $hotel->post_title);
				$is_selected = !empty($post) && $post == $hotel->ID;
				if(array_key_exists($hotel->ID, $rooms_used) && $rooms_used[$hotel->ID] >= intval($hotel_metabox->get_the_value("room_max"))) {
					$selected = $is_selected ? ' selected="selected"' : '';
					$disabled = (!$is_selected) ? ' disabled="disabled"' : '';

					$return .= '<option'.$disabled.$selected.' value="'.$hotel->ID.'">'.$hotel->post_title.' '.__('(plus de place disponible)', 'extra').'</option>';
				} else {  
					$selected = $is_selected ? ' selected="selected"' : '';
					$return .= '<option'.$selected.' value="'.$hotel->ID.'">'.$hotel->post_title.'</option>';
				}
			}
		$return .= '</select>';
	
		/*$return .= '<pre>';
		$return .= print_r(new EM_Bookings, true);
		$return .= '</pre>';*/
		
	} else if($field["fieldid"] == "activity_selector") {
		$return = "";

		////
		//// ACTIVITIES
		////

		// GET ALL ACTIVITIES
		$activities = get_posts(array(
			'post_type' => 'activity',
			'posts_per_page' => -1
		));

		// PREPARE THE SELECT
		//$return .= '<p>';
		//<label for="activities">'.__("Choix de l'activitié", "extra").'</label>';
		$return .= '<select id="'.$field["fieldid"].'" class="input activities" name="'.$field["fieldid"].'">';

		// DEFAULT VALUE
		$return .= '<option value="">'.__("Choisissez une activité", "extra").'</option>';

		// LOOP IN ALL ACTIVITIES
		foreach($activities as $activity) {

			// GET CONNECTED ITEMS
			$connected = get_posts(array(
				'connected_type' => 'restaurant_to_activity',
				'connected_items' => $activity,
				'nopaging' => true
			));
			$connected_output = '';
			foreach($connected as $connected_item) {
				$connected_output .= $connected_item->post_name.' ';

			}
			$return .= '<option data-connected="'.substr($connected_output, 0, -1).'" value="'.$activity->post_name.'">'.$activity->post_title.'</option>';
		}

		$return .= '</select>';
	} else if($field["fieldid"] == "restaurant_selector") {

		$return = "";

		////
		//// RESTAURANTS
		////

		// GET ALL RESTAURANTS
		$restaurants = get_posts(array(
			'post_type' => 'restaurant',
			'posts_per_page' => -1
		));

		// PREPARE THE SELECT
		//$return .= '<p>';
		//<label for="restaurants">'.__("Choix du restaurant", "extra").'</label>';
		$return .= '<select id="'.$field["fieldid"].'" class="input restaurants" name="'.$field["fieldid"].'">';

		// DEFAULT VALUE
		$return .= '<option value="">'.__("Choisissez un restaurant", "extra").'</option>';

		// LOOP IN ALL ACTIVITIES
		foreach($restaurants as $restaurant) {

			// GET CONNECTED ITEMS
			$connected = get_posts(array(
				'connected_type' => 'restaurant_to_activity',
				'connected_items' => $restaurant,
				'nopaging' => true
			));
			$connected_output = '';
			foreach($connected as $connected_item) {
				$connected_output .= $connected_item->post_name.' ';

			}
			$return .= '<option data-connected="'.substr($connected_output, 0, -1).'" value="'.$restaurant->post_name.'">'.$restaurant->post_title.'</option>';
		}
		$return .= '</select>';

		$return .= '<p><a class="button reset" href="#">'.__("Réinitialiser", "extra").'</a></p>';
	} else if($field["fieldid"] == "extra_user_fields") {
	
		if(!is_admin()) {
			
			global $current_user;
			$user_meta = get_user_meta($current_user->data->ID);
			echo '<p class="input-extra_user_fields_email input-user-field">';
			echo '<label for="extra_user_fields_email">'.__('Email (not editable)').'</label>';
			echo '<input type="text" name="extra_user_fields_email" id="extra_user_fields_email" readonly="readonly" class="input" value="'.$current_user->data->user_email.'">';
			echo '</p>';
			
		} else {
		
			$user_meta = array();
			$user_meta['first_name'][0] = "";
			$user_meta['last_name'][0] = "";
		
		}
		
		
		echo '<p class="input-extra_user_fields_firstname input-user-field">';
		echo '<label for="extra_user_fields_firstname">';
		echo __('First name').' <span class="em-form-required">*</span></label>';
		echo '<input type="text" name="extra_user_fields_firstname" id="extra_user_fields_firstname" class="input" value="'.reset($user_meta['first_name']).'">';
		echo '</p>';
		
		
		echo '<p class="input-extra_user_fields_lastname input-user-field">';
		echo '<label for="extra_user_fields_lastname">';
		echo __('Last name').' <span class="em-form-required">*</span></label>';
		echo '<input type="text" name="extra_user_fields_lastname" id="extra_user_fields_lastname" class="input" value="'.reset($user_meta['last_name']).'">';
		echo '</p>';
		 
	
	} else {

		if($field['type'] == 'select' || $field['type'] == "multiselect") {

			$return = "";

			$field_name = !empty($field['name']) ? $field['name']:$field['fieldid'];

			$values = explode("\r\n",$field['options_select_values']);

			$multi = $field['type'] == 'multiselect';

			$default = '';
			if($post === true && !empty($_REQUEST[$field['fieldid']])) {
				$default = is_array($_REQUEST[$field['fieldid']]) ? $_REQUEST[$field['fieldid']]:esc_attr($_REQUEST[$field['fieldid']]);
			}elseif( $post !== true && !empty($post) ){
				$default = is_array($post) ? $post:esc_attr($post);
			}

			if($multi && !is_array($default)) $default = (empty($default)) ? array():array($default);

			$multi_txt = ($multi) ? '[]':'';
			$multi_attr = ($multi) ? 'multiple':'';
			$return .= '<select id="'.$field_name.$multi_txt.'" name="'.$field_name.$multi_txt.'" class="'.$field['fieldid'].'" '.$multi_attr.'>';

				//calculate default value to be checked

				if( !$field['options_select_default'] ){

					$return .= '<option value="">'.esc_html($field['options_select_default_text']).'</option>';

				}

				$count = 0;

			?>

			<?php foreach($values as $value): $value = trim($value); $count++;

				$selected_option = (($count == 1 && $field['options_select_default']) || ($multi && in_array($value, $default)) || ($value == $default)) ? ' selected="selected"':'';
				$return .= '<option'.$selected_option.'>';

					$return .= esc_html($value);

				$return .= '</option>';

			endforeach;

			$return .= '</select>';
		}
	}
	return $return;
}
add_action("emp_forms_output_field_input", "extra_custom_fields_emp_forms_output_field_input", 10, 4);



function extra_custom_fields_emp_forms_get_formatted_value ($value, $field) {
	$formatted_value = $value;

	if($field["fieldid"] == "extra_hotel" && !empty($value)) {
		$hotel = get_post($value);
		$formatted_value = $hotel->post_title;
	}

	return $formatted_value;
}
add_filter("extra_emp_forms_get_formatted_value", "extra_custom_fields_emp_forms_get_formatted_value", 10, 2);


function extra_custom_fields_admin_init(){
	if( !empty($_REQUEST['page']) && $_REQUEST['page'] == 'events-manager-bookings' ){
		global $EM_Event;

		$EM_Event->post_id;
		the_extra_booking_datas($EM_Event->post_id);
	}
}

add_action('admin_init', 'extra_custom_fields_admin_init');
?>
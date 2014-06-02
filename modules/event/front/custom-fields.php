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
function extra_forms_output_field_input($return, $fields, $field, $post) {
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

				if(array_key_exists($hotel->ID, $rooms_used) && $rooms_used[$hotel->ID] >= intval($hotel_metabox->get_the_value("room_max"))) {
					$return .= '<option disabled="disabled" value="'.$hotel->ID.'">'.$hotel->post_title.' '.__('(plus de place disponible)', 'extra').'</option>';
				} else {  
					$selected = (array_key_exists($field["fieldid"], $_POST) && $_POST[$field["fieldid"]] == $hotel->post_title) ? ' selected="selected"' : '';
					$return .= '<option'.$selected.' value="'.$hotel->ID.'">'.$hotel->post_title.'</option>';
				}
			}
		$return .= '</select>';
	
		/*$return .= '<pre>';
		$return .= print_r(new EM_Bookings, true);
		$return .= '</pre>';*/
		
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
add_action("emp_forms_output_field_input", "extra_forms_output_field_input", 10, 4);
?>
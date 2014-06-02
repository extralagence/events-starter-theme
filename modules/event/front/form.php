<?php
/**********************
 *
 *
 *
 * BEGINNING
 *
 *
 *
 *********************/
/**
 * @param $EM_Event EM_Event
 */
function extra_em_booking_form_before_user_details($EM_Event) {
	/* @var $EM_Form EM_Form */
	$EM_Form = EM_Booking_Form::get_form($EM_Event);

	echo '<div id="extra-booking-navigation">';
	echo '<ol>';
	echo '<li><a href="#extra-ticket-place">'.__("Participant(s)", "extra").'</a></li>';
	foreach($EM_Form->form_fields as $form_field) {
		$type = $form_field['type'];
		if ($type == \ExtraEvents\Fields\StartFieldset::get_name()) {
			$label = $form_field['label'];
			$options_html_content = $form_field['options_html_content'];
			if (!empty($options_html_content)) {
				$label = $options_html_content;
			}

			echo '<li><a href="#'.$form_field['fieldid'].'">'.$label.'</a></li>';
		}
	}
	echo '<li><a href="#booking-summary">'.__("Récapitulatif et montant", "extra").'</a></li>';
	echo '<li><a href="#booking-paiement">'.__("Paiement", "extra").'</a></li>';
	echo '</ol>';
	echo '</div>';

	//get_template_part("modules/event/front/booking-form-navigation");
	echo '<div id="extra-booking-content">';
}
add_action("em_booking_form_before_tickets", "extra_em_booking_form_before_user_details");
/**********************
 *
 *
 *
 * AFTER TICKETS
 *
 *
 *
 *********************/
function extra_em_booking_form_after_user_details($EM_EVENT) {
	//echo '</fieldset>';

}
add_action("em_booking_form_after_tickets", "extra_em_booking_form_after_user_details");
/**********************
 *
 *
 *
 * SUMMARY
 *
 *
 *
 *********************/
function extra_em_booking_form_custom($EM_Event) {
	global $current_user;
	wp_get_current_user();
	?>

	<fieldset id="booking-summary">
		<legend> <?php _e("Récapitulatif et montant", "extra"); ?></legend>
		<div class="summary-bloc" id="booking-informations-summary">
			<h3><?php _e("Informations personnelles", "extra"); ?></h3>
			<p class="name"><?php
				if(!empty($current_user->ID)){
					if(!empty($current_user->first_name)) echo $current_user->first_name.' ';
					if(!empty($current_user->last_name)) echo $current_user->last_name;
				} else {
					echo ' ';
				}
				?></p>
			<p class="email"><?php
				if(!empty($current_user->ID) && !empty($current_user->user_email)) echo $current_user->user_email;
				else echo ' ';
				?></p>
			<p class="tel"><?php
				if(!empty($current_user->ID) && !empty($current_user->dbem_extra_phone)) echo $current_user->dbem_extra_phone;
				else echo ' ';
				?></p>
			<p class="mobile"><?php
				if(!empty($current_user->ID) && !empty($current_user->dbem_extra_mobile)) echo $current_user->dbem_extra_mobile;
				else echo ' ';
				?></p>
			<p class="address"><?php
				if(!empty($current_user->ID)){
					if(!empty($current_user->dbem_extra_adress)) echo $current_user->dbem_extra_adress.'<br />';
					if(!empty($current_user->dbem_extra_adress2)) echo $current_user->dbem_extra_adress2.'<br />';
					if(!empty($current_user->dbem_extra_postal_code)) echo $current_user->dbem_extra_postal_code.' ';
					if(!empty($current_user->dbem_extra_city)) echo $current_user->dbem_extra_city.' ';
					if(!empty($current_user->dbem_extra_country)) echo $current_user->dbem_extra_country;
				} else {
					echo ' ';
				}
				?></p>
		</div>
		<div class="summary-bloc" id="booking-hosting-summary">
			<h3><?php _e("Hébergement", "extra"); ?></h3>
			<div class="hosting-option1">
				<p><?php _e("Je gère mon hébergement moi-même", "extra"); ?></p>
			</div>
			<div class="hosting-option2">
				<p><?php _e("Je souhaite que vous gériez mon hébergement", "extra"); ?></p>
				<p><?php _e('Séjour à l\'hôtel <span class="hotel"></span> dans une chambre <span class="room"></span>'); ?></p>
				<p class="arrival"><?php _e('Arrivée le <span class="date"></span> à <span class="time"></span>', "extra"); ?></p>
				<p class="departure"><?php _e('Départ le <span class="date"></span> à <span class="time"></span>', "extra"); ?></p>
			</div>
		</div>
		<div class="summary-bloc" id="booking-meal-summary">
			<h3><?php _e("Dîner et cocktail", "extra"); ?></h3>
			<p class="cocktail-yes"><?php _e("Je participe au cocktail", "extra"); ?></p>
			<p class="cocktail-no"><?php _e("Je ne participe pas au cocktail", "extra"); ?></p>
			<p class="gala-yes"><?php _e("Je participe à la soirée de gala", "extra"); ?></p>
			<p class="gala-no"><?php _e("Je ne participe pas à la soirée de gala", "extra"); ?></p>
			<p class="guest-yes"><?php _e("Je serais accompagné par :", "extra"); ?></p>
			<p class="guest-no"><?php _e("Je ne serais pas accompagné.", "extra"); ?></p>
			<ul class="guest-list"></ul>
			<p class="diet"><?php _e("J'ai un régime spécifique:", "extra"); ?></p>
			<p class="diet-text"></p>
		</div>
		<div class="summary-bloc" id="price-summary">
			<h3><?php _e("Détail des montants", "extra"); ?></h3>
			<pre>
				<?php
				global $extra_event_metabox;
				$ticket = current(current($EM_Event->bookings->tickets));
				//$attributes = $EM_Event->event_attributes;
				$attributes = $extra_event_metabox->the_meta($EM_Event->post_id);
				?>
			</pre>
			<!-- BILLET -->
			<p class="summary-ticket-price" data-price="<?php echo intval($ticket->price); ?>"><?php _e("Participation à l'évènement : ", "extra"); ?> <span class="price"><?php echo intval($ticket->price); ?> &euro;</span></p>
			<!-- GALA -->
			<p class="summary-gala-price" data-price="<?php echo $attributes["extra_gala_price"]; ?>"><?php _e("Participation au dîner de gala : ", "extra"); ?> <span class="price"><?php echo $attributes["extra_gala_price"]; ?> &euro;</span></p>
			<!-- COCKTAIL -->
			<p class="summary-cocktail-price" data-price="<?php echo $attributes["extra_cocktail_price"]; ?>"><?php _e("Participation au cocktail : ", "extra"); ?> <span class="price"><?php echo $attributes["extra_cocktail_price"]; ?> &euro;</span></p>
			<!-- HOTELS -->
			<div class="summary-hotels-price">
				<?php
				global $hotel_metabox;
				$hotels = get_posts(array(
					'posts_per_page' => -1,
					'post_type' => 'hotel'
				));
//				var_dump($hotels);
				$hotel_metabox->the_meta();
				?>
				<?php foreach ($hotels as $hotel) : $hotel_meta = $hotel_metabox->the_meta($hotel->ID); ?>
					<!-- HOTEL SIMPLE -->
					<p class="summary-hotel-simple-price" data-hotel-id="<?php echo $hotel->ID; ?>" data-price="<?php echo $hotel_meta['price_single']; ?>"><?php _e("Nuit d'hôtel simple : ", "extra"); ?> <span class="price"><?php echo $hotel_meta['price_single']; ?> &euro;</span></p>
					<!-- HOTEL DOUBLE -->
					<p class="summary-hotel-double-price" data-hotel-id="<?php echo $hotel->ID; ?>" data-price="<?php echo $hotel_meta['price_double']; ?>"><?php _e("Nuit d'hôtel double : ", "extra"); ?> <span class="price"><?php echo $hotel_meta['price_double']; ?> &euro;</span></p>
				<?php endforeach; ?>
			</div>
			<h3><?php _e("Total", "extra"); ?></h3>
			<p class="total-price"><strong class="price"><?php echo $ticket->price; ?> &euro;</strong></p>
		</div>
	</fieldset>
	<fieldset id="booking-paiement">
	<legend><?php _e("Paiement", "extra"); ?></legend>
<?php
}
add_action("em_booking_form_custom", "extra_em_booking_form_custom");
function extra_em_booking_form_footer_after_buttons($EM_Event){
	?>
	</fieldset>
	</div>
	<?php
}
add_action("em_booking_form_footer_after_buttons", "extra_em_booking_form_footer_after_buttons");
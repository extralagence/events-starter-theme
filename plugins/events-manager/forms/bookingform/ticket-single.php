<?php
/*
 * This file generates the input fields for an event with a single ticket and settings set to not show a table for single tickets (default setting)
 * If you want to add to this form this, you'd be better off hooking into the actions below.
 */
/* @var $EM_Ticket EM_Ticket */
/* @var $EM_Event EM_Event */
global $allowedposttags;
do_action('em_booking_form_ticket_header', $EM_Ticket); //do not delete

remove_action('em_booking_form_ticket_spaces', array('EM_Attendees_Form','ticket_form'),1,1);
add_action('em_booking_form_ticket_spaces', 'extra_ticket_form',1,1);

/*
 * This variable can be overriden, by hooking into the em_booking_form_tickets_cols filter and adding your collumns into this array.
 * Then, you should create a em_booking_form_ticket_field_arraykey action for your collumn data, which will pass a ticket and event object.
 */
$collumns = array( 'type' => __('Ticket Type','dbem'), 'price' => __('Price','dbem'), 'spaces' => __('Spaces','dbem'));
if( $EM_Event->is_free() ) unset($collumns['price']); //add event price
$collumns = apply_filters('em_booking_form_tickets_cols', $collumns, $EM_Event );

foreach( $collumns as $type => $name ): ?>
	<?php
	//output collumn by type, or call a custom action
	switch($type){
		case 'type':
			if(!empty($EM_Ticket->ticket_description)){ //show description if there is one
				?><p class="ticket-desc"><?php echo wp_kses($EM_Ticket->ticket_description,$allowedposttags); ?></p><?php
			}
			break;
		case 'price':
			?><p class="ticket-price"><label><?php echo $name; ?></label><strong><?php echo $EM_Ticket->get_price(true); ?></strong></p><?php
			break;
		case 'spaces':
			if( $EM_Ticket->get_available_spaces() > 1 && ( empty($EM_Ticket->ticket_max) || $EM_Ticket->ticket_max > 1 ) ): //more than one space available ?>
				<fieldset id="extra-ticket-place">
					<legend><?php _e("Participant(s)"); ?></legend>
					<p class="em-tickets-spaces">
						<label for='em_tickets'><?php echo $name; ?></label>
						<?php
						$default = !empty($_REQUEST['em_tickets'][$EM_Ticket->ticket_id]['spaces']) ? $_REQUEST['em_tickets'][$EM_Ticket->ticket_id]['spaces']:0;
						$spaces_options = $EM_Ticket->get_spaces_options(false,$default);
						if( $spaces_options ){
							echo $spaces_options;
						}else{
							echo "<strong>".__('N/A','dbem')."</strong>";
						}
						?>
					</p>
					<?php
					do_action('em_booking_form_ticket_spaces', $EM_Ticket); //do not delete
					//extra_ticket_form($EM_Ticket);
					?>
				</fieldset>
			<?php else: //if only one space or ticket max spaces per booking is 1 ?>
				<fieldset id="extra-ticket-place" class="extra-single-ticket">
					<legend><?php _e("Participant"); ?></legend>
					<input type="hidden" name="em_tickets[<?php echo $EM_Ticket->ticket_id ?>][spaces]" value="1" class="em-ticket-select" />
					<?php
					do_action('em_booking_form_ticket_spaces', $EM_Ticket); //do not delete
					//extra_ticket_form($EM_Ticket);
					?>
				</fieldset>
			<?php endif;
			break;
		default:
			do_action('em_booking_form_ticket_field_'.$type, $EM_Ticket, $EM_Event);
			break;
	}
endforeach; ?>
<?php do_action('em_booking_form_ticket_footer', $EM_Ticket); //do not delete ?>


<?php
/**
 * For each ticket row in the booking table, add a hidden row with ticket form
 * @param EM_Ticket $EM_Ticket
 */
function extra_ticket_form($EM_Ticket){
	$form = EM_Attendees_Form::get_ticket_form(EM_Attendees_Form::get_form($EM_Ticket->event_id),$EM_Ticket);
	if( EM_Attendees_Form::$form_id > 0 ){
		$available_spaces = $EM_Ticket->get_available_spaces();
		$min_spaces = 0;
		if( $EM_Ticket->is_available() ) {
			$min_spaces = $EM_Ticket->get_spaces_minimum();
			if( !$EM_Ticket->is_required() ) $min_spaces = 0; //zero value allowed
			if( !empty($_REQUEST['em_tickets'][$EM_Ticket->ticket_id]['spaces']) ) $min_spaces = $_REQUEST['em_tickets'][$EM_Ticket->ticket_id]['spaces'];
			?>
			<div class="em-attendee-fieldset">
				<?php
				for($i = 0; $i < $min_spaces; $i++ ){
					$form->attendee_number = $i;
					if ($i == 0) {
						?>
						<div class="em-attendee-fields em-first-attendee-fields">
							<?php echo str_replace('Participant n°#NUM#', __("Participant n°1 (Vous)", "extra"), $form->__toString()); ?>
						</div>
						<?php
					} else {
						?>
						<div class="em-attendee-fields">
							<?php echo str_replace('#NUM#', $i+1, $form->__toString()); ?>
						</div>
						<?php
					}
				}
				$form->attendee_number = false;
				?>
			</div>
			<div class="em-attendee-fields-template" style="display:none;">
				<?php echo $form; ?>
			</div>
		<?php
		}
	}
}


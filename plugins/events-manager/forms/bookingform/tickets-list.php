<?php 
/* 
 * This file generates a tabular list of tickets for the event booking forms with input values for choosing ticket spaces.
 * If you want to add to this form this, you'd be better off hooking into the actions below.
 */
/* @var $EM_Event EM_Event */
global $allowedposttags;
$EM_Tickets = $EM_Event->get_bookings()->get_tickets(); //already instantiated, so should be a quick retrieval.
foreach( $EM_Tickets->tickets as $EM_Ticket ): /* @var $EM_Ticket EM_Ticket */
if($EM_Ticket->is_available()) {
	echo '<p>'.wp_kses_data($EM_Ticket->ticket_name).'<br />';
	echo __("Jusqu'au", 'extra').' '.date(get_option('date_format'), $EM_Ticket->end_timestamp).'<br />';
	echo $EM_Ticket->get_price(true).' '.__("HT", "extra").'</p>';
	echo '<input name="em_tickets['.$EM_Ticket->ticket_id.'][spaces]" type="hidden" value="1" />';
} else {
	echo '<p class="unavailable">'.wp_kses_data($EM_Ticket->ticket_name).'<br />';
	echo __("À partir du", 'extra').' '.date(get_option('date_format'), $EM_Ticket->start_timestamp).'<br />';
	echo $EM_Ticket->get_price(true).' '.__("HT", "extra").'</p>';
}
endforeach;
?>

<h2>TICKETS LIST</h2>
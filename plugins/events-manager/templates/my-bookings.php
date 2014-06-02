<?php do_action('em_template_my_bookings_header'); ?>

<?php 

global $extra_options;


	global $wpdb, $current_user, $EM_Notices, $EM_Person;
	if(is_user_logged_in()):
		$EM_Person = new EM_Person( get_current_user_id() );
		$EM_Bookings = $EM_Person->get_bookings();
		$bookings_count = count($EM_Bookings->bookings);
		if($bookings_count > 0){
			//Get events here in one query to speed things up
			$event_ids = array();
			foreach($EM_Bookings as $EM_Booking){
				$event_ids[] = $EM_Booking->event_id;
			}
		}
		$limit = ( !empty($_GET['limit']) ) ? $_GET['limit'] : 20;//Default limit
		$page = ( !empty($_GET['pno']) ) ? $_GET['pno']:1;
		$offset = ( $page > 1 ) ? ($page-1)*$limit : 0;
		echo $EM_Notices;
		?>
		<div class='em-my-bookings'>
				<?php if( $bookings_count > 0 ):
					$rowno = 0;
					$event_count = 0;
					$nonce = wp_create_nonce('booking_cancel');
					foreach ($EM_Bookings as $EM_Booking) {
						/* @var $EM_Booking EM_Booking */
						$EM_Event = $EM_Booking->get_event();
						$attributes = $EM_Event->event_attributes;
						if( ($rowno < $limit || empty($limit)) && ($event_count >= $offset || $offset === 0) ) {
							$rowno++;
							?>

							<h3><?php _e("Statut : ", "extra"); ?><?php echo $EM_Booking->get_status(); ?></h3>
							<p><?php _e("Pour modifier votre réservation, ", "extra"); ?> <a href="<?php echo get_permalink($extra_options['contact_page']); ?>"><?php _e("veuillez nous contacter", "extra"); ?></a>.</p>

							<?php
							$cancel_link = '';
							//$cancel_limit_date = DateTime::createFromFormat('d/m/Y', $attributes["extra_cancel_limit"]);
							$cancel_limit_date = DateTime::createFromFormat('d/m/Y', '30/10/2018');
							if( !in_array($EM_Booking->status, array(2,3)) && get_option('dbem_bookings_user_cancellation') && $EM_Event->get_bookings()->has_open_time()){
								if(time() < $cancel_limit_date->getTimestamp()) {
									$cancel_url = em_add_get_params($_SERVER['REQUEST_URI'], array('action'=>'booking_cancel', 'booking_id'=>$EM_Booking->booking_id, '_wpnonce'=>$nonce));
									$cancel_link = '<a class="em-bookings-cancel button" href="'.$cancel_url.'" onclick="if( !confirm(EM.booking_warning_cancel) ){ return false; }">'.__('Cancel','dbem').'</a>';
								} else {
									echo '<p><strong>'.__("L'annulation n'est plus possible.", "extra").'</strong></p>';
								}
							}
							echo apply_filters('em_my_bookings_booking_actions', $cancel_link, $EM_Booking);

						}
						do_action('em_my_bookings_booking_loop',$EM_Booking);
						$event_count++;
					}
					?>
				<?php else: ?>
					<?php _e('You do not have any bookings.', 'dbem'); ?>
				<?php endif; ?>
		</div>	
<?php else: ?>
	<p><?php echo sprintf(__('Please <a href="%s">Log In</a> to view your bookings.','dbem'),site_url('wp-login.php?redirect_to=' . urlencode(get_permalink()), 'login'))?></p>
<?php endif; ?>
<?php do_action('em_template_my_bookings_footer', $EM_Bookings); ?>
<?php
/*
 * GUESTS
 * Guests number
 * extra_guest_num
 * text
 */
global $extra_mails; 
if($_SERVER["HTTP_HOST"] == "dev.extralagence.com") {
	$extra_mails = array();
} else {
	$extra_mails = array();
}

/**********************
 *
 *
 *
 * ATTENDEES
 *
 *
 *
 *********************/
include_once THEME_PATH . '/modules/event/front/attendees.php';

/**********************
 *
 *
 *
 * PAYPAL
 * 
 *
 *
 *********************/
include_once THEME_PATH . '/modules/event/front/paypal.php';
/**********************
 *
 *
 *
 * PAYPAL
 * 
 *
 *
 *********************/
include_once THEME_PATH . '/modules/event/front/ticket-price.php';
/**********************
 *
 *
 *
 * BANK TRANSFERT
 * 
 *
 *
 *********************/
include_once THEME_PATH . '/modules/event/front/bank.php';
/**********************
 *
 *
 *
 * CUSTOM FORM
 * 
 *
 *
 *********************/
include_once THEME_PATH . '/modules/event/front/form.php';
/**********************
 *
 *
 *
 * VALIDATION
 * 
 *
 *
 *********************/
include_once THEME_PATH . '/modules/event/front/validation.php';
/**********************
 *
 *
 *
 * EMAILS
 * 
 *
 *
 *********************/
include_once THEME_PATH . '/modules/event/front/mails.php';
/**********************
 *
 *
 *
 * CUSTOM FIELDS
 * 
 *
 *
 *********************/
include_once THEME_PATH . '/modules/event/front/custom-fields.php';
/**********************
 *
 *
 *
 * CSV EXPORT
 * 
 *
 *
 *********************/
//include_once THEME_PATH . '/modules/event/front/csv-exporter.php';
/**********************
 *
 *
 *
 * PAYBOX
 *
 *
 *
 *********************/
include_once THEME_PATH . '/modules/event/front/paybox.php';
/**********************
 *
 *
 *
 * BETTER SAVE OF CUSTOM FORMS
 * 
 *
 *
 *********************/
class EMP_Forms_Fix{
	public static function init(){
		global $pagenow;
		if( !empty($_REQUEST['page']) && $_REQUEST['page'] == 'events-manager-forms-editor'){
			add_action('admin_init', 'EMP_Forms_Fix::post', 1, 1);
			add_action('admin_head', 'EMP_Forms_Fix::js', 1, 1);
		}
	}

	public static function post(){
		if( isset($_REQUEST['fields_json']) ){
			$str = $test = str_replace(array('[]\\"','\\"','\\\\'),array('"','"','\\'),$_REQUEST['fields_json']);
			$test = (array) json_decode($test);
			if (count($test)) $_REQUEST = array_merge($_REQUEST, $test);
		}
	}

	public static function js( $form_name) {
		?>
		<script type="text/javascript">
			jQuery(document).ready( function($){
				if (typeof JSON.stringify != 'undefined'){
					if (typeof jQuery.serializeJSON == 'undefined') jQuery.fn.serializeJSON = function(){
					    var o = {},
					    a = this.serializeArray();
					    jQuery.each(a, function() {
					        if (o[this.name] !== undefined) {
					            if (!o[this.name].push) { o[this.name] = [o[this.name]]; }
					            o[this.name].push(this.value || '');
					        } else {
					            o[this.name] = this.value || '';
					        }
					    });
					    return JSON.stringify(o, null, 2);
					}
					
					jQuery('.em-form-custom').submit(function(event){
					    var myform = jQuery(this);
					    if (myform.find('#fields_json').length) return;	//have already made switch, so let default submit take place
					    event.preventDefault();
					    var data = myform.serializeJSON();
					    myform.empty().append(jQuery('<input/>').attr({id:'fields_json', name:'fields_json', value:data})).submit();
					});
				}
			});
		</script>
		<?php

	}
}
if( is_admin() ){
	EMP_Forms_Fix::init();
}



global $extra_event_metabox;
$extra_event_metabox = new ExtraMetaBox(array(
	'id' => '_extra_event_meta',
	'title' => __("Paramètres de l'événement", "extra"),
	'mode' => WPALCHEMY_MODE_EXTRACT,
	'prefix' => '_',
	'types' => array('event'),
	'hide_editor' => TRUE,
	'fields' => array(
		array(
			'type' => 'bloc',
			'label' => __("Arrivée", "extra-admin"),
			'subfields' => array(
				array(
					'type' => 'date',
					'name' => 'extra_arrival_date_min',
					'label' => __("Date minimum", "extra-admin")
				),
				array(
					'type' => 'date',
					'name' => 'extra_arrival_date_max',
					'label' => __("Date maximum", "extra-admin")
				),
				array(
					'type' => 'slider',
					'name' => 'extra_arrival_time_min',
					'max' => '24',
					'label' => __("Heure minimum", "extra-admin")
				),
				array(
					'type' => 'slider',
					'name' => 'extra_arrival_time_max',
					'max' => '24',
					'label' => __("Heure maximum", "extra-admin")
				),
			)
		),
		array(
			'type' => 'bloc',
			'label' => __("Départ", "extra-admin"),
			'subfields' => array(
				array(
					'type' => 'date',
					'name' => 'extra_departure_date_min',
					'label' => __("Date minimum", "extra-admin")
				),
				array(
					'type' => 'date',
					'name' => 'extra_departure_date_max',
					'label' => __("Date maximum", "extra-admin")
				),
				array(
					'type' => 'slider',
					'name' => 'extra_departure_time_min',
					'max' => '24',
					'label' => __("Heure minimum", "extra-admin")
				),
				array(
					'type' => 'slider',
					'name' => 'extra_departure_time_max',
					'max' => '24',
					'label' => __("Heure maximum", "extra-admin")
				),
			)
		),
		array(
			'type' => 'bloc',
			'label' => __("Prix", "extra-admin"),
			'subfields' => array(
				array(
					'type' => 'slider',
					'name' => 'extra_cocktail_price',
					'max' => '500',
					'label' => __("Pour le cocktail", "extra-admin")
				),
				array(
					'type' => 'slider',
					'name' => 'extra_gala_price',
					'max' => '500',
					'label' => __("Pour le gala", "extra-admin")
				)
			)
		),
	)
));

function extra_event_enqueue_assets() {
	if (is_singular('event')) {
		wp_enqueue_style( 'extra-event-form', THEME_MODULES_URI.'/event/front/css/event.less', array(), false, 'all' );

		wp_register_style('extra-jquery-ui', THEME_URI . '/assets/css/jquery-ui/jquery-ui-1.9.2.custom.min.css', array(), false, 'all' );
		wp_enqueue_style('extra-jquery-ui');

		// DATEPICKER
		wp_enqueue_script('jquery-ui');
		wp_enqueue_script('jquery-ui-core');
		wp_enqueue_script('jquery-ui-slider');
		wp_enqueue_script('jquery-ui-datepicker');
		// DATEPICKER JS
		wp_enqueue_script('jquery-ui-datepicker-fr', THEME_URI.'/assets/js/lib/jquery.ui.datepicker-fr.js', array('jquery'), false, true);
		// STICKY
		wp_enqueue_script('jquery-waypoints', THEME_URI.'/assets/js/lib/waypoints.min.js', array('jquery'), false, true);
		wp_enqueue_script('jquery-waypoints-sticky', THEME_URI.'/assets/js/lib/waypoints-sticky.min.js', array('jquery'), false, true);
		// CHECKBOX
		wp_enqueue_script('extra-checkbox', THEME_MODULES_URI.'/event/front/js/extra.checkbox.js', array('jquery'), false, true);
		// EVENT
		wp_enqueue_script('extra-event', THEME_MODULES_URI.'/event/front/js/event.js', array('jquery', 'jquery-ui-slider', 'jquery-ui-datepicker', 'jquery-ui-datepicker-fr', 'jquery-waypoints', 'jquery-waypoints-sticky', 'extra-checkbox'), false, true);
	}
}
add_action('wp_enqueue_scripts', 'extra_event_enqueue_assets');


function the_extra_booking_datas($id) {
	global $extra_event_metabox;
	$meta = $extra_event_metabox->the_meta($id);

	// CUSTOM METAS
	$extra_arrival_date_max = $meta['extra_arrival_date_max'];
	$extra_arrival_date_min = $meta['extra_arrival_date_min'];
	$extra_arrival_time_max = $meta['extra_arrival_time_max'];
	$extra_arrival_time_min = $meta['extra_arrival_time_min'];
	$extra_departure_date_max = $meta['extra_departure_date_max'];
	$extra_departure_date_min = $meta['extra_departure_date_min'];
	$extra_departure_time_max = $meta['extra_departure_time_max'];
	$extra_departure_time_min = $meta['extra_departure_time_min'];

	$user_meta = get_user_meta(get_current_user_id());
	$extra_first_name = '';
	$extra_last_name = '';
	if ($user_meta != false) {
		$extra_first_name = $user_meta['first_name'][0];
		$extra_last_name = $user_meta['last_name'][0];
	}
	?>
	<script type="text/javascript">
		var extra_booking_datas = {
		'template_url': "<?php echo THEME_URI; ?>",
			'extra_arrival_date_max': "<?php echo $extra_arrival_date_max; ?>",
			'extra_arrival_date_min': "<?php echo $extra_arrival_date_min; ?>",
			'extra_arrival_time_max': "<?php echo $extra_arrival_time_max; ?>",
			'extra_arrival_time_min': "<?php echo $extra_arrival_time_min; ?>",
			'extra_departure_date_max': "<?php echo $extra_departure_date_max; ?>",
			'extra_departure_date_min': "<?php echo $extra_departure_date_min; ?>",
			'extra_departure_time_max': "<?php echo $extra_departure_time_max; ?>",
			'extra_departure_time_min': "<?php echo $extra_departure_time_min; ?>",
			'extra_first_name': "<?php echo $extra_first_name; ?>",
			'extra_last_name': "<?php echo $extra_last_name; ?>"
		};
	</script>
	<?php
}

?>
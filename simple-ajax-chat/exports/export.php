<?php // Simple Ajax Chat > Export CSV

define('WP_USE_THEMES', false);

require(dirname(dirname(dirname(dirname(dirname(__FILE__))))) .'/wp-load.php');

if (!defined('ABSPATH')) exit;

function sac_export_csv() {
	
	$nonce = isset($_GET['sac-download']) ? sanitize_text_field($_GET['sac-download']) : null;
	
	if (!wp_verify_nonce($nonce, 'sac-download')) return false;
	
	if (!current_user_can('manage_options')) wp_die(__('Sorry, you are not allowed to export data.', 'simple-ajax-chat'));
	
	$key = get_option('sac_export', false);
	
	$file = $key ? 'sac-export-'. $key .'.csv' : false;
	
	if ($file) {
		
		$size = (string) filesize($file);
		
		header('Expires: 0');
		header('Pragma: public');
		header('Cache-Control: public');
		header('Content-Length: '. $size);
		header('Content-Type: application/csv');
		header('Content-Description: SAC Export Download');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Content-Disposition: attachment; filename='. $file);
		
		readfile($file);
		
		exit();
		
	}
	
}

sac_export_csv();

exit();
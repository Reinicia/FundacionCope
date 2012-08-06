<?php

/*
Plugin Name: WP SES
Version: 0.2.2
Plugin URI: http://wp-ses.com
Description: Uses Amazon Simple Email Service instead of local mail for all outgoing WP emails.
Author: Sylvain Deaure
Author URI: http://www.blog-expert.fr
*/

define('WPSES_VERSION', 0.22);

// refs
// http://aws.amazon.com/fr/
//

// 0.2.2 : Reference language is now english
// 0.2.1 : return-path | stats | Quota | Deactivate plugin | Production mode test
// 0.1.2

// TODO
// stats cache (beware of directory)
// logs of mails sent (inc details ?)
// traiter les erreurs (stocker contenu) pour les re-tenter plus tard ?
// Mailqueue
// limits (check once per hour (or  faster) and stop if near limit)
// blacklist, mail delivery handling
// dashboard integration (main stats without extra page)


if (is_admin()) {
	// TODO : Ask before activate
	// include_once(WP_PLUGIN_DIR.'/wp-ses/sdrssw.php');
	add_action('init', 'wpses_init');
	add_action('admin_menu', 'wpses_admin_menu');
	register_activation_hook(__FILE__, 'wpses_install');
	register_deactivation_hook(__FILE__, 'wpses_uninstall');
}
require_once (WP_PLUGIN_DIR . '/wp-ses/ses.class.php');

function wpses_init() {
	load_plugin_textdomain('wpses', false, basename(dirname(__FILE__)));
	wpses_admin_warnings();
}

add_filter('wp_mail_from', 'wpses_from', 1);
add_filter('wp_mail_from_name', 'wpses_from_name', 1);

function wpses_install() {
	global $wpdb, $wpses_options;
	if (!get_option('wpses_options')) {
		add_option('wpses_options', array (
			'from_email' => '',
			'return_path' => '',
			'from_name' => 'WordPress',
			'access_key' => '',
			'secret_key' => '',
			'credentials_ok' => 0,
			'sender_ok' => 0,
			'last_ses_check'=>0, // timestamp of last quota check
			'active' => 0, // reset to 0 if not pluggable or config change.
			'version' => '0' // Version of the db
			// TODO: garder liste des ids des demandes associ�es � chaque email.
			// afficher : email, id demande , valid� ?


		));
		$wpses_options = get_option('wpses_options');
	}
}

function wpses_options() {
	global $wpdb, $wpses_options;
	global $current_user;
	get_currentuserinfo();
	if (!in_array('administrator', $current_user->roles)) {
		//die('Pas admin');
	}
	$autorized = '';
	if (($wpses_options['access_key'] != '') and ($wpses_options['secret_key'] != '')) {
		$autorized = wpses_getverified();
	}
	$senders = (array) get_option('wpses_senders');
	// ajouter dans senders les verified absents
	$update = false;
	foreach ($autorized as $email) {
		if (!array_key_exists($email, $senders)) {
			$senders[$email] = array (
				-1,
				TRUE
			);
			$updated = true;
		} else {
			if (!$senders[$email][1]) {
				// activer ceux qu'on a re�u depuis
				$senders[$email][1] = TRUE;
				$updated = true;
			}
		}
	}

	if ($updated) {
		update_option('wpses_senders', $senders);
	}
	if ( ($wpses_options['sender_ok'] != 1) or ($wpses_options['credentials_ok'] != 1) ){
		$wpses_options['active'] = 0;
		update_option('wpses_options', $wpses_options);
	}
	if (($wpses_options['from_email'] != '') and ($senders[$wpses_options['from_email']][1]===TRUE)) {
		// email exp enregistr� non vide et list�, on peut donc supposer que credentials ok et exp ok.
		if ($wpses_options['credentials_ok'] == 0) {
			$wpses_options['credentials_ok'] = 1;
			update_option('wpses_options', $wpses_options);
		}
		if ($wpses_options['sender_ok'] == 0) {
			$wpses_options['sender_ok'] = 1;
			update_option('wpses_options', $wpses_options);
		}
	}
	if ($senders[$wpses_options['from_email']][1]!==TRUE) {
		$wpses_options['sender_ok'] = 0;
		update_option('wpses_options', $wpses_options);
	}

	if (!empty ($_POST['activate'])) {
		if (($wpses_options['sender_ok'] == 1) and ($wpses_options['credentials_ok'] == 1)) {
			$wpses_options['active'] = 1;
			update_option('wpses_options', $wpses_options);
			echo '<div id="message" class="updated fade">
							<p>' . __('Plugin is activated and functionnal', 'wpses') . '</p>
							</div>' . "\n";
		}
	}
	if (!empty ($_POST['deactivate'])) {
			$wpses_options['active'] = 0;
			update_option('wpses_options', $wpses_options);
			echo '<div id="message" class="updated fade">
							<p>' . __('Plugin de-activated', 'wpses') . '</p>
							</div>' . "\n";
	}
	if (!empty ($_POST['save'])) {
		//check_admin_referer();
		//$wpses_options['active'] = trim($_POST['active']);
		if ($wpses_options['from_email'] != trim($_POST['from_email'])) {
			$wpses_options['sender_ok'] = 0;
			$wpses_options['active'] = 0;
		}
		$wpses_options['from_email'] = trim($_POST['from_email']);
		$wpses_options['return_path'] = trim($_POST['return_path']);
		if ($wpses_options['return_path'] =='') {
			$wpses_options['return_path']=$wpses_options['from_email'];
		}
		$wpses_options['from_name'] = trim($_POST['from_name']); //
		// TODO si mail diff�re, relancer proc�dure check => resetter sender_ok si besoin

		if (($wpses_options['access_key'] != trim($_POST['access_key'])) or ($wpses_options['secret_key'] != trim($_POST['secret_key']))) {
			$wpses_options['credentials_ok'] = 0;
			$wpses_options['sender_ok'] = 0;
			$wpses_options['active'] = 0;
		}
		$wpses_options['access_key'] = trim($_POST['access_key']); //
		$wpses_options['secret_key'] = trim($_POST['secret_key']); //
		// TODO si credentials different, resetter credentials_ok

		update_option('wpses_options', $wpses_options);
		echo '<div id="message" class="updated fade">
																											<p>' . __('Settings updated', 'wpses') . '</p>
																											</div>' . "\n";
	}
	$wpses_options = get_option('wpses_options');
	// validation cle amazon
	// validation email envoi
	if (!empty ($_POST['addemail'])) {
		wpses_verify_sender_step1($wpses_options['from_email']);
	}
	// envoi mail test
	if (!empty ($_POST['testemail'])) {
		wpses_test_email($wpses_options['from_email']);
	}
	// envoi mail test prod
	if (!empty ($_POST['prodemail'])) {
		wpses_prod_email($_POST['prod_email_to'],$_POST['prod_email_subject'],$_POST['prod_email_content']);
	}

	include ('admin.tmpl.php');
}

// TODO
function wpses_uninstall() {
	// delete_option('wpses_options');
	// Do not delete, else we loose the version number
	// TODO: add an uninstall link ? Not a big deal since we added very little overhead
}

function wpses_admin_warnings() {
	global $wpses_options;
	$active = $wpses_options['active'];
	if ($active <= 0) {
		function wpses_warning() {
			global $wpses_options;
			echo "<div id='wpses-warning' class='updated fade'><p><strong>" . __("WP SES - Simple Email Service is not fully activated. Please check it's config: ", 'wpses') .
			'<a href="options-general.php?page=wp-ses/wp-ses.php">'.__("Settings &rarr; WP SES",'wpses').'</a>.' . "</p></div>";
		}
		add_action('admin_notices', 'wpses_warning');
		return;
	}
}

function wpses_admin_menu() {
	add_options_page('wpses', __('WP SES', 'wpses'), 8, __FILE__, 'wpses_options');
	// Quota and Stats
	add_submenu_page('index.php', 'SES Stats', 'SES Stats', 8, 'wp-ses/ses-stats.php');

}

function wpses_from($mail_from_email) {
	global $wpses_options;
	$from_email = $wpses_options['from_email'];
	if (empty ($from_email)) {
		return $mail_from_email;
	} else {
		return $from_email;
	}
}

function wpses_from_name($mail_from_name) {
	global $wpses_options;
	$from_name = $wpses_options['from_name'];
	if (empty ($from_name)) {
		return $mail_from_name;
	} else {
		return $from_name;
	}
}

function wpses_message_step1done() {
	global $WPSESMSG;
	echo "<div id='wpses-warning' class='updated fade'><p><strong>" . __("A confirmation request has been sent. You will receive at the stated email a confirmation request from amazon SES. You MUST click on the provided link in order to confirm your sender Email.<br />SES Answer - ", 'wpses') . $WPSESMSG . "</strong></p></div>";
}

function wpses_getverified() {
	global $wpses_options;
	global $SES;
	wpses_check_SES();
	@ $result = $SES->listVerifiedEmailAddresses();
	if (is_array($result)) {
		return $result['Addresses'];
	} else {
		return NULL;
	}
}

function wpses_check_SES() {
	global $wpses_options;
	global $SES;
	if (!isset ($SES)) {
		$SES = new SimpleEmailService($wpses_options['access_key'], $wpses_options['secret_key']);
	}
}

function wpses_error_handler($level, $message, $file, $line, $context) {
	global $WPSESMSG;
	$WPSESMSG = __('SES Error: ', 'wpses') . $message;
	return (true); //And prevent the PHP error handler from continuing
}

// start email verification (mail from amazon to sender, requesting validation)
function wpses_verify_sender_step1($mail) {
	global $wpses_options;
	global $SES, $WPSESMSG;
	wpses_check_SES();
	$WPSESMSG = '';
	// dans la chaine : Sender - InvalidClientTokenId  si auth pas correct
	// Sender - OptInRequired
	// The AWS Access Key Id needs a subscription for the service: si cl� aws ok, mais pas d'abo au service amazon lors de la verif d'un mail
	// inscription depuis aws , verif phone.
	//Use our custom handler
	//set_error_handler('wpses_error_handler');
	try {
		$rid = $SES->verifyEmailAddress($mail);
		$senders = get_option('wpses_senders');
		if ($rid <> '') {
			$senders[$mail] = array (
				$rid['RequestId'],
				false
			);
			$wpses_options['credentials_ok'] = 1;
			update_option('wpses_options', $wpses_options);
			update_option('wpses_senders', $senders);
		}
		//echo("rid ");
		//print_r($rid);
	} catch (Exception $e) {
		$WPSESMSG = __('Got exception: ','wpses') . $e->getMessage() . "\n";
	}
	//restore_error_handler();
	$WPSESMSG .= ' id ' . var_export($rid, true);
	wpses_message_step1done();
	//	add_action('admin_notices', 'wpses_message_step1done'); // no : too late for this !
}

function wpses_message_testdone() {
	global $WPSESMSG;
	echo "<div id='wpses-warning' class='updated fade'><p><strong>" . __("Test message has been sent to your sender Email address.<br />SES Answer - ", 'wpses') . $WPSESMSG . "</strong></p></div>";
}

function wpses_test_email($mail) {
	global $wpses_options;
	global $SES, $WPSESMSG;
	wpses_check_SES();
	$WPSESMSG = '';
	$rid = wpses_mail($wpses_options['from_email'], __('WP SES - Test Message','wpses'), __("This is WP SES Test message. It has been sent via Amazon SES Service.\nAll looks fine !\n\n",'wpses') . __('WP SES is a plugin by', 'wpses') . ' http://www.blog-expert.fr/');
	$WPSESMSG .= ' id ' . var_export($rid, true);
	wpses_message_testdone();
}

function wpses_prod_email($mail,$subject,$content) {
	global $wpses_options;
	global $SES, $WPSESMSG;
	wpses_check_SES();
	$WPSESMSG = '';
	$rid = wpses_mail($mail,$subject,$content);
	$WPSESMSG .= ' id ' . var_export($rid, true);
	echo "<div id='wpses-warning' class='updated fade'><p><strong>" . __("Test message has been sent.<br />SES Answer - ", 'wpses') . $WPSESMSG . "</strong></p></div>";

}

// returns msg id
function wpses_mail($to, $subject, $message, $headers = '') {
	global $SES;
	global $wpses_options;
	wpses_check_SES();
	$html = $message;
	$txt = strip_tags($html);
	if (strlen($html) == strlen($txt)) {
		$html = ''; // que msg text
	}
	// TODO: option pour que TXT si msg html, ou les deux comme ici par d�faut.
	$m = new SimpleEmailServiceMessage();
	$m->addTo($to);
	$m->setFrom('"' . $wpses_options['from_name'] . '" <' . $wpses_options['from_email'] . ">");
	$m->setReturnPath($wpses_options['return_path']);
	$m->setSubject($subject);
	if ($html == '') { // que texte
		$m->setMessageFromString($message);
	} else {
		$m->setMessageFromString($txt, $html);
	}
	$res = $SES->sendEmail($m);
	if (is_array($res)) {
		return $res['MessageId'];
	} else {
		return NULL;
	}
}

if (!isset ($wpses_options)) {
	$wpses_options = get_option('wpses_options');
}

if ($wpses_options['active'] == 1) {
	if (!function_exists('wp_mail')) {
		function wp_mail($to, $subject, $message, $headers = '') {
			global $wpses_options;
			$id = wpses_mail($to, $subject, $message, $headers);
			if ($id != '') {
				return true;
			} else {
				return false;
			}
		}
	} else {
		function wpses_warningmail() {
			echo "<div id='wpses-warning' class='updated fade'><p><strong>" . __('Another plugin did override wp-mail function. Please de-activate the other plugin if you want WP SES to work properly.', 'wpses') . "</strong></p></div>";
		}
		add_action('admin_notices', 'wpses_warningmail');
		// D�sactiver "active" si actif.
		if ($wpses_options['active'] == 1) {
			$wpses_options['active'] = 0;
			update_option('wpses_options', $wpses_options);
		}
	}
	$SES = new SimpleEmailService($wpses_options['access_key'], $wpses_options['secret_key']);
}

$WPSESMSG = '';
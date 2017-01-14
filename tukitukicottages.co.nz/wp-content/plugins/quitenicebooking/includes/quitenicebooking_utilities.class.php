<?php
/**
 * Common utilities and helpers for Quitenicebooking_*
 */
class Quitenicebooking_Utilities {

	/**
	 * Convert a date string to unix time
	 *
	 * @param string $datestring The date string
	 * @param array $settings The global settings
	 * @param boolean $midnight Whether to append ' 00:00:00' to the datestring
	 * @return int The unix time
	 */
	public static function to_timestamp($datestring, $settings, $midnight = TRUE) {
		if ($midnight) {
			$datestring .= ' 00:00:00';
		}
		$version = explode('.', phpversion());
		// PHP >= 5.3.0
        if(((int)$version[0] >= 5 && (int)$version[1] >= 3 && (int)$version[2] >= 0)){
			return date_timestamp_get(date_create_from_format($settings['date_format_strings'][$settings['date_format']]['php'], $datestring));
        }
		// PHP < 5.3.0
		if ($settings['date_format'] == 'dd/mm/yy') {
			$datestring = str_replace('/', '-', $datestring);
			return strtotime($datestring);
		} elseif ($settings['date_format'] == 'mm/dd/yy') {
			return strtotime($datestring);
		} elseif ($settings['date_format'] == 'yy/mm/dd') {
			return strtotime($datestring);
		}
	}

	/**
	 * Convert unix time to date string
	 *
	 * @param int $unixtime The unix time
	 * @param array $settings The global settings
	 * @param boolean $trim Whether to trim ' 00:00:00' from the end or not
	 * @return string The date string
	 */
	public static function to_datestring($unixtime, $settings, $trim = TRUE) {
		if ($trim) {
			return substr(date($settings['date_format_strings'][$settings['date_format']]['php'], $unixtime), 0, -9);
		}
		return date($settings['date_format_strings'][$settings['date_format']]['php'], $unixtime);
	}

	/**
	 * Sends mail by SMTP or mail(), depending on settings
	 *
	 * @global PHPMailer $phpmailer
	 * @param array $from array('name' => string, 'email' => string)
	 * @param array $to array('name => string, 'email' => string)
	 * @param string $subject
	 * @param string $body
	 * @param array $settings The global settings
	 * @return mixed TRUE if mail succeded, string containing error message if it did not
	 */
	public static function send_mail($from, $to, $subject, $body, $settings) {
		// instantiate mailer
		global $phpmailer;
		// from wp-includes/pluggable.php
		if (!is_object($phpmailer) || !is_a($phpmailer, 'PHPMailer')) {
			require_once ABSPATH . WPINC . '/class-phpmailer.php';
			require_once ABSPATH . WPINC . '/class-smtp.php';
		}
		$phpmailer = new PHPMailer(TRUE); // clear out any previous settings

		// determine whether to send by SMTP
		if (!empty($settings['enable_smtp']) && !empty($settings['smtp_host']) && !empty($settings['smtp_port'])) {
			$phpmailer->isSMTP();
			$phpmailer->Host = $settings['smtp_host'];
			$phpmailer->Port = $settings['smtp_port'];
			$phpmailer->SMTPSecure = $settings['smtp_encryption'];
			$phpmailer->SMTPAuth = !empty($settings['smtp_auth']) && !empty($settings['smtp_auth']) ? TRUE : FALSE;
			if ($phpmailer->SMTPAuth) {
				$phpmailer->Username = $settings['smtp_username'];
				$phpmailer->Password = $settings['smtp_password'];
			}
		}

		$phpmailer->From = $from['email'];
		$phpmailer->FromName = $from['name'];
		$phpmailer->clearAllRecipients();
		$phpmailer->AddAddress($to['email']);
		$phpmailer->Subject = $subject;
		$phpmailer->CharSet = 'UTF-8';
		$phpmailer->Body = $body;
		$phpmailer->IsHTML(TRUE);

		try {
			$phpmailer->Send();
		} catch (Exception $e) {
			$error = $e->getMessage();
		}
		
		unset($phpmailer);

		if (isset($error)) {
			return $error;
		}
		return TRUE;
	}

	/**
	 * Decodes the reservation form
	 *
	 * @param array $settings The global settings
	 * @return array An array representation of the reservation form
	 *		array(
	 *			$position (int) => array(
	 *				'type' => string
	 *				'required' => boolean
	 *				'id' => string
	 *				'label' => string
	 *				'value' => string (optional)
	 *				'maxlength' => int (optional)
	 *				'choices' => array (optional)
	 *				'multiple' => boolean (optional)
	 *				'class' => string (optional)
	 *			)
	 *		)
	 */
	public static function decode_reservation_form($settings) {
		$tags = array();
		preg_match_all('/\[(guest_first_name|guest_last_name|guest_email)\]|\[(text|textarea|checkbox|radio|select)\s+(required)?\s?id="([^"]+)"\s+label="([^"]+)"\s*(?:value="([^"]+)")?\s*(?:maxlength="(\d+)")?\s*(?:choices="([^"]+)")?\s*(multiple)?\s*(?:class="([^"]+)")?\s*\]/', $settings['reservation_form'], $tags, PREG_SET_ORDER);

		$reservation_form = array();
		$position = 0;
		foreach ($tags as $tag) {
			if (in_array($tag[1], array('guest_first_name', 'guest_last_name', 'guest_email'))) {
				$reservation_form[$position]['type'] = $tag[1];
			} else {
				$reservation_form[$position]['type'] = $tag[2];
				if (!empty($tag[3])) {
					$reservation_form[$position]['required'] = TRUE;
				}
				$reservation_form[$position]['id'] = $tag[4];
				$reservation_form[$position]['label'] = $tag[5];
				if (!empty($tag[6])) {
					$reservation_form[$position]['value'] = $tag[6];
				}
				if (!empty($tag[7])) {
					$reservation_form[$position]['maxlength'] = $tag[7];
				}
				if (!empty($tag[8])) {
					$reservation_form[$position]['choices'] = explode(',', $tag[8]);
				}
				if (!empty($tag[9])) {
					$reservation_form[$position]['multiple'] = TRUE;
				}
				if (!empty($tag[10])) {
					$reservation_form[$position]['class'] = $tag[10];
				}
			}
			$position ++;
		}

		return $reservation_form;
	}

	/**
	 * Formats a price string
	 *
	 * Puts the currency symbol before/after the price, depending on settings
	 *
	 * @param float $price The price
	 * @param array $settings The global settings
	 * @return string The formatted price string
	 */
	public static function format_price($price, $settings) {
		if (!empty($settings['currency_unit_suffix'])) {
			return $price.$settings['currency_unit'];
		}
		return $settings['currency_unit'].$price;
	}

}

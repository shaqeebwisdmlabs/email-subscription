<?php

/**
 * Fired during plugin activation
 *
 * @link       https://shaqeeb.com
 * @since      1.0.0
 *
 * @package    Email_Subscription
 * @subpackage Email_Subscription/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Email_Subscription
 * @subpackage Email_Subscription/includes
 * @author     Shaqeeb Akhtar <shaqeeb.akhtar@wisdmlabs.com>
 */
class Email_Subscription_Activator
{

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate()
	{
		global $wpdb;
		$table_name = $wpdb->prefix . 'subscription_emails';
		$sql =	"CREATE TABLE IF NOT EXISTS `$table_name` (
			`id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
			`email` varchar(255) NOT NULL
		  ) ENGINE='InnoDB';";
		$wpdb->query($sql);
	}
}
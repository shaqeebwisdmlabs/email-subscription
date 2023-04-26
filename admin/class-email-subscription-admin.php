<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://shaqeeb.com
 * @since      1.0.0
 *
 * @package    Email_Subscription
 * @subpackage Email_Subscription/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Email_Subscription
 * @subpackage Email_Subscription/admin
 * @author     Shaqeeb Akhtar <shaqeeb.akhtar@wisdmlabs.com>
 */
class Email_Subscription_Admin
{

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($plugin_name, $version)
	{

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Email_Subscription_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Email_Subscription_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/email-subscription-admin.css', array(), $this->version, 'all');
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Email_Subscription_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Email_Subscription_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/email-subscription-admin.js', array('jquery'), $this->version, false);
	}

	public function wsdm_register_admin_menu()
	{
		add_menu_page("Subscription Settings", "Subscription Settings", "manage_options", "subscription-settings", array($this, "wsdm_admin_menu_display"), "dashicons-bell", 6);
	}

	public function wsdm_admin_menu_display()
	{
		require_once 'partials/email-subscription-admin-display.php';
	}

	function wsdm_subscription_settings()
	{
		register_setting('subscription', 'post_count_input');
		add_settings_section('post_count_settings', 'Post Count Settings', '', 'subscription');
		add_settings_field('post_count_input', 'Post Count', array($this, 'wsdm_subscription_post_count_field'), 'subscription', 'post_count_settings');
	}

	public function wsdm_subscription_post_count_field()
	{
?>
		<input type="number" name="post_count_input" min="0" value="<?php echo get_option('post_count_input'); ?>" required>

<?php
	}
}

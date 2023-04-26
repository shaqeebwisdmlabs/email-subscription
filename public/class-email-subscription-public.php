<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://shaqeeb.com
 * @since      1.0.0
 *
 * @package    Email_Subscription
 * @subpackage Email_Subscription/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Email_Subscription
 * @subpackage Email_Subscription/public
 * @author     Shaqeeb Akhtar <shaqeeb.akhtar@wisdmlabs.com>
 */
class Email_Subscription_Public
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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($plugin_name, $version)
	{

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/email-subscription-public.css', array(), $this->version, 'all');
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/email-subscription-public.js', array('jquery'), $this->version, false);
		wp_localize_script($this->plugin_name, 'ajax_url', array('ajaxurl' => admin_url('admin-ajax.php')));
	}

	public function wsdm_email_subscription_shortcode()
	{
		ob_start();
?>
		<div class="wrapper">
			<form action="" class="subscription-form" id="subscription-form">
				<div class="container">
					<h3>Newsletter Subscription</h3>
					<p>Subscribe to our newsletter and stay updated.</p>
				</div>
				<div class="form-input">
					<div class="input">
						<input type="email" name="email" id="email" placeholder="Your Email">
						<button class="subscribe-btn" id="subscribe-btn">Subscribe Me</button>
					</div>
					<div id="error-message"></div>
				</div>
			</form>
			<div id="subscription-message"></div>
		</div>
<?php
		return ob_get_clean();
	}

	public function wsdm_email_subscription()
	{
		$email = sanitize_email($_POST['email']);

		global $wpdb;

		$table_name = $wpdb->prefix . 'subscription_emails';

		$result = $wpdb->insert($table_name, array(
			'email' => $email,
		));

		if ($result) {

			$sent = $this->wsdm_post_email($email);

			if ($sent) {
				wp_send_json_success(array(
					'message' => 'You have been subscribed successfully.'
				));
			}
		} else {
			wp_send_json_error(array(
				'message' => 'An error occurred while processing your request.'
			));
		}

		wp_die();
	}

	public function wsdm_post_email($email)
	{
		$headers = array(
			'From:  shaqeeb.akhtar@wisdmlabs.com',
			'Content-Type: text/html'
		);
		$subject = 'You have subscribed to our newsletter';
		$message = 'Thank you for subscribing to our newsletter. You will receive updates and news from us. Here are Some latest posts:' . '\n';

		$post_count = get_option('post_count_input', 1);

		$args = array(
			'post_type' => 'post',
			'post_status' => 'publish',
			'posts_per_page' => $post_count,
			'orderby' => 'date',
			'order' => 'DESC',
		);
		$query = new WP_Query($args);

		while ($query->have_posts()) {
			$query->the_post();
			$message .= '----------' . "\n";
			$message .= 'Title: ' . get_the_title() . "\n";
			$message .= 'URL: ' . get_permalink() . "\n";
		}

		// send email
		return wp_mail($email, $subject, $message, $headers);
	}
}

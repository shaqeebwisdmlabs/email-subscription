<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://shaqeeb.com
 * @since      1.0.0
 *
 * @package    Email_Subscription
 * @subpackage Email_Subscription/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="wrap">
    <h1>Subscription Mail Settings</h1>
    <form action="options.php" method="post">
        <?php
        settings_errors();
        settings_fields('subscription');
        do_settings_sections('subscription');
        submit_button('Save Changes');
        ?>
    </form>
</div>
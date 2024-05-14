<?php
/**
 * Plugin Name: Disable RSS Feed
 * Description: This plugin allows users to disable the RSS feed functionality in WordPress.
 * Version: 1.0
 * Author: Rehan Saeed
 * Author URI: https://www.linkedin.com/in/rehan-saeed-4502211a4/
 */

// Add a settings page to the WordPress admin menu
function disable_rss_feed_settings_menu() {
    add_options_page(
        'Disable RSS Feed Settings',
        'Disable RSS Feed',
        'manage_options',
        'disable-rss-feed-settings',
        'disable_rss_feed_settings_page'
    );
}
add_action('admin_menu', 'disable_rss_feed_settings_menu');

// Render the settings page content
function disable_rss_feed_settings_page() {
    if (!current_user_can('manage_options')) {
        return;
    }

    if (isset($_POST['submit'])) {
        if (isset($_POST['disable_rss_feed'])) {
            update_option('disable_rss_feed', 1);
        } else {
            delete_option('disable_rss_feed');
        }
        echo '<div id="setting-error-settings_updated" class="updated settings-error notice is-dismissible"><p><strong>Settings saved.</strong></p></div>';
    }

    $disabled = get_option('disable_rss_feed');
    ?>
    <div class="wrap">
        <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
        <form method="post" action="">
            <label for="disable_rss_feed_checkbox">
                <input type="checkbox" id="disable_rss_feed_checkbox" name="disable_rss_feed" <?php checked($disabled, 1); ?>>
                Disable RSS feed
            </label>
            <p class="submit">
                <input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes">
            </p>
        </form>
    </div>
    <?php
}

// Disable RSS feeds if the option is enabled
function disable_rss_feeds() {
    $disabled = get_option('disable_rss_feed');
    if ($disabled) {
        wp_redirect(home_url());
        exit;
    }
}
add_action('do_feed', 'disable_rss_feeds', 1);
add_action('do_feed_rdf', 'disable_rss_feeds', 1);
add_action('do_feed_rss', 'disable_rss_feeds', 1);
add_action('do_feed_rss2', 'disable_rss_feeds', 1);
add_action('do_feed_atom', 'disable_rss_feeds', 1);
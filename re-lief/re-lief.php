<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://https://github.com/hugoybrahim
 * @since             1.0.0
 * @package           Re_Lief
 *
 * @wordpress-plugin
 * Plugin Name:       re-lief
 * Plugin URI:        https://re-lief.co
 * Description:       This is a description of the plugin.
 * Version:           1.0.0
 * Author:            Hugo Ontiveros
 * Author URI:        https://https://github.com/hugoybrahim/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       re-lief
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'RE_LIEF_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-re-lief-activator.php
 */
function activate_re_lief() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-re-lief-activator.php';
	Re_Lief_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-re-lief-deactivator.php
 */
function deactivate_re_lief() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-re-lief-deactivator.php';
	Re_Lief_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_re_lief' );
register_deactivation_hook( __FILE__, 'deactivate_re_lief' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-re-lief.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_re_lief() {

	$plugin = new Re_Lief();
	$plugin->run();

}
run_re_lief();


// Registro de plantilla personalizada
function custom_template_register($templates) {
    $templates['info.php'] = 'Info Login'; //__('Re-lief', 're-lief');
    $templates['customer_info.php'] = 'Customer Info';
    $templates['myaccount.php'] = 'Account Info';
    $templates['plans.php'] = 'Plans';

    return $templates;
}

add_filter('theme_page_templates', 'custom_template_register');



function custom_template_include($template) {
    if (is_page_template('info.php')) {
        $template = plugin_dir_path(__FILE__) . 'info.php';
    }
    return $template;
}

add_filter('template_include', 'custom_template_include');

function customer_template_include($template) {
    if (is_page_template('customer_info.php')) {
        $template = plugin_dir_path(__FILE__) . 'customer_info.php';
    }
    return $template;
}

add_filter('template_include', 'customer_template_include');

function customer_account_include($template) {
    if (is_page_template('myaccount.php')) {
        $template = plugin_dir_path(__FILE__) . 'myaccount.php';
    }
    return $template;
}

add_filter('template_include', 'customer_account_include');

function customer_plans_include($template) {
    if (is_page_template('plans.php')) {
        $template = plugin_dir_path(__FILE__) . 'plans.php';
    }
    return $template;
}

add_filter('template_include', 'customer_plans_include');

function cambiar_enlace_login_logout() {
    ?>
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            var menuItems = document.querySelectorAll('li.menu-item');

            menuItems.forEach(function(item) {
                var link = item.querySelector('a');

                if (link && link.textContent.trim() === 'Login/Logout') {
                    var urlLogin = '<?php echo home_url('/login'); ?>';
                    var urlLogout = '<?php echo wp_logout_url(home_url('/')); ?>';
                    var userLoggedIn = <?php echo json_encode(is_user_logged_in()); ?>;

                    if (userLoggedIn) {
                        link.setAttribute('href', urlLogout);
                    } else {
                        link.setAttribute('href', urlLogin);
                    }
                }
            });
        });
    </script>
    <?php
}
add_action('wp_footer', 'cambiar_enlace_login_logout');


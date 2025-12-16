<?php
/**
 * Plugin Name: Smart WhatsApp Chat
 * Description: A premium, super-fast, very easy-to-use WhatsApp chat plugin with analytics.
 * Version: 1.0.0
 * Author: Smart WhatsApp Chat
 * Text Domain: smart-whatsapp-chat
 * Domain Path: /languages
 */

if (!defined('ABSPATH')) {
    exit;
}

define('SWC_VERSION', '1.0.0');
define('SWC_PLUGIN_FILE', __FILE__);
define('SWC_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('SWC_PLUGIN_URL', plugin_dir_url(__FILE__));

spl_autoload_register(function ($class) {
    if (strpos($class, 'SWC\\') !== 0) {
        return;
    }
    $relative = str_replace('SWC\\', '', $class);
    $relative = str_replace('\\', DIRECTORY_SEPARATOR, $relative);
    $path = SWC_PLUGIN_DIR . 'includes/' . $relative . '.php';
    if (file_exists($path)) {
        require_once $path;
    }
});

register_activation_hook(__FILE__, function () {
    $install = new SWC\Setup\Install();
    $install->activate();
});

add_action('plugins_loaded', function () {
    $plugin = new SWC\Core\Plugin();
    $plugin->boot();
});

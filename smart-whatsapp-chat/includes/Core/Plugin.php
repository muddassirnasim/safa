<?php
namespace SWC\Core;

use SWC\Admin\Menu;
use SWC\Admin\Assets as AdminAssets;
use SWC\Frontend\Button;
use SWC\Frontend\Popup;
use SWC\Frontend\Message;
use SWC\Analytics\Schema;
use SWC\Analytics\Tracker;
use SWC\Core\Rest;
use SWC\Integrations\WooCommerce;

class Plugin
{
    public function boot(): void
    {
        add_action('init', [$this, 'load_textdomain']);
        add_action('rest_api_init', [$this, 'rest']);
        add_action('init', [$this, 'frontend']);
        add_action('admin_menu', [$this, 'admin']);
        add_action('admin_enqueue_scripts', [$this, 'admin_assets']);
        add_action('wp_enqueue_scripts', [$this, 'frontend_assets']);
        add_action('wp_footer', [$this, 'render_button']);
        add_action('wp_head', [$this, 'render_popup']);
        add_action('init', [$this, 'maybe_install_schema']);
    }

    public function load_textdomain(): void
    {
        load_plugin_textdomain('smart-whatsapp-chat', false, dirname(plugin_basename(SWC_PLUGIN_FILE)) . '/languages');
    }

    public function rest(): void
    {
        $rest = new Rest();
        $rest->register();
    }

    public function frontend(): void
    {
        $message = new Message();
        $message->hooks();
        $woo = new WooCommerce();
        $woo->hooks();
    }

    public function admin(): void
    {
        $menu = new Menu();
        $menu->register();
    }

    public function admin_assets(string $hook): void
    {
        $assets = new AdminAssets();
        $assets->enqueue($hook);
    }

    public function frontend_assets(): void
    {
        $assets = new Assets();
        $assets->enqueue();
    }

    public function render_button(): void
    {
        $button = new Button();
        $button->render();
    }

    public function render_popup(): void
    {
        $popup = new Popup();
        $popup->render();
    }

    public function maybe_install_schema(): void
    {
        $schema = new Schema();
        $schema->create();
        $tracker = new Tracker();
        $tracker->hooks();
    }
}

<?php
namespace SWC\Admin;

class Assets
{
    public function enqueue(string $hook): void
    {
        if (strpos($hook, 'swc') === false) {
            return;
        }

        wp_register_style('swc-admin', SWC_PLUGIN_URL . 'assets/admin/css/admin.css', [], SWC_VERSION);
        wp_register_script('swc-admin', SWC_PLUGIN_URL . 'assets/admin/js/admin.js', ['wp-i18n'], SWC_VERSION, true);

        $data = [
            'rest' => [
                'url' => esc_url_raw(rest_url('swc/v1/settings')),
                'nonce' => wp_create_nonce('wp_rest'),
            ],
            'settings' => \SWC\Core\Helpers::get_settings(),
            'agents' => \SWC\Core\Helpers::get_agents(),
        ];

        wp_localize_script('swc-admin', 'SWC_ADMIN', $data);

        wp_enqueue_style('swc-admin');
        wp_enqueue_script('swc-admin');
    }
}

<?php
namespace SWC\Core;

class Assets
{
    public function enqueue(): void
    {
        if (!Helpers::is_enabled()) {
            return;
        }

        $settings = Helpers::get_settings();
        $agents = Helpers::get_agents();

        wp_register_style('swc-frontend', SWC_PLUGIN_URL . 'assets/frontend/css/frontend.css', [], SWC_VERSION);
        wp_register_script('swc-frontend', SWC_PLUGIN_URL . 'assets/frontend/js/frontend.js', [], SWC_VERSION, true);

        $vars = [
            'enabled' => !empty($settings['enabled']),
            'number' => Helpers::sanitize_number($settings['number']),
            'message' => $settings['message'],
            'design' => $settings['design'],
            'triggers' => $settings['triggers'],
            'agents' => $agents,
            'rest' => [
                'url' => esc_url_raw(rest_url('swc/v1/analytics')),
                'nonce' => wp_create_nonce('wp_rest'),
            ],
        ];

        wp_localize_script('swc-frontend', 'SWC_DATA', $vars);

        wp_enqueue_style('swc-frontend');
        wp_enqueue_script('swc-frontend');
    }
}

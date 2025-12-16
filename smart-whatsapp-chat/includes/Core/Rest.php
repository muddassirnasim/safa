<?php
namespace SWC\Core;

use SWC\Analytics\Repository;

class Rest
{
    public function register(): void
    {
        register_rest_route('swc/v1', '/settings', [
            'methods' => 'POST',
            'permission_callback' => function () {
                return current_user_can('manage_options');
            },
            'callback' => [$this, 'save_settings'],
        ]);

        register_rest_route('swc/v1', '/analytics', [
            'methods' => 'GET',
            'permission_callback' => function () {
                return current_user_can('manage_options');
            },
            'callback' => [$this, 'analytics'],
        ]);

        register_rest_route('swc/v1', '/analytics', [
            'methods' => 'POST',
            'permission_callback' => '__return_true',
            'callback' => [$this, 'log_click'],
        ]);
    }

    public function save_settings(\WP_REST_Request $request)
    {
        $data = $request->get_json_params();
        $number = Helpers::sanitize_number($data['number'] ?? '');
        $message = sanitize_text_field($data['message'] ?? '');
        $enabled = !empty($data['enabled']);
        $design = is_array($data['design'] ?? null) ? $data['design'] : [];
        $triggers = is_array($data['triggers'] ?? null) ? $data['triggers'] : [];
        $agents = is_array($data['agents'] ?? null) ? $data['agents'] : [];

        $settings = Helpers::get_settings();
        $settings['number'] = $number;
        $settings['message'] = $message;
        $settings['enabled'] = $enabled;
        $settings['design'] = wp_parse_args($design, $settings['design']);
        $settings['triggers'] = wp_parse_args($triggers, $settings['triggers']);

        update_option('swc_settings', $settings);
        update_option('swc_agents', array_values(array_map(function ($agent) {
            return [
                'name' => sanitize_text_field($agent['name'] ?? ''),
                'role' => sanitize_text_field($agent['role'] ?? ''),
                'number' => Helpers::sanitize_number($agent['number'] ?? ''),
                'active' => !empty($agent['active']),
            ];
        }, $agents)));

        return rest_ensure_response([
            'success' => true,
            'message' => __('Your WhatsApp chat is live 🎉', 'smart-whatsapp-chat'),
            'settings' => Helpers::get_settings(),
        ]);
    }

    public function analytics(\WP_REST_Request $request)
    {
        $repo = new Repository();
        $start = sanitize_text_field($request->get_param('start'));
        $end = sanitize_text_field($request->get_param('end'));
        $rows = $repo->filter($start, $end);
        return rest_ensure_response($rows);
    }

    public function log_click(\WP_REST_Request $request)
    {
        $repo = new Repository();
        $payload = $request->get_json_params();
        $agent = sanitize_text_field($payload['agent'] ?? '');
        $page_id = absint($payload['pageId'] ?? 0);
        $page_title = sanitize_text_field($payload['pageTitle'] ?? '');
        $page_url = esc_url_raw($payload['pageUrl'] ?? '');
        $device = $payload['device'] === 'mobile' ? 'mobile' : 'desktop';

        $repo->insert([
            'agent' => $agent,
            'page_id' => $page_id,
            'page_title' => $page_title,
            'page_url' => $page_url,
            'device' => $device,
        ]);

        return rest_ensure_response(['logged' => true]);
    }
}

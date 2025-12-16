<?php
namespace SWC\Core;

class Helpers
{
    public static function get_settings(): array
    {
        $settings = get_option('swc_settings');
        if (!is_array($settings)) {
            $settings = [];
        }
        $defaults = new \SWC\Setup\Defaults();
        return wp_parse_args($settings, $defaults->settings());
    }

    public static function get_agents(): array
    {
        $agents = get_option('swc_agents');
        if (!is_array($agents)) {
            return [];
        }
        return array_values(array_filter(array_map(function ($agent) {
            $agent['name'] = sanitize_text_field($agent['name'] ?? '');
            $agent['role'] = sanitize_text_field($agent['role'] ?? '');
            $agent['number'] = preg_replace('/\D+/', '', $agent['number'] ?? '');
            $agent['active'] = !empty($agent['active']);
            return $agent['name'] && $agent['number'] && $agent['active'] ? $agent : null;
        }, $agents)));
    }

    public static function is_enabled(): bool
    {
        $settings = self::get_settings();
        return !empty($settings['enabled']) && !empty($settings['number']);
    }

    public static function sanitize_number(string $number): string
    {
        return preg_replace('/\D+/', '', $number);
    }

    public static function device(): string
    {
        return wp_is_mobile() ? 'mobile' : 'desktop';
    }
}

<?php
namespace SWC\Frontend;

use SWC\Core\Helpers;

class Button
{
    public function render(): void
    {
        if (!Helpers::is_enabled()) {
            return;
        }
        $settings = Helpers::get_settings();
        $agents = Helpers::get_agents();
        $number = Helpers::sanitize_number($settings['number']);
        $is_mobile = Helpers::device() === 'mobile';
        if (($is_mobile && empty($settings['triggers']['show_on_mobile'])) || (!$is_mobile && empty($settings['triggers']['show_on_desktop']))) {
            return;
        }
        echo '<div id="swc-button" class="swc-button" role="button" aria-label="WhatsApp chat"></div>';
        echo '<script type="application/json" id="swc-data">' . wp_json_encode([
            'number' => $number,
            'message' => $settings['message'],
            'design' => $settings['design'],
            'agents' => $agents,
        ]) . '</script>';
    }
}

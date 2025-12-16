<?php
namespace SWC\Admin\Pages;

use SWC\Core\Helpers;

class Triggers
{
    public function render(): void
    {
        $settings = Helpers::get_settings();
        echo '<div class="swc-card">';
        echo '<p>' . esc_html__('Control when the chat shows.', 'smart-whatsapp-chat') . '</p>';
        echo '<label class="swc-toggle"><input type="checkbox" id="swc-show-mobile"' . checked($settings['triggers']['show_on_mobile'], true, false) . ' /> ' . esc_html__('Show on mobile', 'smart-whatsapp-chat') . '</label>';
        echo '<label class="swc-toggle"><input type="checkbox" id="swc-show-desktop"' . checked($settings['triggers']['show_on_desktop'], true, false) . ' /> ' . esc_html__('Show on desktop', 'smart-whatsapp-chat') . '</label>';
        echo '</div>';
    }
}

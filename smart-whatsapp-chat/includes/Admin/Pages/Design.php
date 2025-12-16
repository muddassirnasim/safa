<?php
namespace SWC\Admin\Pages;

use SWC\Core\Helpers;

class Design
{
    public function render(): void
    {
        $settings = Helpers::get_settings();
        echo '<div class="swc-card">';
        echo '<p>' . esc_html__('Customize colors and position.', 'smart-whatsapp-chat') . '</p>';
        echo '<label>' . esc_html__('Button Color', 'smart-whatsapp-chat') . '</label>';
        echo '<input type="color" id="swc-color" value="' . esc_attr($settings['design']['color']) . '" />';
        echo '<label>' . esc_html__('Text Color', 'smart-whatsapp-chat') . '</label>';
        echo '<input type="color" id="swc-text-color" value="' . esc_attr($settings['design']['text_color']) . '" />';
        echo '<label>' . esc_html__('Label', 'smart-whatsapp-chat') . '</label>';
        echo '<input type="text" id="swc-label" value="' . esc_attr($settings['design']['label']) . '" />';
        echo '<label>' . esc_html__('Desktop Margin (px)', 'smart-whatsapp-chat') . '</label>';
        echo '<input type="number" id="swc-desktop-margin" value="' . esc_attr($settings['design']['desktop_margin']) . '" min="0" />';
        echo '<label>' . esc_html__('Mobile Margin (px)', 'smart-whatsapp-chat') . '</label>';
        echo '<input type="number" id="swc-mobile-margin" value="' . esc_attr($settings['design']['mobile_margin']) . '" min="0" />';
        echo '<label>' . esc_html__('Position', 'smart-whatsapp-chat') . '</label>';
        echo '<select id="swc-position">';
        $positions = ['right' => __('Bottom Right', 'smart-whatsapp-chat'), 'left' => __('Bottom Left', 'smart-whatsapp-chat')];
        foreach ($positions as $value => $label) {
            echo '<option value="' . esc_attr($value) . '"' . selected($settings['design']['position'], $value, false) . '>' . esc_html($label) . '</option>';
        }
        echo '</select>';
        echo '</div>';
    }
}

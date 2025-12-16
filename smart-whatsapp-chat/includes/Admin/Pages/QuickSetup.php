<?php
namespace SWC\Admin\Pages;

use SWC\Core\Helpers;

class QuickSetup
{
    public function render(): void
    {
        $settings = Helpers::get_settings();
        echo '<div class="swc-card">';
        echo '<p>' . esc_html__('Add your WhatsApp number and publish instantly.', 'smart-whatsapp-chat') . '</p>';
        echo '<label>' . esc_html__('WhatsApp Number', 'smart-whatsapp-chat') . '</label>';
        echo '<input type="tel" id="swc-number" value="' . esc_attr($settings['number']) . '" placeholder="e.g. 15551234567" />';
        echo '<span class="swc-help">' . esc_html__('Include country code, numbers only.', 'smart-whatsapp-chat') . '</span>';
        echo '<label>' . esc_html__('Default Message', 'smart-whatsapp-chat') . '</label>';
        echo '<textarea id="swc-message" rows="2">' . esc_textarea($settings['message']) . '</textarea>';
        echo '<label class="swc-toggle"><input type="checkbox" id="swc-enabled"' . checked($settings['enabled'], true, false) . ' /> ' . esc_html__('Enable chat', 'smart-whatsapp-chat') . '</label>';
        echo '<div class="swc-preview">';
        echo '<p>' . esc_html__('Preview', 'smart-whatsapp-chat') . '</p>';
        echo '<div class="swc-floating-preview" role="button" aria-label="WhatsApp preview">';
        echo '<span class="swc-dot"></span><span class="swc-label">' . esc_html($settings['design']['label']) . '</span>';
        echo '</div>';
        echo '</div>';
        echo '<button class="button button-primary swc-save">' . esc_html__('Save & Activate', 'smart-whatsapp-chat') . '</button>';
        echo '<div class="swc-status" aria-live="polite"></div>';
        echo '</div>';
    }
}

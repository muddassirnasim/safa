<?php
namespace SWC\Admin;

class Menu
{
    public function register(): void
    {
        add_menu_page(
            __('WhatsApp Chat', 'smart-whatsapp-chat'),
            __('WhatsApp Chat', 'smart-whatsapp-chat'),
            'manage_options',
            'swc-dashboard',
            [$this, 'render'],
            'dashicons-format-chat'
        );
    }

    public function render(): void
    {
        $page = new \SWC\Admin\Pages\QuickSetup();
        $design = new \SWC\Admin\Pages\Design();
        $agents = new \SWC\Admin\Pages\Agents();
        $triggers = new \SWC\Admin\Pages\Triggers();
        $analytics = new \SWC\Admin\Pages\Analytics();
        $advanced = new \SWC\Admin\Pages\Advanced();
        echo '<div class="swc-admin">';
        echo '<h1>' . esc_html__('Smart WhatsApp Chat', 'smart-whatsapp-chat') . '</h1>';
        echo '<div class="swc-tabs">';
        echo '<button class="swc-tab active" data-target="swc-quick">' . esc_html__('Quick Setup', 'smart-whatsapp-chat') . '</button>';
        echo '<button class="swc-tab" data-target="swc-design">' . esc_html__('Design', 'smart-whatsapp-chat') . '</button>';
        echo '<button class="swc-tab" data-target="swc-agents">' . esc_html__('Agents', 'smart-whatsapp-chat') . '</button>';
        echo '<button class="swc-tab" data-target="swc-triggers">' . esc_html__('Triggers', 'smart-whatsapp-chat') . '</button>';
        echo '<button class="swc-tab" data-target="swc-analytics">' . esc_html__('Analytics', 'smart-whatsapp-chat') . '</button>';
        echo '<button class="swc-tab" data-target="swc-advanced">' . esc_html__('Advanced', 'smart-whatsapp-chat') . '</button>';
        echo '</div>';
        echo '<div class="swc-panels">';
        echo '<div id="swc-quick" class="swc-panel active">';
        $page->render();
        echo '</div>';
        echo '<div id="swc-design" class="swc-panel">';
        $design->render();
        echo '</div>';
        echo '<div id="swc-agents" class="swc-panel">';
        $agents->render();
        echo '</div>';
        echo '<div id="swc-triggers" class="swc-panel">';
        $triggers->render();
        echo '</div>';
        echo '<div id="swc-analytics" class="swc-panel">';
        $analytics->render();
        echo '</div>';
        echo '<div id="swc-advanced" class="swc-panel">';
        $advanced->render();
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
}

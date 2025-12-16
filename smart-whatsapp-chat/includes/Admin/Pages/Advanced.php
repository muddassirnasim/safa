<?php
namespace SWC\Admin\Pages;

class Advanced
{
    public function render(): void
    {
        echo '<div class="swc-card">';
        echo '<p>' . esc_html__('Advanced options for power users.', 'smart-whatsapp-chat') . '</p>';
        echo '<p>' . esc_html__('The chat button respects pages cached by your setup and loads assets only when needed.', 'smart-whatsapp-chat') . '</p>';
        echo '</div>';
    }
}

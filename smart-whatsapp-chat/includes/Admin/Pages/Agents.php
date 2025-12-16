<?php
namespace SWC\Admin\Pages;

class Agents
{
    public function render(): void
    {
        echo '<div class="swc-card">';
        echo '<p>' . esc_html__('Add multiple agents to route chats.', 'smart-whatsapp-chat') . '</p>';
        echo '<div id="swc-agents-list"></div>';
        echo '<button class="button swc-add-agent">' . esc_html__('Add Agent', 'smart-whatsapp-chat') . '</button>';
        echo '</div>';
    }
}

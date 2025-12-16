<?php
namespace SWC\Frontend;

class Message
{
    public function hooks(): void
    {
        add_shortcode('smart_whatsapp_chat', [$this, 'shortcode']);
    }

    public function shortcode(): string
    {
        ob_start();
        $button = new Button();
        $button->render();
        return ob_get_clean();
    }
}

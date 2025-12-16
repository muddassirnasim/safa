<?php
namespace SWC\Setup;

class Defaults
{
    public function settings(): array
    {
        return [
            'enabled' => true,
            'number' => '',
            'message' => __('Hello! How can we help you?', 'smart-whatsapp-chat'),
            'design' => [
                'position' => 'right',
                'color' => '#25D366',
                'text_color' => '#ffffff',
                'label' => __('Chat with us', 'smart-whatsapp-chat'),
                'desktop_margin' => 20,
                'mobile_margin' => 15,
            ],
            'triggers' => [
                'show_on_mobile' => true,
                'show_on_desktop' => true,
            ],
        ];
    }

    public function agents(): array
    {
        return [];
    }
}

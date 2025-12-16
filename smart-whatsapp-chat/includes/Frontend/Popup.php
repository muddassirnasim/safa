<?php
namespace SWC\Frontend;

use SWC\Core\Helpers;

class Popup
{
    public function render(): void
    {
        if (!Helpers::is_enabled()) {
            return;
        }
        $settings = Helpers::get_settings();
        $design = $settings['design'];
        echo '<style id="swc-inline-styles">:root{--swc-color:' . esc_attr($design['color']) . ';--swc-text:' . esc_attr($design['text_color']) . ';--swc-position:' . esc_attr($design['position']) . ';--swc-desktop:' . intval($design['desktop_margin']) . 'px;--swc-mobile:' . intval($design['mobile_margin']) . 'px;}</style>';
    }
}

<?php
namespace SWC\Integrations;

class WooCommerce
{
    public function hooks(): void
    {
        if (!class_exists('WooCommerce')) {
            return;
        }
        add_action('woocommerce_single_product_summary', [$this, 'button'], 40);
    }

    public function button(): void
    {
        echo do_shortcode('[smart_whatsapp_chat]');
    }
}

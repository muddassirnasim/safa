<?php
namespace SWC\Analytics;

class Tracker
{
    public function hooks(): void
    {
        add_action('rest_api_init', function () {
            register_rest_field('post', 'swc_dummy', ['get_callback' => '__return_null']);
        });
    }
}

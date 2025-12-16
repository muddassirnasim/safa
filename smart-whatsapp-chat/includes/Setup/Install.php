<?php
namespace SWC\Setup;

use SWC\Analytics\Schema;

class Install
{
    public function activate(): void
    {
        $defaults = new Defaults();
        if (get_option('swc_settings') === false) {
            add_option('swc_settings', $defaults->settings());
        }
        if (get_option('swc_agents') === false) {
            add_option('swc_agents', $defaults->agents());
        }
        $schema = new Schema();
        $schema->create();
    }

    public function uninstall(): void
    {
        global $wpdb;
        delete_option('swc_settings');
        delete_option('swc_agents');
        $table = $wpdb->prefix . 'swc_clicks';
        $wpdb->query("DROP TABLE IF EXISTS {$table}");
    }
}

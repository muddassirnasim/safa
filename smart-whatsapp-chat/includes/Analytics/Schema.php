<?php
namespace SWC\Analytics;

class Schema
{
    public function create(): void
    {
        global $wpdb;
        $table = $wpdb->prefix . 'swc_clicks';
        $charset = $wpdb->get_charset_collate();
        $sql = "CREATE TABLE IF NOT EXISTS {$table} (
            id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
            agent VARCHAR(190) DEFAULT '' NOT NULL,
            page_id BIGINT UNSIGNED DEFAULT 0,
            page_title VARCHAR(255) DEFAULT '' NOT NULL,
            page_url TEXT NOT NULL,
            device VARCHAR(20) DEFAULT '' NOT NULL,
            created_at DATETIME NOT NULL,
            PRIMARY KEY  (id),
            KEY page_id (page_id),
            KEY agent (agent)
        ) {$charset};";

        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        dbDelta($sql);
    }
}

<?php
if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

require_once __DIR__ . '/smart-whatsapp-chat.php';

$install = new SWC\Setup\Install();
$install->uninstall();

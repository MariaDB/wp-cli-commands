<?php

if (! class_exists('WP_CLI')) {
    return;
}

$wpcli_mariadb_autoloader = __DIR__ . '/vendor/autoload.php';
if (file_exists($wpcli_mariadb_autoloader)) {
    require_once $wpcli_mariadb_autoloader;
}

\WP_CLI::add_command('mariadb catalog', 'Catalog_Command');

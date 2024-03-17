<?php

class Catalog_Command extends \WP_CLI_Command
{
    /**
     * @var \Mariadb\CatalogsPHP\Catalog
     */
    protected $mariadb_connection;

    protected function get_mariadb_connection()
    {

        if (! empty($this->mariadb_connection)) {
            return $this->mariadb_connection;
        }

        // TODO check if these constants are defined.
        $db_host = \DB_HOST; // TODO check if the constant has a port.
        $db_port = 3306;
        $db_user = \DB_NAME;
        $db_pass = \DB_PASSWORD;

        // TODO: exception handling.
        $this->mariadb_connection = new \Mariadb\CatalogsPHP\Catalog($db_host, $db_port, $db_user, $db_pass);
    }

    /**
     * @when before_wp_load
     */
    public function create($args, $assoc_args)
    {
        $catalog_name = $args[0];
        $this->get_mariadb_connection()->create($catalog_name);
    }
}

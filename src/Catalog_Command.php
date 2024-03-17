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
     * Create a catalog with the specified name.
     *
     * ## OPTIONS
     *
     * <Catalog_name>
     * : Name of the catalog.
     *
     * ## EXAMPLES
     *
     *     # Get the table_prefix as defined in wp-config.php file.
     *     $ wp mariadb catalog create "test"
     *     3307
     *
     * @when before_wp_load
     */
    public function create($args, $assoc_args)
    {
        $catalog_name = $args[0];

        try {
            $port = $this->get_mariadb_connection()->create($catalog_name);
            \WP_CLI::success(sprintf('Catalog "%s" created successfully on port %s.', $catalog_name, $port));
        } catch (Exception $e) {
            \WP_CLI::error(sprintf('Error creating catalog "%s": %s', $catalog_name, $e->getMessage()));
        }

    }
}

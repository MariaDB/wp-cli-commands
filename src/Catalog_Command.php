<?php

class Catalog_Command extends \WP_CLI_Command {

	/**
	 * @var \Mariadb\CatalogsPHP\Catalog
	 */
	protected $mariadb_connection;

	protected function get_mariadb_connection() {

		if ( ! empty( $this->mariadb_connection ) ) {
			return $this->mariadb_connection;
		}

		// Check if the required constants are defined
		if ( ! defined( 'DB_HOST' ) || ! defined( 'DB_USER' ) || ! defined( 'DB_PASSWORD' ) ) {
			\WP_CLI::error( 'The database constants are not defined.' );
		}

		// TODO check if these constants are defined.
		$db_host = \DB_HOST; // TODO check if the constant has a port.
		$db_port = 3306;
		$db_user = \DB_NAME;
		$db_pass = \DB_PASSWORD;

		// TODO: exception handling.
		$this->mariadb_connection = new \Mariadb\CatalogsPHP\Catalog( $db_host, $db_port, $db_user, $db_pass );
	}

	/**
	 * Create a catalog with the specified name.
	 *
	 * ## OPTIONS
	 *
	 * <catalog_name>
	 * : Name of the catalog.
	 *
	 * ## EXAMPLES
	 *
	 *     # Create a catalog with the specified name.
	 *     $ wp mariadb catalog create "test"
	 *     3307
	 *
	 * @when before_wp_load
	 */
	public function create( $args, $assoc_args ) {
		$catalog_name = $args[0];

		try {
			$port = $this->get_mariadb_connection()->create( $catalog_name );
			\WP_CLI::log( absint( $port ) );
		} catch ( Exception $e ) {
			\WP_CLI::error( sprintf( 'Error creating catalog "%s": %s', $catalog_name, $e->getMessage() ) );
		}
	}

	public function is_enabled( $args, $assoc_args ) {
	}

	/**
	 * Retrieve the port of the given catalog.
	 *
	 * ## OPTIONS
	 *
	 * <catalog_name>
	 * : Name of the catalog.
	 *
	 * ## EXAMPLES
	 *
	 *     # Port a catalog to the specified port.
	 *     $ wp mariadb catalog port "test"
	 *     3307
	 *
	 * @when before_wp_load
	 */
	public function port( $args, $assoc_args ) {
		$catalog_name = $args[0];

		try {
			$port = $this->get_mariadb_connection()->getPort( $catalog_name );
			\WP_CLI::log( absint( $port ) );
		} catch ( Exception $e ) {
			\WP_CLI::error( sprintf( 'Error creating catalog "%s": %s', $catalog_name, $e->getMessage() ) );
		}
	}

	public function list( $args, $assoc_args ) {
	}

	public function delete( $args, $assoc_args ) {
	}

	/**
	 * Will list all databases in the catalog.
	 */
	public function databases( $args, $assoc_args ) {
	}
}

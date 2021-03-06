<?php
class Db_config
{
	/**
	 * Returns the *Singleton* instance of this class.
	 *
	 * @staticvar Db_config $instance The *Singleton* instances of this class.
	 *
	 * @return Db_config The *Singleton* instance.
	 */

	public static function getInstance()
	{
		// Configuration
		$dbhost = 'localhost';
		$dbname = 'magic_chess';
		
		static $instance = null;
		
		if (null === $instance) {
			$instance = new static();
			$conn = new MongoClient("mongodb://$dbhost");
			$instance = $conn->$dbname;
		}

		return $instance;
	}

	/**
	 * Protected constructor to prevent creating a new instance of the
	 * *Singleton* via the `new` operator from outside of this class.
	 */
	protected function __construct()
	{
	}

	/**
	 * Private clone method to prevent cloning of the instance of the
	 * *Singleton* instance.
	 *
	 * @return void
	 */
	private function __clone()
	{
	}

	/**
	 * Private unserialize method to prevent unserializing of the *Singleton*
	 * instance.
	 *
	 * @return void
	 */
	private function __wakeup()
	{
	}
}
<?php

namespace IgniteKit\Messages;

use IgniteKit\Messages\Abstracts\BaseAdapter;

use IgniteKit\Messages\Adapters\RabbitMQ\RabbitMQAdapter;
use IgniteKit\Messages\Adapters\RabbitMQ\RabbitMQConnection;

/**
 * The queue manager
 */
class Manager {

	/**
	 * The config
	 * @var array
	 */
	private $config;

	/**
	 * The queue adapter
	 * @var BaseAdapter
	 */
	private $adapter;

	/**
	 * The constructor
	 * @throws \Exception
	 */
	public function __construct( array $config ) {

		$this->config = $config;
		if ( empty( $this->config ) ) {
			throw new \Exception( 'No configuration found.' );
		}

		$current = isset( $this->config['default'] ) && isset( $this->config['adapters'][ $this->config['default'] ] ) ? $this->config['default'] : null;

		if ( is_null( $current ) ) {
			throw new \Exception( 'The default message broker adapter is not found.' );
		}

		if ( 'RabbitMQ' === $current ) {

			$user = isset( $this->config['adapters'][ $current ]['username'] ) ? $this->config['adapters'][ $current ]['username'] : null;
			$pass = isset( $this->config['adapters'][ $current ]['password'] ) ? $this->config['adapters'][ $current ]['password'] : null;
			$host = isset( $this->config['adapters'][ $current ]['hostname'] ) ? $this->config['adapters'][ $current ]['hostname'] : null;
			$port = isset( $this->config['adapters'][ $current ]['port'] ) ? $this->config['adapters'][ $current ]['port'] : null;

			$connection    = new RabbitMQConnection( $user, $pass, $host, $port, true );
			$this->adapter = new RabbitMQAdapter( $connection );

		} else {
			throw new \Exception( 'Unsupported message broker adapter.' ); // Perhaps other?
		}

	}

	/**
	 * The adapter instance
	 * @return BaseAdapter|RabbitMQAdapter
	 */
	public function get_adapter() {
		return $this->adapter;
	}

	/**
	 * Create queue
	 *
	 * @param Exchange $exchange
	 *
	 * @return void
	 */
	public function create( Exchange $exchange ) {
		$this->get_adapter()->create( $exchange );
	}

	/**
	 * Dispatch a message and close
	 * @return void
	 * @throws \Exception
	 */
	public function send( Exchange $exchange, Message $message ) {
		$this->get_adapter()->send( $exchange, $message );
	}

	/**
	 * Dispatch a message and close
	 * @return void
	 * @throws \Exception
	 */
	public function send_close( Exchange $exchange, Message $message ) {
		$this->get_adapter()->send_close( $exchange, $message );
	}

	/**
	 * Receive a message from channel
	 *
	 * @param Exchange $exchange
	 * @param callable $callback
	 *
	 * @return void
	 * @throws \Exception
	 */
	public function receive( Exchange $exchange, callable $callback ) {
		$this->get_adapter()->receive( $exchange, $callback );
	}

	/**
	 * Close the connection
	 * @return void
	 * @throws \Exception
	 */
	public function close() {
		$connection = $this->get_adapter()->get_connection();
		if ( $connection && $connection->is_connected() ) {
			$this->get_adapter()->get_connection()->close();
		}
	}

}

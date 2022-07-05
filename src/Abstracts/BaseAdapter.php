<?php

namespace IgniteKit\Messages\Abstracts;

use IgniteKit\Messages\Message;
use IgniteKit\Messages\Exchange;

abstract class BaseAdapter {

	/**
	 * List of declared exchanges
	 * @var Exchange[]
	 */
	protected $exchanges;

	/**
	 * The queue connection
	 * @var BaseConnection
	 */
	protected $connection;


	/**
	 * The constructor
	 *
	 * @param BaseConnection $connection
	 */
	public function __construct( BaseConnection $connection ) {
		$this->connection = $connection;
	}

	/**
	 * Create a queue
	 *
	 * @return mixed
	 */
	abstract public function create( Exchange $exchange );

	/**
	 * Dispatch a message
	 *
	 * @param Exchange $exchange
	 * @param Message $message
	 * @param array $config
	 *
	 * @return void
	 */
	abstract public function send( Exchange $exchange, Message $message, $config = array() );

	/**
	 * Receive a message
	 *
	 * @param Exchange $exchange
	 * @param callable $callback
	 * @param array $config
	 *
	 * @return void
	 */
	abstract public function receive( Exchange $exchange, callable $callback, $config = array() );

	/**
	 * The connection instance
	 * @return BaseConnection
	 */
	public function get_connection() {
		return $this->connection;
	}
}

<?php

namespace IgniteKit\Messages\Adapters\RabbitMQ;

use IgniteKit\Messages\Abstracts\BaseAdapter;
use IgniteKit\Messages\Message;
use IgniteKit\Messages\Exchange;

use PhpAmqpLib\Message\AMQPMessage;

class RabbitMQAdapter extends BaseAdapter {

	/**
	 * The connection
	 * @var RabbitMQConnection
	 */
	protected $connection;

	/**
	 * Declare an exchange
	 *
	 * @return bool
	 */
	public function create( Exchange $exchange ) {

		if ( isset( $this->exchanges[ $exchange->get_name() ] ) ) {
			return false;
		}

		$this->exchanges[ $exchange->get_name() ] = $exchange;

		$this->connection
			->get()
			->channel()
			->queue_declare(
				$exchange->get_name(),
				$exchange->get_config( 'passive', false ),
				$exchange->get_config( 'durable', true ),
				$exchange->get_config( 'exclusive', false ),
				$exchange->get_config( 'auto_delete', false )
			);

		return true;
	}

	/**
	 * Dispatch a message
	 *
	 * @param Exchange $exchange
	 * @param Message $message
	 * @param array $config
	 *
	 * @return void
	 */
	public function send( Exchange $exchange, Message $message, $config = array() ) {

		if ( ! isset( $this->exchanges[ $exchange->get_name() ] ) ) {
			$this->create( $exchange );
		}

		$amq_message = new AMQPMessage( $message->get_body() );

		$channel = $this->connection
			->get()
			->channel();

		$channel->basic_publish( $amq_message, '', $exchange->get_name() );
	}

	/**
	 * Dispatch a message and close connection
	 *
	 * @param Exchange $exchange
	 * @param Message $message
	 * @param array $config
	 *
	 * @return void
	 */
	public function send_close( Exchange $exchange, Message $message, $config = array() ) {
		$this->send( $exchange, $message, $config );
		$this->connection->close();
	}

	/**
	 * Receive a message
	 *
	 * @param Exchange $exchange
	 * @param callable $callback
	 * @param array $config
	 *
	 * @return void
	 */
	public function receive( Exchange $exchange, callable $callback, $config = array() ) {

		if ( ! isset( $this->exchanges[ $exchange->get_name() ] ) ) {
			$this->create( $exchange );
		}

		$channel = $this->connection->get()->channel();

		$channel->basic_consume(
			$exchange->get_name(),
			$exchange->get_config( 'consumer_tag', '' ),
			$exchange->get_config( 'no_local', false ),
			$exchange->get_config( 'no_ack', true ),
			$exchange->get_config( 'exclusive', false ),
			$exchange->get_config( 'nowait', false ),
			$callback
		);

		while ( $channel->is_open() ) {
			$channel->wait();
		}

	}
}

<?php

namespace IgniteKit\Messages\Adapters\RabbitMQ;

use IgniteKit\Messages\Abstracts\BaseConnection;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class RabbitMQConnection extends BaseConnection {

    /**
     * The connection instance
     * @var AMQPStreamConnection
     */
    protected $instance;

    /**
     * Create the connection
     * @return mixed
     */
    public function open() {
        $this->instance = new AMQPStreamConnection(
            $this->host,
            $this->port,
            $this->user,
            $this->pass
        );

        return $this->instance->isConnected();
    }

    /**
     * Close the active connection
     * @return void
     */
    public function close() {
        if ( ! $this->is_connected() ) {
            return;
        }

        try {
            $this->instance->channel()->close();
            $this->instance->close();
        } catch ( \Exception $e ) {
            return;
        }
    }

    /**
     * Returns the connection
     * @return AMQPStreamConnection
     */
    public function get() {
        return $this->instance;
    }

    /**
     * Check if connected
     * @return bool
     */
    public function is_connected() {
        return $this->instance && $this->instance->isConnected();
    }
}

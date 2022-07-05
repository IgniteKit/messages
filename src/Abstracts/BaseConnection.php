<?php

namespace IgniteKit\Messages\Abstracts;

abstract class BaseConnection {

    protected $user;
    protected $pass;
    protected $host;
    protected $port;

    /**
     * The constructor
     *
     * @param $user
     * @param $pass
     * @param $host
     * @param $port
     */
    public function __construct( $user, $pass, $host, $port, $connect = false ) {
        $this->user = $user;
        $this->pass = $pass;
        $this->host = $host;
        $this->port = $port;

        if ( $connect ) {
            $this->open();
        }
    }

    /**
     * The destructor
     */
    public function __destruct() {
        $this->close();
    }

    /**
     * Create the connection
     * @return mixed
     */
    abstract public function open();

    /**
     * Close the active connection
     * @return void
     */
    abstract public function close();

    /**
     * Returns the connection
     * @return mixed
     */
    abstract public function get();

    /**
     * Check if connected
     * @return bool
     */
    abstract public function is_connected();

}

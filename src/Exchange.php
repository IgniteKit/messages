<?php

namespace IgniteKit\Messages;

/**
 * The queue/channel configuration
 */
class Exchange {

    /**
     * The queue/channel name
     * @var string
     */
    private $name;

    /**
     * The queue/channel config
     * @var array|mixed
     */
    private $config;

    /**
     * Constructor
     *
     * @param $name
     * @param $config
     */
    public function __construct( $name, $config = array() ) {
        $this->name   = $name;
        $this->config = $config;
    }

    /**
     * The queue name
     * @return string
     */
    public function get_name() {
        return $this->name;
    }

    /**
     * The queue config
     * @return array|mixed
     */
    public function get_config( $key = null, $default = null ) {

        if ( ! is_null( $key ) ) {
            return isset( $this->config[ $key ] ) ? $this->config[ $key ] : $default;
        }

        return $this->config;
    }

}

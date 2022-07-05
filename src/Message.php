<?php

namespace IgniteKit\Messages;

/**
 * The queue message
 */
class Message {

    /**
     * The body
     * @var string|mixed
     */
    private $body;

    /**
     * The data
     * @var array|mixed
     */
    private $data;

    /**
     * Constructor
     *
     * @param $body
     * @param $data
     */
    public function __construct( $body, $data = array() ) {

        if ( ! is_scalar( $body ) ) {
            $body = json_encode( $body );
        }

        $this->body = $body;
        $this->data = $data;
    }

    /**
     * Returns the body
     * @return mixed
     */
    public function get_body() {
        return $this->body;
    }

    /**
     * Returns data
     * @return array|mixed
     */
    public function get_data() {
        return $this->data;
    }

}

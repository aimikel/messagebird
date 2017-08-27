<?php

/**
 * Description of Message
 *
 */
class Message extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function send() {
        $this->load->template('send_message', $this->view_data);
    }

}

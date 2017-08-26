<?php

/**
 * Description of MY_Controller
 *
 */
class MY_Controller extends CI_Controller {

    protected $api_key; //variable to store API KEY
    protected $view_data = array(); //variable to store views data

    public function __construct() {
        parent::__construct();
        $this->valid_api_key(); //Check if there is api_key in session otherwise send to login
    }

    /**
     * Check if there is a valid API KEY in session. 
     * If NOT redirect to login
     */
    private function valid_api_key() {
        $api_key = $this->session->userdata('api_key');
        if (!$api_key || $api_key == "")
            redirect('login');
    }

}

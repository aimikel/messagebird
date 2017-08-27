<?php

/**
 * Description of Login
 *
 */
class Login extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Login form validation.
     * If login is successful redirect to start 
     * If login is NOT successful redirect to login
     */
    public function index() {
        $this->form_validation->set_rules('api_key', 'API Key', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('login_view');
        } else {
            $api_key = $this->input->post('api_key');
            if ($this->check_api_key($api_key)) {
                $this->session->set_flashdata('message', 'Succesful API Key. Welcome!');
                $this->session->set_userdata('api_key', $api_key);
                redirect(base_url('dashboard'));
            } else {
                $this->session->set_flashdata('error', 'Incorrect API Key');
                redirect(base_url('login'));
            }
        }
    }

    /**
     * Check if API KEY is valid through HTTP status.
     * If status is 200 return TRUE otherwise return FALSE.
     * 
     * @param type $api_key
     * @return type boolean
     */
    private function check_api_key($api_key) {
        $url = "https://rest.messagebird.com/balance/";
        $ch = curl_init($url);

        $headers = array(
            'Authorization: AccessKey ' . $api_key
        );

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        $output = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE); //store HTTP code to check if 200 or not
        curl_close($ch);
        return ($httpcode == 200 ? TRUE : FALSE);
    }

    /**
     * Logout functionality
     * Unset api_key variable from session and redirect to login form
     */
    public function logout() {
        $this->session->unset_userdata('api_key');
        $this->session->set_flashdata('message', 'You have been logged out succesfully!');
        redirect(base_url('login'));
    }

}

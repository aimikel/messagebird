<?php

/**
 * Description of Dashboard
 *
 */
class Dashboard extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Display all messages in dashboard
     */
    public function index() {
        $balance_info = json_decode($this->get_balance(), TRUE);
        $this->view_data['balance_info'] = $balance_info;
        $this->load->template('dashboard_view', $this->view_data);
    }

    public function get_balance() {
        $url = "https://rest.messagebird.com/balance/";
        $ch = curl_init($url);

        $headers = array(
            'Authorization: AccessKey ' . $this->api_key
        );

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }

}

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
        $view_messages = $this->get_messages($this->api_key);
        $this->view_data['messages'] = (!empty($view_messages) ? $view_messages : FALSE);
        $this->load->template('dashboard_view', $this->view_data);
    }

    /**
     * Return messages through CURL or empty if there are no messages
     * 
     * @param type $api_key
     * @return boolean|array
     */
    public function get_messages($api_key) {
        $url = "https://rest.messagebird.com/messages";
        $ch = curl_init($url);

        $headers = array(
            'Authorization: AccessKey ' . $api_key
        );

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        $output = curl_exec($ch);
        curl_close($ch);

        $messages = json_decode($output, TRUE);

        if ($messages['count'] == 0) //if no messages found return false
            return FALSE;

        return $this->parse_messages($messages);
    }

    /**
     * Parse the json object to retrieve specific details
     * 
     * @param type $messages
     * @return array
     */
    private function parse_messages($messages) {
        $messages_array = array(); //the array to return

        foreach ($messages['items'] as $message) { //for each message
            $temp_message = array();
            $temp_message['recipients'] = array();
            $temp_recipients = array();

            $temp_message['id'] = $message['id'];
            $temp_message['direction'] = $message['direction'];
            $temp_message['originator'] = $message['originator'];
            $temp_message['body'] = $message['body'];
            $temp_message['createdDatetime'] = $message['createdDatetime'];

            foreach ($message['recipients']['items'] as $recipient) { //if there are many recipients
                $temp_recipients['recipient'] = $recipient['recipient'];
                $temp_recipients['status'] = $recipient['status'];
                $temp_recipients['statusDatetime'] = $recipient['statusDatetime'];
                array_push($temp_message['recipients'], $temp_recipients); //push to recipients
            }
            array_push($messages_array, $temp_message); //push to the returned array
        }
        return $messages_array;
    }

}

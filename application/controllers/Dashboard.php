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
        $offset = $this->uri->segment(2);
        $view_messages = $this->get_messages($offset);
        $this->view_data['messages'] = (!empty($view_messages) ? $view_messages : FALSE);
        $messages_ids = $this->parse_messages_ids($view_messages);

        $cookie = array(
            'name' => 'messages_ids',
            'value' => json_encode($messages_ids),
            'expire' => 3000,
        );
        $this->input->set_cookie($cookie);

        $this->load->template('dashboard_view', $this->view_data);
    }

    public function ajax_get_message() {
        $id = $this->input->post('id');
    }

    public function retrieve_message() {
        $id = $this->input->post('id');
        echo json_encode($this->get_message($id));
    }

    private function parse_messages_ids($messages) {
        $messages_ids = array();

        foreach ($messages['messages'] as $message) {
            array_push($messages_ids, $message['id']);
        }
        return $messages_ids;
    }

    /**
     * Return message through CURL or empty if there are no messages
     * 
     * @param type $api_key
     * @return boolean|array
     */
    public function get_message($id) {
        $url = "https://rest.messagebird.com/messages/" . $id;

        $ch = curl_init($url);

        $headers = array(
            'Authorization: AccessKey ' . $this->api_key
        );

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        $output = curl_exec($ch);
        curl_close($ch);

        $message = json_decode($output, TRUE);

        return $this->parse_message($message);
    }

    public function parse_message($message) {
        $message_array['recipients'] = array();
        $temp_recipients = array();

        $message_array['id'] = $message['id'];
        $message_array['originator'] = $message['originator'];
        $message_array['direction'] = $message['direction'];
        $message_array['body'] = $message['body'];
        $message_array['createdDatetime'] = $message['createdDatetime'];

        foreach ($message['recipients']['items'] as $recipient) { //if there are many recipients
            $temp_recipients['recipient'] = $recipient['recipient'];
            $temp_recipients['status'] = $recipient['status'];
            $temp_recipients['statusDatetime'] = $recipient['statusDatetime'];
            array_push($message_array['recipients'], $temp_recipients); //push to recipients
        }
        return $message_array;
    }

    /**
     * Return messages through CURL or empty if there are no messages
     * 
     * @param type $api_key
     * @return boolean|array
     */
    public function get_messages($offset = NULL) {
        $url = "https://rest.messagebird.com/messages/";
        if ($offset != NULL) {
            $url .= "?offset=" . $offset;
        }

        $ch = curl_init($url);

        $headers = array(
            'Authorization: AccessKey ' . $this->api_key
        );

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        $output = curl_exec($ch);
        curl_close($ch);

        $messages = json_decode($output, TRUE);

        if (isset($messages['count']) && $messages['count'] == 0) //if no messages found return false
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
        $messages_info = array(); //array to store general info
        $messages_array['messages'] = array(); //array to store messages
        $merged_array = array(); //array to store merged previous arrays

        $messages_info['offset'] = $messages['offset'];
        $messages_info['limit'] = $messages['limit'];
        $messages_info['count'] = $messages['count'];
        $messages_info['totalCount'] = $messages['totalCount'];
        $messages_info['links'] = $messages['links'];

        $temp_first_offset = explode('?offset=', $messages_info['links']['first']);
        $first_offset = end($temp_first_offset);
        $messages_info['links']['first_offset'] = $first_offset;

        $temp_previous_offset = explode('?offset=', $messages_info['links']['previous']);
        $previous_offset = end($temp_previous_offset);
        $messages_info['links']['previous_offset'] = $previous_offset;

        $temp_next_offset = explode('?offset=', $messages_info['links']['next']);
        $next_offset = end($temp_next_offset);
        $messages_info['links']['next_offset'] = $next_offset;

        $temp_last_offset = explode('?offset=', $messages_info['links']['last']);
        $last_offset = end($temp_last_offset);
        $messages_info['links']['last_offset'] = $last_offset;


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
            array_push($messages_array['messages'], $temp_message); //push to the returned array
        }

        $merged_array = array_merge($messages_array, $messages_info);
        return $merged_array;
    }

}

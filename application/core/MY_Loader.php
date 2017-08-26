<?php

/**
 * Description of MY_Loader
 *
 */
class MY_Loader extends CI_Loader {
    
    /**
     * Override default CI load->view in order to load header_view and footer_view
     * 
     * @param type $template_name
     * @param type $vars
     * @param html
     */
    public function template($template_name, $vars = array(), $return = TRUE) {
        $content = $this->view('header_view', $vars, $return);
        $content .= $this->view($template_name, $vars, $return);
        $content .= $this->view('footer_view', $vars, $return);
        echo $content;
    }

}

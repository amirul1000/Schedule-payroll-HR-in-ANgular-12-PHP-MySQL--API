<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * Author: Amirul Momenin
 * Description: Login model class
 */
class CustomerLogin_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    public function validate()
    {
        // grab user input
        $email = $this->security->xss_clean($this->input->post('email'));
        $password = $this->security->xss_clean($this->input->post('password'));

        // Prep the query
        $this->db->where('email', $email);
        $this->db->where('password', $password);

        // Run the query
        $result = $this->db->get('customer')->result_array();
        // Let's check if there are any results
        if (count($result) == 1) {
            // If there is a user, then create session data
            $data = array(
                'id' => $result[0]['id'],
                'email' => $result[0]['email'],
                'customer_name' => $result[0]['customer_name'],
                'customer_surname' => $result[0]['customer_surname'],
                'validated' => true
            );
            $this->session->set_userdata($data);
            return true;
        }
        // If the previous process did not validate
        // then return false.
        return false;
    }
}
?>